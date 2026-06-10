<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Landing';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['dashboard'] = 'Dashboard';

$route['admin'] = 'Admin';

$route['kadus'] = 'Kadus';

$route['login'] = 'Auth';
$route['logout'] = 'Auth/logout';


$route['admin/edit_surat'] = 'admin/edit_surat';
$route['admin/edit_surat/(:num)'] = 'admin/edit_surat/$1';

$route['pengaduan'] = 'Pengaduan';
$route['pengaduan/store'] = 'Pengaduan/store';


$route['galeri'] = 'Galeri';
$route['aparatur'] = 'Aparatur';
$route['dusun'] = 'Dusun';
$route['users'] = 'Users';
$route['potensi'] = 'Potensi';
$route['peraturan'] = 'Peraturan';
$route['apbdes'] = 'Apbdes';
$route['surat'] = 'Template_surat';

$route['berita'] = 'Berita';
$route['berita'] = 'Berita/index';
$route['berita/create'] = 'Berita/create';
$route['berita/store'] = 'Berita/store';
$route['berita/edit/(:num)'] = 'Berita/edit/$1';
$route['berita/update/(:num)'] = 'Berita/update/$1';
$route['berita/delete/(:num)'] = 'Berita/delete/$1';
$route['berita/(:any)'] = 'berita/detail/$1';

$route['anggota_lembaga/(:num)'] = 'anggota_lembaga/index/$1';
$route['bidang_lembaga/(:num)'] = 'bidang_lembaga/index/$1';
