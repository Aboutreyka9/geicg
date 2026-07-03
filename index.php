<?php
// if (session_status() === PHP_SESSION_NONE) {
session_name("APP6846534_SESSION");
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

use App\Controllers\BoutiqueController;
use App\Controllers\CategorieController;
use App\Controllers\ClientController;
use App\Controllers\Controller;
use App\Controllers\ControllerException;
use App\Controllers\ControllerMailer;
use App\Controllers\FournisseurController;
use App\Controllers\UserController;
use App\Controllers\HomeController;
use App\Controllers\MarkController;
use App\Controllers\UniteController;
use App\Controllers\ProduitController;
use App\Controllers\SettingController;
use App\Core\Router;
use App\Middlewares\RouteMiddleWare;
use App\Models\User;
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

$router->group(['before' => '', 'prefix' => 'geicg'], function ($router) {

    $router->get('/login', [UserController::class, 'login'], ['before' => 'guest'])->name('login');

    $router->get('/categorie', [CategorieController::class, 'categorie']);

    $router->get('/mark', [MarkController::class, 'mark']);

    $router->get('/unite', [UniteController::class, 'unite']);
    $router->get('/produit', [ProduitController::class, 'produit']);

    $router->get('/', [HomeController::class, 'acueil'], ['before' => 'auth']);


    $router->get('/client/liste', [ClientController::class, 'client'], ['before' => 'auth']);
    $router->get('/fournisseur', [FournisseurController::class, 'fournisseur'], ['before' => 'auth']);
    $router->get('/fournisseur/order', [FournisseurController::class, 'order'], ['before' => 'auth']);
    $router->get('/fournisseur/addOrder', [FournisseurController::class, 'addOrder'], ['before' => 'auth']);
    $router->get('/register', [UserController::class, 'register'], ['before' => 'guest']);
    $router->get('/user', [UserController::class, 'userListe'], ['before' => 'auth'])->name('home');


    $router->get('/boutique', [BoutiqueController::class, 'boutique'], ['before' => 'auth']);


    $router->get('/admin/role', [UserController::class, 'role'], ['before' => 'auth'])->name('admin.role');

    $router->get('/setting', [SettingController::class, 'setting'], ['before' => 'auth'])->name('setting');
});

$router->group(['before' => '', 'prefix' => 'gestock/test'], function ($router) {
    $router->get('/admin/role', [UserController::class, 'role'], ['before' => 'auth'])->name('admin.role');
});

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

$router->group(['before' => '', 'prefix' => 'hotel/print'], function ($router) {});



/**
 * ************************************************
 *  Routes SEXION HOTEL LISTE RECAP
 * ************************************************
 */

/**
 * ************************************************
 *  Routes SEXION HOTEL AUTRES
 * ************************************************
 */


// Route pour les utilisateurs connectés


$router->get('hotel/', [UserController::class, 'acueil'], ['before' => 'auth'])->name('home');

// Route pour sexion admin



// Route pour les visiteurs
$router->group(["prefix" => 'hotel/welcome'], function ($router) {
    $router->get('/', [UserController::class, 'home']);
});

/*
je
*/
/**
 * Page for test
 */
$router->get('hotel/test', [Controller::class, 'testing']);


/*
je
*/
/**
 * Page not found
 */
$router->get('hotel/page-not-found', [ControllerException::class, 'notFound'])->name('page.notfound');

/**
 * ************************************************
 *  FIN Routes SEXION HOTEL AUTRES
 * ************************************************
 */


$dispatcher = new Dispatcher($router->getData());
$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $path);

echo $response;



// session_destroy();

var_dump($_SESSION);
