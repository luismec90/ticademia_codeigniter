<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Curso_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function obtenerCursos() {
        if (isset($_SESSION["idUsuario"])) {
            $query = "SELECT c.*,a.*,uc.id_usuario esta_matriculado
                FROM curso c
                JOIN asignatura a ON a.id_asignatura=c.id_asignatura
                LEFT JOIN usuario_x_curso uc ON uc.id_curso=c.id_curso AND uc.id_usuario='{$_SESSION["idUsuario"]}'";
        } else {
            $query = "SELECT c.*,a.* 
                FROM curso c
                JOIN asignatura a ON a.id_asignatura=c.id_asignatura";
        }
        return $this->db->query($query)->result();
    }

    function obtenerCursoPorProfesor($where) {
        return $this->db->get_where('curso', $where)->result();
    }

    function obtenerCurso($idCurso) {
        $query = $this->db->get_where('curso', array('id_curso' => $idCurso));
        return $query->result();
    }

    function obtenerCursoCompleto($idCurso) {
        $this->db->select('*');
        $this->db->from('curso c');
        $this->db->join('asignatura a', "a.id_asignatura = c.id_asignatura");
        $this->db->where('c.id_curso', $idCurso);
        return $this->db->get()->result();
    }

    function obtenerCursoConEvaluacion($idEvaluacion) {
        $query = "SELECT c.*
                  FROM evaluacion e
                  JOIN modulo m ON m.id_modulo=e.id_modulo
                  JOIN curso c ON c.id_curso=m.id_curso
                  WHERE e.id_evaluacion='$idEvaluacion'";
        return $this->db->query($query)->result();
    }

}
