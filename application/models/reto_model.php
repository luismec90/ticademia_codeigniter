<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reto_model extends CI_Model {

    private static $tabla;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tabla = 'reto';
    }

    public function crearReto($datos) {
        $this->db->insert($this->tabla, $datos);
    }

}
