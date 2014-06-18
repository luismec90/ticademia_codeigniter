<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Respuesta_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function listarRespuestas($idTema, $filasPorPagina, $inicio) {
        $this->db->select('SQL_CALC_FOUND_ROWS r.*,e.nombres,e.apellidos', false);
        $this->db->from('respuesta r');
        $this->db->join('usuario e', "e.id_usuario = r.id_usuario");
        $this->db->where('r.id_tema_foro', $idTema);
        $this->db->order_by("r.id_respuesta", "desc");
        $this->db->limit($filasPorPagina, $inicio);
        return $this->db->get()->result();
    }

    public function cantidadRegistros() {
        $query = "select found_rows() as cantidad";
        return $this->db->query($query)->result();
    }

    function obtenerUltimaRespuesta($idTema) {
        $this->db->select('r.*,e.nombres,e.apellidos usuario_ultima_respuesta, count(r.id_respuesta) cantidad_respuestas');
        $this->db->from('respuesta r');
        $this->db->join('usuario e', "e.id_usuario = r.id_usuario");
        $this->db->where('r.id_tema_foro', $idTema);
        $this->db->limit(1);
        return $this->db->get()->result();
    }

    function crearRespuesta($datos) {
        $this->db->insert('respuesta', $datos);
    }

    function eliminarRespuesta($datos) {
        $this->db->delete('respuesta', $datos);
    }

}
