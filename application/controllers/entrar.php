<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Entrar extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        session_start();
        $this->load->model('usuario_model');
        $this->load->model('bitacora_model');
    }

    public function index() {
        $email = $this->input->post("email");
        $password = $this->input->post("password");
        if (!$email || !$password) {
            $this->mensaje("E-mail o contraseña incorrectos", "error");
            echo "post vacio";
        } else {
            $where = array("correo" => $email, "password" => sha1($password), "activo" => 1);
            $usuario = $this->usuario_model->obtenerUsuario($where); //pasamos los valores al modelo para que compruebe si existe el usuario con ese password
            if ($usuario) {
                $_SESSION["idUsuario"] = $usuario[0]->id_usuario;
                $_SESSION["nombre"] = $usuario[0]->nombres . " " . $usuario[0]->apellidos;
                redirect(base_url());
            } else {
                $this->mensaje("E-mail o contraseña incorrectos", "error");
            }
        }
    }

}
