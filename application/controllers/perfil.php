<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Perfil extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->estoyLogueado();
        $this->load->model('usuario_model');
    }

    public function index() {
        $this->load->model('afiliacion_model');

        $data["tab"] = "perfil";
        $data["css"] = array("css/registrase");
        $data["usuario"] = $this->usuario_model->obtenerUsuario(array("id_usuario" => $_SESSION["idUsuario"]));
        $data["afiliaciones"] = $this->afiliacion_model->obtenerAfiliaciones();
        $this->load->view('include/header', $data);
        $this->load->view('perfil_view');
        $this->load->view('include/footer');
    }

    public function actualizar() {
        $this->escapar($_POST);

        $estudiante = $this->usuario_model->obtenerUsuario(array("id_usuario" => $_SESSION["idUsuario"]));
        if (!empty($_POST["currentPassword"]) && !empty($_POST["password"]) && !empty($_POST["rePassword"])) {
            if ($_POST["password"] == $_POST["rePassword"]) {

                if ($estudiante[0]->password == sha1($_POST["currentPassword"])) {
                    $this->usuario_model->actualizar(array("password" => sha1($_POST["password"])), array("id_usuario" => $_SESSION["idUsuario"]));
                } else {
                    $this->mensaje("La contraseña no es correcta", "error", "perfil");
                }
            } else {
                $this->mensaje("Las contraseñas no coinciden", "error", "perfil");
            }
        }

        if (!isset($_POST["nombres"]) || !isset($_POST["apellidos"]) || !isset($_POST["email"]) || !isset($_POST["afiliacion"])) {
            $this->mensaje("Datos incompletos", "error", "perfil");
        }

        $data = array(
            "id_afiliacion" => $_POST["afiliacion"],
            "nombres" => $_POST["nombres"],
            "apellidos" => $_POST["apellidos"],
            "correo" => $_POST["email"],
            "imagen" => $this->avatar($estudiante)
        );

        $this->usuario_model->actualizar($data, array("id_usuario" => $_SESSION["idUsuario"]));

        $_SESSION["nombre"] = $_POST["nombres"] . " " . $_POST["apellidos"];
        $this->mensaje("Datos actualizados exitosamente", "success", "perfil");
    }

    private function avatar($usuario) {
        $this->load->library('image_lib');

        if ($_FILES["file"]["name"]) {
            if ($usuario[0]->imagen != "default.png" && file_exists("assets/img/avatares/{$usuario[0]->imagen}")) {
                unlink("assets/img/avatares/{$usuario[0]->imagen}");
            }
            $extension = explode(".", $_FILES["file"]["name"]);
            $extension = strtolower(end($extension));
            $nombreAvatar = $_SESSION["idUsuario"] . "." . $extension;
            $ruta = "assets/img/avatares/$nombreAvatar";
            move_uploaded_file($_FILES["file"]["tmp_name"], $ruta);
            $this->thumbnail($nombreAvatar);
            return $nombreAvatar;
        } else {
            return $usuario[0]->imagen;
        }
    }

    private function thumbnail($imagen) {
        $source_path = "assets/img/avatares/$imagen";

        $target_path = "assets/img/avatares/thumbnails/";
        $config_manip = array(
            'image_library' => 'gd2',
            'source_image' => $source_path,
            'new_image' => $target_path,
            'maintain_ratio' => TRUE,
            'create_thumb' => TRUE,
            'thumb_marker' => '',
            'width' => 150,
            'height' => 150
        );
        $this->load->library('image_lib');
        $this->image_lib->initialize($config_manip);
        $this->image_lib->resize();
    }

}
