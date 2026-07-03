<?php
// if (session_status() === PHP_SESSION_NONE) {
    session_name("APP15464655_SESSION");
    session_start();

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
use App\Controllers\ControllerComptable;
use App\Controllers\ControllerException;
use App\Controllers\ControllerHotel;
use App\Controllers\ControllerMailer;
use App\Controllers\ControllerPrinter;
use App\Controllers\UserController;
use App\Core\Router;
use App\Middlewares\RouteMiddleWare;
use Phroute\Phroute\Dispatcher;




$path = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);

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
$router->filter('setting', [RouteMiddleWare::class, 'requireSetting']);
$router->filter('ghotel', [RouteMiddleWare::class, 'requireGesHotel']);
$router->filter('comptable', [RouteMiddleWare::class, 'requireComptable']);
$router->filter('reception', [RouteMiddleWare::class, 'requireReception']);
$router->filter('admin', [RouteMiddleWare::class, 'requireAdmin']);

/**
 * ************************************************
 * FIN SEXION FILTER ROUTES 
 * ************************************************
 */




/**
 * ************************************************
 * SEXION ROUTE MAIL 
 * ************************************************
 */


$router->group(['before' => '','prefix' => 'hotel/email'], function($router){
    
    // $router->get('/',[ControllerMailer::class, 'acueil'],['before' => 'auth']);
});

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

 $router->group(['before' => '','prefix' => 'hotel/print'], function($router){
    
    // $router->get('/{file}',[ControllerPrinter::class, 'print']);
    // $router->get('/download',[ControllerPrinter::class, 'download']);
    // $router->get('/save',[ControllerPrinter::class, 'acueil']);
});



    $router->get('hotel/print/facture/{code}',[ControllerPrinter::class, 'printFacture'])->name('facture');

    $router->get('hotel/print/versement/{code}',[ControllerPrinter::class, 'printVersement'])->name('print.versement');

    $router->get('hotel/print/liste-client/{periode}',[ControllerPrinter::class, 'printListeClient'])->name('print.liste.client');

    
    $router->get('hotel/print/liste-reservation/{periode}',[ControllerPrinter::class, 'printListeReservation'])->name('print.liste.reservation');
    $router->get('hotel/print/liste-salaire/{periode}',[ControllerPrinter::class, 'printListeSalaire'])->name('print.liste.salaire');
    $router->get('hotel/print/liste-depense/{periode}',[ControllerPrinter::class, 'printListeDepense'])->name('print.liste.depense');

    $router->get('hotel/print/liste-chambres',[ControllerPrinter::class, 'printListeChambres'])->name('print.liste.chambres');

    $router->get('hotel/print/liste-services',[ControllerPrinter::class, 'printListeServices'])->name('print.liste.services');
    $router->get('hotel/print/liste-versement/{periode}',[ControllerPrinter::class, 'printListeVersement'])->name('print.liste.versement');
    $router->get('hotel/print/liste-check-reservation/{periode}',[ControllerPrinter::class, 'printListeCheckReservation'])->name('print.liste.check.reservation');


/**
 * ************************************************
 * FIN SEXION ROUTE PRINTER
 * ************************************************
 */



 /**
 * ************************************************
 * Routes CREATION DE COMPTE ET LA CONNEXION
 * ************************************************
 */

    $router->get('hotel/admin/role',[Controller::class, 'role'],['before' => 'admin'])->name('admin.role');

    $router->get('hotel/admin/liste-employes',[UserController::class, 'userListe'],['before' => 'admin'])->name('admin.user');
    $router->get('hotel/admin/profile-employe/{code}',[UserController::class, 'profileEmploye'],['before' => 'admin'])->name('profile.employe');
    $router->get('hotel/mon-profile/{code}',[UserController::class, 'myProfile'],['before' => 'auth'])->name('user.profile');

    $router->get('hotel/register',
    [UserController::class, 'register'],
    ['before' => 'guest'])->name('register');

    
    $router->get('hotel/login',
    [UserController::class, 'login'],
    ['before' => 'guest'])->name('login'); 

    $router->get('hotel/activation/{token}',
    [UserController::class, 'activationAccount'],
    ['before' => 'guest'])->name('activation');
     

    $router->get('hotel/user/edit-profile',
    [UserController::class, 'editProfile'],
    ['before' => 'auth'])->name('user.edit.profile');

    
    $router->get('hotel/user/reset-password',
    [UserController::class, 'resetPassword'],
    ['before' => 'guest'])->name('reset.password');

    $router->get('hotel/user/change-password',
    [UserController::class, 'changePassword'],
    ['before' => 'guest'])->name('user.change.password');

    $router->get('hotel/user/logout',
    [UserController::class, 'logout'],
    ['before' => 'auth'])->name('user.logout');

 /**
 * ************************************************
 * Routes FIN CREATION DE COMPTE ET CONNEXION
 * ************************************************
 */



 /**
 * ************************************************
 * Routes SEXION PARAMETRES COMPTE
 * ************************************************
 */
    $router->get('hotel/setting/fonctions',
    [UserController::class, 'fonction'],
    ['before' => 'admin'])->name('setting.fonctions');
    
    $router->get('hotel/setting/home',
    [UserController::class, 'setting'],
    ['before' => 'setting'])->name('setting.home');
    


 /**
 * ************************************************
 * Routes FIN SEXION PARAMETRES COMPTE
 * ************************************************
 */


  /**
 * ************************************************
 * Routes SEXION HOTEL PARAMETRES
 * ************************************************
 */

 $router->get('hotel/categorie-chambres',
 [ControllerHotel::class, 'categorieChambres'],
 ['before' => 'ghotel'])->name('categorie.chambres');

 $router->get('hotel/chambres',
 [ControllerHotel::class, 'chambres'],
 ['before' => 'ghotel'])->name('hotel.chambres');

 $router->get('hotel/services',
 [ControllerHotel::class, 'services'],
 ['before' => 'ghotel'])->name('hotel.services');

 /**
 * ************************************************
 * FIN Routes SEXION HOTEL PARAMETRES
 * ************************************************
 */



 /**
 * ************************************************
 * Routes SEXION HOTEL RESERVATION
 * ************************************************
 */


// Route reception hotel
$router->get('hotel/reservation',[ControllerHotel::class, 'reservation'],['before' => 'reception'])->name('hotel.reservation');
$router->get('hotel/reservation/details/{code}',[ControllerHotel::class, 'reservationDetails'],['before' => 'reception'])->name('reservation.details');

$router->get('hotel/add-reservation',[ControllerHotel::class, 'addReservation'],['before' => 'reception'])->name('hotel.add.reservation');

$router->get('hotel/profile-client/{code}',[ControllerHotel::class, 'profile'],['before' => 'reception'])->name('client.profile');
$router->get('hotel/liste-client',[ControllerHotel::class, 'clients'],['before' => 'auth'])->name('client');
$router->get('hotel/historique-versement',[ControllerHotel::class, 'versement'],['before' => 'reception'])->name('versement');
$router->get('hotel/facture-non-regler',[ControllerHotel::class, 'factureNonRegler'],['before' => 'reception'])->name('facture.attente');
$router->get('hotel/reservation-annuler',[ControllerHotel::class, 'reservationAnnuler'],['before' => 'auth'])->name('reservation.annuler');
$router->get('hotel/service-annuler',[ControllerHotel::class, 'serviceAnnuler'],['before' => 'auth'])->name('service.annuler');

$router->get('hotel/reservation/check/{code}',[ControllerHotel::class, 'check'],['before' => 'reception'])->name('reservation.check');



 /**
 * ************************************************
 * FIN Routes SEXION HOTEL RESERVATION
 * ************************************************
 */

 


  /**
 * ************************************************
 * Routes SEXION HOTEL COMPTABILITE
 * ************************************************
 */

 
// $router->get('hotel/reservation/details/{code}',[ControllerHotel::class, 'reservationDetails'],['before' => 'auth'])->name('reservation.details');

$router->get('hotel/abonnement',[ControllerComptable::class, 'abonnement'],['before' => 'comptable'])->name('hotel.abonnement');
$router->get('hotel/comptabilite/caisse',[ControllerComptable::class, 'caisse'],['before' => 'comptable'])->name('comptable.caisse');
$router->get('hotel/comptabilite/versement',[ControllerComptable::class, 'versement'],['before' => 'comptable'])->name('comptable.versement');
$router->get('hotel/comptabilite/depense',[ControllerComptable::class, 'compteDepense'],['before' => 'comptable'])->name('comptable.depense');
$router->get('hotel/depenses',[ControllerComptable::class, 'depense'],['before' => 'ghotel'])->name('hotel.depenses');

$router->get('hotel/salaires',[ControllerComptable::class, 'salaire'],['before' => 'comptable'])->name('hotel.salaire');
  /**
 * ************************************************
 * FIN Routes SEXION HOTEL COMPTABILITE
 * ************************************************
 */

  /**
 * ************************************************
 *  Routes SEXION HOTEL LISTE RECAP
 * ************************************************
 */

$router->get('hotel/liste-clients',[ControllerHotel::class, 'recaptListeClients'],['before' => 'auth'])->name('liste.clients');
$router->get('hotel/liste-reservations',[ControllerHotel::class, 'recaptListeReservations'],['before' => 'auth'])->name('liste.reservations');
$router->get('hotel/liste-chambres',[ControllerHotel::class, 'recaptListeChambres'],['before' => 'auth'])->name('liste.chambres');
$router->get('hotel/liste-depenses',[ControllerHotel::class, 'recaptListeDepenses'],['before' => 'auth'])->name('liste.depenses');
$router->get('hotel/listes-services',[ControllerHotel::class, 'recaptListeServices'],['before' => 'auth'])->name('liste.services');


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
 
 
$router->get('hotel/',[UserController::class, 'acueil'],['before' => 'auth'])->name('home');

// Route pour sexion admin



/**
 * ************************************************
 * SEXION ROUTE DES VUES 
 * ************************************************
 */

$router->get('/login',     [AuthController::class, 'login']);
$router->get('/dashboard',  [DashboardController::class, 'index']);
$router->get('/etablissements',[EtablissementController::class, 'index']);
$router->get('/annees',    [AnneeController::class, 'index']);
$router->get('/cycles',       [CycleController::class, 'index']);
$router->get('/classes',      [ClasseController::class, 'index']);
$router->get('/matieres',     [MatiereController::class, 'index']);
$router->get('/enseignants',  [EnseignantController::class, 'index']);
$router->get('/etudiants',    [EtudiantController::class, 'index']);
$router->get('/inscriptions', [InscriptionController::class, 'index']);
$router->get('/paiements',         [PaiementController::class, 'index']);
$router->get('/emplois-du-temps', [EmploiTempsController::class, 'index']);
$router->get('/notes',            [NoteController::class, 'index']);
$router->get('/communication',    function () { require __DIR__ . '/../templates/communication.php'; });

/**
 * Page not found
 */
$router->get('hotel/page-not-found',[ControllerException::class, 'notFound'])->name('page.notfound');

  /**
 * ************************************************
 *  FIN Routes SEXION HOTEL AUTRES
 * ************************************************
 */


$dispatcher = new Dispatcher($router->getData());
$response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'],$path);

echo $response;
