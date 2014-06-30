<?php

class Estudiante_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function distribucionNiveles($idCurso) {
        $query = "select n.nombre,
                 (select count(uc.id_usuario) from usuario_x_curso uc where uc.id_nivel=n.id_nivel and uc.id_curso='$idCurso') 
                 cantidad from nivel n";
        return $this->db->query($query)->result();
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
