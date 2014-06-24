<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class recuperar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->model('usuario_model');
    }

    public function index() {

        $data["tab"] = "recuperar";
        $this->load->view('include/header', $data);
        $this->load->view('recuperar_view');
        $this->load->view('include/footer');
    }

    public function enviar() {
        $this->escapar($_POST);
        if (empty($_POST["email"])) {
            $this->mensaje("Datos incompletos", "error", "recuperar");
        }
        $email = $_POST["email"];
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $newPass = "";
        for ($i = 0; $i < 12; $i++) {
            $newPass .= substr($str, rand(0, 62), 1);
        }
        $usuario = $this->usuario_model->obtenerUsuario(array("correo" => $email));
        if (!$usuario) {
            $this->mensaje("el e-mail: $email no existe", "error", "recuperar");
        }
        $this->usuario_model->actualizar(array("password" => sha1($newPass)), array("correo" => $email));

         enviarEmail($email, "Nueva contraseña", "Cordial saludo. <br><br> Su nueva contarseña es: <b>$newPass</b>");
           $this->mensaje("Se ha enviado un e-mail con la nueva contraseña a la dirección: $email", "success");
    }

}
