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

    public function actulizarDuracion($idMaterial, $duracionSegundos) {
        $data = array(
            'duracion' => $duracionSegundos
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

    function obtenerMateriales($where) {
        return $this->db->get_where('material', $where)->result();
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

    public function cantidadPDFs($idCurso) {
        $query = "select count(*) cantidad from modulo mo join material ma ON mo.id_modulo=ma.id_modulo where mo.id_curso='$idCurso' and ma.tipo='pdf'";
        return $this->db->query($query)->result();
    }

    public function cantidadVideos($idCurso) {
        $query = "select count(*) cantidad from modulo mo join material ma ON mo.id_modulo=ma.id_modulo where mo.id_curso='$idCurso' and ma.tipo='video'";
        return $this->db->query($query)->result();
    }

    public function visitasPorDiaPdfs($idCurso) {
        $query = "SELECT ma.id_material,DATE_FORMAT(um.fecha_inicial,'%Y-%m-%d') as fecha,count(ma.id_material)
                 visitas from material ma JOIN usuario_x_material um ON ma.id_material=um.id_material JOIN modulo modu ON ma.id_modulo=modu.id_modulo AND modu.id_curso='$idCurso' 
                 WHERE ma.tipo='pdf' AND um.fecha_inicial >= (SELECT c.fecha_inicio FROM curso c WHERE c.id_curso='$idCurso') GROUP BY fecha";
        return $this->db->query($query)->result();
    }

    public function visitasPorDiaVideos($idCurso) {
        $query = "SELECT ma.id_material,DATE_FORMAT(um.fecha_inicial,'%Y-%m-%d') as fecha,count(ma.id_material)
                 visitas from material ma JOIN usuario_x_material um ON ma.id_material=um.id_material
                 WHERE ma.tipo='video' AND um.fecha_inicial >= (SELECT c.fecha_inicio FROM curso c WHERE c.id_curso='$idCurso') GROUP BY fecha";
        return $this->db->query($query)->result();
    }

    public function tiempoPromdedioReproduccion($idCurso) {
        $query = "SELECT ma.id_material,COALESCE(ma.duracion,1) duracion, DATE_FORMAT(um.fecha_inicial, '%Y-%m-%d') as fecha, 
                count(ma.id_material) visitas, ROUND(AVG(TIME_TO_SEC(TIMEDIFF(um.fecha_final, um.fecha_inicial))/60)) minutos 
                from material ma JOIN usuario_x_material um ON ma.id_material = um.id_material JOIN modulo modu ON ma.id_modulo=modu.id_modulo AND modu.id_curso='$idCurso' 
                WHERE ma.tipo = 'video' AND um.fecha_final IS NOT NULL 
                AND um.fecha_inicial >= (SELECT c.fecha_inicio FROM curso c WHERE c.id_curso = '$idCurso') GROUP BY fecha";
        return $this->db->query($query)->result();
    }

    public function cantidadMaterialesObservados($idUsuario, $idCurso) {
        $query = "select count(distinct um.id_material) cantidad from usuario_x_material um
                join material ma ON um.id_material=ma.id_material
                join modulo m ON m.id_modulo=ma.id_modulo
                where um.id_usuario='$idUsuario' AND m.id_curso='$idCurso'";
        return $this->db->query($query)->result();
    }

}
