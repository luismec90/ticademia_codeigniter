<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Curso extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->estoyLogueado();
        $this->load->model('modulo_model');
        $this->load->model('usuario_model');
        $this->load->model('usuario_x_modulo_model');
        $this->load->model('curso_model');
        $this->load->model('material_valoracion_model');
        $this->load->model('material_model');
        $this->load->model('evaluacion_model');
        $this->load->model('evaluacion_x_material_model');
        $this->load->model('bitacora_nivel_model');
        $this->months = array("01" => "Ene", "02" => "Feb", "03" => "Mar", "04" => "Abr", "05" => "May", "06" => "Jun", "07" => "Jul", "08" => "Ago", "09" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Dic");
    }

    public function verCurso($idCurso) {

        $this->verificarMatricula($idCurso);
        $data["tab"] = "curso";
        $data["idCurso"] = $idCurso;
        $data["css"] = array("libs/jquery-ui-1.10.4.custom/css/redmond/jquery-ui-1.10.4.custom.min", "libs/mediaElement/mediaelementplayer", "libs/slider-pips/dist/jquery-ui-slider-pips", "css/ranking", "css/curso");
        $data["js"] = array("libs/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min", "libs/mediaElement/mediaelement-and-player", "libs/slider-pips/dist/jquery-ui-slider-pips", "libs/raty/lib/jquery.raty.min", "libs/googleCharts/jsapi", "js/curso");

        $modulos = $this->modulo_model->getModulos($idCurso);
        if ($modulos) {
            $data["moduloActual"] = $modulos[0]->id_modulo;
        } else {
            $data["moduloActual"] = -1;
        }

        $json = array();
        $json2 = array();
        $json3 = array();
        $i = 1;
        foreach ($modulos as $row) {
            array_push($json, $row->nombre . "<br>" . $this->dateToView($row->fecha_inicio) . " - " . $this->dateToView($row->fecha_fin));
            array_push($json2, $row->id_modulo);
            array_push($json3, " <h4  data-placement='top'  data-toggle='tooltip' class='tip' title='{$row->nombre}'>$i</h4>");
            $i++;
        }

        $data["modulos"] = json_encode($json);
        $data["idModulos"] = json_encode($json2);
        $data["numeroModulos"] = json_encode($json3);
        $data["cantidadModulos"] = sizeof($json);
        $this->load->view('include/header', $data);
        $this->load->view('curso_view');
        $this->load->view('include/footer');
    }

    private function dateToView($date) {
        $date = explode("-", $date);
        return $this->months[$date[1]] . " " . $date[2];
    }

    function getmodulo() {
        $idModulo = $this->input->get("idModulo");
        if ($idModulo != -1) {
            $modulo = $this->modulo_model->obtenerModulo($idModulo);
            $idCurso = $modulo[0]->id_curso;


            $tab = "modulo";
            index_bitacora($idCurso);


            $datos = $this->material_model->obtenerMaterialesUsuario($idModulo, $_SESSION["idUsuario"]);
            $infoMaterial = array();
            foreach ($datos as $row) {
                $row->tiempo_total = round($row->tiempo_total / 60);
                $infoMaterial[$row->id_material]["tiempo_total"] = $row->tiempo_total;
            }

            $materiales = $this->material_model->obtenerMaterialesPorModulo($idModulo);
            $cantidadMateriales = sizeof($materiales);
            foreach ($materiales as $row) {
                $row->extension = substr(strrchr($row->ubicacion, '.'), 1);
                if ($row->extension != "pdf") {
                    $row->extension = "video";
                }
                $row->ubicacion = base_url() . "material/" . $row->id_curso . "/" . $row->id_modulo . "/" . $row->ubicacion;

                $row->tiempo_total = 0;
                if (isset($infoMaterial[$row->id_material]["tiempo_total"])) {
                    $row->visto = true;
                    $row->tiempo_total = $infoMaterial[$row->id_material]["tiempo_total"];
                } else {
                    $row->visto = false;
                }
                $row->puntaje_promedio = round($row->puntaje_promedio) / 2;
                $row->total_comentarios = $this->material_valoracion_model->contarComentarios($row->id_material);
                $row->total_comentarios = $row->total_comentarios[0]->total;
            }


            $curso = $this->curso_model->obtenerCurso($idCurso);
            $umbral = $curso[0]->umbral;
            $valorMinimo = 150;
            $datos = $this->evaluacion_model->obtenerIntentosAprobados($idModulo, $_SESSION["idUsuario"]);

            $infoEvaluacion = array();
            foreach ($datos as $row) {
                if (!array_key_exists($row->id_evaluacion, $infoEvaluacion)) {
                    $infoEvaluacion[$row->id_evaluacion] = array();
                }
                if (!array_key_exists("veces_aprobado", $infoEvaluacion[$row->id_evaluacion])) {
                    $infoEvaluacion[$row->id_evaluacion]["veces_aprobado"] = 0;
                    $infoEvaluacion[$row->id_evaluacion]["veces_intentado"] = 0;
                    $infoEvaluacion[$row->id_evaluacion]["puntuacion"] = $row->valor;
                    $infoEvaluacion[$row->id_evaluacion]["flag"] = true;
                    $infoEvaluacion[$row->id_evaluacion]["menor_tiempo"] = -1;
                }
                $infoEvaluacion[$row->id_evaluacion]["veces_intentado"] ++;
                if ($row->calificacion >= $umbral) {
                    $infoEvaluacion[$row->id_evaluacion]["veces_aprobado"] ++;
                }
                if ($infoEvaluacion[$row->id_evaluacion]["flag"] && $row->calificacion < $umbral) {
                    $infoEvaluacion[$row->id_evaluacion]["puntuacion"]-=10 - 10 * $row->calificacion;
                } else if ($infoEvaluacion[$row->id_evaluacion]["flag"]) {
                    $infoEvaluacion[$row->id_evaluacion]["puntuacion"] = MAX($valorMinimo, $infoEvaluacion[$row->id_evaluacion]["puntuacion"]);
                    $infoEvaluacion[$row->id_evaluacion]["flag"] = false;
                }
                if ($row->calificacion >= $umbral && $row->fecha_inicial != null && $row->fecha_final != null) {
                    $tiempo = strtotime($row->fecha_final) - strtotime($row->fecha_inicial);
                    if ($tiempo < $infoEvaluacion[$row->id_evaluacion]["menor_tiempo"] || $infoEvaluacion[$row->id_evaluacion]["menor_tiempo"] == -1) {
                        $infoEvaluacion[$row->id_evaluacion]["menor_tiempo"] = $tiempo;
                    }
                }
            }

            $evaluaciones = $this->evaluacion_model->obtenerEvaluacionesPorModulo($idModulo, $_SESSION["idUsuario"]);
//  var_dump($evaluaciones);
//  echo $this->db->last_query();
            $version=3;
            $estatusPrev = "solved";
            foreach ($evaluaciones as $row) {
                if ($row->calificacion_maxima >= $umbral && $row->calificacion_minima!=-1) {
                    $row->estatus = "solved";
                    $row->icono = "check";
                    $estatusPrev = "solved";
                    $row->ubicacion = base_url() . "resources/$idCurso/$idModulo/" . $row->id_evaluacion . "/launch.html?version=$version";
                    $row->veces_aprobado = $infoEvaluacion[$row->id_evaluacion]["veces_aprobado"];
                    $row->veces_intentado = $infoEvaluacion[$row->id_evaluacion]["veces_intentado"];
                    $row->puntuacion = $infoEvaluacion[$row->id_evaluacion]["puntuacion"];
                    $row->menor_tiempo = $infoEvaluacion[$row->id_evaluacion]["menor_tiempo"];
                }else if ($row->calificacion_maxima >= $umbral && $row->calificacion_minima==-1) {
                    $row->estatus = "solved";
                    $row->icono = "check";
                    $estatusPrev = "solved";
                    $row->ubicacion = base_url() . "resources/$idCurso/$idModulo/" . $row->id_evaluacion . "/launch.html?version=$version";
                    $row->veces_aprobado = $infoEvaluacion[$row->id_evaluacion]["veces_aprobado"];
                    $row->veces_intentado = $infoEvaluacion[$row->id_evaluacion]["veces_intentado"];
                    $row->puntuacion = 0;
                    $row->menor_tiempo = $infoEvaluacion[$row->id_evaluacion]["menor_tiempo"];
                } else if ($row->calificacion_minima == -1) {
                    $row->estatus = "solved";
                    $row->icono = "share";
                    $estatusPrev = "solved";
                    $row->ubicacion = base_url() . "resources/$idCurso/$idModulo/" . $row->id_evaluacion . "/launch.html?version=$version";
                    $row->veces_aprobado = $infoEvaluacion[$row->id_evaluacion]["veces_aprobado"];
                    $row->veces_intentado = $infoEvaluacion[$row->id_evaluacion]["veces_intentado"];
                    $row->puntuacion = 0;
                    $row->menor_tiempo = "--";
                } else if ($estatusPrev == "solved") {
                    $row->estatus = "open";
                    $row->icono = "candado-abierto";
                    $estatusPrev = "lock";
                    $row->ubicacion = base_url() . "resources/$idCurso/$idModulo/" . $row->id_evaluacion . "/launch.html?version=$version";
                    $row->veces_aprobado = "0";
                    $row->puntuacion = "0";
                    $row->menor_tiempo = "--";
                    if (isset($infoEvaluacion[$row->id_evaluacion])) {
                        $row->veces_intentado = $infoEvaluacion[$row->id_evaluacion]["veces_intentado"];
                    } else {
                        $row->veces_intentado = "0";
                    }
                } else {
                    $row->estatus = "lock";
                    $row->icono = "candado-cerrado";
                    $estatusPrev = "lock";
                    $row->ubicacion = "";
                    $row->veces_aprobado = "0";
                    $row->veces_intentado = "0";
                    $row->puntuacion = "0";
                    $row->menor_tiempo = "--";
                }
                if ($_SESSION["rol"] == 2 || $_SESSION["rol"] == 3) {
                    $row->estatus = "open";
                    $row->icono = "candado-abierto";
                    $row->ubicacion = base_url() . "resources/$idCurso/$idModulo/" . $row->id_evaluacion . "/launch.html?version=$version";
                }
            }


            $topN = $this->calcultarTopN($idModulo, 10, $idCurso);
            $cantidadEvaluaciones = sizeof($evaluaciones);

            $allModulos = $this->modulo_model->getModulos($idCurso);
            $imagenModulo = 1;
            foreach ($allModulos as $row) {
                if ($modulo[0]->id_modulo == $row->id_modulo) {
                    break;
                }
                $imagenModulo++;
            }
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12">
                        <?php if ($_SESSION["rol"] == 2) { ?>
                            <br>
                            <button class='btn btn-primary' data-toggle="modal" data-target="#modalCrearModulo">Crear módulo</button>
                            <button class='btn btn-primary' data-toggle="modal" data-target="#modalEditarModulo">Editar módulo</button>
                            <button class='btn btn-danger' data-toggle="modal" data-target="#modalEliminarModulo">Eliminar módulo</button>
                        <?php } ?>
                    </div>  
                </div> 
                <?php //if ($cantidadMateriales || $_SESSION["rol"] == 2) { ?>
                <div id="div-material" class="col-xs-12 col-sm-12 col-md-4  <?= ($_SESSION["rol"] == 2) ? "profesor" : "" ?>">
                    <div class="widget-box">
                        <div class="widget-header header-color-green2">
                            <?php if ($_SESSION["rol"] == 2) { ?>
                                <button title="Ordenar materiales" class="btn btn-default pull-right" data-toggle="modal" data-target="#modalOrdenarMaterial"> <i class="fa fa-plus"></i> Oredenar materiales</button>                  
                                <button title="Crear material" class="btn btn-default pull-right" data-toggle="modal" data-target="#modalCrearMaterial"> <i class="fa fa-plus"></i> Crear material</button>  
                            <?php } ?>
                            <img class="pull-left" src="<?= base_url() ?>assets/img/temas/default/icono-barra-materiales.png" height="38"><h4 class="lighter smaller">  Materiales</h4>
                        </div>
                        <div class="widget-body">
                            <div class="widget-main">
                                <table  id="lista-material" class="table table-hover">
                                    <?php
                                    $t = sizeof($materiales);
                                    $i = 1;
                                    foreach ($materiales as $row) {
                                        ?>
                                        <tr class="material" data-id-material="<?= $row->id_material ?>">
                                            <td class="tdIcono">
                                                <span class="  icono-<?= $row->extension ?>"></span>
                                            </td>
                                            <td class="no-padding-left">
                                                <span class="<?= $row->extension ?> link-material tip" data-ubicacion="<?= $row->ubicacion ?>" data-id-material="<?= $row->id_material ?>"  data-toggle="tooltip" data-placement="<?= ($i == $t) ? "top" : "bottom" ?>" title="<?= $row->descripcion ?>"><?= $row->nombre ?></span>
                                                <?php if ($row->visto) { ?><i class="fa fa-check"></i><span class="tiempo"><?= $row->tiempo_total ?>m</span> <?php } ?> 
                                                <br>  
                                                <div id="star-<?= $row->id_material ?>" class="estrellas" data-score="<?= $row->puntaje_promedio ?>" data-id-material="<?= $row->id_material ?>" data-comentario="<?= $row->comentario ?>"></div><span class="text-muted"> (<?= $row->total_valoraciones ?>)</span>
                                                <a href="#" class="ver-comentarios" data-id-material="<?= $row->id_material ?>" data-toggle="modal" data-target="#modalVerValoracionesMaterial">Ver comentarios</a> <span class="text-muted"> (<?= $row->total_comentarios ?>)</span>
                                            </td>
                                            <?php if ($_SESSION["rol"] == 2) { ?>
                                                <td class="min-with-estudiante">
                                                    <button title="Estadísticas" class="btn btn-primary btn-size-custom-1 estadisticasMaterial" data-id-material="<?= $row->id_material ?>" data-tipo="<?= $row->extension ?>"> <i class="fa fa-bar-chart-o"></i></button>
                                                    <button title="Editar" class="btn btn-warning btn-size-custom-1 editarMaterial" data-toggle="modal" data-target="#modalEditarMaterial" data-id-material="<?= $row->id_material ?>" data-nombre="<?= $row->nombre ?>" data-descripcion="<?= $row->descripcion ?>"> <i class="fa fa-pencil-square-o"></i></button>
                                                    <button title="Eliminar" class="btn btn-danger btn-size-custom-1 eliminarMaterial" data-toggle="modal" data-target="#modalEliminarMaterial" data-id-material="<?= $row->id_material ?>" data-nombre="<?= $row->nombre ?>"><i class="fa fa-trash-o"></i></button>
                                                </td>
                                            <?php } ?>
                                        <tr>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php // } ?>
                <div id="div-canvas"  class="col-xs-12 col-sm-12 col-md-3">
                    <center> <h3 ><?= $modulo[0]->nombre ?></h3>
                        <h4 class='text-muted'><?= $this->dateToView($modulo[0]->fecha_inicio) . " - " . $this->dateToView($modulo[0]->fecha_fin) ?></h4>
                    </center>
                    <div id="imagen" class="media-image">
                        <img src="../assets/img/temas/default/modulo<?= $imagenModulo ?>.png" class="media-image"  width="300">
                    </div>
                    <div id="opcionesModulo">

                                                                                                                                                                                                                                                                                                        <!--                    <a href="<?= base_url() ?>curso/<?= $idCurso ?>" class="btn btn-info" title="Ir atrás"><i class="fa fa-reply"></i></a>-->
                        <?= $topN ?><span title="Ver ranking" class="btn btn-info pull-right" onclick="loadRankingMod(this)" data-id-modulo="1" data-id-curso="1">
                            <i class="fa fa-trophy"></i> Ranking</span>
                    </div>
                </div>
                <?php // if ($cantidadEvaluaciones || $_SESSION["rol"] == 2) { ?>
                <div  id="div-evaluaciones" class="col-xs-12 col-sm-12 col-md-5">
                    <div id="container-evaluaciones" class="<?= ($_SESSION["rol"] == 2) ? "profesor-in" : "" ?>" >
                        <div class="widget-box">
                            <div class="widget-header header-color-green2">
                                <?php if ($_SESSION["rol"] == 2) { ?>
                                    <button title="Ordenar evaluaciones" id="ordenarEvaluaciones"  class="btn btn-default pull-right" data-toggle="modal" data-target="#modalOrdenarEvaluacion"> <i class="fa fa-plus"></i>  Ordenar evaluaciones</button>                  
                                    <button title="Crear evaluaciones" class="btn btn-default pull-right" data-toggle="modal" data-target="#modalCrearEvaluacion"> <i class="fa fa-plus"></i> Crear evaluación</button>                  
                                <?php } ?>
                                <img class="pull-left" src="<?= base_url() ?>assets/img/temas/default/icono-barra-evaluaciones.png" height="38">
                                <h4 class="lighter smaller">Evaluaciones
                                </h4>
                            </div>

                            <div class="widget-body ">
                                <div class="widget-main filas padding-8">
                                    <div class="row">
                                        <?php
                                        $t = sizeof($evaluaciones);
                                        $i = 1;
                                        /*  foreach ($evaluaciones as $row) {
                                          ?>
                                          <div class="box-evaluacion">

                                          </div>
                                          <div class="box-next">

                                          </div>
                                          <?php } */
                                        ?>
                                    </div>
                                    <?php ?>
                                    <center>
                                        <?php
                                        $t = sizeof($evaluaciones);
                                        $i = 1;
                                        foreach ($evaluaciones as $row) {
                                            if ($row->id_tipo_evaluacion == 1) {
                                                $tipo = "glyphicon-list";
                                            } else if ($row->id_tipo_evaluacion == 2) {
                                                $tipo = "glyphicon-pencil";
                                            } else if ($row->id_tipo_evaluacion == 3) {
                                                $tipo = "glyphicon-tower";
                                            }
                                            $materialesAosciados = $this->evaluacion_x_material_model->obtener(array("id_evaluacion" => $row->id_evaluacion));
                                            $class = "";
                                            foreach ($materialesAosciados as $row2) {
                                                $class.=" resaltar-evaluacion-{$row2->id_material}";
                                            }
                                            ?>
                                            <div class="box-evaluacion">
                                                <div id="evaluacion-<?= $row->id_evaluacion ?>" class="<?= $class ?> boxEvaluaciones2 <?= $row->estatus ?>" data-ubicacion="<?= $row->ubicacion ?>" data-id-evaluacion="<?= $row->id_evaluacion ?>">
                                                    <div class="icono fa fa-<?= $row->icono ?> fa-2x"></div>
                                                    <div class="numeroEvaluacion"><?= $i ?></div>
                                                    <?php if ($row->estatus != "lock") { ?>
                                                        <div class="tipo glyphicon <?= $tipo ?>"></div>
                                                    <?php } ?>
                                                    <div class="intentos"><?= $row->veces_aprobado ?>/<?= $row->veces_intentado ?></div>
                                                    <div class="puntaje"><?= $row->puntuacion ?><span class="glyphicon glyphicon-star"></span></div>
                                                    <div class="tiempo"><?= $row->menor_tiempo ?><span class="glyphicon glyphicon glyphicon-time"></span></div>
                                                </div>


                                                <?php if ($_SESSION["rol"] == 2) { ?>
                                                    <div class="opciones">
                                                        <button title="Estadísticas" class="btn btn-primary btn-size-custom-1 estadisticasEvaluacion" data-id-evaluacion="<?= $row->id_evaluacion ?>"> <i class="fa fa-bar-chart-o"></i></button>
                                                        <button title="Editar" class="btn btn-warning btn-size-custom-1 editarEvaluacion"  data-toggle="modal" data-target="#modalEditarEvaluacion"  data-id-evaluacion="<?= $row->id_evaluacion ?>" data-tipo="<?= $row->id_tipo_evaluacion ?>"> <i class="fa fa-pencil-square-o"></i></button>
                                                        <button title="Eliminar" class="btn btn-danger btn-size-custom-1 eliminarEvaluacion"  data-toggle="modal" data-target="#modalEliminarEvaluacion"  data-id-evaluacion="<?= $row->id_evaluacion ?>" data-numero="<?= $i ?>"><i class="fa fa-trash-o"></i></button>
                                                    </div>
                                                <?php } ?>

                                            </div>
                                            <div class="box-next">
                                                <?php if ($row->veces_intentado > 0 && $row->veces_aprobado == 0 && $row->calificacion_minima != -1) { ?>

                                                    <a class="btn btn-primary btn-size-custom-1 saltarEvaluacion pull-left" title="Saltar evalución" data-id-evaluacion="<?= $row->id_evaluacion ?>" data-toggle="popover" data-placement="bottom" data-content="Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum. Mei facer fabulas ut, id eum stet regione."> <i class="fa fa-share"></i></a>

                                                <?php } ?> 
                                            </div>   


                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </center>
                                    <?php ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php //}  ?>
                <?php
                if ($_SESSION["rol"] == 2) {
                    $ultimoModulo = $this->modulo_model->ultimoModulo($idCurso);
                    ?>
                    <div class="modal fade" id="modalCrearMaterial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post"  class="formSubmit"  action="<?= base_url() ?>material/crearMaterial" autocomplete="off"  enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Crear material</h4>
                                    </div>
                                    <div class="modal-body">

                                        <input type="hidden" name="modulo" required="" readonly="" value="<?= $idModulo ?>">
                                        <div class="control-group">
                                            <label>Nombre: <span class="text-danger">*</span></label>
                                            <div class="controls">
                                                <input required="" id="nombre" name="nombre" type="text" class="form-control" placeholder="" maxlength="128">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="control-group">
                                            <label>Descripción:</label>
                                            <div class="controls">
                                                <textarea name="descripcion" rows="4" type="text" class="form-control" placeholder="" maxlength="512"></textarea>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="control-group">
                                            <div class="controls">
                                                <label>Material: <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" readonly="">
                                                    <span class="input-group-btn">
                                                        <span class="btn btn-primary btn-file">
                                                            Seleccionar archivo<input type="file" name="file" accept=".pdf,.mp4"  required>
                                                        </span>
                                                    </span>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalEditarMaterial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post"  class="formSubmit"  action="<?= base_url() ?>material/editarMaterial" autocomplete="off"  enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Editar material</h4>
                                    </div>
                                    <div class="modal-body">

                                        <input type="hidden" name="modulo" required="" readonly="" value="<?= $idModulo ?>">
                                        <input type="hidden" id="inputIdMaterial" name="material" required="" readonly="">
                                        <div class="control-group">
                                            <label>Nombre: <span class="text-danger">*</span></label></label>
                                            <div class="controls">
                                                <input required="" id="editarNombreMaterial" name="nombre" type="text" class="form-control" placeholder="" maxlength="128" >
                                            </div>
                                        </div>
                                        <br>
                                        <div class="control-group">
                                            <label>Descripción:</label>
                                            <div class="controls">
                                                <textarea id="editarDescripcionMaterial" name="descripcion" rows="4" type="text" class="form-control" placeholder="" maxlength="512"></textarea>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="control-group">
                                            <div class="controls">
                                                <label>Material:</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" readonly="">
                                                    <span class="input-group-btn">
                                                        <span class="btn btn-primary btn-file">
                                                            Cambiar archivo<input type="file" name="file" accept=".pdf,.mp4">
                                                        </span>
                                                    </span>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalEliminarMaterial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="formSubmit" action="<?= base_url() ?>material/eliminarMaterial" autocomplete="off" >
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Eliminar material</h4>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="modulo" required="" readonly="" value="<?= $idModulo ?>">
                                        <input type="hidden" id="inputEliminarIdMaterial" name="material" required="" readonly="">
                                        <h5>Realmente desea eliminar el material: <span id="eliminarNombreMaterial" class="text-info"></span> ?</h5>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalOrdenarMaterial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="formSubmit" action="<?= base_url() ?>material/ordenarMaterial" autocomplete="off" >
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Ordenar materiales</h4>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="modulo" required="" readonly="" value="<?= $idModulo ?>">
                                        <input type="hidden" id="ordenMateriales" name="orden" required="" readonly="" >
                                        <ul id="sortableMateriales" class="sortable">
                                            <?php foreach ($materiales as $row) { ?>
                                                <li id="<?= $row->id_material ?>" class="ui-state-default"><?= $row->nombre ?></li>
                                            <?php } ?>
                                        </ul>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalCrearEvaluacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post"  class="formSubmit"  action="<?= base_url() ?>evaluacion/crearEvaluacion" autocomplete="off"  enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Crear evaluación</h4>
                                    </div>
                                    <div class="modal-body">

                                        <input type="hidden" name="modulo" required="" readonly="" value="<?= $idModulo ?>">
                                        <div class="control-group">
                                            <label>Tipo de evaluación: <span class="text-danger">*</span></label>
                                            <div class="controls">
                                                <select name="tipoEvaluacion" class="form-control" required>
                                                    <option value="">Seleccionar...</option>
                                                    <option value="1">Selección multiple</option>
                                                    <option value="2">Respuesta libre</option>
                                                    <option value="3">Desafio</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="control-group">
                                            <div class="controls">
                                                <label>Evaluación: <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" readonly="">
                                                    <span class="input-group-btn">
                                                        <span class="btn btn-primary btn-file">
                                                            Seleccionar archivo<input type="file" name="file" accept=".zip"  required>
                                                        </span>
                                                    </span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <hr>
                                                <b>Por favor seleccione los materiales con los cuales el estudiante podrá solucionar esta evaluación:</b>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php foreach ($materiales as $row) { ?>
                                                <div class="col-sm-12">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input name="materiales[]" value="<?= $row->id_material ?>" type="checkbox"><?= $row->nombre ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalEditarEvaluacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post"  class="formSubmit"  action="<?= base_url() ?>evaluacion/editarEvaluacion" autocomplete="off"  enctype="multipart/form-data">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Editar evaluación</h4>
                                    </div>
                                    <div class="modal-body">

                                        <input type="hidden"  name="modulo" required="" readonly="" value="<?= $idModulo ?>">
                                        <input type="hidden" id="inputIdEvaluacion" name="evaluacion" required="" readonly="">
                                        <div class="control-group">
                                            <label>Tipo de evaluación: <span class="text-danger">*</span></label>
                                            <div class="controls">
                                                <select id="editarTipoEvaluacion" name="tipoEvaluacion" class="form-control" required>
                                                    <option value="">Seleccionar...</option>
                                                    <option value="1">Selección multiple</option>
                                                    <option value="2">Respuesta libre</option>
                                                    <option value="3">Desafio</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="control-group">
                                            <div class="controls">
                                                <label>Evaluación: <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" readonly="">
                                                    <span class="input-group-btn">
                                                        <span class="btn btn-primary btn-file">
                                                            Seleccionar archivo<input type="file" name="file" accept=".zip" >
                                                        </span>
                                                    </span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <hr>
                                                <b>Por favor seleccione los materiales con los cuales el estudiante podrá solucionar esta evaluación:</b>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php foreach ($materiales as $row) { ?>
                                                <div class="col-sm-12">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input id="check-evaluacion-<?= $row->id_material ?>" name="materiales[]" class="input-check" value="<?= $row->id_material ?>" type="checkbox"><?= $row->nombre ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalEliminarEvaluacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="formSubmit" action="<?= base_url() ?>evaluacion/eliminarEvaluacion" autocomplete="off" >
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Eliminar evaluacion</h4>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="modulo" required="" readonly="" value="<?= $idModulo ?>">
                                        <input type="hidden" id="inputEliminarIdEvaluacion" name="evaluacion" required="" readonly="">
                                        <h5>Realmente desea eliminar la evaluación número: <span id="eliminarNumeroEvaluacion" class="text-info"></span> ?</h5>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalOrdenarEvaluacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="formSubmit" action="<?= base_url() ?>evaluacion/ordenarEvaluacion" autocomplete="off" >
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Ordenar evaluaciones</h4>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="modulo" required="" readonly="" value="<?= $idModulo ?>">
                                        <input type="hidden" id="ordenEvaluaciones" name="orden" required="" readonly="" >
                                        <ul id="sortableEvaluaciones" class="sortable">
                                            <?php
                                            $i = 1;
                                            foreach ($evaluaciones as $row) {
                                                ?>
                                                <li id="<?= $row->id_evaluacion ?>" class="ui-state-default"><?= $i++ ?></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalCrearModulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post"  class="formSubmit"  action="<?= base_url() ?>modulo/crearModulo" autocomplete="off">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Crear módulo</h4>
                                    </div>
                                    <div class="modal-body">

                                        <input type="hidden" name="curso" required="" readonly="" value="<?= $idCurso ?>">
                                        <div class="control-group">
                                            <label>Nombre: <span class="text-danger">*</span></label>
                                            <div class="controls">
                                                <input required="" id="nombre" name="nombre" type="text" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="control-group col-md-6">
                                                <label>Fecha inicial: <span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input required="" id="desde" name="desde" type="text" class="form-control datepicker" value="<?= $ultimoModulo[0]->fecha_fin ?>" placeholder="">
                                                </div>
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label>Fecha final: <span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input required="" id="hasta" name="hasta" type="text" class="form-control datepicker" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="control-group">
                                            <label>Descripción: <span class="text-danger">*</span></label>
                                            <div class="controls">
                                                <textarea required="" id="descripcion" rows="10" name="descripcion" class="form-control" placeholder=""></textarea>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalEditarModulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="formSubmit" action="<?= base_url() ?>modulo/editarModulo" autocomplete="off" >
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Editar módulo</h4>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="curso" required="" readonly="" value="<?= $idCurso ?>">
                                        <input type="hidden" id="editarIdModulo" name="idModulo" value="<?= $modulo[0]->id_modulo ?>" required="" readonly="">
                                        <div class="control-group">
                                            <label>Nombre: <span class="text-danger">*</span></label>
                                            <div class="controls">
                                                <input required="" id="editarNombreModulo" value="<?= $modulo[0]->nombre ?>" name="nombre" type="text" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="control-group col-md-6">
                                                <label>Fecha inicial: <span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input required="" id="editarDesdeModulo" id="desde" name="desde" value="<?= $modulo[0]->fecha_inicio ?>" type="text" class="form-control datepicker" placeholder="">
                                                </div>
                                            </div>
                                            <div class="control-group col-md-6">
                                                <label>Fecha final: <span class="text-danger">*</span></label>
                                                <div class="controls">
                                                    <input required="" id="editarHastaModulo" name="hasta" type="text" value="<?= $modulo[0]->fecha_fin ?>" class="form-control datepicker" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="control-group">
                                            <label>Descripción: <span class="text-danger">*</span></label>
                                            <div class="controls">
                                                <textarea required="" id="editarDescripcionModulo" rows="10" name="descripcion" class="form-control" placeholder=""><?= $modulo[0]->descripcion ?></textarea>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modalEliminarModulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" class="formSubmit" action="<?= base_url() ?>modulo/eliminarModulo" autocomplete="off" >
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Eliminar módulo</h4>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="curso" required="" readonly="" value="<?= $idCurso ?>">
                                        <input type="hidden" id="eliminarIdModulo" name="idModulo" value="<?= $modulo[0]->id_modulo ?>" required="" readonly="">
                                        <h5>Realmente desea eliminar el módulo: <span id="eliminarNombreModulo" class="text-info"><?= $modulo[0]->nombre ?></span> ?</h5>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <?php
        } else if ($_SESSION["rol"] == 2) {
            $idCurso = $this->input->get('idCurso');
            $curso = $this->curso_model->obtenerCurso($idCurso);
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12">
                        <br><br>
                        <center><button class='btn btn-primary' data-toggle="modal" data-target="#modalCrearModulo">Crear el primer módulo</button></center>
                    </div>  
                </div> 
            </div> 
            <div class="modal fade" id="modalCrearModulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post"  class="formSubmit"  action="<?= base_url() ?>modulo/crearModulo" autocomplete="off">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Crear módulo</h4>
                            </div>
                            <div class="modal-body">

                                <input type="hidden" name="curso" required="" readonly="" value="<?= $idCurso ?>">
                                <div class="control-group">
                                    <label>Nombre: <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        <input required="" id="nombre" name="nombre" type="text" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="control-group col-md-6">
                                        <label>Fecha inicial: <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input required="" id="desde" name="desde" type="text" class="form-control datepicker" value='<?= $curso[0]->fecha_inicio ?>' placeholder="">
                                        </div>
                                    </div>
                                    <div class="control-group col-md-6">
                                        <label>Fecha final: <span class="text-danger">*</span></label>
                                        <div class="controls">
                                            <input required="" id="hasta" name="hasta" type="text" class="form-control datepicker" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="control-group">
                                    <label>Descripción: <span class="text-danger">*</span></label>
                                    <div class="controls">
                                        <textarea required="" id="descripcion" rows="10" name="descripcion" class="form-control" placeholder=""></textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    private function calcultarTopN($idModulo, $n, $idCurso) {
        $topN = $this->usuario_x_modulo_model->obtenerTopN($idModulo, $n);
        $string = "";

        $i = 1;
        foreach ($topN as $row) {
            $string.="<img class='rank rank$i hide' title='Puesto: $i, Puntaje: {$row->puntaje},{$row->nombres} {$row->apellidos}' data-id-curso='$idCurso' data-id-modulo='$idModulo' data-id-estudiante='{$row->id_usuario}' data-nombre='{$row->nombres} {$row->apellidos}' data-puntaje='{$row->puntaje}' src='" . base_url() . "assets/img/avatares/thumbnails/{$row->imagen}'>";
            $i++;
        }
        $posiciones = $this->usuario_x_modulo_model->rankingModulo($idModulo);
        $i = 1;
        $posicion = "N/A";
        foreach ($posiciones as $row) {
            if ($row->id_usuario == $_SESSION["idUsuario"]) {
                $posicion = $i;
                break;
            }
            $i++;
        }
        return $string; // return $string . "<a id='link-posicion' >$posicion</a>";
    }

    public function matricularse($idCurso) {
        $curso = $this->curso_model->obtenerCursoCompleto($idCurso);
        if ($curso) {
            $this->load->model('usuario_x_curso_model');
            $where = array("id_curso" => $idCurso, "id_usuario" => $_SESSION["idUsuario"]);
            $validar = $this->usuario_x_curso_model->obtenerRegistro($where);
            if (!$validar) {
                $datos = array(
                    'id_curso' => $idCurso,
                    'id_usuario' => $_SESSION["idUsuario"],
                    'fecha' => date("Y-m-d H:i:s")
                );
                $this->usuario_x_curso_model->crear($datos);

                $datos = array(
                    'id_curso' => $idCurso,
                    'id_usuario' => $_SESSION["idUsuario"],
                    'id_nivel' => 1
                );
                $this->bitacora_nivel_model->crear($datos);
            }
            $usuario = $this->usuario_model->obtenerUsuario(array("id_usuario" => $_SESSION["idUsuario"]));
            $email = $usuario[0]->correo;

            enviarEmail($email, "Bienvenido al curso {$curso[0]->nombre}", "Te damos la bienvenida al curso {$curso[0]->nombre}");

            $this->mensaje("Se ha matriculado exitosamente", "success", "curso/$idCurso");
        } else {
            $this->mensaje("Por favor inténtalo nuevamente", "error");
        }
    }

    public function asesorias() {
        $idCurso = $this->input->post('idCurso');
        if (!$idCurso) {
            exit();
        }
        $this->load->model('usuario_x_curso_model');
        $monitores = $this->usuario_x_curso_model->obtenerMonitores($idCurso);
        ?>
        <table class='table table-bordered table-hover'>
            <th>Monitor</th>
            <th>Información de contacto</th>
            <?php
            foreach ($monitores as $row) {
                if($row->informacion_contacto!=""){
                ?>
                <tr>
                    <td><?= $row->nombres . " " . $row->apellidos ?></td>
                    <td><?= $row->informacion_contacto ?></td>
                </tr>
                <?php
                }
            }
            ?>
        </table>
        <?php
    }

}
