<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->get('/', 'Home::index');

//測試用
$routes->get('/', 'JWTController::index');
$routes->get('/test', 'Home::test');
//email send  測試用
$routes->get('/donateMailSend/(:alphanum)', 'MailController::donateMailSend/$1');

// CORS API FILTER
$routes->options('/(:any)', 'Home::options', ['filter' => 'apiAccessFilter']);
/**
 * 捐款類別路由
 */
$routes->group(
    'api',
    [
        'namespace' => 'App\Controllers',
    ],
    function (\CodeIgniter\Router\RouteCollection $routes) {

        $routes->group(
            'user',
            [
                'namespace' => 'App\Controllers',
            ],
            function (\CodeIgniter\Router\RouteCollection $routes) {
                $routes->get('googleLogin', 'UserController::googleLogin');
                $routes->get('googleCallback', 'UserController::googleCallback');
                $routes->post('userdata', 'UserController::userData', ['filter' => 'JWTFilter']);
            }
        );
    }
     
    
);

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
