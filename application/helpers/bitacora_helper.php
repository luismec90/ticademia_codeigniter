<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('index_bitacora')) {

    function index_bitacora($idCurso) {
        $CI = & get_instance();
        $CI->load->model('bitacora_model');
        if (isset($_SESSION["ultimaActividad"])) {
            $datos = explode("|", $_SESSION["ultimaActividad"]);
            $idCursoPrev = $datos[0];
            $hora = $datos[1];
            $id = $datos[2];
            if ($idCurso == $idCursoPrev) {
                $where = array("id_bitacora" => $id);
                $CI->bitacora_model->actializarRegistro($where);
            } else {
                $data = array("id_curso" => $idCurso,
                    "id_usuario" => $_SESSION["idUsuario"]);
                $lastId = $CI->bitacora_model->crearRegistro($data);
                $_SESSION["ultimaActividad"] = $idCurso . "|" . date("Y-m-d H:i:s") . "|" . $lastId;
            }
        } else {
            $data = array("id_curso" => $idCurso,
                "id_usuario" => $_SESSION["idUsuario"]);
            $lastId = $CI->bitacora_model->crearRegistro($data);
            $_SESSION["ultimaActividad"] = $idCurso . "|" . date("Y-m-d H:i:s") . "|" . $lastId;
          
        }
         
    }

}


