<?php

namespace App\Controllers;

use TABLES;
use App\Core\Auth;
use App\Models\Personne;
use App\Services\Service;
use App\Core\MainController;
use App\Services\PersonneService;

class FournisseurController extends MainController
{
    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES RENDUS
     * SEXION POUR LES VUES 
     * **********************************************************************
     * --------------------------------------------------------------------------
     */


    public  function fournisseur()
    {
        return $this->view('fournisseurs/liste', ['title' => "Fournisseurs"]);
    }

    public  function order()
    {
        return $this->view('fournisseurs/order', ['title' => "liste commandes fournisseurs"]);
    }
    public  function addOrder()
    {
        return $this->view('fournisseurs/addOrder', ['title' => "Ajouter commande fournisseur"]);
    }



    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES REQUESTS AJAX
     * SEXION POUR LES AJAX REQUESTS
     * **********************************************************************
     * --------------------------------------------------------------------------
     */


    public function bGetListeFournisseurs()
    {

        extract($_POST);
        $output = "";
        $personne = new Personne();
        $columns = ['nom_fournisseur', 'email_fournisseur', 'telephone_fournisseur', 'sexe_fournisseur', 'fournisseur_created_at'];

        $likeParams = [];
        $whereParams = ['boutique_code' => BOUTIQUE_CODE, 'etat_fournisseur' => 1];
        $orderBy = ["nom_fournisseur" => "ASC"];
        $limit  = $_POST['length'];
        $start  = $_POST['start'];
        $search = $_POST['search']['value'] ?? '';


        // 🔎 Recherche
        if (!empty($search)) {
            $likeParams = ['nom_fournisseur' => $search, 'telephone_fournisseur' => $search, 'sexe_fournisseur' => $search, 'email_fournisseur' => $search, 'fournisseur_created_at' => $search];
        }

        // 🔢 Total
        $total = $personne->dataTbleCountTotalRow(TABLES::FOURNISSEURS, $whereParams);

        // 🔢 Total filtré

        $totalFiltered = $personne->dataTbleCountTotalRow(TABLES::FOURNISSEURS, $whereParams, $likeParams);
        // 📄 Données

        $fournisseur = $personne->DataTableFetchAllListe(TABLES::FOURNISSEURS, $whereParams, $likeParams, $orderBy, $start, $limit);


        $data = [];


        $data = PersonneService::fournisseurDataService($fournisseur);
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

    public function bModalAddFournisseur()
    {

        extract($_POST);
        $output = PersonneService::bFournisseurAddModalService();
        echo json_encode(['data' => $output, 'code' => 200]);
        return;
    }

    public function bAddNewFournisseur()
    {
        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";

        if (!empty($_POST['nom_fournisseur']) && !empty($_POST['telephone_fournisseur']) && !empty($_POST['sexe'])) {
            extract($_POST);
            $telephone = removeSpace($telephone_fournisseur);
            $telephone = str_replace('(+225)', '', $telephone);

            if (ctype_digit($telephone) && mb_strlen($telephone) == 10) {

                $personne = new Personne();

                $fournisseur = $personne->getFieldsForParams(TABLES::FOURNISSEURS, ['boutique_code' => BOUTIQUE_CODE, 'telephone_fournisseur' => $telephone]);

                if (empty($fournisseur)) {
                    $date = date("Y-m-d H:i:s");
                    $codeFournisseur = $personne->generatorCode(TABLES::FOURNISSEURS, "code_fournisseur");

                    $data_fournisseur = [
                        'nom_fournisseur' => strtoupper($nom_fournisseur),
                        'telephone_fournisseur' => $telephone,
                        'code_fournisseur' => $codeFournisseur,
                        'boutique_code' => Auth::user("boutique_code"),
                        'compte_code' => Auth::user("compte_code"),
                        'sexe_fournisseur' => $sexe,
                        'fournisseur_created_at' => $date
                    ];

                    if ($personne->create(TABLES::FOURNISSEURS, $data_fournisseur)) {
                        $msg['code'] = 200;
                        $msg['type'] = "success";
                        $msg['message'] = "Fournisseur enregistré avec succès";
                    } else {
                        $msg['message'] = "Désolé, erreur d'enregistrement du fournisseur";
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

    public static function bModalUpdateFournisseur()
    {
        $_POST = sanitizePostData($_POST);
        extract($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";
        $personne = new Personne();
        $fournisseur = $personne->getFieldsForParams(TABLES::FOURNISSEURS, ['boutique_code' => BOUTIQUE_CODE, 'code_fournisseur' => $codeFournisseur]);

        $output = PersonneService::bFournisseurUpdateModalService($fournisseur);

        // $output = Service::frmUpdateReservation($code_reservation);
        echo json_encode(['data' => $output, 'code' => 200]);
        return;
    }

    public function bUpdateFournisseur()
    {
        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";

        if (!empty($_POST['nom_fournisseur']) && !empty($_POST['telephone_fournisseur']) && !empty($_POST['sexe']) && !empty($_POST['code_fournisseur'])) {
            extract($_POST);
            $telephone = removeSpace($telephone_fournisseur);
            $telephone = str_replace('(+225)', '', $telephone);


            if (ctype_digit($telephone) && mb_strlen($telephone) == 10) {

                $personne = new Personne();

                $fournisseur = $personne->getFieldsForParams(TABLES::FOURNISSEURS, ['boutique_code' => BOUTIQUE_CODE, 'telephone_fournisseur' => $telephone]);


                if (empty($fournisseur) || ($code_fournisseur == $fournisseur['code_fournisseur'])) {

                    $data_fournisseur = [
                        'nom_fournisseur' => strtoupper($nom_fournisseur),
                        'telephone_fournisseur' => $telephone,
                        'sexe_fournisseur' => $sexe,
                        'email_fournisseur' => $email_fournisseur,
                    ];

                    $rest = $personne->update(TABLES::FOURNISSEURS, 'code_fournisseur', $code_fournisseur, $data_fournisseur);
                    if ($rest || $rest == 0) {
                        $msg['code'] = 200;
                        $msg['type'] = "success";
                        $msg['message'] = "Fournisseur modifié avec succès";
                    } else {
                        $msg['message'] = "Désolé, erreur de modification du fournisseur";
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
}
