<?php
namespace App\Controllers;





use App\Core\MainController;
use App\Models\Factory;

class ControllerMailer extends MainController
{

   public  function index()  {
        $test = new Factory();
       
       $rest = $this->SendMail('nQKk9@example.com', 'test', 'welcome', ['nom' => 'nom', 'prenom' => 'prenom']);
        var_dump($rest);
        // return $this->view('test', ['data' => $t]);
        return;
    }
   
}
