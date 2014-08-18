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
        
    }

    public function checkSinInformacion() {
        if (empty($_POST['idEvaluacion'])) {
            exit();
        }
        $data = array(
            'id_usuario_evaluacion' => $_SESSION[$_SESSION["idUsuario"] . "-" . $_POST['idEvaluacion']]
        );
        unset($_SESSION[$_SESSION["idUsuario"] . "-" . $_POST['idEvaluacion']]);
        $this->usuario_x_evaluacion_model->setSinInformacion($data);
    }

    public function calificar() {
        $A = array("Felicitaciones", "Enhorabuena", "Magnífico", "Perfecto", "Muy bien");
        $B = array(", tu respuesta es correcta", ", has acertado", ", lo hiciste sin errores", ", te has lucido con la respuesta");

        $C = array("Lamentablemente", "Desafortunadamente", "Tendrás que esforzarte más", "Lo siento");
        $D = array(", la respuesta no es correcta", ", no has acertado");



        $this->load->model('usuario_x_curso_model');

        if (!isset($_POST['idEvaluacion']) || !isset($_POST['duracion'])) {
            exit();
        }
        if ($_POST["calificacion"] == 1) {
            $feedback = $A[rand(0, 4)] . $B[rand(0, 3)];
            $realimentacion = "Correcto";
        } else if (true || $_POST["calificacion"] == 0) {
            $feedback = $C[rand(0, 3)] . $D[rand(0, 1)];
            $realimentacion = "Incorrecto";
        } else {
            $feedback = $_POST["feedback"];
            $realimentacion = $feedback;
        }
        echo $feedback . ".";
        if ($_SESSION["rol"] != 1) { //Si no es un estudiante no continuar
            exit();
        }
        $data = array(
            'id_usuario_evaluacion' => $_SESSION[$_SESSION["idUsuario"] . "-" . $_POST['idEvaluacion']],
            'calificacion' => $_POST["calificacion"],
            'duracion' => $_POST['duracion'],
            'realimentacion' => $realimentacion
        );

        $this->usuario_x_evaluacion_model->calificar($data);

        $curso = $this->curso_model->obtenerCursoConEvaluacion($_POST['idEvaluacion']);
        $idCurso = $curso[0]->id_curso;
        $umbral = $curso[0]->umbral;

        if ($_POST["calificacion"] >= $umbral) {
            $puntajeLogrado = $this->actualizarPuntaje($_POST['idEvaluacion'], $umbral);
            $where = array("id_usuario" => $_SESSION["idUsuario"], "id_curso" => $idCurso);
            $logrosObtenidos = $this->usuario_curso_logro_model->obtenerRegistros($where);
            $idLogrosObtenidos = array();
            foreach ($logrosObtenidos as $row) {
                array_push($idLogrosObtenidos, $row->id_logro);
            }


            $evaluacionesResueltas = $this->usuario_x_evaluacion_model->obtenerEvaluacionesAprobadas($idCurso, $umbral);
            $totalEvaluaciones = $this->evaluacion_model->obtenerTotalEvaluacionesCurso($idCurso);
            $totalEvaluaciones = $totalEvaluaciones[0]->total;
            $porcentaje = round(sizeof($evaluacionesResueltas) / $totalEvaluaciones, 2) * 100;

            if (!in_array("1", $idLogrosObtenidos)) {//Si no tiene el logro primer ejercicio, darselo
                $data = array(
                    'id_usuario' => $_SESSION["idUsuario"],
                    'id_logro' => 1,
                    'id_curso' => $idCurso
                );
                $this->usuario_curso_logro_model->crear($data);
            }

            if (!in_array("11", $idLogrosObtenidos) || !in_array("12", $idLogrosObtenidos) || !in_array("13", $idLogrosObtenidos)) {
                $this->enLinea($idCurso, $umbral);
            }
            $mensajeNivel = $this->checkNivel($idCurso, $curso[0]->niveles, $porcentaje);
            if ($puntajeLogrado != -1) {// Si es la primera vez que responde la pregunta
                echo "<br><br>Acabas de ganar <b>$puntajeLogrado <span class='glyphicon glyphicon-star'></span> puntos</b> y tu tiempo fue de <b>{$_POST['duracion']} <span class='glyphicon glyphicon glyphicon-time'></span> segundos</b>.";
            }
            echo $mensajeNivel;
        }
    }

    public function actualizarPuntaje($idEvaluacion, $umbral) {
        $this->load->model('usuario_x_modulo_model');

        $vecesAprobadaEvaluacion = $this->usuario_x_evaluacion_model->vecesAprobada($idEvaluacion, $umbral);
        $vecesSaltada = $this->usuario_x_evaluacion_model->vecesSaltada($idEvaluacion);
        if ($vecesAprobadaEvaluacion[0]->total == 1 && $vecesSaltada[0]->total == 0) {
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
            $retornarPuntajeTotal = $puntajeTotal;
            $where = array("id_usuario" => $_SESSION["idUsuario"], "id_modulo" => $idModulo);
            $existe = $this->usuario_x_modulo_model->obtenerRegistro($where);
            if ($existe) {
                $data = array("puntaje" => $puntajeTotal + $existe[0]->puntaje);
                $where = array("id_usuario_modulo" => $existe[0]->id_usuario_modulo);
                $this->usuario_x_modulo_model->actualizar($data, $where);
            } else {
                $data = array("id_usuario" => $_SESSION["idUsuario"],
                    "id_modulo" => $idModulo,
                    "puntaje" => $puntajeTotal);
                $this->usuario_x_modulo_model->crear($data);
            }
            return $retornarPuntajeTotal;
        } else {
            return -1;
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
        $this->load->model('bitacora_nivel_model');
        $this->load->model('nivel_model');
        $this->load->model('usuario_model');

        if ($porcentaje > 90) {
            $nivel = 9;
        } else if ($porcentaje > 80) {
            $nivel = 8;
        } else if ($porcentaje > 70) {
            $nivel = 7;
        } else if ($porcentaje > 50) {
            $nivel = 6;
        } else if ($porcentaje > 30) {
            $nivel = 5;
        } else if ($porcentaje > 20) {
            $nivel = 4;
        } else if ($porcentaje > 10) {
            $nivel = 3;
        } else if ($porcentaje > 0) {
            $nivel = 2;
        }

        $mensaje = "";

        $nivelActual = $this->usuario_x_curso_model->obtenerRegistro(array("id_curso" => $idCurso, "id_usuario" => $_SESSION["idUsuario"]));
        if ($nivel != $nivelActual[0]->id_nivel) {
            $this->usuario_x_curso_model->actualizar(array("id_nivel" => $nivel), array("id_curso" => $idCurso, "id_usuario" => $_SESSION["idUsuario"]));
            $data = array(
                "id_usuario" => $_SESSION["idUsuario"],
                "id_curso" => $idCurso,
                "id_nivel" => $nivel
            );
            $this->bitacora_nivel_model->crear($data);
            $nivelAnterior = $this->nivel_model->obtener(array("id_nivel" => $nivelActual[0]->id_nivel));
            $nivelaActual = $this->nivel_model->obtener(array("id_nivel" => $nivel));


            $usuario = $this->usuario_model->obtenerUsuario(array("id_usuario" => $_SESSION["idUsuario"]));
            if ($usuario[0]->sexo == "m") {
                $rutaImagenNivel = base_url() . "assets/img/niveles/hombre/{$nivelaActual[0]->imagen}";
            } else {
                $rutaImagenNivel = base_url() . "assets/img/niveles/mujer/{$nivelaActual[0]->imagen}";
            }

            $mensaje = "<br><br>Ya no eres más un(a) {$nivelAnterior[0]->nombre}, ahora eres un(a) {$nivelaActual[0]->nombre}.";
            $mensaje.="<center><img class='featurette-image img-responsive' src='$rutaImagenNivel'></center>";
        }
        return $mensaje;
    }

}
