<?php

namespace App\Services;


class PersonneService
{

    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * DEBUT SEXION CLIENT 
     * **********************************************************************
     * --------------------------------------------------------------------------
     */

    public static function bClientAddModalService()
    {
        $output = "";
        $output .= '
             <form method="post" id="frmAddClientData">
                 <div class="row mb-3 px-3 ">
                     <input type="hidden" value="btn_add_client_data" name="action">
                     <input type="hidden" name="csrf_token" value="' . csrfToken()::token() . '"> 

                     <label for="nom_client" class="form-label">Nom & prénoms <strong
                             class="text-danger">*</strong></label>
                     <input type="text" class="form-control" id="nom_client" name="nom_client" required>
                 </div>

                 <div class="row mb-3 px-3">
                     <label for="telephone_client" class="form-label">Téléphone <strong
                             class="text-danger">*</strong></label>
                     <input type="text" class="form-control" id="telephone_client" name="telephone_client" required>
                 </div>

                 <div class="row mb-3 px-3">
                    
                         <label for="email_client" class="form-label">Email </label>
                         <input type="email" class="form-control" name="email_client" id="email_client">
                 </div>


                 <div class="row mb-3 px-3">
                     <label for="sexe" class="form-label">Civilé <strong class="text-danger">*</strong></label>
                     <select name="sexe" class="form-control" id="sexe" required>
                         <option value="">--- CHOISIR ---</option>
                         ';

        foreach (SEXEP as $sx) {
            $output .= '<option value="' . $sx . '">' . $sx . '</option>';
        }

        $output .= '
                     </select>

                 </div>
               
                 <div class="col-md-12">
                 <button type="submit" class="btn btn-primary modal_footer" id="btnAddClient"><i class="fa fa-save"></i> &nbsp;
                         Enregistrer le client</button>
                 </div>
                
             </form> ';

        return $output;
    }

    public static function bClientUpdateModalService($data)
    {
        $output = "";
        $output .= '
             <form method="post" id="frmUpdateClientData">
                 <div class="row mb-3 px-3 ">
                 <input type="hidden" name="csrf_token" value="' . csrfToken()::token() . '"> 

                     <input type="hidden" value="btn_modifier_client_data" name="action">
                     <input type="hidden" value="' . $data['code_client'] . '" name="code_client">

                     <label for="nom_client" class="form-label">Nom & prénoms <strong
                             class="text-danger">*</strong></label>
                     <input type="text" class="form-control" id="nom_client" name="nom_client" value="' . $data['nom_client'] . '" required>
                 </div>

                 <div class="row mb-3 px-3">
                     <label for="telephone_client" class="form-label">Téléphone <strong
                             class="text-danger">*</strong></label>
                     <input type="text" class="form-control" id="telephone_client" name="telephone_client" value="' . $data['telephone_client'] . '" required>
                 </div>

                 <div class="row mb-3 px-3">
                    
                         <label for="email_client" class="form-label">Email </label>
                         <input type="email" class="form-control" name="email_client" id="email_client" value="' . $data['email_client'] . '">
                 </div>
                    <div class="row mb-3 px-3">
                        <label for="sexe" class="form-label">Civilé <strong class="text-danger">*</strong></label>
                        <select name="sexe" class="form-control" id="sexe" required>
                            <option value="">--- CHOISIR ---</option>
                            ';

        foreach (SEXEP as $sx) {
            $output .= '<option value="' . $sx . '" ' . selected($data['sexe_client'], $sx) . '>' . $sx . '</option>';
        }

        $output .= '
                     </select>

                 </div>
               
                 <div class="col-md-12">
                 <button type="submit" class="btn btn-primary modal_footer" id="btnUpdateClient"><i class="fa fa-edit"></i> &nbsp;
                         Modifier le client</button>
                 </div>
                
             </form> ';

        return $output;
    }

    public static function clientDataService($clients)
    {
        $data = [];

        $i = 0;
        foreach ($clients as $client) :
            $i++;
            $data[] = [
                $i,
                $client['nom_client'],
                $client['telephone_client'],
                $client['sexe_client'],
                date_formater($client['client_created_at']),
                '
                <div class="table_button">
                 <button type="button" data-client="' . $client["code_client"] . '" class="btn btn-primary btn-sm mr-2 frmModifierClientData" > <i class="fa fa-edit"></i> &nbsp; Modifier </button>
                <a class="btn btn-info btn-sm mr-2" href=" ' . url('profile-client', ['code' => $client['code_client']]) . ' "> <i
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
     * * FIN SEXION CLIENT
     * ****************************************************************
     * --------------------------------------------------------------------------
     */


    /**
     * ------------------------------------------------------------------------
     * **********************************************************************
     * * DEBUT SEXION FOURNISSEUR 
     * **********************************************************************
     * --------------------------------------------------------------------------
     */

    public static function bFournisseurAddModalService()
    {
        $output = "";
        $output .= '
             <form method="post" id="frmAddFournisseurData">
                 <div class="row mb-3 px-3 ">
                     <input type="hidden" value="btn_add_fournisseur_data" name="action">
                        <input type="hidden" name="csrf_token" value="' . csrfToken()::token() . '">

                     <label for="nom_fournisseur" class="form-label">Nom & prénoms <strong
                             class="text-danger">*</strong></label>
                     <input type="text" class="form-control" id="nom_fournisseur" name="nom_fournisseur" required>
                 </div>

                 <div class="row mb-3 px-3">
                     <label for="telephone_fournisseur" class="form-label">Téléphone <strong
                             class="text-danger">*</strong></label>
                     <input type="text" class="form-control" id="telephone_fournisseur" name="telephone_fournisseur" required>
                 </div>

                 <div class="row mb-3 px-3">
                    
                         <label for="email_fournisseur" class="form-label">Email </label>
                         <input type="email" class="form-control" name="email_fournisseur" id="email_fournisseur">
                 </div>


                 <div class="row mb-3 px-3">
                     <label for="sexe" class="form-label">Civilé <strong class="text-danger">*</strong></label>
                     <select name="sexe" class="form-control" id="sexe" required>
                         <option value="">--- CHOISIR ---</option>
                         ';

        foreach (SEXEP as $sx) {
            $output .= '<option value="' . $sx . '">' . $sx . '</option>';
        }

        $output .= '
                     </select>

                 </div>
               
                 <div class="col-md-12">
                 <button type="submit" class="btn btn-primary modal_footer" id="btnAddFournisseur"><i class="fa fa-save"></i> &nbsp;
                         Enregistrer le fournisseur</button>
                 </div>
                
             </form> ';

        return $output;
    }

    public static function bFournisseurUpdateModalService($data)
    {
        $output = "";
        $output .= '
             <form method="post" id="frmUpdateFournisseurData">
                 <div class="row mb-3 px-3 ">
                 <input type="hidden" name="csrf_token" value="' . csrfToken()::token() . '"> 

                     <input type="hidden" value="btn_modifier_fournisseur_data" name="action">
                     <input type="hidden" value="' . $data['code_fournisseur'] . '" name="code_fournisseur">

                     <label for="nom_fournisseur" class="form-label">Nom & prénoms <strong
                             class="text-danger">*</strong></label>
                     <input type="text" class="form-control" id="nom_fournisseur" name="nom_fournisseur" value="' . $data['nom_fournisseur'] . '" required>
                 </div>

                 <div class="row mb-3 px-3">
                     <label for="telephone_fournisseur" class="form-label">Téléphone <strong
                             class="text-danger">*</strong></label>
                     <input type="text" class="form-control" id="telephone_fournisseur" name="telephone_fournisseur" value="' . $data['telephone_fournisseur'] . '" required>
                 </div>

                 <div class="row mb-3 px-3">
                    
                         <label for="email_fournisseur" class="form-label">Email </label>
                         <input type="email" class="form-control" name="email_fournisseur" id="email_fournisseur" value="' . $data['email_fournisseur'] . '">
                 </div>
                    <div class="row mb-3 px-3">
                        <label for="sexe" class="form-label">Civilé <strong class="text-danger">*</strong></label>
                        <select name="sexe" class="form-control" id="sexe" required>
                            <option value="">--- CHOISIR ---</option>
                            ';

        foreach (SEXEP as $sx) {
            $output .= '<option value="' . $sx . '" ' . selected($data['sexe_fournisseur'], $sx) . '>' . $sx . '</option>';
        }

        $output .= '
                     </select>

                 </div>
               
                 <div class="col-md-12">
                 <button type="submit" class="btn btn-primary modal_footer" id="btnUpdateFournisseur"><i class="fa fa-edit"></i> &nbsp;
                         Modifier le fournisseur</button>
                 </div>
                
             </form> ';

        return $output;
    }

    public static function fournisseurDataService($fournisseurs)
    {
        $data = [];

        $i = 0;
        foreach ($fournisseurs as $fournisseur) :
            $i++;
            $data[] = [
                $i,
                $fournisseur['nom_fournisseur'],
                $fournisseur['telephone_fournisseur'],
                $fournisseur['sexe_fournisseur'],
                date_formater($fournisseur['fournisseur_created_at']),
                '
                <div class="table_button">
                 <button type="button" data-fournisseur="' . $fournisseur["code_fournisseur"] . '" class="btn btn-primary btn-sm mr-2 frmModifierFournisseurData" > <i class="fa fa-edit"></i> &nbsp; Modifier </button>
                <a class="btn btn-info btn-sm mr-2" href=" ' . url('profile-fournisseur', ['code' => $fournisseur['code_fournisseur']]) . ' "> <i
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
     * * FIN SEXION FOURNISSEUR
     * ****************************************************************
     * --------------------------------------------------------------------------
     */
}
