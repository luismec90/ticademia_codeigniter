<?php
if (!function_exists('enviarEmail')) {

    include_once("assets/libs/PHPMailer/class.phpmailer.php");
    include_once("assets/libs/PHPMailer/class.smtp.php");

    function enviarEmail($to, $subject, $msj) {

        $email = new PHPMailer();
        $email->IsSMTP();
        $email->SMTPAuth = true;
        $email->SMTPSecure = "ssl";
        $email->Host = "smtp.gmail.com";
        $email->Port = 465;
        $email->Username = 'soporte.ticademia@gmail.com';
        $email->From = "soporte.ticademia@gmail.com";
        $email->Password = "ticademia2014";
        $email->FromName = "Ticademia";
        $email->Subject = utf8_decode($subject);
        $email->MsgHTML($msj);
        $email->AddAddress($to, "destinatario");
        $email->IsHTML(true);
        $email->Send();

    }

}