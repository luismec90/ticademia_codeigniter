<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Curso extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->estoyLogueado();
        $this->load->model('curso_model');
        $this->load->model('usuario_x_modulo_model');
    }

    public function verCurso($idCurso) {
        $this->verificarMatricula($idCurso);
        $this->load->model('modulo_model');


        $data["tab"] = "curso";
        $data["css"] = array("libs/jquery-ui-1.10.4.custom/css/redmond/jquery-ui-1.10.4.custom.min", "css/curso", "css/ranking");
        $data["js"] = array("libs/time-line/storyjs-embed", "libs/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min", "js/curso");
        $data["idCurso"] = $idCurso;
        index_bitacora($idCurso);
        $modulos = $this->modulo_model->getModulos($idCurso);
        $data["json"] = $this->generarJson($modulos, $idCurso);



        $data["ranking"] = "";
        //  var_dump($data["ranking"]);
        //exit();


        $this->load->view('include/header', $data);
        $this->load->view('curso_view');
        $this->load->view('include/footer');
    }

    public function matricularse($idCurso) {
        $curso = $this->curso_model->obtenerCurso($idCurso);
        if ($curso) {
            $this->load->model('usuario_x_curso_model');
            $where = array("id_curso" => $idCurso, "id_usuario" => $_SESSION["idUsuario"]);
            $validar = $this->usuario_x_curso_model->obtenerRegistro($where);
            if (!$validar) {
                $datos = array(
                    'id_curso' => $idCurso,
                    'id_usuario' => $_SESSION["idUsuario"],
                    'fecha' => date("Y-m-d H:i:s")
                );
                $this->usuario_x_curso_model->crear($datos);
            }
            $this->mensaje("Se ha matriculado exitosamente", "success", "curso/$idCurso");
        } else {
            $this->mensaje("Por favor inténtalo nuevamente", "error");
        }
    }

    private function generarJson($modulos, $idCurso) {


        $c['timeline']['headline'] = 'Cálculo diferencial';
        $c['timeline']['type'] = 'default';
        $c['timeline']['text'] = '';
        $c['timeline']['date'] = array();

        if ($_SESSION["rol"] == "estudiante") {
            foreach ($modulos as $row) {
                $topN = $this->calcultarTopN($row->id_modulo, 10, $idCurso);
                array_push($c['timeline']['date'], array(
                    "headline" => $row->nombre,
                    "startDate" => str_replace("-", ",", $row->fecha_inicio),
                    "endDate" => str_replace("-", ",", $row->fecha_fin),
                    "classname" => "modulo" . $row->id_modulo,
                    "text" => $row->descripcion,
                    "asset" => array(
                        "media" => '../assets/img/p2.png',
                        "credit" => "$topN<span title='Ver ranking' class='btn btn-info btn-ver-ranking' onclick='loadRankingMod(this)' data-id-modulo='" . $row->id_modulo . "' data-id-curso='$idCurso'><i class='fa fa-trophy'></i> Ranking</span>"
                    )
                ));
            }
        } else if ($_SESSION["rol"] == "profesor") {
            foreach ($modulos as $row) {
                $topN = $this->calcultarTopN($row->id_modulo, 10, $idCurso);
                array_push($c['timeline']['date'], array(
                    "headline" => $row->nombre,
                    "startDate" => str_replace("-", ",", $row->fecha_inicio),
                    "endDate" => str_replace("-", ",", $row->fecha_fin),
                    "classname" => "modulo" . $row->id_modulo,
                    "text" => $row->descripcion,
                    "asset" => array(
                        "media" => '../assets/img/p2.png',
                        "credit" => "$topN<span title='Ver ranking' class='btn btn-info' onclick='loadRankingMod(this)'  data-id-modulo='" . $row->id_modulo . "'  data-id-curso='$idCurso'><i class='fa fa-trophy'></i> Ranking</span>
                                <span title='Editar módulo' class='btn btn-warning editarModulo' data-toggle='modal' data-target='#modalEditarModulo' data-id-modulo='" . $row->id_modulo . "' data-nombre='" . $row->nombre . "' data-desde='" . $row->fecha_inicio . "' data-hasta='" . $row->fecha_fin . "' data-descripcion='" . $row->descripcion . "'> <i class='fa fa-pencil-square-o'></i> Editar</span>
                                <span title='Eliminar módulo' class='btn btn-danger eliminarModulo' data-toggle='modal' data-target='#modalEliminarModulo' data-id-modulo='" . $row->id_modulo . "' data-nombre='" . $row->nombre . "'><i class='fa fa-trash-o'></i> Eliminar</span>"
                    )
                ));
            }
        }
        //    var_dump($c['timeline']['date']);
        //  exit();
        $r = json_encode($c);
        return $r;
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
