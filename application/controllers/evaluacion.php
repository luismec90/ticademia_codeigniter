<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Evaluacion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->estoyLogueado();
        $this->load->model('evaluacion_model');
        $this->load->model('modulo_model');
    }

    public function crearEvaluacion() {
        $this->escapar($_POST);
        if (empty($_POST["modulo"])) {
            $this->mensaje("Por favor inténtalo nuevamente", "error");
        } else
        if (empty($_POST["tipoEvaluacion"]) || empty($_FILES["file"]) || $_FILES["file"]["error"] > 0) {
            $this->mensaje("Por favor inténtalo nuevamente", "error", "modulo/{$_POST["modulo"]}");
        }
        $modulo = $this->modulo_model->obtenerModulo($_POST["modulo"]);
        $idCurso = $modulo[0]->id_curso;
        $this->soyElProfesor($idCurso);
        $idModulo = $_POST["modulo"];
        $maxOrden = $this->evaluacion_model->obtenerUltimoNumeroOrden($idModulo);
        $num = $maxOrden[0]->num + 1;
        $lastId = $this->evaluacion_model->crearEvaluacion($idModulo, $_POST["tipoEvaluacion"], $num);

        $ruta = "/var/www/minerva/resources/$idCurso/$idModulo/$lastId";
        echo exec("unzip {$_FILES["file"]['tmp_name']} -d $ruta");
        $this->mensaje("Evaluación creada exitosamente", "success", "modulo/$idModulo");
    }

    public function editarEvaluacion() {
        $this->escapar($_POST);

        if (empty($_POST["modulo"]) || empty($_POST["evaluacion"])) {
            $this->mensaje("Por favor inténtalo nuevamente", "error");
        } else if (empty($_POST["tipoEvaluacion"]) || empty($_FILES["file"]) || $_FILES["file"]["error"] > 0) {
            $this->mensaje("Por favor inténtalo nuevamente", "error", "modulo/{$_POST["modulo"]}");
        }
        $idModulo = $_POST["modulo"];
        $idEvaluacion = $_POST["evaluacion"];
        $modulo = $this->modulo_model->obtenerModulo($idModulo);
        $idCurso = $modulo[0]->id_curso;
        $this->soyElProfesor($idCurso);

        $evaluacion = $this->evaluacion_model->obtenerEvaluacion($idEvaluacion);
        if ($evaluacion[0]->id_modulo != $_POST["modulo"]) {
            $this->mensaje("Por favor inténtalo nuevamente", "error");
        }
        $this->evaluacion_model->actualizarTipo($_POST["evaluacion"], $_POST["tipoEvaluacion"]);

        $ruta = "/var/www/minerva/resources/$idCurso/$idModulo/{$evaluacion[0]->id_evaluacion}";

        if (file_exists($ruta)) {
            echo exec("rm -R $ruta");
        }
        echo exec("unzip {$_FILES["file"]['tmp_name']} -d $ruta");
        $this->mensaje("Evaluación editada exitosamente", "success", "modulo/$idModulo");
    }

    public function eliminarEvaluacion() {
        $this->escapar($_POST);
        if (empty($_POST["modulo"]) || empty($_POST["evaluacion"])) {
            $this->mensaje("Por favor inténtalo nuevamente", "error");
        }
        $idModulo = $_POST["modulo"];
        $idEvaluacion = $_POST["evaluacion"];
        $modulo = $this->modulo_model->obtenerModulo($idModulo);
        $idCurso = $modulo[0]->id_curso;
        $this->soyElProfesor($idCurso);

        $evaluacion = $this->evaluacion_model->obtenerEvaluacion($idEvaluacion);
        if ($evaluacion[0]->id_modulo != $_POST["modulo"]) {
            $this->mensaje("Por favor inténtalo nuevamente", "error");
        }


        $this->evaluacion_model->eliminar($_POST["evaluacion"]);

        $ruta = "/var/www/minerva/resources/$idCurso/$idModulo/{$evaluacion[0]->id_evaluacion}";
        if (file_exists($ruta)) {
            echo exec("rm -R $ruta");
        }
        $this->mensaje("Evaluación eliminada exitosamente", "success", "modulo/$idModulo");
    }

    public function ordenarEvaluacion() {
        $this->escapar($_POST);
        if (empty($_POST["modulo"])) {
            $this->mensaje("Por favor inténtalo nuevamante", "error");
        }
        $idModulo = $_POST["modulo"];
        $modulo = $this->modulo_model->obtenerModulo($idModulo);
        $idCurso = $modulo[0]->id_curso;
        $this->soyElProfesor($idCurso);
        if (!empty($_POST["orden"])) {
            $orden = explode(",", $_POST["orden"]);
            foreach ($orden as $key => $row) {
                $this->evaluacion_model->setOrden($row, $key);
            }
        }
        $this->mensaje("Evaluaciones ordenados exitosamente", "success", "modulo/$idModulo");
    }

    public function estadisticasRespuestas() {
        $this->load->model('usuario_x_evaluacion_model');

        $idEvalucion = $this->input->get('idEvaluacion');

        $respuestas = $this->usuario_x_evaluacion_model->obtenerRespuestas($idEvalucion);


        $rows = array();
        $table = array();
        $table['cols'] = array(
            array('label' => 'Respuesta', 'type' => 'string'),
            array('label' => 'Cantidad', 'type' => 'number')
        );

        foreach ($respuestas as $r) {

            $temp = array();

            // the following line will be used to slice the Pie chart
            if ($r->realimentacion == "") {
                $r->realimentacion = "Sin información";
            }
            $temp[] = array('v' => "Realimentacion: " . $r->realimentacion);

            // Values of each slice

            $temp[] = array('v' => (int) $r->cantidad);
            $rows[] = array('c' => $temp);
        }

        $table['rows'] = $rows;
        $jsonTable = json_encode($table);
        echo $jsonTable;
    }

    public function estadisticasRespuestas2() {
        $this->load->model('usuario_x_evaluacion_model');
        $this->load->model('curso_model');

        $idEvalucion = $this->input->get('idEvaluacion');
        $respuestas = $this->usuario_x_evaluacion_model->posiblesRespuestas($idEvalucion);

        $idCurso = $this->input->get('idCurso');

        $curso = $this->curso_model->obtenerCursoCompleto($idCurso);
        $fechaInicio = $curso[0]->fecha_inicio;

        $respuestasPorDia = $this->usuario_x_evaluacion_model->respuestasPorDia($idEvalucion, $idCurso);
        $datos = array();

        foreach ($respuestasPorDia as $row) {
            foreach ($respuestas as $row2) {
                if ($row2->realimentacion == $row->realimentacion) {
                    $datos[$row->fecha][$row2->realimentacion] = $row->cantidad;
                } else if (!isset($datos[$row->fecha][$row2->realimentacion])) {
                    $datos[$row->fecha][$row2->realimentacion] = 0;
                }
            }
        }


        $rows = array();
        $table = array();
        $table['cols'] = array(array('label' => 'Fecha', 'type' => 'string'));

        foreach ($respuestas as $row) {
            $aux = array('label' => ($row->realimentacion == "") ? "Sin información" : $row->realimentacion, 'type' => 'number');
            array_push($table['cols'], $aux);
        }
        $current = $fechaInicio;
        $end = Date('Y-m-d');
        $startDate = strtotime($current);
        $endDate = strtotime($end);
        while ($startDate <= $endDate) {

            $tmp = array(array("v" => dateToxAxis($current)));
            if (isset($datos[$current])) {

                foreach ($respuestas as $row) {
                    $aux = array("v" => $datos[$current][$row->realimentacion]);
                    array_push($tmp, $aux);
                }
            } else {
                foreach ($respuestas as $row) {
                    $aux = array("v" => 0);
                    array_push($tmp, $aux);
                }
            }

            array_push($rows, array('c' => $tmp));
            $current = date("Y-m-d", $startDate = strtotime('+1 day', $startDate));
        }
        $table['rows'] = $rows;
        $jsonTable = json_encode($table);
        echo $jsonTable;
    }

    public function saltar() {

        $fechaInicial = date('Y-m-d H:i:s');
        $idEvaluacion = $this->input->post('idEvaluacion');
        if (!$idEvaluacion) {
            exit();
        }
        $this->load->model('usuario_x_evaluacion_model');
        $data = array(
            'id_usuario' => $_SESSION["idUsuario"],
            'id_evaluacion' => $idEvaluacion,
            'calificacion' => -1,
            'fecha_inicial' => $fechaInicial
        );
        $this->usuario_x_evaluacion_model->crearIntento($data);
        $this->session->set_flashdata('mensaje', "Evaluación omitida correctamente");
        $this->session->set_flashdata('tipo', "success");
    }

}
