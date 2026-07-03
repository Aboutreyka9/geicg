<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\MainController;
use App\Models\Factory;
use App\Services\Service;
use Groupes;

class Controller extends MainController
{

    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES VUES
     * SEXION POUR LES VIEWS
     * **********************************************************************
     * --------------------------------------------------------------------------
     */

    public function testing()
    {
        $fc = new Factory();
        $users = $fc->getAllReservationsArrive('2025-11-22 23:59:59', '2025-12-25 23:59:59');

        return $this->view('trash/test', ["users" => $users, 'title' => 'Gestion des roles']);
    }




    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES REQUESTS AJAX
     * SEXION POUR LES AJAX REQUESTS
     * **********************************************************************
     * --------------------------------------------------------------------------
     */
}
