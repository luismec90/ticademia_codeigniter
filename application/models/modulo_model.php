<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modulo_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function getModulos($idCurso) {
        $this->db->select('*');
        $this->db->from('modulo');
        $this->db->where('id_curso', $idCurso);
        $this->db->order_by("fecha_inicio");
        return $this->db->get()->result();
    }

    function obtenerModulo($idModulo) {
        return $this->db->get_where('modulo', array('id_modulo' => $idModulo))->result();
    }

    function crearModulo($datos) {
        $this->db->insert('modulo', $datos);
    }

    function editarModulo($datos, $where) {
        $this->db->update('modulo', $datos, $where);
    }

    function eliminarModulo($where) {
        $this->db->delete('modulo', $where);
    }

    function obtenerModuloConEvaluacion($idEvaluacion) {
        $query = "SELECT m.*,te.valor
                FROM evaluacion e
                JOIN modulo m ON m.id_modulo=e.id_modulo
                JOIN tipo_evaluacion te ON te.id_tipo_evaluacion=e.id_tipo_evaluacion
                WHERE e.id_evaluacion='$idEvaluacion'";
        return $this->db->query($query)->result();
    }

    function puntajePorModuloPorCurso($idCurso) {
        $query = "SELECT m.id_modulo,m.nombre,COALESCE(um.puntaje,0) puntaje
                FROM modulo m
                LEFT JOIN usuario_x_modulo um ON um.id_modulo=m.id_modulo AND um.id_usuario='{$_SESSION["idUsuario"]}'
                WHERE m.id_curso='$idCurso'
                ORDER BY m.fecha_inicio ASC";
        return $this->db->query($query)->result();
    }

}
