<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Evaluacion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->estoyLogueado();
        $this->load->model('curso_model');
        $this->load->model('evaluacion_model');
        $this->load->model('usuario_x_curso_model');
    }

    public function index($idCurso = -1) {
        if ($idCurso == -1)
            show_404();
        $this->soyElProfesorOMonitor($idCurso);
        $data["idCurso"] = $idCurso;
        $data["tab"] = "estadisticaevaluaciones";
        $data["js"] = array("libs/googleCharts/jsapi", "js/estadisticas/evaluacion");
        $curso = $this->curso_model->obtenerCursoCompleto($idCurso);
        $data["nombre_curso"] = $curso[0]->nombre;
        $data["fechaInicio"] = $curso[0]->fecha_inicio;
//        $data["cantidadMatriculas"] = $this->usuario_x_curso_model->cantidadEstudiantesMatriculados($idCurso);
//        $data["cantidadMatriculas"] = $data["cantidadMatriculas"][0]->cantidad;
        $data["totalEvaluaciones"] = $this->evaluacion_model->obtenerTotalEvaluacionesCurso($idCurso);
        $data["totalEvaluaciones"] = $data["totalEvaluaciones"][0]->total;

        $data['cantidadPreguntasIntentadasPorDia'] = $this->evaluacion_model->cantidadPreguntasIntentadasPorDia($idCurso);
        $datos = array();
        foreach ($data['cantidadPreguntasIntentadasPorDia'] as $row) {
            $datos[$row->fecha] = $row->cantidad;
        }
        $data['cantidadPreguntasIntentadasPorDia'] = $datos;

        $data['cantidadPreguntasResueltasPorDia'] = $this->evaluacion_model->cantidadPreguntasResueltasPorDia($idCurso);
        $datos = array();
        foreach ($data['cantidadPreguntasResueltasPorDia'] as $row) {
            $datos[$row->fecha] = $row->cantidad;
        }
        $data['cantidadPreguntasResueltasPorDia'] = $datos;


        $this->load->view('include/header', $data);
        $this->load->view('estadisticas/evaluacionV');
        $this->load->view('include/footer');
    }

}
