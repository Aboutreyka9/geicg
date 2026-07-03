<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Gqr;
use App\Core\MainController;
use App\Models\Factory;
use App\Services\Service;
use Roles;

class HomeController extends MainController
{

    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES RENDUS
     * SEXION POUR LES VUES 
     * **********************************************************************
     * --------------------------------------------------------------------------
     */

    public function acueil()
    {

        $result = "";
       
        return $this->view('welcome', ['title' => "Mon espace"]);
    }

}