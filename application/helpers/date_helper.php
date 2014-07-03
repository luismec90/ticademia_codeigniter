<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('dateToxAxis')) {

    function dateToxAxis($date) {
        $meses = array('01'=>'ene','02'=> 'feb','03'=> 'mar','04'=> 'abr','05'=> 'may','06'=> 'jun','07'=> 'jul','08'=> 'ago','09'=> 'sep','10'=> 'oct','11'=> 'nov','12'=> 'dic');
        $date = explode("-", $date);
        return $meses[$date[1]] . " " . $date[2];
    }

}


