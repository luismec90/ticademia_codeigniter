<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */

$route['default_controller'] = "inicio";
$route['curso/(:num)'] = "curso/verCurso/$1";
$route['modulo/(:num)'] = "modulo/verModulo/$1";
$route['ranking/(:num)'] = "ranking/index/$1";
$route['logros/(:num)'] = "logros/index/$1";
$route['foro/(:num)'] = "foro/index/$1";
$route['foro/(:num)'] = "foro/index/$1";
$route['foro/(:num)/(:num)'] = "foro/verTema/$1/$2";
$route['muro/(:num)'] = "muro/index/$1";
$route['logros/(:num)/(:num)'] = "logros/verLogro/$1/$2";
$route['activar'] = "registrarse/activar";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */