<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reporte extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->estoyLogueado();
        $this->load->model('curso_model');
        $this->load->model('modulo_model');
    }

    public function index($idCurso = - 1)
    {
        if ($idCurso == - 1)
            show_404();
        $this->soyElProfesorOMonitor($idCurso);
        $data["idCurso"] = $idCurso;
        $data["tab"] = "reporte";
        $curso = $this->curso_model->obtenerCursoCompleto($idCurso);
        $data["nombre_curso"] = $curso[0]->nombre;
        $data["modulos"] = $this->modulo_model->getModulos($idCurso);


        $this->load->view('include/header', $data);
        $this->load->view('estadisticas/reporteV');
        $this->load->view('include/footer');
    }

    public function excel()
    {
        $idCurso = $_POST["idCurso"];
        $idModulo = $_POST["modulo"];
        $this->soyElProfesorOMonitor($idCurso);

        $curso = $this->curso_model->obtenerCurso($idCurso);
        $umbral = $curso[0]->umbral;

        $modulo = $this->modulo_model->obtenerModulo($idModulo);
        $cantidadEvaluaciones = $this->modulo_model->cantidadEvaluaciones($idModulo);
        $cantidadEvaluaciones = $cantidadEvaluaciones[0]->cantidad;

        if ($idModulo == 21)
        {
            $modulo[0]->fecha_fin = $modulo[0]->fecha_fin . " 12:02:00";
        } else
        {
            $modulo[0]->fecha_fin = $modulo[0]->fecha_fin . " 23:59:59";
        }

        $reporte = $this->modulo_model->reporteTotal($idModulo, $modulo[0]->fecha_fin, $cantidadEvaluaciones, $umbral);

        $this->load->library('export');

        $this->export->to_excel($reporte, 'reporte_' . date("Y-m-d H:i:s"));
    }

}
