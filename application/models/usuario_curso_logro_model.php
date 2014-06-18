<?php

class Usuario_curso_logro_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function obtenerRegistros($where) {
        return $this->db->get_where('usuario_curso_logro', $where)->result();
    }

    public function crear($data) {
        $this->db->insert('usuario_curso_logro', $data);
    }

    public function actualizar($data, $where) {
        $this->db->update('usuario_curso_logro', $data, $where);
    }

    public function logrosPorCurso($idCurso) {
        $this->db->select('l.id_logro,l.nombre,l.descripcion,ucl.fecha_obtencion,a.nombre nombre_asignatura,ucl.id_usuario_curso_logro');
        $this->db->from('usuario_curso_logro ucl');
        $this->db->join('logro l', "l.id_logro=ucl.id_logro");
        $this->db->join('curso c', "c.id_curso=ucl.id_curso AND c.id_curso='$idCurso'");
        $this->db->join('asignatura a', "a.id_asignatura=c.id_asignatura");
        $this->db->where('ucl.id_usuario', $_SESSION["idUsuario"]);
        $this->db->order_by('ucl.fecha_obtencion');
        return $this->db->get()->result();
    }

    public function obtenerLogro($idLogroUsuario) {
        $this->db->select('l.id_logro,l.nombre,l.descripcion,ucl.fecha_obtencion,a.nombre nombre_asignatura,ucl.id_usuario');
        $this->db->from('usuario_curso_logro ucl');
        $this->db->join('curso c', "c.id_curso=ucl.id_curso");
        $this->db->join('asignatura a', "a.id_asignatura=c.id_asignatura");
        $this->db->join('logro l', "l.id_logro=ucl.id_logro");
        $this->db->where('ucl.id_usuario_curso_logro', $idLogroUsuario);
        return $this->db->get()->result();
    }

    public function logroPediente() {
        $this->db->select('l.id_logro,l.nombre,l.descripcion,ucl.fecha_obtencion,a.nombre nombre_asignatura,ucl.id_usuario_curso_logro,c.id_curso');
        $this->db->from('usuario_curso_logro ucl');
        $this->db->join('logro l', "l.id_logro=ucl.id_logro");
        $this->db->join('curso c', "c.id_curso=ucl.id_curso");
        $this->db->join('asignatura a', "a.id_asignatura=c.id_asignatura");
        $this->db->where('ucl.id_usuario', $_SESSION["idUsuario"]);
        $this->db->where('ucl.visto', 0);
        $this->db->limit(1);
        return $this->db->get()->result();
    }

    public function visto($idLogroUsuario) {
        $this->db->update('usuario_curso_logro', array("visto" => 1), array("id_usuario_curso_logro" => $idLogroUsuario));
    }

    function checkLogro($idCurso, $idLogro) {
        $query = "SELECT * 
                 FROM usuario_curso_logro ucl
                 WHERE ucl.id_usuario='{$_SESSION["idUsuario"]}'
                 AND ucl.id_curso='$idCurso' 
                 AND ucl.id_logro='$idLogro'";
        return $this->db->query($query)->result();
    }

    function checkLogroOtroUsuario($idUsuario, $idCurso, $idLogro) {
        $query = "SELECT * 
                 FROM usuario_curso_logro ucl
                 WHERE ucl.id_usuario='$idUsuario'
                 AND ucl.id_curso='$idCurso' 
                 AND ucl.id_logro='$idLogro'";
        return $this->db->query($query)->result();
    }

    public function logrosPorUsuario($idUsuario) {
        $this->db->select('l.id_logro,l.nombre,l.descripcion,ucl.fecha_obtencion,a.nombre nombre_asignatura,ucl.id_usuario_curso_logro');
        $this->db->from('usuario_curso_logro ucl');
        $this->db->join('logro l', "l.id_logro=ucl.id_logro");
        $this->db->join('curso c', "c.id_curso=ucl.id_curso");
        $this->db->join('asignatura a', "a.id_asignatura=c.id_asignatura");
        $this->db->where('ucl.id_usuario', $idUsuario);
        $this->db->order_by('ucl.fecha_obtencion');
        return $this->db->get()->result();
    }

}
