<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->model('usuario_x_evaluacion_model');
        $this->load->model('evaluacion_model');
        $this->load->model('modulo_model');
        $this->load->model('curso_model');
        $this->load->model('usuario_curso_logro_model');
        $this->load->model('usuario_x_evaluacion_model');
    }

    public function LMSInitialize() {
        if (empty($_POST['idEvaluacion'])) {
            exit();
        }
        $fechaInicial = date('Y-m-d H:i:s');
        $data = array(
            'id_usuario' => $_SESSION["idUsuario"],
            'id_evaluacion' => $_POST['idEvaluacion'],
            'calificacion' => 0,
            'fecha_inicial' => $fechaInicial
        );
        $this->usuario_x_evaluacion_model->crearIntento($data);
        $_SESSION[$_SESSION["idUsuario"] . "-" . $_POST['idEvaluacion']] = $this->db->insert_id();
    }

    public function LMSSetValue() {
        //Do something
    }

    public function LMSFinish() {
        //Do something
    }

    public function calificar() {
        $this->load->model('usuario_x_curso_model');

        if (!isset($_POST['idEvaluacion']) || !isset($_POST['duracion'])) {
            exit();
        }
        if ($_POST["calificacion"] == 1) {
            $feedback = "Correcto";
        } else if ($_POST["calificacion"] == 0) {
            $feedback = "Incorrecto";
        } else {
            $feedback = $_POST["feedback"];
        }
        $data = array(
            'id_usuario_evaluacion' => $_SESSION[$_SESSION["idUsuario"] . "-" . $_POST['idEvaluacion']],
            'calificacion' => $_POST["calificacion"],
            'duracion' => $_POST['duracion'],
            'realimentacion' => $feedback
        );
        unset($_SESSION[$_SESSION["idUsuario"] . "-" . $_POST['idEvaluacion']]);
        $this->usuario_x_evaluacion_model->calificar($data);

        $curso = $this->curso_model->obtenerCursoConEvaluacion($_POST['idEvaluacion']);
        $idCurso = $curso[0]->id_curso;
        $umbral = $curso[0]->umbral;
        if ($_POST["calificacion"] >= $umbral) {
            $this->actualizarPuntaje($_POST['idEvaluacion'], $umbral);
            $where = array("id_usuario" => $_SESSION["idUsuario"], "id_curso" => $idCurso);
            $logrosObtenidos = $this->usuario_curso_logro_model->obtenerRegistros($where);
            $idLogrosObtenidos = array();
            foreach ($logrosObtenidos as $row) {
                array_push($idLogrosObtenidos, $row->id_logro);
            }
            if (!in_array("1", $idLogrosObtenidos)) {// Si no tiene el logro 1
                $this->primeraEvaluacionResuelta($idCurso, $umbral);
            }

            $evaluacionesResueltas = $this->usuario_x_evaluacion_model->obtenerEvaluacionesAprobadas($idCurso, $umbral);
            $totalEvaluaciones = $this->evaluacion_model->obtenerTotalEvaluacionesCurso($idCurso);
            $totalEvaluaciones = $totalEvaluaciones[0]->total;
            $porcentaje = round(sizeof($evaluacionesResueltas) / $totalEvaluaciones, 2) * 100;
            $flag = true; // Si no obtuve un porcetnaje mayor al 25% no tiene sentido comprobar los demas porcentajes
            if (!in_array("2", $idLogrosObtenidos)) {
                $flag = $this->checkPorcentaje25($idCurso, $umbral, $porcentaje);
            }
            if ($flag && !in_array("3", $idLogrosObtenidos)) {
                $flag = $this->checkPorcentaje50($idCurso, $umbral, $porcentaje);
            }
            if ($flag && !in_array("4", $idLogrosObtenidos)) {
                $flag = $this->checkPorcentaje75($idCurso, $umbral, $porcentaje);
            }
            if ($flag && !in_array("5", $idLogrosObtenidos)) {
                $this->checkPorcentaje100($idCurso, $umbral, $porcentaje);
            }
            if (!in_array("11", $idLogrosObtenidos) || !in_array("12", $idLogrosObtenidos) || !in_array("13", $idLogrosObtenidos)) {
                $this->enLinea($idCurso, $umbral);
            }
            $this->checkNivel($idCurso, $curso[0]->niveles, $porcentaje);
        }
    }

    public function actualizarPuntaje($idEvaluacion, $umbral) {
        $this->load->model('usuario_x_modulo_model');

        $vecesAprobadaEvaluacion = $this->usuario_x_evaluacion_model->vecesAprobada($idEvaluacion, $umbral);
        if ($vecesAprobadaEvaluacion[0]->total == 1) {
            $modulo = $this->modulo_model->obtenerModuloConEvaluacion($idEvaluacion);
            $idModulo = $modulo[0]->id_modulo;
            $intentos = $this->usuario_x_evaluacion_model->obtenerIntentos($idEvaluacion);
            $valorMaximo = $modulo[0]->valor;
            $valorMinimo = 150;
            $puntajeTotal = 0;
            $array = array();
            foreach ($intentos as $row) {
                if (!array_key_exists($row->id_evaluacion, $array)) {
                    $array[$row->id_evaluacion] = array('id_usuario_evaluacion' => $row->id_usuario_evaluacion, 'puntaje' => $valorMaximo, 'calificacion' => $row->calificacion, 'flag' => true);
                }
                if ($array[$row->id_evaluacion]['flag'] && $row->calificacion < $umbral) {
                    $array[$row->id_evaluacion]['puntaje'] -=(10 - 10 * $row->calificacion);
                } else if ($array[$row->id_evaluacion]['flag']) {
                    $puntajeTotal += max($valorMinimo, $array[$row->id_evaluacion]['puntaje']);
                    $array[$row->id_evaluacion]['flag'] = false;
                }
            }
            $where = array("id_usuario" => $_SESSION["idUsuario"], "id_modulo" => $idModulo);
            $existe = $this->usuario_x_modulo_model->obtenerRegistro($where);
            if ($existe) {
                $data = array("puntaje" => $puntajeTotal+$existe[0]->puntaje);
                $where = array("id_usuario_modulo" => $existe[0]->id_usuario_modulo);
                $this->usuario_x_modulo_model->actualizar($data, $where);
            } else {
                $data = array("id_usuario" => $_SESSION["idUsuario"],
                    "id_modulo" => $idModulo,
                    "puntaje" => $puntajeTotal);
                $this->usuario_x_modulo_model->crear($data);
            }
        }
    }

    public function primeraEvaluacionResuelta($idCurso, $umbral) {
        $evaluacionesResueltas = $this->usuario_x_evaluacion_model->obtenerEvaluacionesAprobadas($idCurso, $umbral);
        if (sizeof($evaluacionesResueltas) == 1) {
            $data = array(
                'id_usuario' => $_SESSION["idUsuario"],
                'id_logro' => 1,
                'id_curso' => $idCurso
            );
            $this->usuario_curso_logro_model->crear($data);
        }
    }

    public function checkPorcentaje25($idCurso, $umbral, $porcentaje) {
        if ($porcentaje >= 25) {
            $data = array(
                'id_usuario' => $_SESSION["idUsuario"],
                'id_logro' => 2,
                'id_curso' => $idCurso
            );
            $this->usuario_curso_logro_model->crear($data);
            return true;
        } else {
            return false;
        }
    }

    public function checkPorcentaje50($idCurso, $umbral, $porcentaje) {
        if ($porcentaje >= 50) {
            $data = array(
                'id_usuario' => $_SESSION["idUsuario"],
                'id_logro' => 3,
                'id_curso' => $idCurso
            );
            $this->usuario_curso_logro_model->crear($data);
            return true;
        } else {
            return false;
        }
    }

    public function checkPorcentaje75($idCurso, $umbral, $porcentaje) {
        if ($porcentaje >= 75) {
            $data = array(
                'id_usuario' => $_SESSION["idUsuario"],
                'id_logro' => 4,
                'id_curso' => $idCurso
            );
            $this->usuario_curso_logro_model->crear($data);
            return true;
        } else {
            return false;
        }
    }

    public function checkPorcentaje100($idCurso, $umbral, $porcentaje) {
        if ($porcentaje == 100) {
            $data = array(
                'id_usuario' => $_SESSION["idUsuario"],
                'id_logro' => 5,
                'id_curso' => $idCurso
            );
            $this->usuario_curso_logro_model->crear($data);
        }
    }

    public function enLinea($idCurso, $umbral) {
        $ultimasEvaluaciones = $this->usuario_x_evaluacion_model->obtenerUltimasEvaluaciones($idCurso, 20);
        $keys = array();
        foreach ($ultimasEvaluaciones as $row) {
            if ($row->calificacion >= $umbral) {
                if (!in_array($row->id_evaluacion, $keys)) {
                    array_push($keys, $row->id_evaluacion);
                }
                $t = sizeof($keys);
                if ($t == 3) {
                    $tieneElLogro = $this->usuario_curso_logro_model->checkLogro($idCurso, "11");
                    if (sizeof($tieneElLogro) == "0") {
                        $data = array(
                            'id_usuario' => $_SESSION["idUsuario"],
                            'id_logro' => 11,
                            'id_curso' => $idCurso
                        );
                        $this->usuario_curso_logro_model->crear($data);
                    }
                } else if ($t == 5) {
                    $tieneElLogro = $this->usuario_curso_logro_model->checkLogro($idCurso, "12");
                    if (sizeof($tieneElLogro) == "0") {
                        $data = array(
                            'id_usuario' => $_SESSION["idUsuario"],
                            'id_logro' => 12,
                            'id_curso' => $idCurso
                        );
                        $this->usuario_curso_logro_model->crear($data);
                    }
                } else if ($t == 10) {
                    $tieneElLogro = $this->usuario_curso_logro_model->checkLogro($idCurso, "13");
                    if (sizeof($tieneElLogro) == "0") {
                        $data = array(
                            'id_usuario' => $_SESSION["idUsuario"],
                            'id_logro' => 13,
                            'id_curso' => $idCurso
                        );
                        $this->usuario_curso_logro_model->crear($data);
                    }
                } else if ($t > 10) {
                    break;
                }
            } else {
                break;
            }
        }
    }

    public function checkNivel($idCurso, $cantidadNiveles, $porcentaje) {
        $valorPorNivel = 100 / $cantidadNiveles;
        $nivel = ceil($porcentaje / $valorPorNivel);
        $this->usuario_x_curso_model->actualizar(array("id_nivel" => $nivel), array("id_curso" => $idCurso, "id_usuario" => $_SESSION["idUsuario"]));
    }

}
