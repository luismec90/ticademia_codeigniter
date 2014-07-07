<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Material extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->estoyLogueado();
        $this->load->model('curso_model');
        $this->load->model('material_model');
    }

    public function index($idCurso = -1) {
        if ($idCurso == -1)
            show_404();
        $this->soyElProfesor($idCurso);
        $data["idCurso"] = $idCurso;
        $data["tab"] = "estadisticamateriales";
        $data["js"] = array("libs/googleCharts/jsapi", "js/estadisticas/material");
        $curso = $this->curso_model->obtenerCursoCompleto($idCurso);
        $data["nombre_curso"] = $curso[0]->nombre;
        $data["fechaInicio"] = $curso[0]->fecha_inicio;

        $data["cantidadPDFs"] = $this->material_model->cantidadPDFs($idCurso);
        $data["cantidadVideos"] = $this->material_model->cantidadVideos($idCurso);

        $data["pdfVisitas"] = $this->material_model->visitasPorDiaPdfs($idCurso);
        $data["videoVisitas"] = $this->material_model->visitasPorDiaVideos($idCurso);

        $data["tiempoPromedioReproduccion"] = $this->material_model->tiempoPromdedioReproduccion($idCurso);
        $this->load->view('include/header', $data);
        $this->load->view('estadisticas/materialV');
        $this->load->view('include/footer');
    }

}
