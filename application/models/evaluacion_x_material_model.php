<?php

class Evaluacion_x_material_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function obtener($where) {
        return $this->db->get_where('evaluacion_x_material', $where)->result();
    }

    public function crear($data) {
        $this->db->insert('evaluacion_x_material', $data);
    }

    public function actualizar($data, $where) {
        $this->db->update('evaluacion_x_material', $data, $where);
    }

    public function eliminar($where) {
        $this->db->delete('evaluacion_x_material', $where);
    }

}
