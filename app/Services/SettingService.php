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

    public static function saveFonctionData(array $post)
    {
        extract($post);


        if (!empty(self::$settingModel->getFieldsForParams(TABLES::FONCTIONS, ['libelle_fonction' => $libelle_fonction, 'etablissement_code' => Auth::user('etablissement_code')]))) {
            return ['success' => false, 'message' => 'Desolé! Ce libelle de fonction existe déjà.'];
        }

        $code = self::$settingModel->generatorCode(TABLES::FONCTIONS, 'code_fonction');

        $data_fonction = [
            'libelle_fonction' => strtoupper($libelle_fonction),
            'description_fonction' => $description_fonction,
            'code_fonction' => $code,
            'statut_fonction' => STATUT_ACTIF,
            'etablissement_code' => Auth::user('etablissement_code'),
            'user_code' => Auth::user('id'),
            'created_at_fonction' => date('Y-m-d H:i:s'),
        ];

        if (!self::$settingModel->create(TABLES::FONCTIONS, $data_fonction)) {
            return ['success' => false, 'message' => "Desolé! echec d'operation."];
        }

        return [
            'success' => true,
            'message' => 'Fonction enregistrée avec succès.',
        ];
    }


    public static function updateFonctionData($post)
    {
        extract($post);


        $libelle = self::$settingModel->getFieldsForParams(TABLES::FONCTIONS, ['libelle_fonction' => $libelle_fonction, 'etablissement_code' => Auth::user('etablissement_code')]);
        if (!empty($libelle) && $libelle['code_fonction'] != $code_fonction) {
            return ['success' => false, 'message' => 'Desolé! Ce libellé de fonction existe déjà.'];
        }


        $data_fonction = [
            'libelle_fonction' => strtoupper($libelle_fonction),
            'description_fonction' => $description_fonction,
            'updated_at_fonction' => date('Y-m-d H:i:s'),
        ];

        if (!self::$settingModel->update(TABLES::FONCTIONS, 'code_fonction', $code_fonction, $data_fonction)) {
            return ['success' => false, 'message' => "Desolé! echec d'operation."];
        }


        return [
            'success' => true,
            'message' => 'Modification effectuée avec succès.',
        ];
    }

    public static function saveServiceData(array $post)
    {
        extract($post);


        if (!empty(self::$settingModel->getFieldsForParams(TABLES::SERVICES, ['libelle_service' => $libelle_service, 'etablissement_code' => Auth::user('etablissement_code')]))) {
            return ['success' => false, 'message' => 'Desolé! Ce libelle de service existe déjà.'];
        }

        $code = self::$settingModel->generatorCode(TABLES::SERVICES, 'code_service');

        $data_service = [
            'libelle_service' => strtoupper($libelle_service),
            'description_service' => $description_service,
            'code_service' => $code,
            'statut_service' => STATUT_ACTIF,
            'etablissement_code' => Auth::user('etablissement_code'),
            'user_code' => Auth::user('id'),
            'created_at_service' => date('Y-m-d H:i:s'),
        ];

        if (!self::$settingModel->create(TABLES::SERVICES, $data_service)) {
            return ['success' => false, 'message' => "Desolé! echec d'operation."];
        }

        return [
            'success' => true,
            'message' => 'Fonction enregistrée avec succès.',
        ];
    }


    public static function updateServiceData($post)
    {
        extract($post);


        $libelle = self::$settingModel->getFieldsForParams(TABLES::SERVICES, ['libelle_service' => $libelle_service, 'etablissement_code' => Auth::user('etablissement_code')]);
        if (!empty($libelle) && $libelle['code_service'] != $code_service) {
            return ['success' => false, 'message' => 'Desolé! Ce libellé de service existe déjà.'];
        }


        $data_service = [
            'libelle_service' => strtoupper($libelle_service),
            'description_service' => $description_service,
            'updated_at_service' => date('Y-m-d H:i:s'),
        ];

        if (!self::$settingModel->update(TABLES::SERVICES, 'code_service', $code_service, $data_service)) {
            return ['success' => false, 'message' => "Desolé! echec d'operation."];
        }


        return [
            'success' => true,
            'message' => 'Modification effectuée avec succès.',
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
                    <div class="col-md-12 mb-3">
                        <input type="hidden" value="btn_add_fonction" name="action">
                        <input type="hidden" value="' . csrfToken()::token() . '" name="csrf_token">
                        <label for="libelle_fonction" class="form-label">Libelle fonction <strong class="text-danger">*</strong></label>
                        <input type="text" class="form-control" id="libelle_fonction" name="libelle_fonction" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="description_fonction" class="form-label">Description </label>
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


    public static function fonctionUpdateModalService(array $fonction)
    {
        $output = "";
        $output .= '
            <form action="#" method="post" id="frmUpdateFonction">
                <div class="row mb-3">
                    <div class="col-md-12 mb-3">
                        <input type="hidden" value="btn_update_fonction" name="action">
                        <input type="hidden" value="' . $fonction['code_fonction'] . '" name="code_fonction">
                        <input type="hidden" value="' . csrfToken()::token() . '" name="csrf_token">
                        <label for="libelle_fonction" class="form-label">Libelle fonction <strong class="text-danger">*</strong></label>
                        <input type="text" class="form-control" id="libelle_fonction" name="libelle_fonction" value="' . $fonction['libelle_fonction'] . '" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="description_fonction" class="form-label">Description </label>
                        <textarea rows="3" class="form-control" name="description_fonction" id="description_fonction">' . $fonction['description_fonction'] . '</textarea>
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

    public static function serviceAddModalService()
    {
        $output = "";
        $output .= '
            <form action="#" method="post" id="frmAddService">
                <div class="row mb-3">
                    <div class="col-md-12 mb-3">
                        <input type="hidden" value="btn_add_service" name="action">
                        <input type="hidden" value="' . csrfToken()::token() . '" name="csrf_token">
                        <label for="libelle_service" class="form-label">Libelle service <strong class="text-danger">*</strong></label>
                        <input type="text" class="form-control" id="libelle_service" name="libelle_service" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="description_service" class="form-label">Description </label>
                        <textarea rows="3" class="form-control" name="description_service" id="description_service"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12 modal_footer">
                        <button type="submit" class="btn btn-primary" id="btnSubmitFormService"><i class="fas fa-save"></i> &nbsp;  Enregistrer </button>
                        <button type="button" class="btn btn-light dismiss_modal">Close</button>

                    </div>
                </div>


            </form> ';
        return $output;
    }


    public static function serviceUpdateModalService(array $service)
    {
        $output = "";
        $output .= '
            <form action="#" method="post" id="frmUpdateService">
                <div class="row mb-3">
                    <div class="col-md-12 mb-3">
                        <input type="hidden" value="btn_update_service" name="action">
                        <input type="hidden" value="' . $service['code_service'] . '" name="code_service">
                        <input type="hidden" value="' . csrfToken()::token() . '" name="csrf_token">
                        <label for="libelle_service" class="form-label">Libelle service <strong class="text-danger">*</strong></label>
                        <input type="text" class="form-control" id="libelle_service" name="libelle_service" value="' . $service['libelle_service'] . '" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="description_service" class="form-label">Description </label>
                        <textarea rows="3" class="form-control" name="description_service" id="description_service">' . $service['description_service'] . '</textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12 modal_footer">
                        <button type="submit" class="btn btn-primary" id="btnSubmitFormService"><i class="fas fa-save"></i> &nbsp;  Enregistrer </button>
                        <button type="button" class="btn btn-light dismiss_modal">Close</button>

                    </div>
                </div>


            </form> ';
        return $output;
    }

    public static function serviceDataService($services)
    {

        $i = 0;
        $data = [];

        foreach ($services as $service) {
            $i++;

            $etat = checkEtatData($service['statut_service']);

            $actions = '
            <button class="btn btn-light btn-link " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-h"></i>
            </button>
            <div class="dropdown-menu">

        <button class="dropdown-item " id="Modifier" onclick="modalUpdatedService(\'' . $service['code_service'] . '\')" 
            data-toggle="tooltip" title="" data-original-title="Modifier service">
        <i class="fa fa-edit text-icon-primary"></i> &nbsp; &nbsp; Modifier service </button>
        ';
            if ($service['statut_service'] == STATUT_ACTIF) {
                $actions .= '
        <button class="dropdown-item " id="" onclick="changeStatutService(\'' . $service['code_service'] . '\',\'' . STATUT_INACTIF . '\')" 
            data-toggle="tooltip" title="" data-original-title="Désactiver service ">
            <i class="fa fa-times text-icon-danger"></i> &nbsp; &nbsp; Désactiver service </button>
        ';
            } else {
                $actions .= '
        <button class="dropdown-item " id="" onclick="changeStatutService(\'' . $service['code_service'] . '\',\'' . STATUT_ACTIF . '\')" 
            data-toggle="tooltip" title="" data-original-title="Activer service ">
            <i class="fa fa-check text-icon-success"></i> &nbsp; &nbsp; Activer service </button>
        ';
            }
            $actions .= ' </div>
            ';

            $data[] = [
                $i,
                $etat,
                strtoupper($service['libelle_service']),
                textLimit($service['description_service']),
                date_formater($service['created_at_service']),
                $actions
            ];
        }

        return $data;
    }
}
