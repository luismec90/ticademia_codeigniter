<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Afiliacion_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function obtenerAfiliaciones() {
        $this->db->from("afiliacion");
        $this->db->order_by("nombre", "asc");
        $query = $this->db->get();
        return $query->result();
    }

}
