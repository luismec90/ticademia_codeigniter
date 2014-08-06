<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('evaluacion_model');
    }

    public function index() {
       /*
        
        $k=74;
        for ($j = 18; $j <= 21; $j++) {
            $idModulo = $j;
            for ($i = 1; $i <= 40; $i++) {
                  echo exec("cp -R /var/www/html/resources/1/74 /var/www/html/resources/1/$j/$k");
                  $k++;
            }
        }
        */
    }

}
