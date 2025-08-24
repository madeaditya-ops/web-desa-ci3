<?php
defined('BASEPATH') OR exit('No direct script access allowed');





$route['default_controller'] = 'auth/login';
$route['auth/login'] = 'auth/login';
$route['auth/logout'] = 'auth/logout';
$route['dashboard/admin'] = 'dashboard/admin';
$route['dashboard/kades'] = 'dashboard/kades';
$route['dashboard/kadus'] = 'dashboard/kadus';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
