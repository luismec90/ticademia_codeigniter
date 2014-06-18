<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
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
        $this->email->MsgHTML("<b>mensaje</b>");

        $this->email->AddAddress('luismec90@gmail.com', "destinatario");
        $this->email->IsHTML(true);
        if (!$this->email->Send()) {
            echo "<b>Error:" . $this->email->ErrorInfo . "</b><br/>";
        } else {
            echo "Mensaje enviado correctamente";
        }
    }

}
