<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\MainController;
use App\Models\Catalogue;
use App\Models\Factory;
use App\Services\CatalogueService;
use Groupes;
use TABLES;

class UniteController extends MainController
{

    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES VUES
     * SEXION POUR LES VIEWS
     * **********************************************************************
     * --------------------------------------------------------------------------
     */

    private $model;
    public function __construct()
    {
        $this->model = new Catalogue();
    }

    public function unite()
    {
        return $this->view('catalogues/unite', ['title' => 'Unité']);
    }


    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES REQUESTS AJAX
     * SEXION POUR LES AJAX REQUESTS
     * **********************************************************************
     * --------------------------------------------------------------------------
     */

    public function aGetListeUnite()
    {

        extract($_POST);
        $output = "";
        $unite = new Catalogue();

        $likeParams = [];
        $whereParams = ['compte_code' => Auth::user("compte_code"), 'boutique_code' => Auth::user("boutique_code"), 'etat_unite' => ETAT_ACTIF];
        $orderBy = ["libelle_unite" => "ASC"];
        $limit  = $_POST['length'];
        $start  = $_POST['start'];
        $search = $_POST['search']['value'] ?? '';


        // 🔎 Recherche
        if (!empty($search)) {
            $likeParams = ['libelle_unite' => $search];
        }

        // 🔢 Total
        $total = $unite->dataTbleCountTotalRow(TABLES::UNITES, $whereParams);
        // 🔢 Total filtré

        $totalFiltered = $unite->dataTbleCountTotalRow(TABLES::UNITES, $whereParams, $likeParams);
        // 📄 Données

        $uniteList = $unite->DataTableFetchAllListe(TABLES::UNITES, $whereParams, $likeParams, $orderBy, $start, $limit);

        $data = [];


        $data = CatalogueService::uniteDataService($uniteList);
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

    public function aDeleteUnite()
    {

        $_POST = sanitizePostData($_POST);
        $code_unite = $_POST['code_unite'] ?? null;
        $msg['code'] = 400;
        $msg['type'] = "warning";
        if ($code_unite != null) {

            $data_unite = [
                'etat_unite' => ETAT_INACTIF
            ];
            $rest = (new Factory())->update(TABLES::UNITES, 'code_unite', $code_unite, $data_unite);
            if ($rest) {
                $msg['code'] = 200;
                $msg['type'] = "success";
                $msg['message'] = "unite unite Supprimée avec succes";
            } else {
                $msg['message'] = "Echec d'enregistrement!";
            }
        } else {
            $msg['message'] = "Impossible d'effectuer cette operation!";
        }
        echo json_encode($msg);
        return;
    }

    public function aModalUpdateUnite()
    {

        $_POST = sanitizePostData($_POST);

        $code = ($_POST['code']);
        $result['code'] = 400;
        $output = "";
        if ($code) {
            $fc = new Factory();
            $unite = $this->model->aGetUniteByField("code_unite", $code);
            if (!empty($unite)) {
                $output = CatalogueService::modalUpdateUnite($unite);
                $result['data'] = $output;
                $result['code'] = 200;
            } else {
                $result['data'] = "Erreur lors de la recuperation!";
                $result['code'] = 400;
            }
        } else {
            $result['data'] = "unite introuvable!";
            $result['code'] = 400;
        }
        echo json_encode($result);
        return;
    }

    public function aUpdateUnite()
    {

        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";

        $code = ($_POST['code_unite']);

        if (!empty($code)) {

            if (!empty($_POST['libelle_unite'])) {
                extract($_POST);
                $fc = new Factory();

                $unite = $this->model->aGetUniteByField("libelle_unite", $libelle_unite);

                if (empty($unite) || ($code == $unite['code_unite'])) {

                    $data_unite = [
                        'libelle_unite' => strtoupper($libelle_unite),
                    ];

                    $rest = $fc->update(TABLES::UNITES, 'code_unite', $code, $data_unite);

                    if ($rest || $rest == 0) {
                        $msg['code'] = 200;
                        $msg['type'] = "success";
                        $msg['message'] = "unite unite modifiée avec succes";
                    } else {
                        $msg['message'] = "Echec d'enregistrement!";
                    }
                } else {
                    $msg['message'] = "Desolé! Cette unite existe déjà. ";
                }
            } else {
                $msg['message'] = "Veuillez remplire tous les champs. ";
            }
        } else {
            $msg['message'] = "Erreur de donnée, vueillez ressayer plus tard. ";
        }

        echo json_encode($msg);
        return;
    }

    public function aModalAddUnite()
    {
        $output = "";

        $output = CatalogueService::aModalAddUnite();
        echo json_encode(['data' => $output, 'code' => 200]);
        return;
    }


    public function aAjouterUnite()
    {
        $msg['code'] = 400;
        $_POST = sanitizePostData($_POST);

        if (!empty($_POST['libelle_unite'])) {
            extract($_POST);

            $fc = new Factory();


            if (!$fc->verif(TABLES::UNITES, "libelle_unite", $libelle_unite)) {
                $code = $fc->generateCode(TABLES::UNITES, "code_unite", "CAT-", 8);
                $data_unite = [
                    'libelle_unite' => strtoupper($libelle_unite),
                    'code_unite' => $code,
                    'compte_code' => Auth::user("compte_code"),
                    'boutique_code' => Auth::user("boutique_code")
                ];
                $rest = $fc->create(TABLES::UNITES, $data_unite);
                if ($rest || $rest == 0) {
                    $msg['code'] = 200;
                    $msg['type'] = "success";
                    $msg['message'] = "unite enregistré avec succes";
                } else {
                    $msg['type'] = "warning";
                    $msg['message'] = "Echec d'enregistrement!";
                }
            } else {

                $msg['type'] = "warning";
                $msg['message'] = "Desolé! Cette unite existe déjà. ";
            }
        } else {
            $msg['type'] = "warning";
            $msg['message'] = "Veuillez remplire tous les champs. ";
        }
        echo json_encode($msg);
    }
}
