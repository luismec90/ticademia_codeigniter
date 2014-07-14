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

    public function obtenerMateriales($idModulo, $idUsuario) {
        $query = "select m.*,um.id_usuario_x_material visto,mv.puntaje,mv.comentario  from material m 
                  left join usuario_x_material um on um.id_material=m.id_material and um.id_usuario='$idUsuario' 
                  left join material_valoracion mv on mv.id_material=m.id_material and mv.id_usuario='$idUsuario' 
                  where m.id_modulo='$idModulo' group by m.id_material order by m.orden";
        return $this->db->query($query)->result();
    }

}
