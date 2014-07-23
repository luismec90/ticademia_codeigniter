<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ranking extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->estoyLogueado();
        $this->load->model('curso_model');
        $this->load->model('usuario_x_modulo_model');
    }

    public function index($idCurso) {
        $this->verificarMatricula($idCurso);

        if ($_SESSION["rol"] != 2) {
            $data["tab"] = "ranking";
            $data["limit"] = (empty($_GET["limit"])) ? 10 : $_GET["limit"];
            $curso = $this->curso_model->obtenerCursoCompleto($idCurso);
            $data["nombre_curso"] = $curso[0]->nombre;
            $data["idCurso"] = $idCurso;
            index_bitacora($idCurso);
            $posiciones = $this->usuario_x_modulo_model->rankingCurso($idCurso);
            $data["posicion"] = "n/a";
            $data["nombre_completo"] = $_SESSION["nombre"];
            $data["puntaje"] = 0;
            $i = 1;
            foreach ($posiciones as $row) {
                if ($row->id_usuario == $_SESSION["idUsuario"]) {
                    $data["posicion"] = $i;
                    $data["nombre_completo"] = $row->nombres . " " . $row->apellidos;
                    $data["puntaje"] = $row->puntaje_total;
                    break;
                }
                $i++;
            }

            //  var_dump($posiciones);

            $data["posiciones"] = $posiciones;
            $this->load->view('include/header', $data);
            $this->load->view('ranking_view');
            $this->load->view('include/footer');
        } else {
            $data["tab"] = "ranking";
            $data["css"] = array("libs/bootstrap-table/bootstrap-table");
            $data["js"] = array("libs/bootstrap-table/bootstrap-table", "js/ranking_profesor");
            $data["idCurso"] = $idCurso;

            $this->load->view('include/header', $data);
            $this->load->view('ranking_profesor_view');
            $this->load->view('include/footer');
        }
    }

    public function rankingJson($idCurso) {
        $this->load->model('modulo_model');
        $this->load->model('muro_model');
        $this->load->model('tema_foro_model');
        $this->load->model('material_model');
        $this->load->model('evaluacion_model');
        $this->load->model('usuario_curso_logro_model');
        $this->load->model('bitacora_model');

        $json = array();
        $posiciones = $this->usuario_x_modulo_model->rankingCursoCompleto($idCurso);
        $i = 1;
        foreach ($posiciones as $row) {

            // $row->total_time = round($row->total_time);

            $listaModulos = $this->modulo_model->getModulos($idCurso);
            $modulosAprobados = 0;
            foreach ($listaModulos as $modulo) {
                $cantidadEvaluaciones = $this->evaluacion_model->cantidadEvaluacionesPorModulo($modulo->id_modulo);
                if ($cantidadEvaluaciones[0]->cantidad != 0) {
                    $cantidadEvaluacionesAprobadas = $this->evaluacion_model->cantidadEvaluacionesAprobadasPorModulo($row->id_usuario, $modulo->id_modulo, $idCurso);
                    if ($cantidadEvaluaciones[0]->cantidad == $cantidadEvaluacionesAprobadas[0]->cantidad) {
                        $modulosAprobados++;
                    }
                }
            }

            $last_login = $this->bitacora_model->lastLoginCurso($row->id_usuario, $idCurso);
            $last_login = $last_login[0]->last_login;

            $logins = $this->bitacora_model->cantidadAccesos($row->id_usuario, $idCurso);
            $logins = $logins[0]->cantidad;

            $total_time = $this->bitacora_model->obtenerTiempoLogueado($row->id_usuario, $idCurso);
            $total_time = round($total_time[0]->tiempo * 60);

            $logros = $this->usuario_curso_logro_model->contarLogrosObtenidos($row->id_usuario, $idCurso);
            $logros = $logros[0]->cantidad;

            $evaluaciones = $this->evaluacion_model->cantidadEvaluacionesAprobadas($row->id_usuario, $idCurso);
            $evaluaciones = $evaluaciones[0]->cantidad;

            $materiales = $this->material_model->cantidadMaterialesObservados($row->id_usuario, $idCurso);
            $materiales = $materiales[0]->cantidad;

            $videos = $this->material_model->porcentajeVisualizacionTodoElCurso($row->id_usuario, $idCurso);
            $videos = $videos[0]->promedio;

            if(!$videos){
                $videos=0;
            }
            
            $foro = $this->tema_foro_model->contarPublicaciones($row->id_usuario, $idCurso);
            $foro = $foro[0]->cantidad;

            $muro = $this->muro_model->contarPublicaciones($row->id_usuario, $idCurso);
            $muro = $muro[0]->cantidad;



            $aux = array(
                "posicion" => $i++,
                "nombre" => "<a href='" . base_url() . "infoestudiante/{$row->id_usuario}/$idCurso'>$row->nombres</a>",
                "avatar" => "<img width='70' src='" . base_url() . "assets/img/avatares/thumbnails/" . $row->imagen . "'>",
                "puntaje" => $row->puntaje_total,
                "last_login" => $last_login,
                "logins" => $logins,
                "total_time" => $total_time,
                "logros" => $logros,
                "modulos" => $modulosAprobados,
                "evaluaciones" => $evaluaciones,
                "materiales" => $materiales,
                "videos" => $videos."%",
                "foro" => $foro,
                "muro" => $muro
            );
            array_push($json, $aux);
        }
        echo json_encode($json);
    }

}
