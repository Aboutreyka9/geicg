<?php

namespace App\Controllers;

use App\Core\Auth;
use TABLES;
use App\Models\Personne;
use App\Services\Service;
use App\Core\MainController;
use App\Models\Boutique;
use App\Services\BoutiqueService;
use App\Services\PersonneService;

class BoutiqueController extends MainController
{
    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES RENDUS
     * SEXION POUR LES VUES 
     * **********************************************************************
     * --------------------------------------------------------------------------
     */


    public  function boutique()
    {
        return $this->view('boutiques/liste', ['title' => "Boutique"]);
    }



    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES REQUESTS AJAX
     * SEXION POUR LES AJAX REQUESTS
     * **********************************************************************
     * --------------------------------------------------------------------------
     */



    public function bGetListeBoutique()
    {

        extract($_POST);
        $output = "";
        $boutique = new Boutique();
        $columns = ['libelle_boutique', 'email_boutique', 'telephone_boutique', 'telephone2_boutique', 'adresse_boutique', 'boutique_created_at'];

        $likeParams = [];
        $whereParams = ['compte_code' => Auth::user("compte_code"), 'etat_boutique' => ETAT_ACTIF];
        $orderBy = ["libelle_boutique" => "ASC"];
        $limit  = $_POST['length'];
        $start  = $_POST['start'];
        $search = $_POST['search']['value'] ?? '';


        // 🔎 Recherche
        if (!empty($search)) {
            $likeParams = ['libelle_boutique' => $search, 'telephone_boutique' => $search, 'adresse_boutique' => $search, 'telephone2_boutique' => $search, 'email_boutique' => $search, 'boutique_created_at' => $search];
        }

        // 🔢 Total
        $total = $boutique->dataTbleCountTotalRow(TABLES::BOUTIQUES, $whereParams);
        // 🔢 Total filtré

        $totalFiltered = $boutique->dataTbleCountTotalRow(TABLES::BOUTIQUES, $whereParams, $likeParams);
        // 📄 Données

        $boutiqueList = $boutique->DataTableFetchAllListe(TABLES::BOUTIQUES, $whereParams, $likeParams, $orderBy, $start, $limit);

        $data = [];


        $data = BoutiqueService::boutiqueDataService($boutiqueList);
        echo json_encode([
            "draw"            => intval($_POST['draw']),
            "recordsTotal"    => $total,
            "recordsFiltered" => $totalFiltered,
            "data"            => $data
            // "data"            => $data
        ]);
        // echo json_encode(['data' => $total, 'code' => 200]);
        return;
    }

    public function bModalAddBoutique()
    {

        extract($_POST);
        $output = BoutiqueService::bBoutiqueAddModalService();
        echo json_encode(['data' => $output, 'code' => 200]);
        return;
    }

    public function bAddNewBoutique()
    {
        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";

        if (!empty($_POST['telephone_boutique']) && !empty($_POST['libelle_boutique'])) {

            extract($_POST);

            $telephone = removeSpace($telephone_boutique);
            $telephone = str_replace('(+225)', '', $telephone);

            if (ctype_digit($telephone) && mb_strlen($telephone) == 10) {

                $boutique = new Boutique();

                $resp = $boutique->getFieldsForParams(TABLES::BOUTIQUES, ['telephone_boutique' => $telephone]);

                if (empty($resp)) {
                    $date = date("Y-m-d H:i:s");
                    $codeBoutique = $boutique->generatorCode(TABLES::BOUTIQUES, "code_boutique");
                    $data_boutique = [
                        'libelle_boutique' => strtoupper($libelle_boutique),
                        'telephone_boutique' => $telephone,
                        'telephone2_boutique' => $telephone2_boutique,
                        'email_boutique' => $email_boutique,
                        'code_boutique' => $codeBoutique,
                        'compte_code' => Auth::user("compte_code"),
                        'adresse_boutique' => $adresse_boutique,
                        'boutique_created_at' => $date
                    ];

                    if ($boutique->create(TABLES::BOUTIQUES, $data_boutique)) {
                        $msg['code'] = 200;
                        $msg['type'] = "success";
                        $msg['message'] = "Boutique enregistrée avec succès";
                    } else {
                        $msg['message'] = "Désolé, erreur d'enregistrement de la boutique";
                    }
                } else {
                    $msg['message'] = "Desolé, ce numéro de telephone existe déjà.";
                }
            } else {
                $msg['message'] = "Numero de telephone invalide.";
            }
        } else {
            $msg['message'] = "Veuillez renseigner  tous les champs.";
        }

        echo json_encode($msg);
        return;
    }

    public static function bModalUpdateBoutique()
    {
        $_POST = sanitizePostData($_POST);
        extract($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";
        $boutique = new Boutique();
        $resp = $boutique->getFieldsForParams(TABLES::BOUTIQUES, ['compte_code' => Auth::user("compte_code"), 'code_boutique' => $codeBoutique]);

        $output = BoutiqueService::bBoutiqueUpdateModalService($resp);

        // $output = Service::frmUpdateReservation($code_reservation);
        echo json_encode(['data' => $output, 'code' => 200]);
        return;
    }

    public function bUpdateBoutique()
    {
        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";

        if (!empty($_POST['libelle_boutique']) && !empty($_POST['telephone_boutique'])) {
            extract($_POST);
            $telephone = removeSpace($telephone_boutique);
            $telephone = str_replace('(+225)', '', $telephone);


            if (ctype_digit($telephone) && mb_strlen($telephone) == 10) {

                $boutique = new Boutique();

                $resp = $boutique->getFieldsForParams(TABLES::BOUTIQUES, ['code_boutique' => BOUTIQUE_CODE, 'telephone_boutique' => $telephone]);

                if (empty($resp) || ($code_boutique == $resp['code_boutique'])) {

                    $data_boutique = [
                        'libelle_boutique' => strtoupper($libelle_boutique),
                        'telephone_boutique' => $telephone,
                        'telephone2_boutique' => $telephone2_boutique,
                        'email_boutique' => $email_boutique,
                        'adresse_boutique' => $adresse_boutique,
                    ];

                    $resp = $boutique->update(TABLES::BOUTIQUES, 'code_boutique', $code_boutique, $data_boutique);
                    if ($resp || $resp == 0) {
                        $msg['code'] = 200;
                        $msg['type'] = "success";
                        $msg['message'] = "Boutique modifiée avec succès";
                    } else {
                        $msg['message'] = "Désolé, erreur de modification de la boutique";
                    }
                } else {
                    $msg['message'] = "Desolé, ce numéro de telephone existe déjà.";
                }
            } else {
                $msg['message'] = "Numero de telephone invalide.";
            }
        } else {
            $msg['message'] = "Veuillez renseigner tous les champs.";
        }

        echo json_encode($msg);
        return;
    }



    function ActiveAnnee()
    {

        if (isset($_POST['btn_active_annee'])) {
            $code = $_POST['code_annee'];
            $msg['code'] = 400;
            $msg['data'] = "";

            UpdateAllAnnee();
            if (UpdateAnneeByCode(1, $code)) {
                $_SESSION[KEY_AUTH]['annee'] = $_POST['code_annee'];
                $msg['code'] = 200;
                $msg['data'] = 'Operation effectuée avec succes';
            }

            echo json_encode($msg);
            return;
        }
    }


    function changeBoutique()
    {
        $code = $_POST['code_annee'];
        $msg['code'] = 400;
        $msg['data'] = "";

        UpdateAllAnnee();
        $_SESSION[KEY_AUTH]['annee']  = getAnneeActive()['code_annee'];
        // if ( UpdateAnneeByCode(0,$code)) {
        $msg['code'] = 200;
        $msg['data'] = 'Operation effectuée avec succes';
        // }

        echo json_encode($msg);
        return;
    }
}
