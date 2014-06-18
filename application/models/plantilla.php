<?php

class Conductor_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function obtenerConductores() {
        $this->db->from('conductor');
        $this->db->order_by("apellidos", "asc");
        return $this->db->get()->result();
    }

    public function crear($data) {
        $this->db->insert('conductor', $data);
    }

    public function actualizar($data, $where) {
        $this->db->update('conductor', $data, $where);
    }

    public function eliminar($where) {
        $this->db->delete('conductor', $where);
    }

}
