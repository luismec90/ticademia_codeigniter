<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('tabForo')) {

    function tabForo($idCurso) {
        $CI = & get_instance();
        $CI->load->model('tema_foro_model');
        $ultimaActividad = $CI->tema_foro_model->ultimaActividad($idCurso);
        if ($ultimaActividad) {
            ?>
            <a  id="link-foro-color" title="Ver foro" href="#" class="dropdown-toggle white" data-toggle="dropdown"> <i class="icon-position fa fa-comments icon-animated-vertical"></i> <?= sizeof($ultimaActividad) ?> <b class="caret white"></b></a> 
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
            <a  id="link-foro-color" title="Ver foro" href="<?= base_url() ?>foro/<?= $idCurso ?>" class="white"> <i class="icon-position fa fa-comments icon-animated-vertical"></i></a> 
            <?php
        }
    }

}


