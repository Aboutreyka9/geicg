<?php

namespace App\Services;


class BoutiqueService
{

    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * DEBUT SEXION BOUTIQUE 
     * **********************************************************************
     * --------------------------------------------------------------------------
     */

    public static function bBoutiqueAddModalService()
    {
        $output = "";
        $output .= '
             <form method="post" id="frmAddBoutiqueData">
                 <div class="row mb-3 px-3 ">
                     <input type="hidden" value="btn_add_boutique_data" name="action">
                     <input type="hidden" name="csrf_token" value="' . csrfToken()::token() . '"> 

                     <label for="libelle_boutique" class="form-label">Libelle boutique <strong
                             class="text-danger">*</strong></label>
                     <input type="text" class="form-control" id="libelle_boutique" name="libelle_boutique" required>
                 </div>

                 <div class="row mb-3 px-3">
                     <label for="telephone_boutique" class="form-label">Téléphone <strong
                             class="text-danger">*</strong></label>
                     <input type="text" class="form-control" id="telephone_boutique" name="telephone_boutique" required>
                 </div>

                 <div class="row mb-3 px-3">
                     <label for="telephone2_boutique" class="form-label">Téléphone <strong
                             class="text-danger">*</strong></label>
                     <input type="text" class="form-control" id="telephone2_boutique" name="telephone2_boutique">
                 </div>

                 <div class="row mb-3 px-3">
                    
                         <label for="email_boutique" class="form-label">Email </label>
                         <input type="email" class="form-control" name="email_boutique" id="email_boutique">
                 </div>
                  <div class="row mb-3 px-3">
                    
                         <label for="adresse_boutique" class="form-label">Adresse </label>
                         <textarea rows="4" class="form-control" name="adresse_boutique" id="adresse_boutique"></textarea>
                 </div>
               
                 <div class="col-md-12">
                 <button type="submit" class="btn btn-primary modal_footer" id="btnAddBoutique"><i class="fa fa-save"></i> &nbsp;
                         Enregistrer la boutique</button>
                 </div>
                
             </form> ';

        return $output;
    }

    public static function bBoutiqueUpdateModalService($data)
    {
        $output = "";
        $output .= '
             <form method="post" id="frmUpdateBoutiqueData">
                 <div class="row mb-3 px-3 ">
                 <input type="hidden" name="csrf_token" value="' . csrfToken()::token() . '"> 

                     <input type="hidden" value="btn_modifier_boutique_data" name="action">
                     <input type="hidden" value="' . $data['code_boutique'] . '" name="code_boutique">

                        <label for="libelle_boutique" class="form-label">Libelle boutique <strong
                                class="text-danger">*</strong></label>
                        <input type="text" class="form-control" id="libelle_boutique" name="libelle_boutique" value="' . $data['libelle_boutique'] . '" required>
                    </div>

                    <div class="row mb-3 px-3">
                        <label for="telephone_boutique" class="form-label">Téléphone <strong
                                class="text-danger">*</strong></label>
                        <input type="text" class="form-control" id="telephone_boutique" name="telephone_boutique" value="' . $data['telephone_boutique'] . '" required>
                    </div>

                    <div class="row mb-3 px-3">
                        <label for="telephone2_boutique" class="form-label">Téléphone 2 </label>
                        <input type="text" class="form-control" id="telephone2_boutique" name="telephone2_boutique" value="' . $data['telephone2_boutique'] . '">
                    </div>

                    <div class="row mb-3 px-3">
                    
                         <label for="email_boutique" class="form-label">Email </label>
                         <input type="email" class="form-control" name="email_boutique" id="email_boutique" value="' . $data['email_boutique'] . '">
                    </div>
                     <div class="row mb-3 px-3">
                    
                         <label for="adresse_boutique" class="form-label">Adresse </label>
                         <textarea rows="4" class="form-control" name="adresse_boutique" id="adresse_boutique">' . $data['adresse_boutique'] . '</textarea>
                    </div>

                 <div class="col-md-12">
                 <button type="submit" class="btn btn-primary modal_footer" id="btnUpdateBoutique"><i class="fa fa-edit"></i> &nbsp;
                         Modifier la boutique</button>
                 </div>
                
             </form> ';

        return $output;
    }

    public static function boutiqueDataService($boutiques)
    {
        $data = [];

        $i = 0;
        foreach ($boutiques as $boutique) :
            $i++;
            $data[] = [
                $i,
                $boutique['libelle_boutique'],
                $boutique['telephone_boutique'],
                $boutique['telephone2_boutique'],
                $boutique['email_boutique'],
                $boutique['adresse_boutique'],
                date_formater($boutique['boutique_created_at']),
                '
                <div class="table_button">
                 <button type="button" data-boutique="' . $boutique["code_boutique"] . '" class="btn btn-primary btn-sm mr-2 frmModifierBoutiqueData" > <i class="fa fa-edit"></i> &nbsp; Modifier </button>
                <a class="btn btn-info btn-sm mr-2" href=" ' . url('profile-boutique', ['code' => $boutique['code_boutique']]) . ' "> <i
                        class="fa fa-eye"></i> &nbsp; Info </a> 
                </div>
               '
            ];

        endforeach;

        return $data;
    }

    /**
     * ------------------------------------------------------------------------
     * ****************************************************************
     * 
     * * FIN SEXION BOUTIQUE
     * ****************************************************************
     * --------------------------------------------------------------------------
     */
}
