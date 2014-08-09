<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reto_model extends CI_Model {

    private static $tabla;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->tabla = 'reto';
    }

    public function crearReto($datos) {
        $this->db->insert($this->tabla, $datos);
    }

    function cantidadRetosUsuario($idUsuario, $idCurso) {
        $query = "select count(*) cantidad from reto where id_curso='$idCurso' AND (retador='$idUsuario' or retado='$idUsuario')";
        return $this->db->query($query)->result();
    }

    function cantidadRetosUsuarioGanados($idUsuario, $idCurso) {
        $query = "select count(*) cantidad from reto where id_curso='$idCurso' AND (retador='$idUsuario' or retado='$idUsuario') and ganador='$idUsuario'";
        return $this->db->query($query)->result();
    }

}
