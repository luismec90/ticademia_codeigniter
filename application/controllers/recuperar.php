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
        $this->email->Subject = utf8_decode("Nueva contraseña");
        $this->email->MsgHTML("Cordial saludo. <br><br> Su suario es: <b>{$usuario[0]->usuario}</b> <br> su nueva contarseña es: <b>$newPass</b>");
        $this->email->AddAddress($email, "destinatario");
        $this->email->IsHTML(true);
        $this->email->Send();
        $this->mensaje("Se ha enviado un e-mail con la nueva contraseña a la dirección: $email", "success");
    }

}
