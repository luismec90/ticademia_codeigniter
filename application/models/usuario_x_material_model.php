<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario_x_material_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function crearRegistro($data) {
        $this->db->insert('usuario_x_material', $data);
    }

    function actualizar($data) {
        $this->db->where('id_usuario_x_material', $data['id_usuario_x_material']);
        $this->db->set('fecha_final', "DATE_ADD(fecha_inicial,INTERVAL {$data['duracion']} SECOND)", FALSE);
        $this->db->update('usuario_x_material');
    }

}
