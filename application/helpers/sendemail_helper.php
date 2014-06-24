<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('enviarEmail')) {

    function enviarEmail($to, $subject, $msj) {


        include("assets/libs/PHPMailer/class.phpmailer.php");
        include("assets/libs/PHPMailer/class.smtp.php");

        $email = new PHPMailer();
        $email->IsSMTP();
        $email->SMTPAuth = true;
        $email->SMTPSecure = "ssl";
        $email->Host = "smtp.gmail.com";
        $email->Port = 465;
        $email->Username = 'info.ticademia@gmail.com';
        $email->From = "info.ticademia@gmail.com";
        $email->Password = "ticademia2014";
        $email->FromName = "Minerva";
        $email->Subject = utf8_decode($subject);
        $email->MsgHTML($msj);
        $email->AddAddress($to, "destinatario");
        $email->IsHTML(true);
        $email->Send();
    }

}


