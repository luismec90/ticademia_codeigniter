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
    }

}
