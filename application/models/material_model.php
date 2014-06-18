<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Material_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function obtenerMaterialesPorModulo($idModulo) {
        $this->db->select('mo.id_curso,mo.id_modulo,ma.*,mv.comentario,AVG(mva.puntaje) puntaje_promedio,COUNT(mva.puntaje) total_valoraciones');
        $this->db->from('material ma');
        $this->db->join('modulo mo', "mo.id_modulo = ma.id_modulo AND mo.id_modulo='$idModulo'");
        $this->db->join('material_valoracion mv', "mv.id_material=ma.id_material AND mv.id_usuario='{$_SESSION["idUsuario"]}'", "left");
        $this->db->join('material_valoracion mva', "mva.id_material=ma.id_material", "left");
        $this->db->group_by("ma.id_material");
        $this->db->order_by("ma.orden");
        return $this->db->get()->result();
    }

    function obtenerMaterialesUsuario($idModulo, $idUsuario) {
        $this->db->select('mo.id_curso,mo.id_modulo,ma.*,um.*,sum(um.fecha_final-um.fecha_inicial) tiempo_total');
        $this->db->from('material ma');
        $this->db->join('modulo mo', "mo.id_modulo = ma.id_modulo AND mo.id_modulo='$idModulo'");
        $this->db->join('usuario_x_material um', "um.id_material=ma.id_material AND um.id_usuario='$idUsuario' ");
        $this->db->where("um.fecha_final is not ", "NULL", false);
        $this->db->group_by("ma.id_material");
        $this->db->order_by("um.id_usuario_x_material");
        return $this->db->get()->result();
    }

    function crearMaterial($idModulo, $nombre, $descripcion) {
        $datos = array(
            'id_modulo' => $idModulo,
            'nombre' => $nombre,
            'descripcion' => $descripcion
        );
        $this->db->insert('material', $datos);
        return $this->db->insert_id();
    }

    public function actualizar($idMaterial, $nombre, $descripcion, $ubicacion) {
        $data = array(
            'nombre' => $nombre,
            'ubicacion' => $ubicacion,
            'descripcion' => $descripcion
        );
        $where = array(
            'id_material' => $idMaterial
        );
        $this->db->update('material', $data, $where);
    }

    public function actulizarUbicacion($idMaterial, $ubicacion) {
        $data = array(
            'ubicacion' => $ubicacion
        );
        $where = array(
            'id_material' => $idMaterial
        );
        $this->db->update('material', $data, $where);
    }

    function eliminar($idMaterial) {
        $data = array(
            'id_material' => $idMaterial
        );
        $this->db->delete('material', $data);
    }

    function obtenerMaterial($idMaterial) {
        return $this->db->get_where('material', array('id_material' => $idMaterial))->result();
    }

    function setOrden($idMaterial, $orden) {
        $data = array(
            'orden' => $orden
        );
        $where = array(
            'id_material' => $idMaterial
        );
        $this->db->update('material', $data, $where);
    }

}
