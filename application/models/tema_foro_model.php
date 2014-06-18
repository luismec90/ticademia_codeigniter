<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tema_foro_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function obtenerTema($idTema) {
        $this->db->select('t.*,e.nombres,e.apellidos');
        $this->db->from('tema_foro t');
        $this->db->join('usuario e', "t.id_usuario = e.id_usuario AND t.id_tema_foro='$idTema' ");
        return $this->db->get()->result();
    }

    function listarTemas($idCurso, $filasPorPagina, $inicio) {
        $this->db->select('SQL_CALC_FOUND_ROWS t.*,e.nombres,e.apellidos', false);
        $this->db->from('tema_foro t');
        $this->db->join('usuario e', "t.id_usuario = e.id_usuario AND t.id_curso='$idCurso'");
        $this->db->order_by("t.fecha_creacion", "asc");
        $this->db->limit($filasPorPagina, $inicio);
        return $this->db->get()->result();
    }

    public function cantidadRegistros() {
        $query = "select found_rows() as cantidad";
        return $this->db->query($query)->result();
    }

    public function crearTema($datos) {
        $this->db->insert('tema_foro', $datos);
    }

    public function eliminarTema($datos) {
        $this->db->delete('tema_foro', $datos);
    }

    public function haParticipadoForo() {
        $query = "SELECT count(*) total FROM tema_foro where id_usuario='{$_SESSION["idUsuario"]}'";
        $r = $this->db->query($query)->result();
        $t = $r[0]->total;
        $query = "SELECT count(*) total FROM respuesta where id_usuario='{$_SESSION["idUsuario"]}'";
        $r = $this->db->query($query)->result();
        $t = $t + $r[0]->total;
        return $t;
    }

    public function temasPopulares($idTema, $param) {
        $query = "SELECT t.id_usuario,count(*) total 
                  FROM tema_foro t JOIN respuesta r ON r.id_tema_foro=t.id_tema_foro AND r.id_usuario<>t.id_usuario
                  WHERE t.id_tema_foro='$idTema'
                  HAVING total  >= '$param'";
        return $this->db->query($query)->result();
    }

    public function muyParticipativo($idCurso, $param) {
        $query = "SELECT count(*) total 
                  FROM tema_foro t JOIN respuesta r ON r.id_tema_foro=t.id_tema_foro AND t.id_curso='$idCurso'
                  WHERE (t.id_usuario='{$_SESSION["idUsuario"]}' OR r.id_usuario='{$_SESSION["idUsuario"]}')
                  HAVING total  >= '$param'";
        return $this->db->query($query)->result();
    }

    public function ultimaActividad($idCurso) {
        $query = "SELECT t.id_tema_foro,t.id_tema_foro id_respuesta,t.nombre  nombre,u.nombres,u.apellidos,t.fecha_creacion fecha,'tipo' 'tema'
                  FROM tema_foro t
                  JOIN usuario u ON u.id_usuario=t.id_usuario AND u.id_usuario<>'{$_SESSION["idUsuario"]}'
                  WHERE t.id_curso='$idCurso'
                  AND t.fecha_creacion>='{$_SESSION["ultimaActividad"]}'
                  UNION
                  SELECT  t.id_tema_foro,r.id_respuesta, r.respuesta  nombre,u.nombres,u.apellidos,r.fecha_creacion fecha,'tipo' 'respuesta'
                  FROM respuesta r
                  JOIN tema_foro t ON t.id_curso='$idCurso' AND r.id_tema_foro=t.id_tema_foro
                  JOIN usuario u ON u.id_usuario=r.id_usuario  AND u.id_usuario<>'{$_SESSION["idUsuario"]}'
                  WHERE r.fecha_creacion>='{$_SESSION["ultimaActividad"]}' ORDER BY fecha desc";
        return $this->db->query($query)->result();
    }

}
