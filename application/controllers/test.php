<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('evaluacion_model');
    }

    public function index()
    {
        $evaluaciones = $this->evaluacion_model->sql2("select * from evaluacion");
        foreach ($evaluaciones as $row)
        {
            $menor_tiempo = $this->evaluacion_model->sql2("SELECT *, MIN(TIME_TO_SEC( TIMEDIFF( fecha_final, fecha_inicial ) )) diff
FROM usuario_x_evaluacion
WHERE fecha_final is not null  and fecha_inicial is not null and id_evaluacion={$row->id_evaluacion} and fecha_inicial<fecha_final");
            foreach ($menor_tiempo as $row2)
            {
                if ($row2->diff > 0)
                {
                    $this->evaluacion_model->sql("update evaluacion set mejor_tiempo='$row2->diff',id_usuario='$row2->id_usuario' where id_evaluacion='$row->id_evaluacion'");

                }
            }
        }

    }

}
