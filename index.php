<?php
// if (session_status() === PHP_SESSION_NONE) {
session_name("APP675444554_SESSION");
session_start();
include __DIR__ . '/app/Core/security.php';

// }
// Charger le fichier de configuration une fois en ligne

// declare(strict_types=1);
// include 'config-production.php';
// include 'config-production-user.php';

// Activer le rapport d'erreurs (en développement uniquement)
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require __DIR__ . '/vendor/autoload.php';

use App\Controllers\AuthController;
use App\Controllers\Controller;
use App\Controllers\ControllerException;
use App\Controllers\DashboardController;
use App\Controllers\HomeController;
use App\Controllers\SettingController;
use App\Controllers\UserController;
use App\Core\Router;
use App\Middlewares\RouteMiddleWare;
use Phroute\Phroute\Dispatcher;

        
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$title = "";

$router = new Router();

/**
 * ************************************************
 * SEXION FILTER ROUTES 
 * ************************************************
 */

/* filter  for all routes*/
$router->filter('auth', [RouteMiddleWare::class, 'requireAuth']);

$router->filter('guest', [RouteMiddleWare::class, 'isLogged']);
// $router->filter('setting', [RouteMiddleWare::class, 'requireSetting']);
// $router->filter('ghotel', [RouteMiddleWare::class, 'requireGesHotel']);
// $router->filter('comptable', [RouteMiddleWare::class, 'requireComptable']);
// $router->filter('reception', [RouteMiddleWare::class, 'requireReception']);
// $router->filter('admin', [RouteMiddleWare::class, 'requireAdmin']);

/**
 * ************************************************
 * FIN SEXION FILTER ROUTES 
 * ************************************************
 */


/**
 * ************************************************
 * DEBUT SEXION ROUTES 
 * ************************************************
 */


$router->group(['before' => '', 'prefix' => 'geicg'], function ($router) {

    // ─── Auth ───────────────────────────────────────────────────────────────────
    // $router->post('auth/logout',  [AuthController::class, 'logout']);
    // $router->get('auth/check',    [AuthController::class, 'check']);

    // $router->get('/register', [UserController::class, 'register'], ['before' => 'guest']);
    // $router->get('/user', [UserController::class, 'userListe'], ['before' => 'auth'])->name('home');


    // $router->get('/admin/role', [UserController::class, 'role'], ['before' => 'auth'])->name('admin.role');

    // $router->get('/setting', [SettingController::class, 'setting'], ['before' => 'auth'])->name('setting');



/**
 * ************************************************
 * SEXION ROUTE MAIL 
 * ************************************************
 */


// $router->group(['before' => 'auth', 'prefix' => 'gestocks/t'], function ($router) {

//     $router->get('/testd', [UserController::class, 'acueil']);
// });

/**
 * ************************************************
 * FIN SEXION ROUTE MAIL 
 * ************************************************
 */



/**
 * ************************************************
 * SEXION ROUTE PRINTER 
 * ************************************************
 */




/**
 * ************************************************
 *  Routes SEXION HOTEL LISTE RECAP
 * ************************************************
 */

/**
 * ************************************************
 *  Routes SEXION VUES 
 * ************************************************
 */

$router->get('login', [AuthController::class, 'login'], ['before' => 'guest']);
// <!-- sexion utilisateur  -->
$router->group(['before' => 'auth', 'prefix' => '/'], function ($router) {
    
    $router->get('dashboard', [HomeController::class, 'acueil']);
    $router->get('/', [HomeController::class, 'acueil'], ['before' => 'auth']);

    $router->get('recrutements/personnel',[UserController::class, 'recrutement']);
    $router->get('personnel-enseignants',[UserController::class, 'enseignants']);
    $router->get('personnel-administratifs',[UserController::class, 'administratif']);

    // <!-- parametrage -->
    $router->get('fonctions',[SettingController::class, 'fonction']);

});


/**
 * Page not found
 */
$router->get('page-not-found', [ControllerException::class, 'notFound']);

/**
 * ************************************************
 *  FIN Routes SEXION HOTEL AUTRES
 * ************************************************
 */

});


$dispatcher = new Dispatcher($router->getData());
$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $path);

echo $response;



// session_destroy();
// var_dump($_SESSION);