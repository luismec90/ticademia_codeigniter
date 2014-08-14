<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('evaluacion_model');
    }

    public function index() {
        
    
        
        $data["tab"] = "test";
        $data["css"] = array("css/test");
        $data["js"] = array("js/test");
        $data["jsonDuelo"] = array("dummies" => array(), "retado" => array(), "modulo" => "", "pregunta" => "", "apuesta" => "");
        $data["jsonDuelo"] = json_encode($data["jsonDuelo"]);

        $this->load->view('include/header', $data);
        $this->load->view('test_view');
        $this->load->view('include/footer');
    }

}
