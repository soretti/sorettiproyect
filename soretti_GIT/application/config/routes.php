<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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





$route['en'] = "pagina/home";
$route['en/paginas/(:any)'] = "pagina/index";
$route['en/paginas/contacto'] = "contacto";

$route['en/blogs/(:any)/categoria/(:any)'] = "blog/categoria/$1/$2";
$route['en/blogs/(:any)/(:num)'] = "blog/index/$1";
$route['en/blogs/(:any)/(:any)'] = "blog/post/$1/$2";
$route['en/blogs/(:any)'] = "blog/index/$1";

$route['en/galeria/(:any)'] = "galeria/index/$1";


$route['en/catalogo/categoria/(:any)/(:num)'] = "catalogo/categoria/$1/$2";
$route['en/catalogo/categoria/(:any)/(:any)'] = "catalogo/ficha/$1/$2";
$route['en/catalogo/categoria/(:any)'] = "catalogo/categoria/$1";
$route['en/buscador/(:any)'] = "buscador/index/$1";
$route['en/contacto/inmediato'] = "contacto/inmediato";

/*Español*/

$route['es'] = "pagina/home";
$route['modulo/(:any)'] = "$1";
$route['default_controller'] = "pagina/home";


$route['web/contacto'] = "contacto";
$route['web/quieres-ser-distribuidor'] = "contacto/distribuidores";
$route['web/registro-de-profesionales'] = "contacto/registro_profesionales";
$route['web/registro-de-organizaciones'] = "contacto/registro_organizaciones";


$route['web'] = "pagina/index";
$route['web/(:any)'] = "pagina/index";
 
$route['blog/(:any)/archivo/(:any)'] = "blog/archivo/$1/$2";
$route['blog/(:any)/categoria/(:any)'] = "blog/categoria/$1/$2";
$route['blog/(:any)/(:num)'] = "blog/index/$1";
$route['blog/(:any)/(:any)'] = "blog/post/$1/$2";
$route['blog/(:any)'] = "blog/index/$1";

$route['galeria/(:any)'] = "galeria/index/$1";

$route['catalogo/(:any)/(:num)'] = "catalogo/categoria/$1/$2";
$route['catalogo/(:any)/(:any)'] = "catalogo/ficha/$1/$2";
$route['catalogo/(:any)'] = "catalogo/categoria/$1";



//$route['catalogo/marca/(:any)/(:num)'] = "catalogo/marca/$1/$2";

// $route['catalogo/categoria/(:any)/(:num)'] = "catalogo/categoria/$1/$2";
// $route['catalogo/categoria/(:any)/(:any)'] = "catalogo/ficha/$1/$2";

// $route['catalogo/marca/(:any)/(:num)'] = "catalogo/marca/$1/$2";

$route['buscador/(:any)'] = "buscador/index/$1";

$route['404_override'] = '';



/* End of file routes.php */
/* Location: ./application/config/routes.php */