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
        $puntajePorModulo = $this->modulo_model->puntajePorModuloPorCurso($idCurso);
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
        ?>



        <table class="table">
             <tr>
                <td>Nivel</td>
                <td> <img class="pull-left" height="60" src="<?= base_url() . "assets/img/niveles/{$matricula[0]->imagen}"; ?>"> <h3 class="pull-left"><?= $matricula[0]->nombre ?></h3></td>
            </tr>
            <tr>
                <td>Nombre:</td>
                <td><?= $usuario[0]->nombres . " " . $usuario[0]->apellidos ?></td>
            </tr>
            <tr>
                <td>Avatar:</td>
                <td><img height="100" src="<?= base_url() . "assets/img/avatares/thumbnails/{$usuario[0]->imagen}"; ?>"></td>
            </tr>
            <?php if (sizeof($logros) > 0) { ?>
                <tr>
                    <td> Logros:</td>
                    <td> <?php foreach ($logros as $row) { ?>
                            <img height="60" src="<?= base_url() . "assets/img/logro/{$row->id_logro}.png"; ?>">
                        <?php } ?></td>
                </tr>
            <?php } ?>

            <tr>
                <td>Tiempo logueado:</td>
                <td><?= $tiempo . " " . $escala ?></td>
            </tr>
            <tr>
                <td>Correo:</td>
                <td><?= $usuario[0]->correo ?></td>
            </tr>
           
            <tr>
                <td>Módulo</td>
                <td>Puntaje</td>
            </tr>
            <?php
            foreach ($puntajePorModulo as $row) {
                ?>
                <tr>
                    <td> <?= $row->nombre ?>:</td>
                    <td><?= $row->puntaje ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>


        <?php
    }

}
