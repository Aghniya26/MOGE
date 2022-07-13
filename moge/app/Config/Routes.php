<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

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
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/attendance', 'atdController::index');
$routes->get('/settings', 'userController::displaySettings');
$routes->post('/settings/editUser', 'userController::edit');
$routes->post('/settings/deleteUser', 'userController::delete');
$routes->post('/attendance', 'atdController::index');
$routes->get('/attendance/detail/(:any)/(:any)', 'detailAtdController::index/$1/$2');
$routes->get('/participant', 'ptcController::index');
$routes->get('/class', 'classController::index');
$routes->get('/evaluation', 'evaluationController::index');
$routes->get('/callback', 'zoomController::callback');
$routes->get('/loginzoom', 'zoomController::index');
$routes->get('/ptc/(:any)', 'zoomController::addParticipants/$1');
$routes->get('/detailclass/(:any)', 'classController::currentClass/$1');
$routes->post('/addmeeting', 'zoomController::addMeeting');
$routes->post('/addclass', 'classController::add');
$routes->post('/editclass', 'classController::edit');
$routes->post('/deleteclass', 'classController::delete');
$routes->post('/participant/edit', 'ptcController::edit');
$routes->post('/participant/delete', 'ptcController::delete');
$routes->post('/participant/import', 'ptcController::import');
$routes->post('/evaluation', 'evaluationController::index');
$routes->get('/', 'loginController::displayLogin');
$routes->post('/auth', 'loginController::auth');
$routes->get('/register', 'userController::displayRegister');
$routes->post('/register', 'userController::add');
$routes->get('/logout', 'userController::logout');
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
