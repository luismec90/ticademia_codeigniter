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

    function setSinInformacion($data) {// set sin informacion si no hay realimentacion
        $query = "UPDATE  usuario_x_evaluacion set realimentacion='Sin resolver'
                  WHERE id_usuario_evaluacion='{$data['id_usuario_evaluacion']}' AND realimentacion=''";
         $this->db->query($query);
    }

    function vecesAprobada($idEvaluacion, $umbral) {
        $query = "SELECT COUNT(*) total FROM usuario_x_evaluacion WHERE id_usuario={$_SESSION["idUsuario"]} AND id_evaluacion='$idEvaluacion' AND calificacion>=$umbral";
        return $this->db->query($query)->result();
    }
 function vecesSaltada($idEvaluacion) {
        $query = "SELECT COUNT(*) total FROM usuario_x_evaluacion WHERE id_usuario={$_SESSION["idUsuario"]} AND id_evaluacion='$idEvaluacion' AND calificacion=-1";
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

    function obtenerEvaluaciones($idCurso, $idModulo, $idUsuario) {
        $query = "select e.*,te.nombre tipo_evaluacion,count(ue.id_usuario_evaluacion) intentos, 
                sum(if(ue.calificacion is not null && ue.calificacion>=(select umbral from curso where id_curso='$idCurso'),1,0)) 
                aciertos, min(if(ue.calificacion is not null && ue.calificacion>=(select umbral from curso where id_curso='$idCurso'),
                time_to_sec(timediff(ue.fecha_final,ue.fecha_inicial)),99999)) mejor_tiempo 
                from evaluacion e join tipo_evaluacion te on te.id_tipo_evaluacion=e.id_tipo_evaluacion
                left join usuario_x_evaluacion ue ON ue.id_evaluacion=e.id_evaluacion and ue.id_usuario='$idUsuario' 
                where e.id_modulo='$idModulo' group by e.id_evaluacion";
        return $this->db->query($query)->result();
    }

    function obtenerRespuestas($idEvaluacion) {
        $query = "SELECT realimentacion,count(realimentacion) cantidad FROM `usuario_x_evaluacion` WHERE id_evaluacion='$idEvaluacion' GROUP BY realimentacion";
        return $this->db->query($query)->result();
    }

    function posiblesRespuestas($idEvaluacion) {
        $query = "select distinct realimentacion from usuario_x_evaluacion where id_evaluacion='$idEvaluacion' group by realimentacion";
        return $this->db->query($query)->result();
    }

    function respuestasPorDia($idEvaluacion, $idCurso) {
        $query = "SELECT realimentacion,count(realimentacion) cantidad,DATE(fecha_inicial) fecha FROM `usuario_x_evaluacion` WHERE id_evaluacion='$idEvaluacion' AND fecha_inicial>=(SELECT fecha_inicio FROM curso WHERE id_curso='$idCurso') GROUP BY fecha,realimentacion";
        return $this->db->query($query)->result();
    }

}
