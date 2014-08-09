<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->model('curso_model');
        $this->load->model('usuario_model');
        $this->load->model('modulo_model');
        $this->load->model('usuario_x_curso_model');
        $this->load->model('usuario_x_evaluacion_model');
        $this->load->model('bitacora_model');
        $this->load->model('usuario_curso_logro_model');
        $this->load->model('nivel_model');
        $this->load->model('usuario_x_modulo_model');
        $this->load->model('reto_model');
    }

    public function info() {

        $this->escapar($_GET);
        if (empty($_GET["idCurso"]) || empty($_GET["idUsuario"])) {
            exit();
        }
        $idCurso = $_GET["idCurso"];
        $idUsuario = $_GET["idUsuario"];
        $usuario = $this->usuario_model->obtenerUsuario(array("id_usuario" => $idUsuario));
        $data = array("id_curso" => $idCurso, "id_usuario" => $idUsuario);
        $matricula = $this->usuario_x_curso_model->obtenerRegistroCompleto($data);
        $this->verificarMatricula($idCurso);
        $puntajePorModulo = $this->modulo_model->puntajePorModuloPorCurso($idCurso, $idUsuario);
        $tiempo = $this->bitacora_model->obtenerTiempoLogueado($idUsuario, $idCurso);
        $tiempo = round($tiempo[0]->tiempo, 1);
        $escala = "horas";
        if ($tiempo >= 24) {
            $tiempo = round(($tiempo / 24), 1);
            $escala = "días";
        }
        $lastLogin = $this->bitacora_model->lastLogin($idUsuario);
        if (!$lastLogin) {
            $lastLogin = "n/a";
        } else {
            $lastLogin = $lastLogin[0]->fecha_ingreso;
        }
        $logros = $this->usuario_curso_logro_model->logrosPorUsuario($idUsuario);

        $puntajeTotal = 0;
        foreach ($puntajePorModulo as $row) {
            $puntajeTotal+=$row->puntaje;
        }

        $posiciones = $this->usuario_x_modulo_model->rankingCurso($idCurso);
        $i = 1;
        $posicion = "n/a";
        foreach ($posiciones as $row) {
            if ($row->id_usuario == $idUsuario) {
                $posicion = $i;
                break;
            }
            $i++;
        }
        $cantidadDuelos = $this->reto_model->cantidadRetosUsuario($idUsuario, $idCurso);
        $cantidadDuelos = $cantidadDuelos[0]->cantidad;
        $cantidadDuelosGanados = $this->reto_model->cantidadRetosUsuarioGanados($idUsuario, $idCurso);
        $cantidadDuelosGanados = $cantidadDuelosGanados[0]->cantidad;

        if ($cantidadDuelos == 0) {
            $porcentajeDuelosganados = 0;
        } else {
            $porcentajeDuelosganados = round($cantidadDuelosGanados / $cantidadDuelos * 100);
        }
        if ($usuario[0]->sexo == "m") {
            $rutaImagenNivel = base_url() . "assets/img/niveles/hombre/{$matricula[0]->imagen}";
        } else {
            $rutaImagenNivel = base_url() . "assets/img/niveles/mujer/{$matricula[0]->imagen}";
        }
        $nivel = $this->nivel_model->obtener(array("id_nivel" => $matricula[0]->id_nivel));
        ?>

        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <img class="featurette-image img-responsive col-xs-12" src="<?= base_url() . "assets/img/avatares/thumbnails/{$usuario[0]->imagen}"; ?>">
            </div>
            <div class="col-xs-12 col-sm-8">
                <div class="row">
                    <div class="col-xs-12">
                        <?= $usuario[0]->nombres . " " . $usuario[0]->apellidos ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <em class="text-muted"> <?= $usuario[0]->correo ?></em>
                    </div>
                </div>
                <div class="row">
                    <?php if ($logros) { ?>
                        <div id="myCarousel" class="carousel slide">
                            <!-- Carousel items -->
                            <div class="carousel-inner">
                                <?php
                                $i = 0;
                                foreach ($logros as $row) {
                                    if ($i == 0) {
                                        echo "<div class='item active'>  <div class='row'>";
                                    } else if ($i % 4 == 0) {
                                        echo "<div class='item'><div class='row'>";
                                    }
                                    ?>

                                    <div class="col-sm-3"><a href="#x" title="Nombre: <?= $row->nombre ?>. Descripción: <?= $row->descripcion ?>."><img src="<?= base_url() . "assets/img/logro/{$row->id_logro}.png " ?> " alt="Image" class="img-responsive"></a>
                                    </div>

                                    <!--/row-->
                                    <?php
                                    if ($i != 0 && ($i + 1) % 4 == 0) {
                                        echo " </div></div>";
                                    }
                                    $i++;
                                }
                                if (($i ) % 4 != 0) {
                                    echo " </div></div>";
                                }
                                ?>


                            </div>
                            <?php if (sizeof($logros) > 4) { ?>
                                <!-- Controls -->
                                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                </a>
                                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                </a>
                            <?php } ?>
                        </div>
                        <!--/myCarousel-->
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-7">
                <div class="row">

                    <div class="col-xs-12">
                        <hr>
                        Puntaje total: <?= $puntajeTotal ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <hr>
                        Posición general: <?= $posicion ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <hr>
                        Duelos: <?= $cantidadDuelosGanados ?>/<?= $cantidadDuelos ?> <?= $porcentajeDuelosganados ?>%
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <table id="tabla-puntaje-modulos"  class="table-striped table-bordered table-condensed table-hover table-responsive">
                                <tr>
                                    <td><b>Módulo</b></td>
                                    <td><b>Puntaje</b></td>
                                </tr>
                            <?php foreach ($puntajePorModulo as $row) { ?>
                                <tr>
                                    <td>
                                        <?= $row->nombre ?>
                                    </td>
                                    <td>
                                        <?= $row->puntaje ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-5">
                <img class="featurette-image img-responsive col-xs-12" src="<?= $rutaImagenNivel ?>">
                <center>      Nivel: <?= $nivel[0]->nombre ?></center>
            </div>
        </div>

        <?php
    }

}
