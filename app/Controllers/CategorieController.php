<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\MainController;
use App\Models\Catalogue;
use App\Models\Factory;
use App\Services\CatalogueService;
use Groupes;
use TABLES;

class CategorieController extends MainController
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

    public function categorie()
    {
        return $this->view('catalogues/categorie', ['title' => 'Catégorie']);
    }


    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES REQUESTS AJAX
     * SEXION POUR LES AJAX REQUESTS
     * **********************************************************************
     * --------------------------------------------------------------------------
     */

    public function aGetListeCategorie()
    {

        extract($_POST);
        $output = "";
        $categorie = new Catalogue();

        $likeParams = [];
        $whereParams = ['compte_code' => Auth::user("compte_code"), 'boutique_code' => Auth::user("boutique_code"), 'etat_categorie' => ETAT_ACTIF];
        $orderBy = ["libelle_categorie" => "ASC"];
        $limit  = $_POST['length'];
        $start  = $_POST['start'];
        $search = $_POST['search']['value'] ?? '';


        // 🔎 Recherche
        if (!empty($search)) {
            $likeParams = ['libelle_categorie' => $search];
        }

        // 🔢 Total
        $total = $categorie->dataTbleCountTotalRow(TABLES::CATEGORIES, $whereParams);
        // 🔢 Total filtré

        $totalFiltered = $categorie->dataTbleCountTotalRow(TABLES::CATEGORIES, $whereParams, $likeParams);
        // 📄 Données

        $categorieList = $categorie->DataTableFetchAllListe(TABLES::CATEGORIES, $whereParams, $likeParams, $orderBy, $start, $limit);

        $data = [];


        $data = CatalogueService::categorieDataService($categorieList);
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


    public function aDeleteCategorie()
    {

        $_POST = sanitizePostData($_POST);
        $code_categorie = $_POST['code_categorie'] ?? null;
        $msg['code'] = 400;
        $msg['type'] = "warning";
        if ($code_categorie != null) {

            $data_categorie = [
                'etat_categorie' => ETAT_INACTIF
            ];
            $rest = (new Factory())->update(TABLES::CATEGORIES, 'code_categorie', $code_categorie, $data_categorie);
            if ($rest) {
                $msg['code'] = 200;
                $msg['type'] = "success";
                $msg['message'] = "Categorie categorie Supprimée avec succes";
            } else {
                $msg['message'] = "Echec d'enregistrement!";
            }
        } else {
            $msg['message'] = "Impossible d'effectuer cette operation!";
        }
        echo json_encode($msg);
        return;
    }

    public function aModalUpdateCategorie()
    {

        $_POST = sanitizePostData($_POST);

        $code = ($_POST['code']);
        $result['code'] = 400;
        $output = "";
        if ($code) {
            $fc = new Factory();
            $categorie = $this->model->aGetCategorieByField("code_categorie", $code);
            if (!empty($categorie)) {
                $output = CatalogueService::modalUpdateCategorie($categorie);
                $result['data'] = $output;
                $result['code'] = 200;
            } else {
                $result['data'] = "Erreur lors de la recuperation!";
                $result['code'] = 400;
            }
        } else {
            $result['data'] = "Categorie introuvable!";
            $result['code'] = 400;
        }
        echo json_encode($result);
        return;
    }

    public function aUpdateCategorie()
    {

        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";

        $code = ($_POST['code_categorie']);

        if (!empty($code)) {

            if (!empty($_POST['libelle_categorie'])) {
                extract($_POST);
                $fc = new Factory();

                $categorie = $this->model->aGetCategorieByField("libelle_categorie", $libelle_categorie);

                if (empty($categorie) || ($code == $categorie['code_categorie'])) {

                    $data_categorie = [
                        'libelle_categorie' => strtoupper($libelle_categorie),
                        'description_categorie' => ucfirst($description_categorie),
                    ];

                    $rest = $fc->update(TABLES::CATEGORIES, 'code_categorie', $code, $data_categorie);

                    if ($rest || $rest == 0) {
                        $msg['code'] = 200;
                        $msg['type'] = "success";
                        $msg['message'] = "Categorie categorie modifiée avec succes";
                    } else {
                        $msg['message'] = "Echec d'enregistrement!";
                    }
                } else {
                    $msg['message'] = "Desolé! Cette categorie existe déjà. ";
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

    public function amodalAddCategorie()
    {
        $output = "";

        $output = CatalogueService::amodalAddCategorie();
        echo json_encode(['data' => $output, 'code' => 200]);
        return;
    }


    public function aAjouterCategorie()
    {
        $msg['code'] = 400;
        $_POST = sanitizePostData($_POST);

        if (!empty($_POST['libelle_categorie'])) {
            extract($_POST);

            $fc = new Factory();


            if (!$fc->verif(TABLES::CATEGORIES, "libelle_categorie", $libelle_categorie)) {
                $code = $fc->generateCode(TABLES::CATEGORIES, "code_categorie", "CAT-", 8);
                $description = !empty($description_categorie) ?
                    ucfirst($description_categorie) : null;
                $data_categorie = [
                    'libelle_categorie' => strtoupper($libelle_categorie),
                    'code_categorie' => $code,
                    'compte_code' => Auth::user("compte_code"),
                    'boutique_code' => Auth::user("boutique_code"),
                    'description_categorie' => $description
                ];
                $rest = $fc->create(TABLES::CATEGORIES, $data_categorie);

                if ($rest || $rest == 0) {
                    $msg['code'] = 200;
                    $msg['type'] = "success";
                    $msg['message'] = "Categorie enregistré avec succes";
                } else {
                    $msg['type'] = "warning";
                    $msg['message'] = "Echec d'enregistrement!";
                }
            } else {

                $msg['type'] = "warning";
                $msg['message'] = "Desolé! Cette categorie existe déjà. ";
            }
        } else {
            $msg['type'] = "warning";
            $msg['message'] = "Veuillez remplire tous les champs. ";
        }
        echo json_encode($msg);
    }
}
