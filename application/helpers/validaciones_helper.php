<?php

if (!function_exists('validarProfesor')) {


    function validarProfesor($idCurso, $idUsuario) {
        $CI = & get_instance();
        $CI->load->model('curso_model');
        $curso = $CI->curso_model->obtenerCursoPorProfesor(array("id_curso" => $idCurso, "id_usuario" => $idUsuario));
        if ($curso) {
            return true;
        } else {
            return false;
        }
    }

}


