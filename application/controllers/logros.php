<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Logros extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->model('curso_model');
        $this->load->model('usuario_model');
        $this->load->model('usuario_curso_logro_model');
    }

    public function index($idCurso) {
        $this->estoyLogueado();
        $this->verificarMatricula($idCurso);
        $data = array();
        $curso = $this->curso_model->obtenerCursoCompleto($idCurso);
        $data["tab"] = "logros";
        $data["nombre_curso"] = $curso[0]->nombre;
        $data["idCurso"] = $idCurso;
        index_bitacora($idCurso);
        $data["logros"] = $this->usuario_curso_logro_model->logrosPorCurso($idCurso);
        $this->load->view('include/header', $data);
        $this->load->view('listar_logros_view');
        $this->load->view('include/footer');
    }

    public function verLogro($idCurso, $idLogroUsuario) {
        $data = array();
        $data["tab"] = "logros";
        $data["css"] = array("css/ver_logro");
        $curso = $this->curso_model->obtenerCursoCompleto($idCurso);
        $data["nombre_curso"] = $curso[0]->nombre;
        $data["idCurso"] = $idCurso;
        $data["idLogroUsuario"] = $idLogroUsuario;
        $data["logro"] = $this->usuario_curso_logro_model->obtenerLogro($idLogroUsuario);
        if (sizeof($data["logro"]) == 0) {
            $this->mensaje("El logro no existe", "warning");
        }
        $data["usuario"] = $this->usuario_model->obtenerUsuario(array("id_usuario" => $data["logro"][0]->id_usuario));
        $data["logro"][0]->imagen = base_url() . "assets/img/logro/{$data["logro"][0]->id_logro}.png";
        $this->load->view('include/header', $data);
        $this->load->view('ver_logro_view');
        $this->load->view('include/footer');
    }

    public function compartir() {
        var_dump($_POST);
        $this->load->model('muro_model');
        $idUsuarioCursoLogro = $this->input->post('idUsuarioCursoLogro');
        $logro = $this->usuario_curso_logro_model->obtenerRegistros(array("id_usuario_curso_logro" => $idUsuarioCursoLogro, "id_usuario" => $_SESSION["idUsuario"]));
        if ($logro) {
            $data = array("id_curso" => $logro[0]->id_curso,
                "id_usuario" => $_SESSION["idUsuario"],
                "mensaje" => $idUsuarioCursoLogro,
                "tipo" => "logro"
            );
            $this->muro_model->crear($data);
            $this->mensaje("Logro compartido exitosamente", "success", "muro/" . $logro[0]->id_curso);
        } else {
            $this->mensaje("Por favor inténtalo nuevamente", "error");
        }
    }

}

//http://leta.artrow.net/