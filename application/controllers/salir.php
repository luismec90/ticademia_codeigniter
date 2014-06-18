<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Salir extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        session_start();
//        $this->load->model('bitacora_model');
    }

    public function index() {
       // $this->bitacora_model->actializarRegistro(array("id_bitacora" => $_SESSION["idBitacora"]));
        $_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
            );
        }
// Finally, destroy the session.
        session_destroy();
        redirect(base_url());
    }

}
