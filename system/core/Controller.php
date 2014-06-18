<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

    private static $instance;

    /**
     * Constructor
     */
    public function __construct() {
        self::$instance = & $this;

        // Assign all the class objects that were instantiated by the
        // bootstrap file (CodeIgniter.php) to local class variables
        // so that CI can run as one big super object.
        foreach (is_loaded() as $var => $class) {
            $this->$var = & load_class($class);
        }

        $this->load = & load_class('Loader', 'core');

        $this->load->initialize();

        log_message('debug', "Controller Class Initialized");
    }

    public static function &get_instance() {
        return self::$instance;
    }

    static function estoyLogueado() {
        if (!isset($_SESSION["idUsuario"])) {
            header("Location:" . base_url());
            exit();
        }
    }

    static function escapar(&$data) {
        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $data[$key] = trim(mysql_real_escape_string($value));
            }
        }
    }

    protected function mensaje($mensaje, $tipo, $redirect = "") {
        $this->session->set_flashdata('mensaje', $mensaje);
        $this->session->set_flashdata('tipo', $tipo);
        header("Location:" . base_url() . "$redirect");
        exit();
    }

    protected function verificarMatricula($idCurso) {
        $this->load->model('usuario_x_curso_model');
        $where = array("id_curso" => $idCurso, "id_usuario" => $_SESSION["idUsuario"]);
        $usuario = $this->usuario_x_curso_model->obtenerRegistro($where);
        if (!$usuario) {
            $this->load->model('curso_model');
            $where = array("id_curso" => $idCurso, "id_usuario" => $_SESSION["idUsuario"]);
            $usuario = $this->curso_model->obtenerCursoPorProfesor($where);
            if (!$usuario) {
                $this->mensaje("El curso no existe o no se encuentra matriculado", "error");
            }
        }
    }

    protected function soyElProfesor($idCurso) {
        $this->load->model('curso_model');
        $where = array("id_curso" => $idCurso, "id_usuario" => $_SESSION["idUsuario"]);
        $usuario = $this->curso_model->obtenerCursoPorProfesor($where);
        if (!$usuario) {
            $this->mensaje("El curso no existe o no se encuentra matriculado", "error");
        }
    }

}

// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */