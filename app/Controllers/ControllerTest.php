<?php
namespace App\Controllers;



use App\classes\Mailer;
use App\Core\MainController;

class ControllerTest extends MainController
{

   public  function index()  {
        // $mail = (new Mailer())->hello();
        // return $test->anyWhere(['etat_user' => 1])->get(['nom', 'prenom']);
        // return $test->raw('select * from users', [], 'fetch');
        // return $test->where('etat_user', 1)->limit(5, 0)->all();
        //  var_dump($t);
        // return $mail->hello();
        return $this->view('test', []);
    }

   
}
