<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Estudiante extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->estoyLogueado();
        $this->load->model('curso_model');
        $this->load->model('usuario_x_curso_model');
    }

    public function index($idCurso = -1) {
        if ($idCurso == -1)
            show_404();
        $this->soyElProfesor($idCurso);
        $data["idCurso"] = $idCurso;
        $data["tab"] = "estadisticaestudiantes";
        $curso = $this->curso_model->obtenerCursoCompleto($idCurso);
        $data["nombre_curso"] = $curso[0]->nombre;

        $data["cantidadMatriculas"] = $this->usuario_x_curso_model->cantidadEstudiantesMatriculados($idCurso);
        $data["cantidadMatriculas"] = $data["cantidadMatriculas"][0]->cantidad;

        $this->load->view('include/header', $data);
        $this->load->view('estadisticas/estudianteV');
        $this->load->view('include/footer');
    }

}
