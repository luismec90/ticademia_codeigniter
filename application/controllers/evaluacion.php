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

}
