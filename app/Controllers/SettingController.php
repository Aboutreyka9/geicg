<?php

namespace App\Controllers;

use App\Models\Factory;
use App\Core\MainController;

class SettingController extends MainController
{

    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES RENDUS
     * SEXION POUR LES VUES 
     * **********************************************************************
     * --------------------------------------------------------------------------
     */



    public function setting()
    {
        $this->view('parametres/setting', ['title' => "Paramètres"]);
    }

    public function profileEmploye($code)
    {
        $code = decrypter($code);
        if (!$code) exit(http_response_code(500));

        $fc = new Factory();
        $user = $fc->getUserByCodeWithFoction($code);
        $fonctions = $fc->getAllFonctions();
        $activities = $fc->getAllDetailesVersementReservationsForUser($code);

        $this->view('admins/profile', ["user" => $user, "activities" => $activities, "fonctions" => $fonctions, 'title' => "Profile employe"]);
    }
}
