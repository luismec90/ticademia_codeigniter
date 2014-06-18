<?php

class Usuario_x_evaluacion_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function crearIntento($data) {
        $this->db->insert('usuario_x_evaluacion', $data);
    }

    function calificar($data) {
        $this->db->where('id_usuario_evaluacion', $data['id_usuario_evaluacion']);
        $this->db->set('calificacion', $data['calificacion']);
        $this->db->set('fecha_final', "DATE_ADD(fecha_inicial,INTERVAL {$data['duracion']} SECOND)", FALSE);
        $this->db->set('realimentacion', $data['realimentacion']);
        $this->db->update('usuario_x_evaluacion');
    }

    function vecesAprobada($idEvaluacion, $umbral) {
        $query = "SELECT COUNT(*) total FROM usuario_x_evaluacion WHERE id_usuario={$_SESSION["idUsuario"]} AND id_evaluacion='$idEvaluacion' AND calificacion>=$umbral";
        return $this->db->query($query)->result();
    }

    function obtenerIntentos($idEvaluacion) {
        $query = "SELECT ue.*
                 FROM usuario_x_evaluacion ue
                 JOIN evaluacion e ON e.id_evaluacion=ue.id_evaluacion
                 WHERE e.id_evaluacion='$idEvaluacion'
                 AND ue.id_usuario='{$_SESSION["idUsuario"]}'";
        return $this->db->query($query)->result();
    }

    function obtenerEvaluacionesAprobadas($idCurso, $umbral) {
        $query = "SELECT DISTINCT(e.id_evaluacion)
                  FROM usuario_x_evaluacion ue
                  JOIN evaluacion e ON e.id_evaluacion=ue.id_evaluacion
                  JOIN modulo m ON e.id_modulo=m.id_modulo
                  WHERE ue.calificacion>='$umbral'
                  AND ue.id_usuario={$_SESSION["idUsuario"]}
                  AND m.id_curso='$idCurso'";
        return $this->db->query($query)->result();
    }

    function obtenerUltimasEvaluaciones($idCurso, $limit) {
        $query = "SELECT ue.id_usuario,e.id_evaluacion,ue.calificacion,ue.fecha_final
                  FROM usuario_x_evaluacion ue
                  JOIN evaluacion e ON e.id_evaluacion=ue.id_evaluacion
                  JOIN modulo m ON e.id_modulo=m.id_modulo
                  WHERE  ue.id_usuario={$_SESSION["idUsuario"]}
                  AND m.id_curso='$idCurso'
                  ORDER BY ue.fecha_final DESC LIMIT 0,10";
        return $this->db->query($query)->result();
    }

}
