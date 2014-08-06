<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Evaluacion_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function crear($data) {
        $this->db->insert('evaluacion', $data);
    }

    function crearEvaluacion($idModulo, $tipo, $orden) {
        $datos = array(
            'id_modulo' => $idModulo,
            'id_tipo_evaluacion' => $tipo,
            'orden' => $orden
        );
        $this->db->insert('evaluacion', $datos);
        return $this->db->insert_id();
    }

    function obtenerEvaluacionesPorModulo($idModulo, $idEstudiante) {
        $this->db->select('e.*,MAX(ue.calificacion) calificacion_maxima,MIN(ue.calificacion) calificacion_minima,count(ue.id_evaluacion) intentos,');
        $this->db->from('evaluacion e');
        $this->db->join('modulo mo', "mo.id_modulo = e.id_modulo AND mo.id_modulo='$idModulo'");
        $this->db->join('usuario_x_evaluacion ue', "ue.id_evaluacion=e.id_evaluacion AND ue.id_usuario='$idEstudiante'", 'left');
        $this->db->group_by("e.id_evaluacion");
        $this->db->order_by("e.orden");
        return $this->db->get()->result();
    }

    function obtenerIntentosAprobados($idModulo, $idEstudiante) {
        $this->db->select('ue.*,te.valor');
        $this->db->from('evaluacion e');
        $this->db->join('modulo mo', "mo.id_modulo = e.id_modulo AND mo.id_modulo='$idModulo'");
        $this->db->join('usuario_x_evaluacion ue', "ue.id_evaluacion=e.id_evaluacion AND ue.id_usuario='$idEstudiante'");
        $this->db->join('tipo_evaluacion te', "te.id_tipo_evaluacion=e.id_tipo_evaluacion");
        $this->db->order_by("ue.fecha_inicial");
        return $this->db->get()->result();
    }

    function obtenerEvaluacion($idEvaluacion) {
        return $this->db->get_where('evaluacion', array('id_evaluacion' => $idEvaluacion))->result();
    }

    function obtenerEvaluaciones($where) {
        return $this->db->get_where('evaluacion', $where)->result();
    }

    function setOrden($idEvaluacion, $orden) {
        $data = array(
            'orden' => $orden
        );
        $where = array(
            'id_evaluacion' => $idEvaluacion
        );
        $this->db->update('evaluacion', $data, $where);
    }

    public function actualizarTipo($idEvaluacion, $tipo) {
        $data = array(
            'id_tipo_evaluacion' => $tipo
        );
        $where = array(
            'id_evaluacion' => $idEvaluacion
        );
        $this->db->update('evaluacion', $data, $where);
    }

    function eliminar($idEvaluacion) {
        $data = array(
            'id_evaluacion' => $idEvaluacion
        );
        $this->db->delete('evaluacion', $data);
    }

    function obtenerUltimoNumeroOrden($idModulo) {
        $this->db->select('max(e.orden) num');
        $this->db->from('evaluacion e');
        $this->db->where("e.id_modulo", $idModulo);
        return $this->db->get()->result();
    }

    function obtenerTotalEvaluacionesCurso($idCurso) {
        $this->db->select('count(*) total');
        $this->db->from('evaluacion e');
        $this->db->join('modulo mo', "mo.id_modulo = e.id_modulo AND mo.id_curso='$idCurso'");
        return $this->db->get()->result();
    }

    public function cantidadEvaluacionesAprobadas($idUsuario, $idCurso) {
        $query = "select count(distinct ue.id_evaluacion) cantidad from usuario_x_evaluacion ue
                  join evaluacion e ON ue.id_evaluacion=e.id_evaluacion
                  join modulo m ON m.id_modulo=e.id_modulo
                  where ue.id_usuario='$idUsuario' AND m.id_curso='$idCurso' AND ue.calificacion>=(select umbral from curso where id_curso='$idCurso')";
        return $this->db->query($query)->result();
    }

    public function cantidadEvaluacionesPorModulo($idModulo) {
        $query = "select count(*) cantidad from evaluacion 
                  where id_modulo='$idModulo'";
        return $this->db->query($query)->result();
    }

    function cantidadEvaluacionesAprobadasPorModulo($idUsuario, $idModulo, $idCurso) {
        $query = "select count(distinct ue.id_evaluacion) cantidad from usuario_x_evaluacion ue 
                  join evaluacion e ON ue.id_evaluacion=e.id_evaluacion AND e.id_modulo='$idModulo'
                  where ue.id_usuario='$idUsuario' and ue.calificacion >=(select umbral from curso where id_curso='$idCurso')";
        return $this->db->query($query)->result();
    }

    function cantidadPreguntasIntentadasPorDia($idCurso) {
        $query = "select date(ue.fecha_inicial) fecha,count(ue.id_evaluacion) cantidad from usuario_x_evaluacion ue
                join evaluacion e on ue.id_evaluacion=e.id_evaluacion
                join modulo m on e.id_modulo=m.id_modulo and m.id_curso='$idCurso'
                group by fecha";
        return $this->db->query($query)->result();
    }

    function cantidadPreguntasResueltasPorDia($idCurso) {
        $query = "select date(ue.fecha_inicial) fecha,count( distinct ue.id_evaluacion) cantidad from usuario_x_evaluacion ue
                    join evaluacion e on ue.id_evaluacion=e.id_evaluacion
                    join modulo m on e.id_modulo=m.id_modulo and m.id_curso='$idCurso'
                    where ue.calificacion>=(select umbral from curso where id_curso='$idCurso')
                    group by fecha";
        return $this->db->query($query)->result();
    }

}
