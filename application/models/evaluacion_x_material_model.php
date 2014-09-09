<?php

class Evaluacion_x_material_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function obtener($where) {
        return $this->db->get_where('evaluacion_x_material', $where)->result();
    }

    public function obtenerMaterialesPorEvaluacion($idEvaluacion) {
        $query = "select m.*,mo.id_curso from evaluacion_x_material em
                  join material m ON m.id_material=em.id_material
                  join modulo mo ON m.id_modulo=mo.id_modulo
                  where em.id_evaluacion='$idEvaluacion'";
        return $this->db->query($query)->result();
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
