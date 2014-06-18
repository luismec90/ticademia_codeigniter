<?php

class Usuario_x_modulo_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function obtenerRegistro($where) {
        return $this->db->get_where('usuario_x_modulo', $where)->result();
    }

    public function crear($data) {
        $this->db->insert('usuario_x_modulo', $data);
    }

    public function actualizar($data, $where) {
        $this->db->update('usuario_x_modulo', $data, $where);
    }

    function obtenerTopN($idModulo, $N) {
        $query = "SELECT *
                FROM usuario_x_modulo um
                JOIN usuario u ON u.id_usuario=um.id_usuario AND u.rol='estudiante'
                JOIN modulo m ON m.id_modulo=um.id_modulo
                JOIN usuario_x_curso uc ON uc.id_usuario=u.id_usuario AND uc.id_curso=m.id_curso
                WHERE um.id_modulo='$idModulo'
                ORDER BY um.puntaje desc,uc.fecha desc
                LIMIT 0,$N";
        return $this->db->query($query)->result();
    }

    function rankingCurso($idCurso) {
        $query = "SELECT u.id_usuario,u.nombres,u.apellidos,u.imagen,SUM(um.puntaje) puntaje_total
                  FROM usuario_x_modulo um
                  JOIN modulo m ON m.id_modulo=um.id_modulo
                  JOIN usuario u ON u.id_usuario=um.id_usuario AND u.rol='estudiante'
                  JOIN usuario_x_curso uc ON uc.id_usuario=u.id_usuario AND uc.id_curso='$idCurso'
                  WHERE m.id_curso='$idCurso'
                  GROUP BY u.id_usuario
                  ORDER BY puntaje_total desc,uc.fecha desc";
        //  echo $query;
        return $this->db->query($query)->result();
    }

    function rankingModulo($idModulo) {
        $query = "SELECT *
                FROM usuario_x_modulo um
                JOIN usuario u ON u.id_usuario=um.id_usuario AND u.rol='estudiante'
                JOIN modulo m ON m.id_modulo=um.id_modulo
                JOIN usuario_x_curso uc ON uc.id_usuario=u.id_usuario AND uc.id_curso=m.id_curso
                WHERE um.id_modulo='$idModulo'
                ORDER BY um.puntaje desc,uc.fecha desc";
        return $this->db->query($query)->result();
    }

}
