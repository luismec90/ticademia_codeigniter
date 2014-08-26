<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('evaluacion_model');
    }

    public function index() {
        echo "asd";
        exit();
        $orden = 10;
        for ($i = 74; $i < 104; $i++) {
            $data = array("id_evaluacion" => $i,
                "id_modulo" => 18,
                "id_tipo_evaluacion" => 3,
                "orden" => $orden++);
            $this->evaluacion_model->crear($data);
        }
    }

}
