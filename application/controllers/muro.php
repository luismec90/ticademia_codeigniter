<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Muro extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->estoyLogueado();
        $this->load->model('curso_model');
        $this->load->model('muro_model');
    }

    public function index($idCurso = -1) {
        $this->load->model('usuario_curso_logro_model');
        
        $this->verificarMatricula($idCurso);
        $data["tab"] = "muro";
        $data["css"] = array("css/muro");
        $data["js"] = array("js/muro");
        $data["idCurso"] = $idCurso;
        index_bitacora($idCurso);
        $curso = $this->curso_model->obtenerCursoCompleto($idCurso);
        $data["nombre_curso"] = $curso[0]->nombre;
        $data["mensajes"] = $this->muro_model->obtenerMensajesCompletos($idCurso);
        foreach ($data["mensajes"] as $row) {
            $data["reply"][$row->id_muro] = $this->muro_model->obtenerRespuestas($row->id_muro);
            if ($row->tipo == "logro") {
                $logro = $this->usuario_curso_logro_model->obtenerLogro($row->mensaje);
                $row->mensaje = "<h4 class='text-info'>  <img class='img-responsive col-xs-6 col-sm-3 col-md-2 col-lg-1' src='". base_url() . "assets/img/logro/{$logro[0]->id_logro}.png'> <span class='col-xs-12 col-sm-7'><br>He obtenido el logro: <b>{$logro[0]->nombre}</b></span></h4>
                ";
            }
        }
        $this->load->view('include/header', $data);
        $this->load->view('muro_view');
        $this->load->view('include/footer');
    }

    public function crear() {
        $idCurso = $this->input->post("idCurso");
        $mensaje = $this->input->post("mensaje");
        if (!$idCurso || !$mensaje) {
            $this->mensaje("Por favor inténtalo nuevamente", "error");
        }
        $this->verificarMatricula($idCurso);
        $data = array("id_curso" => $idCurso,
            "id_usuario" => $_SESSION["idUsuario"],
            "mensaje" => $mensaje
        );
        $this->muro_model->crear($data);
        $this->mensaje("Mensaje creado exitosamente", "success", "muro/$idCurso");
    }

    public function responder() {
        $idCurso = $this->input->post("idCurso");
        $idMensaje = $this->input->post("idMensaje");
        $mensaje = $this->input->post("mensaje");
        if (!$idCurso || !$idMensaje || !$mensaje) {
            $this->mensaje("Por favor inténtalo nuevamente", "error");
        }
        $this->verificarMatricula($idCurso);
        $data = array("id_curso" => $idCurso,
            "muro_id_muro" => $idMensaje,
            "id_usuario" => $_SESSION["idUsuario"],
            "mensaje" => $mensaje
        );
        $this->muro_model->crear($data);
        $this->mensaje("Mensaje creado exitosamente", "success", "muro/$idCurso");
    }

    public function eliminar() {
        $idCurso = $this->input->post("idCurso");
        $idMensaje = $this->input->post("idMensaje");
        if (!$idCurso || !$idMensaje) {
            $this->mensaje("Por favor inténtalo nuevamente", "error");
        }
        $where = array("id_muro" => $idMensaje, "id_usuario" => $_SESSION["idUsuario"]);
        $mensaje = $this->muro_model->obtener($where);
        if (!$mensaje) {
            $this->mensaje("Por favor inténtalo nuevamente", "error");
        }
        $this->muro_model->eliminar($where);
        $this->mensaje("Mensaje eliminado exitosamente", "success", "muro/$idCurso");
    }

}
