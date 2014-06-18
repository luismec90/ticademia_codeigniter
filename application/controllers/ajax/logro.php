<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Logro extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->model('usuario_curso_logro_model');
    }

    public function index() {
        $logrosPendientes = array();
        if (isset($_SESSION["idUsuario"])) {

            $logrosPendientes = $this->usuario_curso_logro_model->logroPediente();
            if (sizeof($logrosPendientes) > 0) {
                $logrosPendientes[0]->imagen = base_url() . "assets/img/logro/{$logrosPendientes[0]->id_logro}.png";
                $logrosPendientes[0]->share_facebook = "https://www.facebook.com/sharer/sharer.php?u=http://guiame.medellin.unal.edu.co/minerva/logros/{$logrosPendientes[0]->id_curso}/{$logrosPendientes[0]->id_usuario_curso_logro}";
                $logrosPendientes[0]->share_twitter = "https://twitter.com/intent/tweet?text=" . urlencode($logrosPendientes[0]->nombre) . "&url=http://guiame.medellin.unal.edu.co/minerva/logros/{$logrosPendientes[0]->id_curso}/{$logrosPendientes[0]->id_usuario_curso_logro}";
//    var_dump($logrosPendientes);
                $this->usuario_curso_logro_model->visto($logrosPendientes[0]->id_usuario_curso_logro);
            }
        }
        echo json_encode($logrosPendientes);
    }

}
