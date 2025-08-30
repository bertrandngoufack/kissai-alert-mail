<?php namespace Config;

use CodeIgniter\Routing\RouterCollection;

$routes = Services::routes();

$routes->setDefaultNamespace('App\\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

if (is_file(APPPATH . 'Config/RoutesApi.php')) {
\trequire APPPATH . 'Config/RoutesApi.php';
}

