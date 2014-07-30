<?php

class Nivel_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function obtener($where) {
        return $this->db->get_where('nivel', $where)->result();
    }

    public function getNiveles($cantidadNiveles) {
        $query = "select * from nivel where id_nivel <='$cantidadNiveles'";
        return $this->db->query($query)->result();
    }

}
