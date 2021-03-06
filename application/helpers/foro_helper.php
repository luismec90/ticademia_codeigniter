<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('tabForo')) {

    function tabForo($idCurso) {
        $CI = & get_instance();
        $CI->load->model('tema_foro_model');
        $CI->load->model('bitacora_model');
        $lastLogin = $CI->bitacora_model->penultimoAcceso($_SESSION["idUsuario"], $idCurso);
        if ($lastLogin) {
            $lastLogin = $lastLogin[0]->fecha_ingreso;
        } else {
            $lastLogin = "0000-00-00 00:00:00";
        }
        $ultimaActividad = $CI->tema_foro_model->ultimaActividad($idCurso, $lastLogin);
        if ($ultimaActividad) {
            ?>
            <a  title="Foro" href="#" class="dropdown-toggle" data-toggle="dropdown"> <img id="icono-foro" src="<?= base_url() ?>assets/img/temas/default/foro.png" height="30"> <?= sizeof($ultimaActividad) ?> <b class="caret white"></b></span></a> 
            <ul class="dropdown-menu">
                <li class="dropdown-header">Desde tu última visita esto ha acontecido</li>
                <li class="divider"></li>
                <?php
                foreach ($ultimaActividad as $row) {
                    if ($row->tipo == "tipotema") {
                        ?>
                        <li><a href="<?= base_url() ?>foro/<?= $idCurso . "/" . $row->id_tema_foro ?>"><span class="text-info"><?= $row->nombres . " " . $row->apellidos ?></span> creó un tema: <small class="text-info">( <?= substr($row->nombre, 0, 10) ?>... )</small></a></li>
                    <?php } else { ?>
                        <li><a href="<?= base_url() ?>foro/<?= $idCurso . "/" . $row->id_tema_foro ?>"><span class="text-info"><?= $row->nombres ?></span> respondió un tema: <small class="text-info">( <?= substr($row->nombre, 0, 10) ?>... )</small></a></li>
                        <?php
                    }
                }
                ?>
                <li class="divider"></li>
                <li><a href="<?= base_url() ?>foro/<?= $idCurso ?>">Ir al foro</a></li>
            </ul>
            <?php
        } else {
            ?>
            <a title="Foro" href="<?= base_url() ?>foro/<?= $idCurso ?>" > <img id="icono-foro" src="<?= base_url() ?>assets/img/temas/default/foro.png" height="30" ></a> 
            <?php
        }
    }

}


