<?php

class Usuario_x_curso_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function obtenerRegistro($where) {
        return $this->db->get_where("usuario_x_curso", $where)->result();
    }

    public function obtenerRegistroCompleto($where) {
        $query = "SELECT *
              FROM usuario_x_curso uc
              JOIN nivel n ON n.id_nivel=uc.id_nivel
              WHERE uc.id_curso='{$where["id_curso"]}' AND uc.id_usuario='{$where["id_usuario"]}'";
        return $this->db->query($query)->result();
    }

    public function obtenerMonitores($idCurso) {
        $query = "SELECT *
              FROM usuario_x_curso uc
              JOIN usuario u ON u.id_usuario=uc.id_usuario
              WHERE uc.id_curso='$idCurso' AND uc.rol='3'";
        return $this->db->query($query)->result();
    }

    public function crear($data) {
        $this->db->insert('usuario_x_curso', $data);
    }

    public function actualizar($data, $where) {
        $this->db->update('usuario_x_curso', $data, $where);
    }

    public function cantidadEstudiantesMatriculados($idCurso) {
        $query = "SELECT count(*) cantidad FROM usuario_x_curso WHERE id_curso='$idCurso' AND rol=1";
        return $this->db->query($query)->result();
    }

    public function obtenerRegistroConEstudiante($idUsuario, $idCurso) {
        $query = "SELECT u.*,uc.fecha fecha_matricula from usuario u 
                  JOIN usuario_x_curso uc ON uc.id_usuario=u.id_usuario AND uc.id_curso='$idCurso'
                  WHERE u.id_usuario='$idUsuario'";
        return $this->db->query($query)->result();
    }

}
