<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modulo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->estoyLogueado();
        $this->load->model('modulo_model');
        $this->load->model('usuario_x_modulo_model');
    }

    public function verModulo($idModulo) {
        $this->load->model('curso_model');
        $this->load->model('material_valoracion_model');
        $modulo = $this->modulo_model->obtenerModulo($idModulo);
        $idCurso = $modulo[0]->id_curso;
        $this->verificarMatricula($idCurso);

        $this->load->model('material_model');
        $this->load->model('evaluacion_model');

        $data["tab"] = "modulo";
        $data["idCurso"] = $idCurso;
        index_bitacora($idCurso);
        $data["idModulo"] = $idModulo;
        $data["css"] = array("libs/jquery-ui-1.10.4.custom/css/redmond/jquery-ui-1.10.4.custom.min", "libs/mediaElement/mediaelementplayer", "css/ranking", "css/modulo");
        $data["js"] = array("libs/time-line/storyjs-embed", "libs/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min", "libs/mediaElement/mediaelement-and-player", "libs/raty/lib/jquery.raty.min", "js/modulo",);

        $datos = $this->material_model->obtenerMaterialesUsuario($idModulo, $_SESSION["idUsuario"]);
        $infoMaterial = array();
        foreach ($datos as $row) {
            $row->tiempo_total = round($row->tiempo_total / 60);
            $infoMaterial[$row->id_material]["tiempo_total"] = $row->tiempo_total;
        }

        $data["materiales"] = $this->material_model->obtenerMaterialesPorModulo($idModulo);
        $data["cantidadMateriales"] = sizeof($data["materiales"]);
        foreach ($data["materiales"] as $row) {
            $row->extension = substr(strrchr($row->ubicacion, '.'), 1);
            if ($row->extension != "pdf") {
                $row->extension = "video";
            }
            $row->ubicacion = base_url() . "material/" . $row->id_curso . "/" . $row->id_modulo . "/" . $row->ubicacion;

            $row->tiempo_total = 0;
            if (isset($infoMaterial[$row->id_material]["tiempo_total"])) {
                $row->visto = true;
                $row->tiempo_total = $infoMaterial[$row->id_material]["tiempo_total"];
            } else {
                $row->visto = false;
            }
            $row->puntaje_promedio = round($row->puntaje_promedio) / 2;
            $row->total_comentarios = $this->material_valoracion_model->contarComentarios($row->id_material);
            $row->total_comentarios = $row->total_comentarios[0]->total;
        }


        $curso = $this->curso_model->obtenerCurso($idCurso);
        $umbral = $curso[0]->umbral;
        $valorMinimo = 150;
        $datos = $this->evaluacion_model->obtenerIntentosAprobados($idModulo, $_SESSION["idUsuario"]);

        $infoEvaluacion = array();
        foreach ($datos as $row) {
            if (!array_key_exists($row->id_evaluacion, $infoEvaluacion)) {
                $infoEvaluacion[$row->id_evaluacion] = array();
            }
            if (!array_key_exists("veces_aprobado", $infoEvaluacion[$row->id_evaluacion])) {
                $infoEvaluacion[$row->id_evaluacion]["veces_aprobado"] = 0;
                $infoEvaluacion[$row->id_evaluacion]["veces_intentado"] = 0;
                $infoEvaluacion[$row->id_evaluacion]["puntuacion"] = $row->valor;
                $infoEvaluacion[$row->id_evaluacion]["flag"] = true;
                $infoEvaluacion[$row->id_evaluacion]["menor_tiempo"] = -1;
            }
            $infoEvaluacion[$row->id_evaluacion]["veces_intentado"] ++;
            if ($row->calificacion >= $umbral) {
                $infoEvaluacion[$row->id_evaluacion]["veces_aprobado"] ++;
            }
            if ($infoEvaluacion[$row->id_evaluacion]["flag"] && $row->calificacion < $umbral) {
                $infoEvaluacion[$row->id_evaluacion]["puntuacion"]-=10 - 10 * $row->calificacion;
            } else if ($infoEvaluacion[$row->id_evaluacion]["flag"]) {
                $infoEvaluacion[$row->id_evaluacion]["puntuacion"] = MAX($valorMinimo, $infoEvaluacion[$row->id_evaluacion]["puntuacion"]);
                $infoEvaluacion[$row->id_evaluacion]["flag"] = false;
            }
            if ($row->fecha_inicial != null && $row->fecha_final != null) {
                $tiempo = strtotime($row->fecha_final) - strtotime($row->fecha_inicial);
                if ($tiempo < $infoEvaluacion[$row->id_evaluacion]["menor_tiempo"] || $infoEvaluacion[$row->id_evaluacion]["menor_tiempo"] == -1) {
                    $infoEvaluacion[$row->id_evaluacion]["menor_tiempo"] = $tiempo;
                }
            }
        }

        $evaluaciones = $this->evaluacion_model->obtenerEvaluacionesPorModulo($idModulo, $_SESSION["idUsuario"]);

        //  echo $this->db->last_query();
        $estatusPrev = "solved";
        foreach ($evaluaciones as $row) {
            if ($row->calificacion_maxima >= $umbral) {
                $row->estatus = "solved";
                $row->icono = "check";
                $estatusPrev = "solved";
                $row->ubicacion = "solved";
                $row->ubicacion = base_url() . "resources/$idCurso/$idModulo/" . $row->id_evaluacion . "/launch.html";
                $row->veces_aprobado = $infoEvaluacion[$row->id_evaluacion]["veces_aprobado"];
                $row->veces_intentado = $infoEvaluacion[$row->id_evaluacion]["veces_intentado"];
                $row->puntuacion = $infoEvaluacion[$row->id_evaluacion]["puntuacion"];
                $row->menor_tiempo = $infoEvaluacion[$row->id_evaluacion]["menor_tiempo"];
            } else if ($estatusPrev == "solved") {
                $row->estatus = "open";
                $row->icono = "unlock";
                $estatusPrev = "lock";
                $row->ubicacion = base_url() . "resources/$idCurso/$idModulo/" . $row->id_evaluacion . "/launch.html";
                $row->veces_aprobado = "0";
                $row->puntuacion = "0";
                $row->menor_tiempo = "--";
                if (isset($infoEvaluacion[$row->id_evaluacion])) {
                    $row->veces_intentado = $infoEvaluacion[$row->id_evaluacion]["veces_intentado"];
                } else {
                    $row->veces_intentado = "0";
                }
            } else {
                $row->estatus = "lock";
                $row->icono = "lock";
                $estatusPrev = "lock";
                $row->ubicacion = "";
                $row->veces_aprobado = "0";
                $row->veces_intentado = "0";
                $row->puntuacion = "0";
                $row->menor_tiempo = "--";
            }
        }


        $data["topN"] = $topN = $this->calcultarTopN($idModulo, 10, $idCurso);
        $data["evaluaciones"] = $evaluaciones;
        $data["cantidadEvaluaciones"] = sizeof($evaluaciones);
        $this->load->view('include/header', $data);
        $this->load->view('modulo_view');
        $this->load->view('include/footer');
    }

    public function crearModulo() {
        $this->escapar($_POST);
        if (empty($_POST["curso"]) || empty($_POST["nombre"]) || empty($_POST["desde"]) || empty($_POST["hasta"]) || empty($_POST["descripcion"])) {
            $this->mensaje("Por favor inténtalo nuevamante", "error");
        }
        $this->soyElProfesor($_POST["curso"]);
        $datos = array(
            'id_curso' => $_POST["curso"],
            'nombre' => $_POST["nombre"],
            'fecha_inicio' => $_POST["desde"],
            'fecha_fin' => $_POST["hasta"],
            'descripcion' => $_POST["descripcion"]
        );
        $this->modulo_model->crearModulo($datos);
        $this->mensaje("Modulo creado exitosamente", "success", "curso/" . $_POST["curso"]);
    }

    public function editarModulo() {
        $this->escapar($_POST);
        if (empty($_POST["curso"]) || empty($_POST["idModulo"]) || empty($_POST["nombre"]) || empty($_POST["desde"]) || empty($_POST["hasta"]) || empty($_POST["descripcion"])) {
            $this->mensaje("Por favor inténtalo nuevamante", "error");
        }
        $datos = array(
            'nombre' => $_POST["nombre"],
            'fecha_inicio' => $_POST["desde"],
            'fecha_fin' => $_POST["hasta"],
            'descripcion' => $_POST["descripcion"]
        );
        $where = array(
            'id_curso' => $_POST["curso"],
            'id_modulo' => $_POST["idModulo"]
        );
        $this->modulo_model->editarModulo($datos, $where);
        $this->mensaje("Modulo editado exitosamente", "success", "curso/" . $_POST["curso"]);
    }

    public function eliminarModulo() {
        $this->escapar($_POST);
        if (empty($_POST["curso"]) || empty($_POST["idModulo"])) {
            $this->mensaje("Por favor inténtalo nuevamante", "error");
        }
        $where = array(
            'id_curso' => $_POST["curso"],
            'id_modulo' => $_POST["idModulo"]
        );
        $this->modulo_model->eliminarModulo($where);
        $this->mensaje("Modulo eliminado exitosamente", "success", "curso/" . $_POST["curso"]);
    }

    private function calcultarTopN($idModulo, $n, $idCurso) {
        $topN = $this->usuario_x_modulo_model->obtenerTopN($idModulo, $n);
        $string = "";

        $i = 1;
        foreach ($topN as $row) {
            $string.="<img class='rank rank$i hide' title='Puesto: $i, Puntaje: {$row->puntaje},{$row->nombres} {$row->apellidos}' data-id-curso='$idCurso' data-id-modulo='$idModulo' data-id-estudiante='{$row->id_usuario}' data-nombre='{$row->nombres} {$row->apellidos}' data-puntaje='{$row->puntaje}' src='" . base_url() . "assets/img/avatares/thumbnails/{$row->imagen}'>";
            $i++;
        }
        $posiciones = $this->usuario_x_modulo_model->rankingModulo($idModulo);
        $i = 1;
        $posicion = "N/A";
        foreach ($posiciones as $row) {
            if ($row->id_usuario == $_SESSION["idUsuario"]) {
                $posicion = $i;
                break;
            }
            $i++;
        }
        return $string . "<a id='link-posicion' href='" . base_url() . "modulo/$idModulo'>$posicion</a>";
    }

}
