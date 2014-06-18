<div id="contenedor">

    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">

            </div>  
        </div> 
        <?php if ($cantidadMateriales || $_SESSION["rol"] == "profesor") { ?>
            <div id="div-material" class="col-xs-12 col-sm-12 <?= ($cantidadEvaluaciones || $_SESSION["rol"] == "profesor") ? "col-md-4" : "col-md-9" ?> <?= ($_SESSION["rol"] == "profesor") ? "profesor" : "" ?>">
                <div class="widget-box">
                    <div class="widget-header header-color-green2">
                        <?php if ($_SESSION["rol"] == "profesor") { ?>

                            <button title="Ordenar materiales" class="btn btn-default pull-right" data-toggle="modal" data-target="#modalOrdenarMaterial"> <i class="fa fa-plus"></i> Oredenar materiales</button>                  
                            <button title="Crear material" class="btn btn-default pull-right" data-toggle="modal" data-target="#modalCrearMaterial"> <i class="fa fa-plus"></i> Crear material</button>  
                        <?php } ?>
                        <h4 class="lighter smaller">Materiales</h4>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">

                            <table  id="lista-material" class="table table-hover">
                                <?php
                                $t = sizeof($materiales);
                                $i = 1;
                                foreach ($materiales as $row) {
                                    ?>
                                    <tr>
                                        <td class="tdIcono">
                                            <img class="icono  icono-<?= $row->extension ?>">
                                        </td>
                                        <td class="no-padding-left">
                                            <span class="<?= $row->extension ?> link-material" data-ubicacion="<?= $row->ubicacion ?>" data-id-material="<?= $row->id_material ?>"  data-toggle="popover" data-placement="<?= ($i == $t) ? "top" : "bottom" ?>" data-content="<?= $row->descripcion ?>"><?= $row->nombre ?></span>
                                            <?php if ($row->visto) { ?><i class="fa fa-check"></i><span class="tiempo"><?= $row->tiempo_total ?>m</span> <?php } ?> 
                                            <br>  
                                            <div id="star-<?= $row->id_material ?>" class="estrellas" data-score="<?= $row->puntaje_promedio ?>" data-id-material="<?= $row->id_material ?>" data-comentario="<?= $row->comentario ?>"></div><span class="text-muted"> (<?= $row->total_valoraciones ?>)</span>
                                            <a href="#" class="ver-comentarios" data-id-material="<?= $row->id_material ?>" data-toggle="modal" data-target="#modalVerValoracionesMaterial">Ver comentarios</a> <span class="text-muted"> (<?= $row->total_comentarios ?>)</span>
                                        </td>
                                        <?php if ($_SESSION["rol"] == "profesor") { ?>
                                            <td class="min-with-estudiante">
                                                <button title="Editar material" class="btn btn-warning btn-size-custom-1 editarMaterial" data-toggle="modal" data-target="#modalEditarMaterial" data-id-material="<?= $row->id_material ?>" data-nombre="<?= $row->nombre ?>" data-descripcion="<?= $row->descripcion ?>"> <i class="fa fa-pencil-square-o"></i></button>
                                                <button title="Eliminar material" class="btn btn-danger btn-size-custom-1 eliminarMaterial" data-toggle="modal" data-target="#modalEliminarMaterial" data-id-material="<?= $row->id_material ?>" data-nombre="<?= $row->nombre ?>"><i class="fa fa-trash-o"></i></button>
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
        <?php } ?>
        <div id="div-canvas"  class="col-xs-12 col-sm-12 col-md-3">
            <div id="imagen" class="media-image">
                <img src="../assets/img/p2.png" class="media-image">
            </div>
            <div id="opcionesModulo">

                <a href="<?= base_url() ?>curso/<?= $idCurso ?>" class="btn btn-info" title="Ir atrás"><i class="fa fa-reply"></i></a>
                <?= $topN ?><span title="Ver ranking" class="btn btn-info pull-right" onclick="loadRankingMod(this)" data-id-modulo="1" data-id-curso="1">
                    <i class="fa fa-trophy"></i> Ranking</span>
            </div>
        </div>
        <?php if ($cantidadEvaluaciones || $_SESSION["rol"] == "profesor") { ?>
            <div  id="div-evaluaciones" class="col-xs-12 col-sm-12 <?= ($cantidadMateriales || $_SESSION["rol"] == "profesor") ? "col-md-5" : "col-md-9" ?>">
                <div id="container-evaluaciones" >
                    <div class="widget-box">
                        <div class="widget-header header-color-green2">
                            <?php if ($_SESSION["rol"] == "profesor") { ?>
                                <button title="Ordenar evaluaciones" id="ordenarEvaluaciones"  class="btn btn-default pull-right" data-toggle="modal" data-target="#modalOrdenarEvaluacion"> <i class="fa fa-plus"></i>  Ordenar evaluaciones</button>                  
                                <button title="Crear evaluaciones" class="btn btn-default pull-right" data-toggle="modal" data-target="#modalCrearEvaluacion"> <i class="fa fa-plus"></i> Crear evaluación</button>                  


                            <?php } ?>
                            <h4 class="lighter smaller">Evaluaciones


                            </h4>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main filas padding-8">
                                <div class="row">
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
                                        ?>
                                        <div class="boxEvaluaciones">
                                            <div id="evaluacion-<?= $row->id_evaluacion ?>" class="boxEvaluaciones2 <?= $row->estatus ?>" data-ubicacion="<?= $row->ubicacion ?>" data-id-evaluacion="<?= $row->id_evaluacion ?>">
                                                <div class="icono fa fa-<?= $row->icono ?> fa-2x"></div>     
                                                <div class="numeroEvaluacion"><?= $i ?></div>
                                                <?php if ($row->estatus != "lock") { ?>
                                                    <div class="tipo glyphicon <?= $tipo ?>"></div>
                                                <?php } ?>
                                                <div class="intentos"><?= $row->veces_aprobado ?>/<?= $row->veces_intentado ?></div>
                                                <div class="puntaje"><?= $row->puntuacion ?><span class="glyphicon glyphicon-star"></span></div>
                                                <div class="tiempo"><?= $row->menor_tiempo ?><span class="glyphicon glyphicon glyphicon-time"></span></div>
                                            </div>
                                            <?php if ($_SESSION["rol"] == "profesor") { ?>
                                                <div class="opciones">
                                                    <button title="Editar material" class="btn btn-warning btn-size-custom-1 editarEvaluacion"  data-toggle="modal" data-target="#modalEditarEvaluacion"  data-id-evaluacion="<?= $row->id_evaluacion ?>" data-tipo="<?= $row->id_tipo_evaluacion ?>"> <i class="fa fa-pencil-square-o"></i></button>
                                                    <button title="Eliminar material" class="btn btn-danger btn-size-custom-1 eliminarEvaluacion"  data-toggle="modal" data-target="#modalEliminarEvaluacion"  data-id-evaluacion="<?= $row->id_evaluacion ?>" data-numero="<?= $i ?>"><i class="fa fa-trash-o"></i></button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<div id="contenedor-video" class="hide">
    <div id="botonCerrarVideo" title="Cerrar">
        <i class="fa fa-times fa-2x"></i> 
    </div>
    <video id="video" width="900" height="510" src="test.mp4" ></video>
</div>
<div id="contenedor-pdf" class="hide">
    <div id="botonCerrarPdf"  title="Cerrar">
        <i class="fa fa-times fa-2x"></i> 
    </div>
    <embed id="pdf" src="">
</div>
<div id="contenedor-frame" class="hide">
    <div id="botonCerrarFrame">
        <i class="fa fa-times fa-2x"></i> 
    </div>
    <iframe width="100%" id="frame" src="" height="90%"></iframe>
    <script src="<?= base_url() ?>assets/libs/jQuery-1.11.0/jQuery.min.js"></script>
    <script src="<?= base_url() ?>assets/js/api.js"></script>
</div>
<div id="custom-popover" class="popover fade top in">
    <div class="arrow"></div><h3 class="popover-title"><div id="popover-titulo" ></div><button id="cerrar-popover" type="button" class="close">&times;</button> </h3>
    <div id="popover-contenido" class="popover-content">bla bla <br> bla bla<br>bla bla
    </div>
</div>
<?php if ($_SESSION["rol"] == "profesor") { ?>
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
                                <label>Material: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" readonly="">
                                    <span class="input-group-btn">
                                        <span class="btn btn-primary btn-file">
                                            Cambiar archivo<input type="file" name="file" accept=".pdf,.mp4" required>
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
                                            Seleccionar archivo<input type="file" name="file" accept=".zip"  required>
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


<?php } ?>

<div class="modal fade" id="modalValoracionMaterial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" class="formSubmit" action="<?= base_url() ?>material/valorarMaterial" autocomplete="off" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Valorar material <div id="preview-stars"></div></h4>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="idMaterial" name="idMaterial" required="" readonly="" >
                    <textarea rows="5" id="comentario" class="form-control" name="comentario" placeholder="Comentario"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="modalVerValoracionesMaterial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Comentarios del material <div id="preview-stars"></div></h4>
            </div>

            <div id="modal-body-ver-valoraciones" class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>