<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\MainController;
use App\Models\Catalogue;
use App\Models\Factory;
use App\Services\CatalogueService;
use Groupes;
use TABLES;

class MarkController extends MainController
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

    public function mark()
    {
        return $this->view('catalogues/mark', ['title' => 'Marque']);
    }


    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * SEXION POUR LES REQUESTS AJAX
     * SEXION POUR LES AJAX REQUESTS
     * **********************************************************************
     * --------------------------------------------------------------------------
     */

    public function aGetListeMark()
    {

        extract($_POST);
        $output = "";
        $mark = new Catalogue();

        $likeParams = [];
        $whereParams = ['compte_code' => Auth::user("compte_code"), 'boutique_code' => Auth::user("boutique_code"), 'etat_mark' => ETAT_ACTIF];
        $orderBy = ["libelle_mark" => "ASC"];
        $limit  = $_POST['length'];
        $start  = $_POST['start'];
        $search = $_POST['search']['value'] ?? '';


        // 🔎 Recherche
        if (!empty($search)) {
            $likeParams = ['libelle_mark' => $search];
        }

        // 🔢 Total
        $total = $mark->dataTbleCountTotalRow(TABLES::MARKS, $whereParams);
        // 🔢 Total filtré

        $totalFiltered = $mark->dataTbleCountTotalRow(TABLES::MARKS, $whereParams, $likeParams);
        // 📄 Données

        $markList = $mark->DataTableFetchAllListe(TABLES::MARKS, $whereParams, $likeParams, $orderBy, $start, $limit);

        $data = [];


        $data = CatalogueService::markDataService($markList);
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

    public function aDeleteMark()
    {

        $_POST = sanitizePostData($_POST);
        $code_mark = $_POST['code_mark'] ?? null;
        $msg['code'] = 400;
        $msg['type'] = "warning";
        if ($code_mark != null) {

            $data_mark = [
                'etat_mark' => ETAT_INACTIF
            ];
            $rest = (new Factory())->update(TABLES::MARKS, 'code_mark', $code_mark, $data_mark);
            if ($rest || $rest == 0) {
                $msg['code'] = 200;
                $msg['type'] = "success";
                $msg['message'] = "mark mark Supprimée avec succes";
            } else {
                $msg['message'] = "Echec d'enregistrement!";
            }
        } else {
            $msg['message'] = "Impossible d'effectuer cette operation!";
        }
        echo json_encode($msg);
        return;
    }

    public function aModalUpdateMark()
    {

        $_POST = sanitizePostData($_POST);

        $code = ($_POST['code']);
        $result['code'] = 400;
        $output = "";
        if ($code) {
            $fc = new Factory();
            $mark = $this->model->aGetMarkByField("code_mark", $code);
            if (!empty($mark)) {
                $output = CatalogueService::modalUpdateMark($mark);
                $result['data'] = $output;
                $result['code'] = 200;
            } else {
                $result['data'] = "Erreur lors de la recuperation!";
                $result['code'] = 400;
            }
        } else {
            $result['data'] = "mark introuvable!";
            $result['code'] = 400;
        }
        echo json_encode($result);
        return;
    }

    public function aUpdateMark()
    {

        $_POST = sanitizePostData($_POST);
        $msg['code'] = 400;
        $msg['type'] = "warning";

        $code = ($_POST['code_mark']);
        if (!empty($code)) {

            if (!empty($_POST['libelle_mark'])) {
                extract($_POST);
                $fc = new Factory();

                $mark = $this->model->aGetMarkByField("libelle_mark", $libelle_mark);

                if (empty($mark) || ($code == $mark['code_mark'])) {

                    $data_mark = [
                        'libelle_mark' => strtoupper($libelle_mark),
                    ];

                    $rest = $fc->update(TABLES::MARKS, 'code_mark', $code, $data_mark);

                    if ($rest || $rest == 0) {
                        $msg['code'] = 200;
                        $msg['type'] = "success";
                        $msg['message'] = "mark mark modifiée avec succes";
                    } else {
                        $msg['message'] = "Echec d'enregistrement!";
                    }
                } else {
                    $msg['message'] = "Desolé! Cette mark existe déjà. ";
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

    public function aModalAddMark()
    {
        $output = "";

        $output = CatalogueService::aModalAddmark();
        echo json_encode(['data' => $output, 'code' => 200]);
        return;
    }


    public function aAjouterMark()
    {
        $msg['code'] = 400;
        $_POST = sanitizePostData($_POST);

        if (!empty($_POST['libelle_mark'])) {
            extract($_POST);

            $fc = new Factory();


            if (!$fc->verif(TABLES::MARKS, "libelle_mark", $libelle_mark)) {
                $code = $fc->generateCode(TABLES::MARKS, "code_mark", "CAT-", 8);
                $data_mark = [
                    'libelle_mark' => strtoupper($libelle_mark),
                    'code_mark' => $code,
                    'compte_code' => Auth::user("compte_code"),
                    'boutique_code' => Auth::user("boutique_code")
                ];
                if ($fc->create(TABLES::MARKS, $data_mark)) {
                    $msg['code'] = 200;
                    $msg['type'] = "success";
                    $msg['message'] = "mark enregistré avec succes";
                } else {
                    $msg['type'] = "warning";
                    $msg['message'] = "Echec d'enregistrement!";
                }
            } else {

                $msg['type'] = "warning";
                $msg['message'] = "Desolé! Cette mark existe déjà. ";
            }
        } else {
            $msg['type'] = "warning";
            $msg['message'] = "Veuillez remplire tous les champs. ";
        }
        echo json_encode($msg);
    }
}
