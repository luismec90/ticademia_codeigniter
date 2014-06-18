<?php

class Muro_model extends CI_Model {

    private static $tabla;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tabla = 'muro';
    }

    public function obtener($where) {
        $this->db->from($this->tabla);
        $this->db->where($where);
        $this->db->order_by("fecha_creacion", "desc");
        return $this->db->get()->result();
    }

    public function obtenerMensajesCompletos($idCurso) {
        $query = "SELECT m.*,u.nombres,u.apellidos,u.imagen 
                FROM muro m
                JOIN usuario u ON m.id_usuario=u.id_usuario
                WHERE m.muro_id_muro IS NULL
                AND m.id_curso='$idCurso'
                ORDER BY m.fecha_creacion DESC";
        return $this->db->query($query)->result();
    }

    public function obtenerRespuestas($idMensaje) {
        $query = "SELECT m.*,u.nombres,u.apellidos,u.imagen 
                FROM muro m
                JOIN usuario u ON m.id_usuario=u.id_usuario
                WHERE muro_id_muro='$idMensaje'
                ORDER BY m.fecha_creacion ASC";
        return $this->db->query($query)->result();
    }

    public function crear($data) {
        $this->db->insert($this->tabla, $data);
    }

    public function actualizar($data, $where) {
        $this->db->update($this->tabla, $data, $where);
    }

    public function eliminar($where) {
        $this->db->delete($this->tabla, $where);
    }

}
