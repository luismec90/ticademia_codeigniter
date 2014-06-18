<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inicio extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->model('curso_model');
        session_start();
    }

    public function index() {
        $data["tab"] = "inicio";
        $data["css"] = array("css/inicio");
        $data["js"] = array("js/inicio");
       
        $data["cursos"] = $this->curso_model->obtenerCursos();

        foreach ($data["cursos"] as $row) {
            $datetime1 = new DateTime($row->fecha_inicio);
            $datetime2 = new DateTime($row->fecha_fin);
            $interval = $datetime1->diff($datetime2);
            $row->duracion = floor($interval->format('%a') / 7);
        }

        $this->load->view('include/header', $data);
        $this->load->view('inicio_view');
        $this->load->view('include/footer');
    }

}
