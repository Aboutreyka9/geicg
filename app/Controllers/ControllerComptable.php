<?php

namespace App\Controllers;



use App\classes\Mailer;
use App\Core\Auth;
use App\Core\MainController;
use App\Models\Factory;
use App\Services\Service;
use DateTime;

class ControllerComptable extends MainController
{

      /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES VUES
     * SEXION POUR LES VIEWS
     * **********************************************************************
     * --------------------------------------------------------------------------
     */

     public  function abonnement()
     {
          // $mail = (new Mailer())->hello();
          // return $test->anyWhere(['etat_user' => 1])->get(['nom', 'prenom']);
          // return $test->raw('select * from users', [], 'fetch');
          // return $test->where('etat_user', 1)->limit(5, 0)->all();
          //  var_dump($t);
          // return $mail->hello();
          return $this->view('comptables/abonnement', ['title' => 'Abonnement']);
     }

     public function caisse()
     {
          return $this->view('comptables/caisse', ['title' => 'Caisse']);
     }

     public function versement()
     {
          return $this->view('comptables/versement', ['title' => 'Versement']);
     }

     public function depense()
     {
          return $this->view('hotels/depense', ['title' => 'Depenses']);
     }
     public function compteDepense()
     {
          return $this->view('comptables/depense', ['title' => 'Depenses']);
     }


     public function salaire()
     {
          return $this->view('comptables/salaire', ['title' => 'Salaire']);
     }



    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES REQUESTS AJAX
     * SEXION POUR LES AJAX REQUESTS
     * **********************************************************************
     * --------------------------------------------------------------------------
     */



     public function confirmDepotUserComptable()
     {
          $_POST = sanitizePostData($_POST);
          $data = decrypter($_POST['periode']);
          $msg['code'] = 400;
          $msg['type'] = "warning";


          if ($data) {
               $code = $_POST['code_versement'];
               [$periodeDebut, $periodeFin] = explode("#", $data);
               $fc = new Factory();

               $data_versement = [
                    "etat_versement" => 1,
                    "confirm_id" => Auth::user('id'),
                    "created_confirm" => date('Y-m-d H:i:s')
               ];

               if ($fc->update2('versements', ['code_versement' => $code, 'hotel_id' => Auth::user('hotel_id')], $data_versement)) {


                    $facture = $fc->getTotalFactureStandByCaisseComptable($periodeDebut, $periodeFin);
                    $caisse = $fc->getTotalFactureEncaisseCaisseComptable($periodeDebut, $periodeFin);

                    $versements = $fc->getAllVersementUserCaisseDepotComptable($periodeDebut, $periodeFin);

                    $msg['data'] = Service::depotUserForCaisseComptable($versements);
                    $msg['caisse'] = money($caisse);
                    $msg['facture'] = money($facture);
                    $msg['code'] = 200;
                    $msg['type'] = "success";
                    $msg['message'] = "Versement confirmé avec succès";
               } else {
                    $msg['message'] = "Désolé, erreur de confirmation";
               }
          } else {
               $msg['message'] = "Désolé, erreur de verification de données";
          }

          echo json_encode($msg);
          return;
     }

     public function listeDepotCaisseComptable()
     {
          $_POST = sanitizePostData($_POST);
          $msg['code'] = 400;
          $msg['type'] = "warning";

          if (!empty($_POST['date_debut']) && !empty($_POST['date_fin'])) {
               extract($_POST);

               $fc = new Factory();

               $msg['facture_standby'] = money($fc->getTotalFactureStandByCaisseComptable($date_debut, $date_fin));
               $msg['facture_encaisse'] = money($fc->getTotalFactureEncaisseCaisseComptable($date_debut, $date_fin));
               $msg['caisse_open'] = money($fc->getTotalFactureOpenCaisseComptable($date_debut, $date_fin));
               
               $versements = $fc->getAllVersementUserCaisseDepotComptable($date_debut, $date_fin);
               
               
               if(!empty($versements)) {
                    $msg['periode'] = crypter($date_debut. "#" . $date_fin);
                    $msg['data'] = Service::depotUserForCaisseComptable($versements);

                    $msg['code'] = 200;
                    $msg['type'] = "success";
                    $msg['message'] = "Recherche effectuée avec succès!";
               }else{
                    $msg['data'] = "<tr> <td colspan='9' class='text-center text-danger'>Aucune information disponible </td>  </tr>";
                    $msg['message'] = "Désolé, aucune information disponible!";
               }

             
          } else {
               $msg['message'] = "Désolé, erreur de verification de données";
          }

          echo json_encode($msg);
          return;
     }

     public function listeBilanCaisseComptable()
     {
          $_POST = sanitizePostData($_POST);
          $msg['code'] = 400;
          $msg['type'] = "warning";

          if (!empty($_POST['date_debut']) && !empty($_POST['date_fin'])) {
               extract($_POST);

               $fc = new Factory();
               $montant_depense = 0;
              
               // sexion bilan 
               $montant_caisse = $fc->getTotalFactureEncaisseCaisseComptable($date_debut, $date_fin);
               $caisse_depense= $fc->getTotalDepenseCaisseComptable($date_debut, $date_fin);
               $caisse_salaire= $fc->getTotalSalaireCaisseComptable($date_debut, $date_fin);
               $montant_depense = $caisse_depense + $caisse_salaire;

               $montant_disponible = $montant_caisse - $montant_depense;
               $color = $montant_disponible <= 0 ? "text-danger" : "text-success";

               $msg['montant_caisse'] = money($montant_caisse);
               $msg['montant_depense'] = money($montant_depense);
               $msg['montant_disponible'] = money($montant_disponible);
               $msg['color'] = $color;

               // sexion details bilan
            
               $detailsReservation = $fc->getDetailsBilanCaisseComptableReservation($date_debut,$date_fin);
               $service = $fc->getDeatailsBilanCaisseComptableService($date_debut,$date_fin);
               $reservationNonRegler = $fc->getDetailsBilanCaisseComptableReservationNonRegler($date_debut,$date_fin);
               $serviceNonRegler = $fc->getDetailsBilanCaisseComptableServiceNonRegler($date_debut,$date_fin);
               $reservationEnnuler = $fc->getDetailsBilanCaisseComptableReservationEnnuler($date_debut,$date_fin);
               $serviceEnnuler = $fc->getDetailsBilanCaisseComptableServiceEnnuler($date_debut,$date_fin);

               $msg['data_details'] = loadDataBilanCaisseComptable($detailsReservation, $service, $reservationNonRegler, $serviceNonRegler, $reservationEnnuler, $serviceEnnuler);

               $msg['code'] = 200;
               $msg['type'] = "success";
               $msg['message'] = "Recherche effectuée avec succès!";
          } else {
               $msg['message'] = "Désolé, erreur de verification de données";
          }

          echo json_encode($msg);
          return;
     }

     // debut depense


      public function listeDepenseRecapt()
     {
          $_POST = sanitizePostData($_POST);
          $msg['code'] = 400;
          $msg['type'] = "warning";
         
          if (!empty($_POST['date_debut']) && !empty($_POST['date_fin'])) {
               extract($_POST);

               $fc = new Factory();
               $depense = $fc->getAllDepenseForSearching($date_debut,$date_fin);

                if((!empty($depense))){

                     $msg['data'] = Service::depenseRecaptData($depense) ;
                    $msg['code'] = 200;
                    $msg['type'] = "success";
                    $msg['message'] = "Recherche effectuée avec succès!";
                    $msg['periode'] = crypter($date_debut."#".$date_fin);
               }else{
                 $msg['data'] =  '<tr> <td colspan="7"  class="text-danger text-center" > Aucune information disponible.</td></tr>';
               }
            
            } else {
                $msg['message'] = "Désolé, erreur de verification de données";
            }

          echo json_encode($msg);
          return;
     }
     public function listeDepense()
     {
          $_POST = sanitizePostData($_POST);
          $msg['code'] = 400;
          $msg['type'] = "warning";
          $past = new DateTime('first day of this month');
          $startDate = $past->format('Y-m-d 00:00:00');

          if (!empty($_POST['date_debut']) && !empty($_POST['date_fin'])) {
               extract($_POST);

               $fc = new Factory();

               $totalDepenseCaisse= $fc->getTotalDepenseCaisseComptable($date_debut,$date_fin);
               $totalDepenseEnAttente= $fc->getTotalDepenseCaisseComptable($date_debut,$date_fin,0);
               $totalDepenseMois = $fc->getTotalDepenseCaisseComptable($startDate,date('Y-m-d 23:59:59'));
               $msg['totalDepenseCaisse'] = ($totalDepenseCaisse != null) ? money($totalDepenseCaisse) : 0;
               $msg['totalDepenseEnAttente'] = ($totalDepenseEnAttente != null) ? money($totalDepenseEnAttente) : 0;
               $msg['totalDepenseMois'] = ($totalDepenseMois != null) ? money($totalDepenseMois) : 0;
               $msg['periode'] = crypter($date_debut."#".$date_fin);


                $depense = $fc->getAllDepenseForSearching($date_debut,$date_fin);
              
              

               if(!empty($depense)){
                 $msg['data'] = Service::depenseDataForSearching($depense) ;
                    $msg['code'] = 200;
                    $msg['type'] = "success";
                    $msg['message'] = "Recherche effectuée avec succès!";

               }else{

                 $msg['data'] = '<tr> <td colspan="8"  class="text-danger text-center" > Aucune information disponible.</td></tr>';
                 $msg['message'] = "Aucune information disponible";

               }

              

            } else {
                $msg['message'] = "Désolé, erreur de verification de données";
            }

          echo json_encode($msg);
          return;
     }
    public function modalAddDepense()
    {

        $output = "";
        $result['code'] = 400;
        $result['type'] = "warning";
        $result['message'] = "Désolé, erreur de verification de données";
        $categories = (new Factory())->getAllTypeDepense();

        if (!empty($categories)) {
            $output = Service::modalAddDepenseHotel($categories);
            $result['data'] = $output;
            $result['code'] = 200;
            $result['type'] = "success";
        }

        echo json_encode($result);
        return;
    }

    public function ajouterDepense()
    {
        // $chambre = $_POST;
        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";


        if (!empty($_POST['categorie']) && !empty($_POST['montant_depense']) && !empty($_POST['date_depense'])) {
            extract($_POST);
            if (ctype_digit($montant_depense) && $montant_depense > 0) {

                $fc = new Factory();

                    $code = $fc->generatorCode('depenses', 'code_depense');
                    $date = date('Y-m-d H:i:s');

                    $etatDepense = 0;
                    $confirm_id = null;
                    $created_confirm = null;
                    if(isset($confirm)){
                       $etatDepense = 1;
                       $confirm_id = Auth::user('id');
                       $created_confirm = date('Y-m-d');
                    }

                    $data_depense = [
                        'code_depense' => $code,
                        'etat_depense' => $etatDepense,
                        'montant_depense' => $montant_depense,
                        'periode_depense' => $date_depense,
                        'description_depense' => $description_depense,
                        'typedepense_id' => $categorie,
                        'created_depense' => $date,
                        'user_id' => Auth::user('id'),
                        'hotel_id' => Auth::user('hotel_id'),
                        'confirm_id'=> $confirm_id,
                        'created_confirm'=> $created_confirm
                    ];

                    if ($fc->create('depenses', $data_depense)) {
                        $msg['code'] = 200;
                        $msg['type'] = "success";
                        $msg['message'] = "Depense enregistrée avec succes";
                    } else {
                        $msg['message'] = "Echec d'enregistrement!";
                    }
               
            } else {
                $msg['message'] = "Desolé! montant invalide. ";
            }
        } else {
            $msg['message'] = "Veuillez renseigner tous les champs. ";
        }

        echo json_encode($msg);
        return;
    }

    public function confirmDepense()
    {
        $_POST = sanitizePostData($_POST);
        $code = decrypter($_POST['code_depense']);
        $data = decrypter($_POST['periode']);
        $msg['code'] = 400;
        $msg['type'] = "warning";
        $past = new DateTime('first day of this month');
        $startDate = $past->format('Y-m-d 00:00:00');

        if ($code) {
            $fc = new Factory();
            
          [$periodeDebut, $periodeFin] = explode("#", $data);
            $data_depense = [
                'etat_depense' => 1,
                'confirm_id' => Auth::user('id'),
                'created_confirm' => date('Y-m-d')
            ];

            $depense = $fc->update('depenses',  'code_depense', $code,$data_depense,);


            if ($depense) {
               $depenses = (new Factory())->getAllDepenseForSearching($periodeDebut,$periodeFin);
                $msg['data'] = Service::depenseDataForSearching($depenses);

                $totalDepenseCaisse= $fc->getTotalDepenseCaisseComptable($periodeDebut,$periodeFin);
                $totalDepenseEnAttente= $fc->getTotalDepenseCaisseComptable($periodeDebut,$periodeFin,0);
                $totalDepenseMois = $fc->getTotalDepenseCaisseComptable($startDate,date('Y-m-d 23:59:59'));
                $msg['totalDepenseCaisse'] = ($totalDepenseCaisse != null) ? money($totalDepenseCaisse) : 0;
                $msg['totalDepenseEnAttente'] = ($totalDepenseEnAttente != null) ? money($totalDepenseEnAttente) : 0;
                $msg['totalDepenseMois'] = ($totalDepenseMois != null) ? money($totalDepenseMois) : 0;

                $msg['code'] = 200;
                $msg['type'] = "success";
                $msg['message'] = "Depense confirmée avec succes";
            } else {
                $msg['message'] = "Echec de confirmation!";
            }
        } else {
            $msg['message'] = "Désolé, erreur de verification de données";
        }

        echo json_encode($msg);
        return;
    }

    public function modalUpdateDepense()
    {

        $_POST = sanitizePostData($_POST);
        extract($_POST);
        $code = decrypter($id_depense);

        if ($code) {
            $fc = new Factory();
            $output = "";
            $categories = $fc->getAllTypeDepense();

            $depense = $fc->find('depenses', 'code_depense', $code);
            $output = Service::frmUpdateDepense($categories, $depense);
        }
        echo json_encode(['data' => $output, 'code' => 200]);
        return;
    }

    public function updateDepense()
    {
        $_POST = sanitizePostData($_POST);
        $code = decrypter($_POST['id_depense']);
        $msg['code'] = 400;
        $msg['type'] = "warning";


        if (!empty($code)) {
            if (!empty($_POST['categorie']) && !empty($_POST['montant_depense']) && !empty($_POST['date_depense'])) {
                extract($_POST);
                if (ctype_digit($montant_depense) && $montant_depense > 0) {

                    $fc = new Factory();

                    $etatDepense = 0;
                    $confirm_id = null;
                    $created_confirm = null;
                    if(isset($confirm)){
                       $etatDepense = 1;
                       $confirm_id = Auth::user('id');
                       $created_confirm = date('Y-m-d');
                    }

                        $data_depense = [
                            'typedepense_id' => $categorie,
                            'montant_depense' => $montant_depense,
                            'periode_depense' => $date_depense,
                            'description_depense' => $description_depense,
                            'etat_depense' => $etatDepense,
                            'confirm_id' => $confirm_id,
                            'created_confirm' => $created_confirm
                        ];

                        $res = $fc->update('depenses', 'code_depense', $code,$data_depense);

                        if ($res || $etatDepense == 0) {
                            $msg['code'] = 200;
                            $msg['type'] = "success";
                            $msg['message'] = "Depense modifiée avec succes";
                        } else {
                            $msg['message'] = "Echec d'enregistrement!";
                        }
                  
                } else {
                    $msg['message'] = "Desolé! montant invalide.";
                }
            } else {
                $msg['message'] = "Veuillez renseigner tous les champs. ";
            }
        } else {
            $msg['message'] = "Erreur de verification.";
        }

        echo json_encode($msg);
        return;
    }

    public function deleteDepense()
    {

        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";

        $code = decrypter($_POST['id_depense']);
        $data = decrypter($_POST['periode']);
        $past = new DateTime('first day of this month');
        $startDate = $past->format('Y-m-d 00:00:00');

        if (!empty($code && $data)) {
          [$periodeDebut, $periodeFin] = explode("#", $data);

          $fc = new Factory();
            $data_depense = [
                'etat_depense' => 2
            ];

            $rest = $fc->update('depenses', 'code_depense', $code, $data_depense);
            if ($rest) {
               $depenses = (new Factory())->getAllDepenseForSearching($periodeDebut,$periodeFin);
                $msg['data'] = Service::depenseDataForSearching($depenses);

                $totalDepenseCaisse= $fc->getTotalDepenseCaisseComptable($periodeDebut,$periodeFin);
                $totalDepenseEnAttente= $fc->getTotalDepenseCaisseComptable($periodeDebut,$periodeFin,0);
                $totalDepenseMois = $fc->getTotalDepenseCaisseComptable($startDate,date('Y-m-d 23:59:59'));
                $msg['totalDepenseCaisse'] = ($totalDepenseCaisse != null) ? money($totalDepenseCaisse) : 0;
                $msg['totalDepenseEnAttente'] = ($totalDepenseEnAttente != null) ? money($totalDepenseEnAttente) : 0;
                $msg['totalDepenseMois'] = ($totalDepenseMois != null) ? money($totalDepenseMois) : 0;

               
                $msg['code'] = 200;
                $msg['type'] = "success";
                $msg['message'] = "Depense Supprimée avec succes";
            } else {
                $msg['message'] = "Echec d'enregistrement!";
            }
        } else {
            $msg['message'] = "Impossible d'effectuer cette operation!";
        }
        echo json_encode($msg);
        return;
    }

     // fin depense

     // debut Salaire

     public function listeSalaire()
     {
          $_POST = sanitizePostData($_POST);
          $msg['code'] = 400;
          $msg['type'] = "warning";
          $past = new DateTime('first day of this month');

        $startDate = $past->format('Y-m-d 00:00:00');


          if (!empty($_POST['date_debut']) && !empty($_POST['date_fin'])) {
               extract($_POST);

               $fc = new Factory();
              

               $totalSalaireEnAttente= $fc->getTotalSalaireCaisseComptable($date_debut,$date_fin,0);
               $totalSalaireMois = $fc->getTotalSalaireCaisseComptable($startDate,date('Y-m-d 23:59:59'));
               $totalSalaireCaisse = $fc->getTotalSalaireCaisseComptable($date_debut,$date_fin);
               $msg['totalSalaireCaisse'] = ($totalSalaireCaisse != null)  ? money($totalSalaireCaisse) : 0;
               $msg['totalSalaireEnAttente'] = ($totalSalaireEnAttente != null) ? money($totalSalaireEnAttente) : 0;
               $msg['totalSalaireMois'] = ($totalSalaireMois != null) ? money($totalSalaireMois) : 0;
               
                $msg['periode'] = crypter($date_debut."#".$date_fin);

                 $salaires = $fc->getAllSalaireForSearching($date_debut,$date_fin);



            if(!empty($salaires)){
                $msg['data'] =  Service::salaireDataForSearching($salaires);
                $msg['code'] = 200;
                $msg['type'] = "success";
                $msg['message'] = "Recherche effectuée avec succès!";
               }else{
                 $msg['data'] =  '<tr> <td colspan="7"  class="text-danger text-center" > Aucune information disponible.</td></tr>';
                $msg['message'] = "Aucune information disponible!";

               }

              
            } else {
                $msg['message'] = "Désolé, erreur de verification de données";
            }

          echo json_encode($msg);
          return;
     }

    public function modalAddSalaire()
    {

        $output = "";
        $result['code'] = 400;
        $result['type'] = "warning";
        $result['message'] = "Désolé, aucun employé enregistré";
        $fc = new Factory();
        $users = $fc->getUserWithFoction();

        if (!empty($users)) {
            $output = Service::modalAddSalaireHotel($users);
            $result['data'] = $output;
            $result['code'] = 200;
            $result['type'] = "success";
        }

        echo json_encode($result);
        return;
    }

    public function ajouterSalaire()
    {
     
        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";


        if (!empty($_POST['user']) && !empty($_POST['montant_salaire']) && !empty($_POST['mois_salaire'])) {
            extract($_POST);
               if (ctype_digit($montant_salaire) && $montant_salaire > 0) {
                    $fc = new Factory();
                    $verifSalaire = $fc->verifSalaireForMonth($user,$mois_salaire);

                if(empty($verifSalaire) || $verifSalaire['etat_salaire'] == 2){ 

                    $code = $fc->generatorCode('salaires', 'code_salaire');
                    $date = date('Y-m-d H:i:s');
                 
                    $etatSalaire = 0;
                    $confirm_id = null;
                    $created_confirm = null;
                    if(isset($confirm)){
                       $etatSalaire = 1;
                       $confirm_id = Auth::user('id');
                       $created_confirm = date('Y-m-d');
                    }

              

                    $data_salaire = [
                        'code_salaire' => $code,
                        'etat_salaire' => $etatSalaire,
                        'montant_salaire' => $montant_salaire,
                        'user_id' => $user,
                        'mois_salaire' => $mois_salaire,
                        'created_salaire' => $date,
                        'created_user' => Auth::user('id'),
                        'hotel_id' => Auth::user('hotel_id'),
                        'confirm_id' => $confirm_id,
                        'created_confirm' => $created_confirm
                    ];

                    if ($fc->create('salaires', $data_salaire)) {

                        $msg['code'] = 200;
                        $msg['type'] = "success";
                        $msg['message'] = "Opération effectuée avec succes";
                    } else {
                        $msg['message'] = "Echec d'enregistrement!";
                    }
               }else{
                    $msg['message'] = "Desolé! Cet employé a déjà reçu son salaire de ce mois !";
               }
               
            } else {
                $msg['message'] = "Desolé! montant invalide. ";
            }
        } else {
            $msg['message'] = "Veuillez renseigner tous les champs. ";
        }

        echo json_encode($msg);
        return;
    }

    public function modalUpdateSalaire()
    {

        $_POST = sanitizePostData($_POST);
        extract($_POST);
        $code = decrypter($id_salaire);

        if ($code) {
            $fc = new Factory();
            $output = "";
            $user = $fc->getUserWithFoction();

            $salaire = $fc->find('salaires', 'code_salaire', $code);
            $output = Service::frmUpdateSalaireHotel($user, $salaire);
        }
        echo json_encode(['data' => $output, 'code' => 200]);
        return;
    }

    public function updateSalaire()
    {
        $_POST = sanitizePostData($_POST);
        $code = decrypter($_POST['id_salaire']);
        $msg['code'] = 400;
        $msg['type'] = "warning";


        if (!empty($code)) {
            if (!empty($_POST['user']) && !empty($_POST['montant_salaire']) && !empty($_POST['mois_salaire'])) {
                extract($_POST);
                if (ctype_digit($montant_salaire) && $montant_salaire > 0) {

                    $fc = new Factory();
                    $verifSalaire = $fc->verifSalaireForMonth($user,$mois_salaire);
                    
                    if(empty($verifSalaire) || ($verifSalaire['code_salaire'] == $code && ($verifSalaire['etat_salaire'] == 2 || $verifSalaire['etat_salaire'] == 0))){   

                         $etat_salaire = 0;
                         $confirm_id = null;
                         $created_confirm = null;
                         if(isset($confirm)){
                            $etat_salaire = 1;
                            $confirm_id = Auth::user('id');
                            $created_confirm = date('Y-m-d');
                         }

                         $data_salaire = [
                            'user_id' => $user,
                            'montant_salaire' => $montant_salaire,
                            'mois_salaire' => $mois_salaire,
                            'etat_salaire' => $etat_salaire,
                            'confirm_id' => $confirm_id,
                            'created_confirm' => $created_confirm,
                            
                        ];

                        $res = $fc->update('salaires', 'code_salaire', $code,$data_salaire);

                        if ($res || $res == 0) {
                            $msg['code'] = 200;
                            $msg['type'] = "success";
                            $msg['message'] = "Opération effectuée avec succes";
                        } else {
                            $msg['message'] = "Echec d'enregistrement!";
                        }
                    }else{
                        $msg['message'] = "Desolé! Cet employé a déjà reçu son salaire de ce mois !";
                    }
                  
                } else {
                    $msg['message'] = "Desolé! montant invalide.";
                }
            } else {
                $msg['message'] = "Veuillez renseigner tous les champs. ";
            }
        } else {
            $msg['message'] = "Erreur de verification.";
        }

        echo json_encode($msg);
        return;
    }

    public function confirmSalaire()
    {
        $_POST = sanitizePostData($_POST);
        $code = decrypter($_POST['code_salaire']);
        $data = decrypter($_POST['periode']);
        $msg['code'] = 400;
        $msg['type'] = "warning";
        $past = new DateTime('first day of this month');

        $startDate = $past->format('Y-m-d 00:00:00');

        if ($code) {
            $fc = new Factory();
            
          [$periodeDebut, $periodeFin] = explode("#", $data);
            $data_salaire = [
                'etat_salaire' => 1,
                'confirm_id' => Auth::user('id'),
                'created_confirm' => date('Y-m-d')
            ];

            $salaire = $fc->update('salaires',  'code_salaire', $code,$data_salaire,);


            if ($salaire) {
               $salaires = $fc->getAllSalaireForSearching($periodeDebut,$periodeFin);
                $msg['data'] = Service::salaireDataForSearching($salaires);

                $totalSalaireEnAttente= $fc->getTotalSalaireCaisseComptable($periodeDebut,$periodeFin,0);
                $totalSalaireMois = $fc->getTotalSalaireCaisseComptable($startDate,date('Y-m-d 23:59:59'));
                $totalSalaireCaisse = $fc->getTotalSalaireCaisseComptable($periodeDebut,$periodeFin);

                $msg['totalSalaireCaisse'] = ($totalSalaireCaisse != null) ? money($totalSalaireCaisse) : 0;
                $msg['totalSalaireEnAttente'] = ($totalSalaireEnAttente != null) ? money($totalSalaireEnAttente) : 0;
                $msg['totalSalaireMois'] = ($totalSalaireMois != null) ? money($totalSalaireMois) : 0;

                $msg['code'] = 200;
                $msg['type'] = "success";
                $msg['message'] = "Opération effectuée avec succes";
            } else {
                $msg['message'] = "Echec de confirmation!";
            }
        } else {
            $msg['message'] = "Désolé, erreur de verification de données";
        }

        echo json_encode($msg);
        return;
    }

    public function deleteSalaire()
    {

        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";

        $code = decrypter($_POST['id_salaire']);
        $data = decrypter($_POST['periode']);
        $past = new DateTime('first day of this month');

        $startDate = $past->format('Y-m-d 00:00:00');

        if (!empty($code && $data)) {
          [$periodeDebut, $periodeFin] = explode("#", $data);

            $fc = new Factory();
            $data_salaire = [
                'etat_salaire' => 2,
                'confirm_id' => Auth::user('id'),
                'created_confirm' => date('Y-m-d')
            ];

            $rest = $fc->update('salaires', 'code_salaire', $code, $data_salaire);
            if ($rest) {
               $salaires = $fc->getAllSalaireForSearching($periodeDebut,$periodeFin);
                $msg['data'] = Service::salaireDataForSearching($salaires);

                $totalSalaireEnAttente= $fc->getTotalSalaireCaisseComptable($periodeDebut,$periodeFin,0);
                $totalSalaireMois = $fc->getTotalSalaireCaisseComptable($startDate,date('Y-m-d 23:59:59'));
                $totalSalaireCaisse = $fc->getTotalSalaireCaisseComptable($periodeDebut,$periodeFin);
                $msg['totalSalaireCaisse'] = ($totalSalaireCaisse != null)  ? money($totalSalaireCaisse) : 0;
                $msg['totalSalaireEnAttente'] = ($totalSalaireEnAttente != null) ? money($totalSalaireEnAttente) : 0;
                $msg['totalSalaireMois'] = ($totalSalaireMois != null) ? money($totalSalaireMois) : 0;

                $msg['code'] = 200;
                $msg['type'] = "success";
                $msg['message'] = "Opération effectuée avec succes";
            } else {
                $msg['message'] = "Echec d'enregistrement!";
            }
        } else {
            $msg['message'] = "Impossible d'effectuer cette opération!";
        }
        echo json_encode($msg);
        return;
    }

     // fin Salaire

    // SEXION CHART 

    public function bilanDashboard()
    {

        $result['code'] = 400;
        $result['type'] = "warning";
        $result['message'] = "Désolé, aucune information disponible!";
        $fc = new Factory();
        $year = $_POST['annee'] != null ? $_POST['annee'] : date("Y");

        $versements = $fc->bilanAnnuelDashboard($year);

        if (!empty($versements)) {
            $result["data"] = $versements;
            $result['code'] = 200;
            $result['type'] = 'success';
            $result['message'] = '';
        }

        echo json_encode($result);
        return;
    }

    // END CHART
    
}
