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
        var_dump($datos);
        var_dump($where);
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

    /*
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
     */
}
