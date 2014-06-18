<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Foro extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->model('tema_foro_model');
        $this->load->model('respuesta_model');
        $this->load->model('curso_model');
        $this->load->model('usuario_curso_logro_model');
    }

    public function index($idCurso) {

        $data["tab"] = "foro";
        $data["css"] = array("css/foro");
        $data["js"] = array("js/foro");
        $data["idCurso"] = $idCurso;
        index_bitacora($idCurso);
        $data["idUsuario"] = $_SESSION["idUsuario"];
        $curso = $this->curso_model->obtenerCursoCompleto($idCurso);
        $data["nombre_curso"] = $curso[0]->nombre;
        $filasPorPagina = 20;
        if (empty($_GET["page"])) {
            $inicio = 0;
            $paginaActual = 1;
        } else {
            $inicio = ($_GET["page"] - 1) * $filasPorPagina;
            $paginaActual = $_GET["page"];
        }
        $data["temas"] = $this->tema_foro_model->listarTemas($idCurso, $filasPorPagina, $inicio);
        $data['paginaActiva'] = $paginaActual;
        $data["cantidadRegistros"] = $this->tema_foro_model->cantidadRegistros();
        $data["cantidadRegistros"] = $data["cantidadRegistros"][0]->cantidad;
        $data["filasPorPagina"] = $filasPorPagina;
        $data['cantidadPaginas'] = ceil($data["cantidadRegistros"] / $filasPorPagina);
        foreach ($data["temas"] as $row) {
            $respuestas = $this->respuesta_model->obtenerUltimaRespuesta($row->id_tema_foro);
            $row->cantidad_respuestas = $respuestas[0]->cantidad_respuestas;
            $row->ultima_respuesta = $respuestas[0]->respuesta;
            $row->usuario_ultima_respuesta = $respuestas[0]->usuario_ultima_respuesta;
            $row->fecha_ultimo_comentario = $respuestas[0]->fecha_creacion;
            if (strlen($row->descripcion) > 100) {
                $row->descripcion = substr($row->descripcion, 0, 100) . "...";
            }
            if (strlen($row->ultima_respuesta) > 50) {
                $row->ultima_respuesta = substr($row->ultima_respuesta, 0, 50) . "...";
            }
        }
        //exit();
        $this->load->view('include/header', $data);
        $this->load->view('foro_view');
        $this->load->view('include/footer');
    }

    public function verTema($idCurso, $idTema) {


        $data["tab"] = "foro";
        $data["css"] = array("css/foro");
        $data["js"] = array("js/foro");
        $data["idCurso"] = $idCurso;
//        $this->checkNuevosTemas($idCurso, $data);
        $data["idTema"] = $idTema;
        $filasPorPagina = 20;
        if (empty($_GET["page"])) {
            $inicio = 0;
            $paginaActual = 1;
        } else {
            $inicio = ($_GET["page"] - 1) * $filasPorPagina;
            $paginaActual = $_GET["page"];
        }
        $data['paginaActiva'] = $paginaActual;


        $data["tema"] = $this->tema_foro_model->obtenerTema($idTema);
        $data["respuestas"] = $this->respuesta_model->listarRespuestas($idTema, $filasPorPagina, $inicio);
        $data["cantidadRegistros"] = $this->respuesta_model->cantidadRegistros();
        $data["cantidadRegistros"] = $data["cantidadRegistros"][0]->cantidad;
        $data["filasPorPagina"] = $filasPorPagina;
        $data['cantidadPaginas'] = ceil($data["cantidadRegistros"] / $filasPorPagina);

        $data["idUsuario"] = $_SESSION["idUsuario"];
        $this->load->view('include/header', $data);
        $this->load->view('tema_view');
        $this->load->view('include/footer');
    }

    public function crearTema($idCurso) {

        $datos = array(
            'id_curso' => $idCurso,
            'id_usuario' => $_SESSION["idUsuario"],
            'nombre' => $this->input->post('nombre'),
            'descripcion' => $this->input->post('descripcion'),
            'fecha_creacion' => date('Y-m-d H:i:s')
        );
        $this->tema_foro_model->crearTema($datos);
        $this->logroMiPrimeraParticipacion($idCurso);
        $this->mensaje("Tema creado exitosamente", "success", "foro/$idCurso");
    }

    public function eliminarTema($idCurso) {
        $datos = array('id_tema_foro' => $this->input->post('idTema'));
        $this->tema_foro_model->eliminarTema($datos);
        $this->mensaje("Tema eliminado exitosamente", "success", "foro/$idCurso");
    }

    public function responder($idCurso, $idTema) {

        $datos = array(
            'id_tema_foro' => $idTema,
            'id_usuario' => $_SESSION["idUsuario"],
            'respuesta' => $this->input->post('respuesta'),
            'fecha_creacion' => date('Y-m-d H:i:s')
        );
        $this->respuesta_model->crearRespuesta($datos);
        $this->logroMiPrimeraParticipacion($idCurso);
        $this->temaPopular($idCurso, $idTema);
        $this->temaSuperPopular($idCurso, $idTema);
        $this->muyParticipativo($idCurso);
        $this->superparticipativo($idCurso);
        $this->mensaje("Mensaje creado exitosamente", "success", "foro/$idCurso/$idTema");
    }

    public function eliminarRespuesta($idCurso, $idTema) {
        $datos = array('id_respuesta' => $this->input->post('idRespuesta'));
        $this->respuesta_model->eliminarRespuesta($datos);
        $this->mensaje("Respuesta eliminada exitosamente", "success", "foro/$idCurso/$idTema");
    }

    private function logroMiPrimeraParticipacion($idCurso) {
        $tieneElLogro = $this->usuario_curso_logro_model->checkLogro($idCurso, "6"); //6 es el id del logro
        if (sizeof($tieneElLogro) == "0") {
            if ($this->tema_foro_model->haParticipadoForo() == "1") {
                if (sizeof($tieneElLogro) == "0") {
                    $data = array(
                        'id_usuario' => $_SESSION["idUsuario"],
                        'id_logro' => 6,
                        'id_curso' => $idCurso
                    );
                    $this->usuario_curso_logro_model->crear($data);
                }
            }
        }
    }

    private function temaPopular($idCurso, $idTema) {

        $r = $this->tema_foro_model->temasPopulares($idTema, 5);
        if (sizeof($r) > 0) {
            $tieneElLogro = $this->usuario_curso_logro_model->checkLogroOtroUsuario($r[0]->id_usuario, $idCurso, "7"); //7 es el id del logro
            if (sizeof($tieneElLogro) == "0") {
                $data = array(
                    'id_usuario' => $r[0]->id_usuario,
                    'id_logro' => 7,
                    'id_curso' => $idCurso
                );
                $this->usuario_curso_logro_model->crear($data);
            }
        }
    }

    private function temaSuperPopular($idCurso, $idTema) {
        $r = $this->tema_foro_model->temasPopulares($idTema, 20);
        if (sizeof($r) > 0) {
            $tieneElLogro = $this->usuario_curso_logro_model->checkLogroOtroUsuario($r[0]->id_usuario, $idCurso, "8");
            if (sizeof($tieneElLogro) == "0") {
                $data = array(
                    'id_usuario' => $r[0]->id_usuario,
                    'id_logro' => 8,
                    'id_curso' => $idCurso
                );
                $this->usuario_curso_logro_model->crear($data);
            }
        }
    }

    private function muyParticipativo($idCurso) {
        $tieneElLogro = $this->usuario_curso_logro_model->checkLogro($idCurso, "9");
        if (sizeof($tieneElLogro) == "0") {
            $r = $this->tema_foro_model->muyParticipativo($idCurso, 5);
            if (sizeof($r) > 0) {
                $data = array(
                    'id_usuario' => $_SESSION["idUsuario"],
                    'id_logro' => 9,
                    'id_curso' => $idCurso
                );
                $this->usuario_curso_logro_model->crear($data);
            }
        }
    }

    private function superparticipativo($idCurso) {
        $tieneElLogro = $this->usuario_curso_logro_model->checkLogro($idCurso, "10");
        if (sizeof($tieneElLogro) == "0") {
            $r = $this->tema_foro_model->muyParticipativo($idCurso, 20);
            if (sizeof($r) > 0) {
                $data = array(
                    'id_usuario' => $_SESSION["idUsuario"],
                    'id_logro' => 10,
                    'id_curso' => $idCurso
                );
                $this->usuario_curso_logro_model->crear($data);
            }
        }
    }

}
