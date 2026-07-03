<?php
namespace App\Controllers;




use App\Core\MainController;

class ControllerException extends MainController
{

   public  function notFound()  {
       
        return $this->viewError('404', ['data' => "connexion"]);
    }

    public function test($test)  {
       
        return $this->viewError('404', ['data' => "connexion"]);
    }

   
}
