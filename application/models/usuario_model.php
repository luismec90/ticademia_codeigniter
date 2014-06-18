<?php

class Usuario_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function obtenerUsuario($where) {
        return $this->db->get_where('usuario', $where)->result();
    }

    public function crear($data) {
        $this->db->insert('usuario', $data);
    }

    public function actualizar($data, $where) {
        $this->db->update('usuario', $data, $where);
    }

    public function eliminar($where) {
        $this->db->delete('usuario', $where);
    }

}
