<?php

namespace App\Services;

use App\Core\Auth;
use App\Models\Factory;
use App\Models\SettingModel;
use App\Models\UserModel;
use TABLES;

class SettingService
{

  public static SettingModel $settingModel;

    public function __construct()
    {
        self::$settingModel = new SettingModel();
    }

    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * DEBUT SEXION SETTING REQUETES
     * **********************************************************************
     * --------------------------------------------------------------------------
     */

      public static function saveFonctionData(array $post)  {
        extract($post);


        if (!empty(self::$settingModel->find(TABLES::FONCTIONS, 'libelle_fonction', $libelle_fonction))) 
            {
            return ['success' => false, 'message' => 'Desolé! Ce libelle de fonction existe déjà.'];
            }

            $passwrod = generetor(5);
            $code = self::$settingModel->generatorCode(TABLES::FONCTIONS, 'code_fonction');
            $token = generetor(random_int(50, 70));

            $data_fonction = [
                'libelle_fonction' => strtoupper($libelle_fonction),
                'description_fonction' => $description_fonction,
                'created_at_fonction' => date('Y-m-d :H:i:s'),
            ];

            if (!self::$settingModel->create(TABLES::FONCTIONS, $data_fonction))
            {
                return ['success' => false, 'message' => "Desolé! echec d'operation."];
            }

            return [
                'success' => true,
                'message' => 'Fonction enregistrée avec succès.',
            ];

    }




      /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * DEBUT SEXION SETTING TEMPLATES 
     * **********************************************************************
     * --------------------------------------------------------------------------
     */

  
    public static function fonctionAddModalService()
    {
        $output = "";
        $output .= '
            <form action="#" method="post" id="frmAddFonction">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <input type="hidden" value="btn_add_fonction" name="action">
                        <input type="hidden" value="' . csrfToken()::token() . '" name="csrf_token">
                        <label for="libelle_fonction" class="form-label">Libelle fonction <strong class="text-danger">*</strong></label>
                        <input type="text" class="form-control" id="libelle_fonction" name="libelle_fonction" required>
                    </div>
                    <div class="col-md-12">
                        <label for="description_fonction" class="form-label">Description <strong class="text-danger">*</strong></label>
                        <textarea rows="3" class="form-control" name="description_fonction" id="description_fonction"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12 modal_footer">
                        <button type="submit" class="btn btn-primary" id="btnSubmitFormFonction"><i class="fas fa-save"></i> &nbsp;  Enregistrer </button>
                        <button type="button" class="btn btn-light dismiss_modal">Close</button>

                    </div>
                </div>


            </form> ';
        return $output;
    }

    public static function fonctionDataService($fonctions)
    {

        $i = 0;
        $data = [];

        foreach ($fonctions as $fonction) {
            $i++;

            $etat = checkEtatData($fonction['statut_fonction']);

            $actions = '
            <button class="btn btn-light btn-link " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-h"></i>
            </button>
            <div class="dropdown-menu">

        <button class="dropdown-item " id="Modifier" onclick="modalUpdatedFonction(\'' . $fonction['code_fonction'] . '\')" 
            data-toggle="tooltip" title="" data-original-title="Modifier fonction">
        <i class="fa fa-edit text-icon-primary"></i> &nbsp; &nbsp; Modifier fonction </button>
        ';
        if ($fonction['statut_fonction'] == STATUT_ACTIF) {
            $actions .= '
        <button class="dropdown-item " id="" onclick="changeStatutFonction(\'' . $fonction['code_fonction'] . '\',\'' . STATUT_INACTIF . '\')" 
            data-toggle="tooltip" title="" data-original-title="Désactiver fonction ">
            <i class="fa fa-times text-icon-danger"></i> &nbsp; &nbsp; Désactiver fonction </button>
        ';
        } else {
            $actions .= '
        <button class="dropdown-item " id="" onclick="changeStatutFonction(\'' . $fonction['code_fonction'] . '\',\'' . STATUT_ACTIF . '\')" 
            data-toggle="tooltip" title="" data-original-title="Activer fonction ">
            <i class="fa fa-check text-icon-success"></i> &nbsp; &nbsp; Activer fonction </button>
        ';
        }
        $actions .= ' </div>
            ';

            $data[] = [
                $i,
                $etat,
                strtoupper($fonction['libelle_fonction']),
                textLimit($fonction['description_fonction']),
                date_formater($fonction['created_at_fonction']),
                $actions
            ];
        }

        return $data;
    }

}