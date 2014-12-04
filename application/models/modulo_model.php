<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modulo_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    function getModulos($idCurso)
    {
        $this->db->select('*');
        $this->db->from('modulo');
        $this->db->where('id_curso', $idCurso);
        $this->db->order_by("fecha_inicio");

        return $this->db->get()->result();
    }

    function obtenerModulo($idModulo)
    {
        return $this->db->get_where('modulo', array('id_modulo' => $idModulo))->result();
    }

    function obtenerModulos($where)
    {
        return $this->db->get_where('modulo', $where)->result();
    }

    function crearModulo($datos)
    {
        $this->db->insert('modulo', $datos);
    }

    function editarModulo($datos, $where)
    {
        $this->db->update('modulo', $datos, $where);
    }

    function eliminarModulo($where)
    {
        $this->db->delete('modulo', $where);
    }

    function obtenerModuloConEvaluacion($idEvaluacion)
    {
        $query = "SELECT m.*,te.valor
                FROM evaluacion e
                JOIN modulo m ON m.id_modulo=e.id_modulo
                JOIN tipo_evaluacion te ON te.id_tipo_evaluacion=e.id_tipo_evaluacion
                WHERE e.id_evaluacion='$idEvaluacion'";

        return $this->db->query($query)->result();
    }

    function puntajePorModuloPorCurso($idCurso, $idUsuario)
    {
        $query = "SELECT m.id_modulo,m.nombre,COALESCE(um.puntaje,0) puntaje
                FROM modulo m
                LEFT JOIN usuario_x_modulo um ON um.id_modulo=m.id_modulo AND um.id_usuario='$idUsuario'
                WHERE m.id_curso='$idCurso'
                ORDER BY m.fecha_inicio ASC";

        return $this->db->query($query)->result();
    }

    function ultimoModulo($idCurso)
    {
        $query = "select * from modulo where id_curso='$idCurso' order by fecha_fin desc limit 1";

        return $this->db->query($query)->result();
    }

    function cantidadEvaluaciones($idModulo)
    {
        $query = "SELECT count(id_evaluacion) cantidad FROM evaluacion WHERE id_modulo='$idModulo' AND id_evaluacion<>'205'";

        return $this->db->query($query)->result();
    }

    function reporteTotal($idModulo,$fechaFin, $cantidadEvaluaciones, $umbral)
    {
        $query = "select uc.grupo,u.dni,u.correo,u.apellidos,u.nombres, round(count(distinct ue.id_evaluacion)/$cantidadEvaluaciones*100,2)  porcentaje from usuario_x_evaluacion ue
        join evaluacion e on e.id_modulo='$idModulo' AND ue.id_evaluacion=e.id_evaluacion
        join usuario u On u.id_usuario=ue.id_usuario
        join usuario_x_curso uc on uc.id_usuario=u.id_usuario
        where ue.calificacion>=$umbral
        AND e.id_evaluacion<>'205'
        AND ue.fecha_final<='$fechaFin'
        group by u.id_usuario order by uc.grupo,u.apellidos,u.nombres";

        return $this->db->query($query)->result();
    }

}
