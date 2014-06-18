<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Registrarse extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->model('usuario_model');
    }

    public function index() {
        $this->load->model('afiliacion_model');

        $data["tab"] = "registrarse";
        $data["css"] = array("css/registrase");
        $data["afiliaciones"] = $this->afiliacion_model->obtenerAfiliaciones();
        $this->load->view('include/header', $data);
        $this->load->view('registrase_view');
        $this->load->view('include/footer');
    }

    public function crear() {

        $this->escapar($_POST);
        if (empty($_POST["nombres"]) || empty($_POST["apellidos"]) || empty($_POST["email"]) || empty($_POST["afiliacion"]) || empty($_POST["usuario"]) || empty($_POST["password"]) || empty($_POST["rePassword"])) {
            $this->mensaje("Datos incompletos", "error", "registrarse");
        }
        $existe = $this->usuario_model->obtenerUsuario(array("correo" => $_POST["email"]));
        if (sizeof($existe) > 0) {
            $this->mensaje("El e-mail: {$_POST["email"]} ya se encuentra registrado", "error", "registrarse");
        }
        $existe = $this->usuario_model->obtenerUsuario(array("usuario" => $_POST["usuario"]));
        if (sizeof($existe) > 0) {
            $this->mensaje("El usuario: {$_POST["usuario"]} ya se encuentra registrado", "error", "registrarse");
        }
        if ($_POST["password"] != $_POST["rePassword"]) {
            $this->mensaje("Las contraseñas no coinciden", "error", "registrarse");
        }
        $data = array(
            "id_afiliacion" => $_POST["afiliacion"],
            "nombres" => $_POST["nombres"],
            "apellidos" => $_POST["apellidos"],
            "correo" => $_POST["email"],
            "imagen" => "default.png",
            "usuario" => $_POST["usuario"],
            "password" => sha1($_POST["password"]),
            "rol" => "estudiante",
            "activo" => "0"
        );
        $this->usuario_model->crear($data);
        $this->enviarEmail($_POST["email"]);
        $this->mensaje("Se ha enviado un e-mail de confirmación a la dirección: {$_POST["email"]}", "success");
    }

    private function enviarEmail($email) {
        $token = sha1($email . "-minerva2014");
        $link = base_url() . "activar?email=$email&token=$token";

        include("assets/libs/PHPMailer/class.phpmailer.php");
        include("assets/libs/PHPMailer/class.smtp.php");

        $this->email = new PHPMailer();
        $this->email->IsSMTP();
        $this->email->SMTPAuth = true;
        $this->email->SMTPSecure = "ssl";
        $this->email->Host = "smtp.gmail.com";
        $this->email->Port = 465;
        $this->email->Username = 'lfmontoyag@unal.edu.co';
        $this->email->From = "lfmontoyag@unal.edu.co";
        $this->email->Password = "1038408348";


        $this->email->From = "lfmontoyag@unal.edu.co";
        $this->email->FromName = "Minerva";
        $this->email->Subject = utf8_decode("Confirmación de e-mail");
        $this->email->MsgHTML("Cordial saludo. <br><br> Por favor dar click en el siguinte enlance para confirmar su e-mail: <br> <a href='$link' target='_blank'>$link</a>");
        $this->email->AddAddress($email, "destinatario");
        $this->email->IsHTML(true);
        $this->email->Send();
    }

    public function activar() {
        $email = $this->input->get("email");
        $token = $this->input->get("token");
        if (sha1($email . "-minerva2014") == $token) {
            $data = array("activo" => 1);
            $where = array("correo" => $email);
            $this->usuario_model->actualizar($data, $where);
            $this->mensaje("Cuenta activada exitosamente", "success");
        } else {
            $this->mensaje("La ULR no es válida", "error");
        }
    }

}
