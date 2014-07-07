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
        $this->load->model('estudiante_model');
        $this->load->model('nivel_model');
        $this->load->model('bitacora_model');
        $this->load->model('usuario_model');
        $this->load->model('modulo_model');
        $this->load->model('usuario_x_material_model');
        $this->load->model('usuario_x_evaluacion_model');
    }

    public function index($idCurso = -1) {
        if ($idCurso == -1)
            show_404();
        $this->soyElProfesor($idCurso);
        $data["idCurso"] = $idCurso;
        $data["tab"] = "estadisticaestudiantes";
        $data["js"] = array("libs/googleCharts/jsapi", "js/estadisticas/estudiante");
        $curso = $this->curso_model->obtenerCursoCompleto($idCurso);
        $data["nombre_curso"] = $curso[0]->nombre;
        $data["fechaInicio"] = $curso[0]->fecha_inicio;
        $data["nivelesCurso"] = $curso[0]->niveles;

        $data["cantidadMatriculas"] = $this->usuario_x_curso_model->cantidadEstudiantesMatriculados($idCurso);
        $data["cantidadMatriculas"] = $data["cantidadMatriculas"][0]->cantidad;

        $data["distribucionNiveles"] = $this->estudiante_model->distribucionNiveles($idCurso);

        $this->distribucionNivelesPorDia($data);

        $this->estudiantesConectados($data);

        $this->load->view('include/header', $data);
        $this->load->view('estadisticas/estudianteV');
        $this->load->view('include/footer');
    }

    function distribucionNivelesPorDia(&$data) {
        $distribucionNivelesPorDia = $this->estudiante_model->distribucionNivelesPorDia($data["idCurso"]);
        $datos = array();
        foreach ($distribucionNivelesPorDia as $row) {
            $datos[$row->fecha_aux][$row->id_nivel] = $row->cantidad;
        }

        $data["distribucionNivelesPorDia"] = $datos;
        $data["niveles"] = $this->nivel_model->getNiveles($data["nivelesCurso"]);
    }

    function estudiantesConectados(&$data) {
        $data["cantidadEstudiantesConectados"] = $this->bitacora_model->cantidadEstudiantesConectados($data["idCurso"]);
        $data["cantidadEstudiantesConectados"] = $data["cantidadEstudiantesConectados"][0]->cantidad;
    }

    public function infoestudiante($idUsuario, $idCurso) {

        $this->soyElProfesor($idCurso);


        $data["idCurso"] = $idCurso;
        $data["tab"] = "ranking";
        $data["js"] = array("libs/raty/lib/jquery.raty.min", "js/infoestudiante");
        $curso = $this->curso_model->obtenerCursoCompleto($idCurso);
        $data["nombre_curso"] = $curso[0]->nombre;
        $data["usuario"] = $this->usuario_x_curso_model->obtenerRegistroConEstudiante($idUsuario, $idCurso);

        $data["modulos"] = $this->modulo_model->obtenerModulos(array("id_curso" => $idCurso));

        foreach ($data["modulos"] as $row) {
            $data["materiales"][$row->id_modulo] = $this->usuario_x_material_model->obtenerMateriales($row->id_modulo, $idUsuario);
            $data["evaluaciones"][$row->id_modulo] = $this->usuario_x_evaluacion_model->obtenerEvaluaciones($idCurso,$row->id_modulo, $idUsuario);
        }

        $this->load->view('include/header', $data);
        $this->load->view('estadisticas/infoestudianteV');
        $this->load->view('include/footer');
    }

}
