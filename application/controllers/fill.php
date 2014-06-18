<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fill extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('fill_model');
    }

    public function index() {
        $this->fill_model->poblarBD();
    }

}
