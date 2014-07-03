<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bitacora_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function crearRegistro($data) {
        $this->db->insert('bitacora', $data);
        return $this->db->insert_id();
    }

    function actializarRegistro($where) {
        $this->db->update('bitacora', array("fecha_salida" => date("Y-m-d H:i:s")), $where);
        return $this->db->insert_id();
    }

    function obtenerTiempoLogueado($idUsuario, $idCurso) {
        $query = "SELECT SUM(TIME_TO_SEC(TIMEDIFF(FECHA_SALIDA,FECHA_INGRESO)))/3600 tiempo FROM bitacora where FECHA_SALIDA is not NULL and id_usuario='$idUsuario' and id_curso='$idCurso'";
        return $this->db->query($query)->result();
    }

    function lastLogin($idUsuario) {
        $query = "SELECT * FROM bitacora WHERE id_usuario='$idUsuario' ORDER BY fecha_ingreso DESC LIMIT 0,1";
        return $this->db->query($query)->result();
    }

    function cantidadEstudiantesConectados($idCurso) {
        $query = "SELECT COUNT(distinct(id_usuario)) cantidad FROM bitacora WHERE id_curso='$idCurso' AND fecha_salida >= date_sub(NOW(),INTERVAL 20 MINUTE)";
        return $this->db->query($query)->result();
    }

    function cantidadAccesos($idUsuario, $idCurso) {
        $query = "SELECT count(*) cantidad FROM bitacora where FECHA_SALIDA is not NULL and id_usuario='$idUsuario' and id_curso='$idCurso'";
        return $this->db->query($query)->result();
    }

    function lastLoginCurso($idUsuario, $idCurso) {
        $query = "SELECT MAX(fecha_ingreso) last_login FROM bitacora WHERE id_usuario='$idUsuario' AND id_curso='$idCurso'";
        return $this->db->query($query)->result();
    }

}
