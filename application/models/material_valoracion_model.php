<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Material_valoracion_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function crearValoracion($data) {
        $this->db->insert('material_valoracion', $data);
    }

    function obtenerValoracion($where) {
        $query = $this->db->get_where('material_valoracion', $where);
        return $query->result();
    }

    function actualizarValoracion($data, $where) {
        $this->db->update('material_valoracion', $data, $where);
    }

    function obtenerRegistros($idMaterial, $inicio, $filasPorPagina) {
        $query = "SELECT SQL_CALC_FOUND_ROWS u.nombres,u.apellidos,mv.puntaje,mv.comentario,mv.fecha
                  FROM material_valoracion mv
                  JOIN usuario u ON u.id_usuario=mv.id_usuario
                  WHERE mv.id_material='$idMaterial' AND mv.comentario<>''
                  ORDER BY mv.fecha DESC LIMIT $inicio,$filasPorPagina";
        return $this->db->query($query)->result();
    }

    function contarComentarios($idMaterial) {
        $query = "SELECT count(*) total
                  FROM material_valoracion mv
                  WHERE mv.id_material='$idMaterial' AND mv.comentario<>''";
        return $this->db->query($query)->result();
    }

    public function cantidadRegistros() {
        $query = "select found_rows() as cantidad";
        return $this->db->query($query)->result();
    }

}
