<?php

namespace App\Services;

use App\Core\Auth;
use DateTime;
use IntlDateFormatter;
use Roles;

class Service
{



    public static function dataSearchReservation($data, $nberDay)
    {
        $output = "";
        $i = 0;
        foreach ($data as $chambre) {
            $i++;
            $montant = $chambre['prix_chambre'] * $nberDay;

            $output .= '
                 <tr>
                   <th scope="row">' . $i . '</th>
                   <td>' . $chambre['categorie'] . '</td>
                   <td>' . $chambre["libelle_chambre"] . '</td>
                   <td>' . checkState($chambre["statut_reservation"]) . $chambre["statut_reservation"] . '</td>
                   <td>' . money($chambre['prix_chambre']) . '</td>
                   <td class="bg-dark text-white">' . money($montant) . '</td>
                   <td class="table_button">
         
                   <button type="button" class="btn btn-primary mr-2 reservationUpdateModal" data-chambre="=' . crypter($chambre['code_chambre']) . '" data-montant="' . $chambre['prix_chambre'] . '" ><i class="fa fa-key"></i>  &nbsp; Reservation </button>
                     
                   </td>
                 </tr>';
        }
        return $output;
    }

    public static function lookForClientExist($client)
    {
        $output = "";
        $name = $client['nom_client'] . ' ' . $client['prenom_client'];
        $output .= '
            <div class="sexion_resultat">
                <input type="hidden"  name="client" value="' . $client['code_client'] . '">
                <input type="hidden"  name="action" value="btn_ajouter_reservation">

                <label class="container_label"> <span>' . $client['genre_client'] . '</span> - <span>' . $name . '</span>
                <input type="checkbox" checked  name="radio">
                <span class="checkmark"></span>
                </label>
            </div>
        ';
        return $output;
    }

    public static function chargerClienForReservation()
    {
        $output = "";
        $output .= '
        <form action="" id="frm_ajouter_reservation" method="POST">
            <div style="position: relative;" class="form-group">
                <label for="telephone">Numéro de Telephne <span class="text-danger">*</span> </label>
                <input name="telephone_client" type="text" class="form-control telephone" id="telephone" >
                <button title="Rechercher..." class="btn btn-primary search_number"> <i class="fa fa-search"></i> &nbsp; Recherche</button>
                
            </div>

              <div class="form-group">
                <label for="nom_client">Nom & Prénoms <span class="text-danger">*</span> </label>
                <input name="nom_client" type="text" class="form-control" id="nom_client">
            </div>

            <div class="form-group row">
            <div class="col-md-5">
                <label for="type_piece">Type pièce</label>
                <select id="type_piece" name="type_piece" class="form-control">
                <option value="">--CHOISIR--</option>';


        // $chambre['categorie'] == $categorie['id_categorie']  ? "selected" : "";

        foreach (PIECES_DATA as $tp) {
            // $select = ($chambre['categorie'] == $categorie['id_categorie'])  ? 'selected' : '';
            $output .= '<option value="' . $tp . '">' . $tp . '</option>';
        }

        $output .= '</select>
            </div> 

             <div class="col-md-7">

                <label for="piece_client">Pièce</label>
                <input name="piece_client" type="text" class="form-control" id="piece_client">
            </div>
            </div>

            <div class="form-group">
            <label for="genre_client">Sexe <span class="text-danger">*</span> </label>
            <select name="genre_client" class="form-control">
            <option value="">--CHOISIR--</option>
            ';

        // $chambre['categorie'] == $categorie['id_categorie']  ? "selected" : "";

        foreach (SEXEP as $genre) {
            // $select = ($chambre['categorie'] == $categorie['id_categorie'])  ? 'selected' : '';
            $output .= '<option value="' . $genre . '">' . $genre . '</option>';
        }

        $output .= '</select>
              </div> 

              <div class="show_resultat"></div>
              
              <input name="action" value="btn_ajouter_reservation" type="hidden">
              <input name="id_chambre" type="hidden">
             
            </form>


        ';
        return $output;
    }

    public static function chargerAddReservation($code, $montant)
    {
        $output = "";
        $output .= '
        <form action="" id="frm_ajouter_reservation" method="POST">

             <div class="form-group">
                <label for="type_piece">Type paiement <span class="text-danger">*</span></label>
                <select id="type_paiement" name="type_paiement" class="form-control">';

        foreach (PAIEMENT as $tp) {
            $output .= '<option value="' . $tp . '">' . strtoupper($tp) . '</option>';
        }

        $output .= '</select>
            </div> 
            <div class="form-group">
                <label>Montant total </label>
                <input readonly type="text" class="form-control"  value="' . money($montant) . '" >
                <input  type="hidden" value="' . $montant . '" id="montant_total">
                <input name="code" type="hidden" value="' . crypter($code) . '" >
            </div>

             <div class="form-group">
                <label for="montant_payer"> <span class="text-danger">*</span> Montant Payer</label>
                <input name="montant_payer" type="number" class="form-control" id="montant_payer">
            </div>

              <div class="form-group">
                <label for="montant_rendu"> Montant Rendu </label>
                <input readonly name="montant_rendu" type="text" class="form-control" id="montant_rendu">
            </div>
                <input name="action" value="btn_add_facture" type="hidden">
            
            </form>


        ';
        return $output;
    }
    public static function chargerFactureForReservation($code, $montant)
    {
        $output = "";
        $output .= '
        <form action="" id="frm_ajouter_reservation" method="POST">

             <div class="form-group">
                <label for="type_piece">Type paiement <span class="text-danger">*</span></label>
                <select id="type_paiement" name="type_paiement" class="form-control">';

        foreach (PAIEMENT as $tp) {
            $output .= '<option value="' . $tp . '">' . strtoupper($tp) . '</option>';
        }

        $output .= '</select>
            </div> 
            <div class="form-group">
                <label>Montant total </label>
                <input readonly type="text" class="form-control"  value="' . money($montant) . '" >
                <input  type="hidden" value="' . $montant . '" id="montant_total">
                <input name="code" type="hidden" value="' . crypter($code) . '" >
            </div>

             <div class="form-group">
                <label for="montant_payer"> <span class="text-danger">*</span> Montant Payer</label>
                <input name="montant_payer" type="number" class="form-control" id="montant_payer">
            </div>

              <div class="form-group">
                <label for="montant_rendu"> Montant Rendu </label>
                <input readonly name="montant_rendu" type="text" class="form-control" id="montant_rendu">
            </div>
                <input name="action" value="btn_add_facture" type="hidden">
            
            </form>


        ';
        return $output;
    }

    public static function chargerFactureForService($code, $montant)
    {
        $output = "";
        $output .= '
        <form action="" id="frm_facture_service_reservation" method="POST">

             <div class="form-group">
                <label for="type_piece">Type paiement <span class="text-danger">*</span></label>
                <select id="type_paiement" name="type_paiement" class="form-control">';

        foreach (PAIEMENT as $tp) {
            $output .= '<option value="' . $tp . '">' . strtoupper($tp) . '</option>';
        }

        $output .= '</select>
            </div> 
            <div class="form-group">
                <label>Montant total </label>
                <input readonly type="text" class="form-control"  value="' . money($montant) . '" >
                <input  type="hidden" value="' . $montant . '" id="montant_total">
                <input name="code" type="hidden" value="' . crypter($code) . '" >
            </div>

             <div class="form-group">
                <label for="montant_payer"> <span class="text-danger">*</span> Montant Payer</label>
                <input name="montant_payer" type="number" class="form-control" id="montant_payer">
            </div>

              <div class="form-group">
                <label for="montant_rendu"> Montant Rendu </label>
                <input readonly name="montant_rendu" type="text" class="form-control" id="montant_rendu">
            </div>
                <input name="action" value="btn_facture_service_client" type="hidden">
            
            </form>


        ';
        return $output;
    }

    public static function chargerFrmModifierReservation($data)
    {
        $output = "";
        $output .= '
        <form action="" id="frm_modfier_reservation" method="POST">

             <div class="form-group">
                <label for="type_paiement">Type paiement <span class="text-danger">*</span></label>
                <select id="type_paiement" name="type_paiement" class="form-control">';

        foreach (PAIEMENT as $tp) {
            $output .= '<option value="' . $tp . '">' . strtoupper($tp) . '</option>';
        }

        $output .= '</select>
            </div> 
            <div class="form-group">
                <label>Montant total </label>
                <input name="code" type="hidden" value="" >
            </div>

             <div class="form-group">
                <label for="montant_payer"> <span class="text-danger">*</span> </label>
                <input name="montant_payer" type="number" class="form-control" id="montant_payer">
            </div>

              <div class="form-group">
                <label for="montant_rendu"> Montant Rendu </label>
                <input readonly name="montant_rendu" type="text" class="form-control" id="montant_rendu">
            </div>
                <input name="action" value="btn_add_facture" type="hidden">
            
            </form>


        ';
        return $output;
    }


    public static function reservationDataForSearching($reservation)
    {
        $output = "";

        $i = 0;
        foreach ($reservation as $data) :
            $state = $data['statut_reservation'];
            $i++;
            $nbjr = daysBetweenDates(
                $data['date_entree'],
                $data['date_sortie']
            );
            $montantchambre = $data['prix_reservation'] * $nbjr;

            $montantTotal = $montantchambre + $data['montant_services'];

            $output .= '

    <tr>
      <th scope="row">  ' . $i . '</th>
      <td>' . date_formater($data['created_reservation']) . '</td>
      <td
        data-titles="Sejour de ' . $nbjr . ' jour(s), du ' . date_formater($data['date_entree']) . ' au ' . date_formater($data['date_sortie']) . '">
        ' . checkState($state) . '</td>
      <td>
        <a title="Voir Profile client" href="' . url("profile-client", ['code' => $data['code_client']]) . '">
          ' . $data['nom_client'] . '</a>
      </td>

      <td>' . money($montantchambre) . '</td>
      <td>' . money($data['montant_services']) . '</td>
      <td class="bg-dark text-white">' . money($montantTotal) . '</td>
      <td class="table_button">
      <span hidden >' . date_formater($data['date_entree']) . ' ' . date_formater($data['date_sortie']) . ' </span>
      <span hidden >' . $data['code_client'] . ' </span>
      <span hidden > ' . $data['code_reservation'] . ' </span>
        <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            Action
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="' . url('reservation/details', ['code' => $data['code_reservation']]) . '"> <i
                class="fa fa-eye text-dark"> </i> &nbsp; Detail</a>';

            if ($data['date_entree'] >= date('Y-m-d') && $data['etat_reservation'] == 0 && $state != STATUT_RESERVATION[2]) :

                $output .= ' <button class="dropdown-item btn_modal_modifier" data-code="' . $data['code_reservation'] . '"> <i
                class="fa fa-edit text-primary"> </i> &nbsp; Modifier</button>';
                if ($data['montant_services'] <= 0) :

                    $output .= '
            <button class="dropdown-item btn_annuler_reservation" data-reservation="' . crypter($data['code_reservation']) . '"> <i class="fa fa-times text-danger"> </i> &nbsp; Ennuler</button>';
                endif;
            endif;

            if ($state == STATUT_RESERVATION[0]) :

                $output .= '
            <button class="dropdown-item btn_modal_confirmement" data-reservation="' . crypter($data['code_reservation']) . '">
              <i class="fa fa-check text-success"> </i> &nbsp; Confirmer</button>';
            endif;

            if ($data['date_sortie'] >= date('Y-m-d') && $state != STATUT_RESERVATION[2]) :

                $output .= '
            <button class="dropdown-item btn_modal_service_reservation"
              data-reservation="' . crypter($data['code_reservation']) . '"> <i class="fa fa-check text-success"> </i> &nbsp;
              Operation</button>';
            endif;
            if ($state != STATUT_RESERVATION[2]) :


                $output .= '                   
             <button class="dropdown-item btn_modal_confirme" data-reservation="' . crypter($data['code_reservation']) . '">
                <i class="fa fa-check text-success"> </i> &nbsp; Regler facture</button>
                <a class="dropdown-item" target="_blank" href="' . url('print/facture', ['code' => $data['code_reservation']]) . '">
                  <i class="fa fa-print text-dark"> </i> &nbsp; IMPRIMER</a>';
            endif;

            $output .= '
          </div>
        </div>
      </td>
    </tr>';
        endforeach;

        return $output;
    }

    public static function reservationsActive($reservation)
    {
        $output = "";

        $i = 0;
        foreach ($reservation as $data) :
            $state = $data['etat_reservation'];
            $i++;
            $nbjr = daysBetweenDates(
                $data['date_entree'],
                $data['date_sortie']
            );
            $montantchambre = $data['prix_reservation'] * $nbjr;
            $lookFor = $i == 2 ? '<div style="height: 100%; width: 100%;" class="bg-danger">' . $i . '</div>' : $i;



            $output .= '

    <tr>
      <th scope="row">   ' . $lookFor . '</th>
      <td>' . date_formater($data['created_reservation']) . '</td>
      <td>' . checkEtatCh($state) . '</td>
      <td>
        <a title="Voir Profile client" href="' . url("profile-client", ['code' => $data['code_client']]) . '">
          ' . $data['nom_client'] . '</a>
      </td>

      <td>' . $data['telephone_client'] . '</td>
      <td>' . $data['chambre'] . '</td>
      <td data-titles="' . date_formater($data['date_entree']) . ' AU ' . date_formater($data['date_sortie']) . '">' . $nbjr . '</td>
      <td>' . money($montantchambre) . '</td>
      <td class="table_button">
      <span hidden >' . $data['code_client'] . ' </span>
      <span hidden > ' . $data['code_reservation'] . ' </span>
        <div class="dropdown">
          <button class="btn btn-dark dropdown-toggle" data-toggle="dropdown">
            
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="' . url('reservation/details', ['code' => $data['code_reservation']]) . '"> <i
                class="fa fa-eye text-dark"> </i> &nbsp; Detail</a>';

            if ($data['date_sortie'] >= date('Y-m-d') && $state != STATUT_RESERVATION[2]) :

                $output .= '
            <button class="dropdown-item btn_modal_service_reservation"
              data-reservation="' . crypter($data['code_reservation']) . '"> <i class="fa fa-check text-success"> </i> &nbsp;
              Operation</button>';
            endif;
            if ($state != STATUT_RESERVATION[2]) :


                $output .= '                   
             <button class="dropdown-item btn_modal_confirme" data-reservation="' . crypter($data['code_reservation']) . '">
                <i class="fa fa-check text-success"> </i> &nbsp; Regler facture</button>
                <a class="dropdown-item" target="_blank" href="' . url('print/facture', ['code' => $data['code_reservation']]) . '">
                  <i class="fa fa-print text-dark"> </i> &nbsp; IMPRIMER</a>';
            endif;

            $output .= '
          </div>
        </div>
      </td>
    </tr>';
        endforeach;

        return $output;
    }

    public static function reservationsArrive($reservation)
    {
        $output = "";

        $i = 0;
        foreach ($reservation as $data) :
            $state = $data['etat_reservation'];
            $i++;
            $nbjr = daysBetweenDates(
                $data['date_entree'],
                $data['date_sortie']
            );
            $montantchambre = $data['prix_reservation'] * $nbjr;
            $lookFor = $i == 2 ? '<div style="height: 100%; width: 100%;" class="bg-danger">' . $i . '</div>' : $i;



            $output .= '

    <tr>
      <th scope="row">   ' . $lookFor . '</th>
      <td>' . date_formater($data['created_reservation']) . '</td>
      <td>' . checkEtatCh($state) . '</td>
      <td>
        <a title="Voir Profile client" href="' . url("profile-client", ['code' => $data['code_client']]) . '">
          ' . $data['nom_client'] . '</a>
      </td>

      <td>' . $data['telephone_client'] . '</td>
      <td>' . $data['chambre'] . '</td>
      <td data-titles="' . date_formater($data['date_entree']) . ' AU ' . date_formater($data['date_sortie']) . '">' . $nbjr . '</td>
      <td>' . money($montantchambre) . '</td>
      <td class="table_button">
      <span hidden >' . $data['code_client'] . ' </span>
      <span hidden > ' . $data['code_reservation'] . ' </span>
        <div class="dropdown">
          <button class="btn btn-dark dropdown-toggle" data-toggle="dropdown">
            
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="' . url('reservation/details', ['code' => $data['code_reservation']]) . '"> <i
                class="fa fa-eye text-dark"> </i> &nbsp; Detail</a>';

            if ($data['date_sortie'] >= date('Y-m-d') && $state != STATUT_RESERVATION[2]) :

                $output .= '
            <button class="dropdown-item btn_modal_service_reservation"
              data-reservation="' . crypter($data['code_reservation']) . '"> <i class="fa fa-check text-success"> </i> &nbsp;
              Operation</button>';
            endif;
            if ($state != STATUT_RESERVATION[2]) :


                $output .= '                   
             <button class="dropdown-item btn_modal_confirme" data-reservation="' . crypter($data['code_reservation']) . '">
                <i class="fa fa-check text-success"> </i> &nbsp; Regler facture</button>
                <a class="dropdown-item" target="_blank" href="' . url('print/facture', ['code' => $data['code_reservation']]) . '">
                  <i class="fa fa-print text-dark"> </i> &nbsp; IMPRIMER</a>';
            endif;

            $output .= '
          </div>
        </div>
      </td>
    </tr>';
        endforeach;

        return $output;
    }

    public static function checkForReservationIn($reservation)
    {
        $output = "";

        $i = 0;
        foreach ($reservation as $data) :
            $state = $data['statut_reservation'];
            $i++;
            $nbjr = daysBetweenDates(
                $data['date_entree'],
                $data['date_sortie']
            );
            $montantchambre = $data['prix_reservation'] * $nbjr;


            $output .= '

    <tr>
      <th scope="row">  ' . $i . '</th>
      <td>' . date_formater($data['created_reservation']) . '</td>
      <td>
        <a title="Voir Profile client" href="' . url("profile-client", ['code' => $data['code_client']]) . '">
          ' . $data['nom_client'] . '</a>
      </td>

      <td>' . $data['libelle_typechambre'] . ' / ' . $data['libelle_chambre'] . '</td>
      <td>' . date_formater($data['date_entree']) . ' AU ' . date_formater($data['date_sortie']) . '</td>
      <td class="bg-dark text-white">' . money($montantchambre) . '</td>
      <td class="table_button">
      <span hidden >' . date_formater($data['date_entree']) . ' ' . date_formater($data['date_sortie']) . ' </span>
      <span hidden >' . $data['code_client'] . ' </span>
      <span hidden > ' . $data['code_reservation'] . ' </span>
        <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            Action
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="' . url('reservation/details', ['code' => $data['code_reservation']]) . '"> <i
                class="fa fa-eye text-dark"> </i> &nbsp; Detail</a>';



            $output .= ' <button class="dropdown-item btn_modal_modifier" data-code="' . $data['code_reservation'] . '"> <i
                class="fa fa-edit text-primary"> </i> &nbsp; Modifier</button>
                <button class="dropdown-item btn_annuler_reservation" data-reservation="' . crypter($data['code_reservation']) . '"> <i class="fa fa-times text-danger"> </i> &nbsp; Ennuler</button>';


            $output .= '                   
             <button class="dropdown-item btn_modal_confirme" data-reservation="' . crypter($data['code_reservation']) . '">
                <i class="fa fa-check text-success"> </i> &nbsp; Regler facture</button>
                <a class="dropdown-item" target="_blank" href="' . url('print/facture', ['code' => $data['code_reservation']]) . '">
                  <i class="fa fa-print text-dark"> </i> &nbsp; IMPRIMER</a>';


            $output .= '
          </div>
        </div>
      </td>
    </tr>';
        endforeach;

        return $output;
    }

    public static function checkForReservationOut($reservation)
    {
        $output = "";

        $i = 0;
        foreach ($reservation as $data) :
            $state = $data['statut_reservation'];
            $i++;
            $nbjr = daysBetweenDates(
                $data['date_entree'],
                $data['date_sortie']
            );
            $montantchambre = $data['prix_reservation'] * $nbjr;


            $output .= '

    <tr>
      <th scope="row">  ' . $i . '</th>
      <td>' . date_formater($data['created_reservation']) . '</td>
      <td>
        <a title="Voir Profile client" href="' . url("profile-client", ['code' => $data['code_client']]) . '">
          ' . $data['nom_client'] . '</a>
      </td>

      <td>' . $data['libelle_typechambre'] . ' / ' . $data['libelle_chambre'] . '</td>
      <td>' . date_formater($data['date_entree']) . ' AU ' . date_formater($data['date_sortie']) . '</td>
      <td class="bg-dark text-white">' . money($montantchambre) . '</td>
      <td class="table_button">
      <span hidden >' . date_formater($data['date_entree']) . ' ' . date_formater($data['date_sortie']) . ' </span>
      <span hidden >' . $data['code_client'] . ' </span>
      <span hidden > ' . $data['code_reservation'] . ' </span>
        <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            Action
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="' . url('reservation/details', ['code' => $data['code_reservation']]) . '"> <i
                class="fa fa-eye text-dark"> </i> &nbsp; Detail</a>';

            if ($data['date_entree'] >= date('Y-m-d') && $data['etat_reservation'] == 0 && $state != STATUT_RESERVATION[2]) :

                $output .= ' <button class="dropdown-item btn_modal_modifier" data-code="' . $data['code_reservation'] . '"> <i
                class="fa fa-edit text-primary"> </i> &nbsp; Modifier</button>
                <button class="dropdown-item btn_annuler_reservation" data-reservation="' . crypter($data['code_reservation']) . '"> <i class="fa fa-times text-danger"> </i> &nbsp; Ennuler</button>';

            endif;

            if ($state == STATUT_RESERVATION[0]) :

                $output .= '
            <button class="dropdown-item btn_modal_confirmement" data-reservation="' . crypter($data['code_reservation']) . '">
              <i class="fa fa-check text-success"> </i> &nbsp; Confirmer</button>';
            endif;


            if ($state != STATUT_RESERVATION[2]) :


                $output .= '                   
             <button class="dropdown-item btn_modal_confirme" data-reservation="' . crypter($data['code_reservation']) . '">
                <i class="fa fa-check text-success"> </i> &nbsp; Regler facture</button>
                <a class="dropdown-item" target="_blank" href="' . url('print/facture', ['code' => $data['code_reservation']]) . '">
                  <i class="fa fa-print text-dark"> </i> &nbsp; IMPRIMER</a>';
            endif;

            $output .= '
          </div>
        </div>
      </td>
    </tr>';
        endforeach;

        return $output;
    }
    public static function reservationRecaptData($reservation)
    {
        $output = "";

        $i = 0;
        foreach ($reservation as $data) :
            $state = $data['statut_reservation'];
            $i++;
            $nbjr = daysBetweenDates(
                $data['date_entree'],
                $data['date_sortie']
            );
            $montantchambre = $data['prix_reservation'] * $nbjr;

            $montantTotal = $montantchambre + $data['montant_services'];

            $output .= '

    <tr>
      <th scope="row">  ' . $i . '</th>
      <td>' . date_formater($data['created_reservation']) . '</td>
      <td
        data-titles="Sejour de ' . $nbjr . ' jour(s), du ' . date_formater($data['date_entree']) . ' au ' . date_formater($data['date_sortie']) . '">
        ' . recaptCheckState($state) . '</td>
      <td>
      ' . $data['nom_client'] . '
      </td>

      <td>' . money($montantchambre) . '</td>
      <td>' . money($data['montant_services']) . '</td>
      <td>' . money($montantTotal) . '</td>
     
    </tr>';
        endforeach;

        return $output;
    }

    // comptabilite

    public static function depotUserForCaisseComptable($versements)
    {
        $output = "";

        $i = 0;
        foreach ($versements as $data) :
            $i++;
            $cloture = $data['cloture'];
            $montant = $cloture != null ?  money($data['montant_cloture']) : '...';
            $statut = $cloture != null ?  '✅ Clôturé' : '⚠ Ouvert';
            $confirm = $data['etat_versement'] == 1 ?  '✅ Confirmé' : '🔂 En cours';
            $user = $data['nom'];
            $caisse = $cloture != null ?  money($data['montant_total']) : '...';
            $date_cloture = $cloture != null ?  date_formater($data['cloture']) : '...';
            $cmpt = $data['etat_versement'] == 1 ? $data['cmpt'] : '...';

            $output .= '

    <tr>
      <th scope="row">  ' . $i . '</th>
      <td>' . date_formater($data['ouverture']) . '</td>
      <td>' . $date_cloture . '</td>
      <td>' . $statut  . '</td>
      <td>' . $user . '</td>
      <td>' . $caisse . '</td>
      <td>' . $montant . '</td>
      <td data-titles="' . $cmpt . '">' . $confirm . '</td>
       <td>

        <div class="dropdown">

          <button ' . disabled($data['cloture'], null) . ' class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown">
            
          </button>';

            $output .= '
          <div class="dropdown-menu">
            
            <a class="dropdown-item" target="_blank" href="' . url('print/versement', ['code' => $data['code_versement']]) . '">  📠 &nbsp; Imprimer</a>';
            if ($data['etat_versement'] == 0) :
                $output .= '<button class="dropdown-item  btn_confirm_depot" data-versement="' . $data['code_versement'] . '"> 
              ✅ &nbsp; Confirmer
            </button>';
            endif;

            $output .= '</div>';

            $output .= '
        </div>

      </td>
      </tr>';
        endforeach;

        return $output;
    }

    // Sexion client
    public static function clientDataForSearching($clients)
    {
        $output = "";

        $i = 0;
        foreach ($clients as $data) :
            $i++;

            $output .= '
            
            <tr>
            <th scope="row">
                
                ' . $i . '</th>
            <td> ' . $data["nom_client"] . " " . $data["prenom_client"] . '</td>
            <td> ' . $data['telephone_client'] . '</td>
            <td> ' . $data['genre_client'] . '</td>
            <td> ' . $data['type_piece'] . " </br> " . $data['piece_client'] . '</td>
            <td> ' . date_formater($data['created_client']) . '</td>
            <td class="table_button">
            <span hidden>  ' . $data["code_client"] . ' </span>
                <a class="btn btn-info btn-sm mr-2" href=" ' . url('profile-client', ['code' => $data['code_client']]) . ' "> <i
                    class="fa fa-eye"></i> &nbsp; Info </a>
            </td>
            </tr> ';
        endforeach;

        return $output;
    }

    public static function clientRecaptData($clients)
    {
        $output = "";

        $i = 0;
        foreach ($clients as $data) :
            $i++;

            $output .= '
            
            <tr>
            <th scope="row">
                
                ' . $i . '</th>
            <td> ' . $data["nom_client"] . " " . $data["prenom_client"] . '</td>
            <td> ' . $data['telephone_client'] . '</td>
            <td> ' . $data['genre_client'] . '</td>
            <td> ' . $data['type_piece'] . " </br> " . $data['piece_client'] . '</td>
            <td> ' . date_formater($data['created_client']) . '</td>
            
            </tr> ';
        endforeach;

        return $output;
    }

    // sexion fonction
    public static function modalFonctionAdd()
    {
        $output = "";
        $output .= '
        <form action="#" method="post" id="frmAddFonction">
            <div class="row mb-3">
                <div class="col-12">
                    <label for="libelle_fonction" class="form-label">Libelle fonction <strong class="text-danger">*</strong></label>
                    <input type="text" class="form-control" id="libelle_fonction" name="libelle_fonction">
                </div>
            </div>
           
            <div class="row mb-3">
                <div class="col-12">
                    <input type="hidden" value="btn_add_fonction" name="action" class="form-control">
                    <label for="" class="form-label">Description </label>
                   <textarea class="form-control" rows="6" name="description" id=""></textarea>
                </div>
               
            </div>
        </form>
        ';
        return $output;
    }

    public static function modaleUpdateFonction($fonction)
    {
        return '
        <form action="#" method="post" id="frmAddFonction">
            <div class="row mb-3">
                <div class="col-12">
                    <label for="libelle_fonction" class="form-label">Libelle fonction <strong class="text-danger">*</strong></label>
                    <input type="text" class="form-control" id="libelle_fonction" name="libelle_fonction" value="' . $fonction['libelle_fonction'] . '">
                </div>
            </div>
    
            <div class="row mb-3">
                <div class="col-12">
                    <input type="hidden" value="btn_modifier_fonction" name="action" class="form-control">
                    <input type="hidden" value="' . crypter($fonction['code_fonction']) . '" name="code_fonction" class="form-control">
                    <label for="" class="form-label">Description </label>
                   <textarea class="form-control" rows="6" name="description" id="">' . $fonction['description_fonction'] . '</textarea>
                </div>
    
            </div>
        </form>
        ';
    }

    public static function modalAddService()
    {
        return '
        <form action="" id="frmAddService" method="POST">
                  <div class="form-group">
                      <label for="libelle_service">Libelle <span class="text-danger">*</span> </label>
                      <input name="libelle_service" type="text" class="form-control"  id="libelle_service" >
                  </div>
                   <div class="form-group">
                      <label for="prix_service">Prix <span class="text-danger">*</span>  </label>
                      <input name="prix_service" type="number" min="0" class="form-control" id="prix_service" required>
                  </div>

                  <div class="form-group">
                  <input value="btn_ajouter_service" name="action" type="hidden">
                    <label for="description_service">Description (200 Caractères)</label>
                    <textarea name="description_service" value="" rows="4"  maxlength="250" class="form-control"></textarea>
                  </div>
                    
              </form>
        ';
    }

    public static function modalUpdateService($service)
    {
        return '
        <form action="" id="frmAddService" method="POST">
                <div class="form-group">
                    <label for="libelle_service">Libelle <span class="text-danger">*</span>  </label>
                    <input name="libelle_service" type="text" class="form-control" value="' . $service['libelle_service'] . '" id="libelle_service" >
                </div>

                <div class="form-group">
                    <label for="prix_service">Prix <span class="text-danger">*</span>  </label>
                    <input name="prix_service" type="number" min="0" class="form-control" value="' . $service['prix_service'] . '" id="prix_service">
                </div>

                <div class="form-group">
                    <label for="description_service">Description (200 Caractères)</label>
                    <textarea name="description_service" rows="4"  maxlength="250" class="form-control">' . $service['description_service'] . '</textarea>
                    <input name="id_service" value="' . crypter($service['code_service']) . '" type="hidden">
                    <input name="action" value="btn_modifier_service" type="hidden">
                </div>
    
            </form>
        ';
    }

    public static function modalAddTypechambre()
    {
        return '
        <form action="" id="frmAddCategorie" method="POST">
                  <div class="form-group">
                      <label for="libelle_categorie">Libelle <span class="text-danger">*</span> </label>
                      <input name="libelle_categorie" type="text" class="form-control"  id="libelle_categorie" >
                  </div>

                  <div class="form-group">
                  <input value="btn_ajouter_categorie" name="action" type="hidden">
                    <label for="description_categorie">Description (200 Caractères)</label>
                    <textarea name="description_categorie" value="" rows="4"  maxlength="250" class="form-control"></textarea>
                  </div>
                    
              </form>
        ';
    }

    public static function modalUpdateTypeCategorie($categorie)
    {
        return '
        <form action="" id="frmAddCategorie" method="POST">
                <div class="form-group">
                    <label for="libelle_categorie">Libelle <span class="text-danger">*</span>  </label>
                    <input name="libelle_categorie" type="text" class="form-control" value="' . $categorie['libelle_typechambre'] . '" id="libelle_categorie" >
                </div>

                <div class="form-group">
                    <label for="description_categorie">Description (200 Caractères)</label>
                    <textarea name="description_categorie" rows="4"  maxlength="250" class="form-control">' . $categorie['description_typechambre'] . '</textarea>
                    <input name="id_categorie" value="' . crypter($categorie['code_typechambre']) . '" type="hidden">
                    <input name="action" value="btn_modifier_categorie" type="hidden">
                </div>
    
            </form>
        ';
    }

    public static function modalAddChambreHotel($categories)
    {
        $output = "";
        $output .= '
        <form action="" id="frmAddAhambre" method="POST">
            <div class="form-group">
            <label for="categorie">Categorie chambre <span class="text-danger">*</span>  </label>
            <select name="categorie" class="form-control select">
           <option disabled selected>---CHOISIR---</option>';

        foreach ($categories as $categorie) {
            $output .= '<option value="' . $categorie['code_typechambre'] . '">' . $categorie['libelle_typechambre'] . '</option>';
        }

        $output .= '</select>
                  </div>

                  <div class="form-group">
                      <label for="libelle_chambre">Libelle chambre <span class="text-danger">*</span> </label>
                      <input name="libelle_chambre" type="text"  class="form-control" id="libelle_chambre">
                      <input name="action" value="btn_ajouter_chambre" type="hidden">
                  </div>
                   <div class="form-group">
                      <label for="prix_chambre">Prix <span class="text-danger">*</span>  </label>
                      <input name="prix_chambre" type="number" min="0" class="form-control" id="prix_chambre" required>
                  </div>

                   <div class="form-group">
                      <label for="telephone">Contact</label>
                      <input name="telephone_chambre" type="text"  class="form-control telephone" id="telephone">
                  </div>
              </form>
        ';
        return $output;
    }

    public static function frmUpdateChambre($categories, $chambre)
    {
        $output = "";
        $output .= '
        <form action="" id="frmAddAhambre" method="POST">
            <div class="form-group">
            <label for="categorie">Categorie chambre</label>
            <select name="categorie" class="form-control select">';

        foreach ($categories as $categorie) {
            $output .= '<option ' . selected($chambre['typechambre_id'], $categorie['code_typechambre']) . ' value="' . $categorie['code_typechambre'] . '">' . $categorie['libelle_typechambre'] . '</option>';
        }

        $output .= '</select>
              </div>

              <div class="form-group">
                  <label for="libelle_chambre">Libelle chambre</label>
                  <input name="libelle_chambre" type="text" value="' . $chambre['libelle_chambre'] . '"  class="form-control" id="libelle_chambre">
                  <input name="id_chambre" value="' . crypter($chambre['code_chambre']) . '" type="hidden">
                  <input name="action" value="btn_modifier_chambre" type="hidden">
              </div>
              <div class="form-group">
                    <label for="prix_chambre">Prix <span class="text-danger">*</span>  </label>
                    <input name="prix_chambre" type="number" min="0" class="form-control" value="' . $chambre['prix_chambre'] . '" id="prix_chambre">
                </div>

               <div class="form-group">
                  <label for="telephone">Contact</label>
                  <input name="telephone_chambre" type="text" value="' . $chambre['telephone_chambre'] . '"  class="form-control telephone" id="telephone">
            </div>

            </form>
        ';
        return $output;
    }




    public static function modalAddServiceReservation($services, $code_reservation)
    {
        $output = "";
        $output .= '
        <form action="" id="frmAttrServiceForReservation" method="POST">
            <div class="form-group">
            <label for="service">Service  <span class="text-danger">*</span>  </label>
            <select id="service" name="service" class="form-control select">
           <option disabled selected>---CHOISIR---</option>';

        foreach ($services as $service) {
            $output .= '<option value="' . $service['code_service'] . '"> ' . $service['libelle_service'] . '</option>';
        }

        $output .= '</select>
                  </div>

                  <div class="form-group">
                      <label for="prix_service">Prix <span class="text-danger">*</span> </label>
                      <input readonly name="prix_service" type="text"  class="form-control" id="prix_service">
                      <input name="action" value="btn_ajouter_service_reservation" type="hidden">
                      <input id="prix" value="" type="hidden">
                  </div>
                   <div class="form-group">
                      <label for="qte_service">Quantité <span class="text-danger">*</span>  </label>
                      <input name="qte_service" type="number" value="1" min="1" class="form-control" id="qte_service" required>
                  </div>

                   <div class="form-group">
                      <label for="total_service">Motant total</label>
                      <input readonly name="total" type="text"  class="form-control total_service" id="total_service">
                      <input name="reservation" value="' . $code_reservation . '" type="hidden">
                  </div>
              </form>
        ';
        return $output;
    }

    public static function modalModifierServiceReservation($services, $consommation)
    {
        $output = "";
        $total = $consommation['quantite_consommation'] * $consommation['prix_consommation'];
        $output .= '
        <form action="" id="frmModifierServiceForReservation" method="POST">
            <div class="form-group">
            <label for="service">Service  <span class="text-danger">*</span>  </label>
            <select id="service" name="service" class="form-control select">
           <option disabled selected>---CHOISIR---</option>';

        foreach ($services as $service) {
            $output .= '<option ' . selected($service['code_service'], $consommation['service_id']) . ' value="' . $service['code_service'] . '"> ' . $service['libelle_service'] . '</option>';
        }

        $output .= '</select>
                  </div>

                  <div class="form-group">
                      <label for="prix_service">Prix <span class="text-danger">*</span> </label>
                      <input readonly name="prix_service" type="text"  class="form-control" id="prix_service" value="' . money($consommation['prix_consommation']) . '">
                      <input name="action" value="btn_modifier_service_for_reservation" type="hidden">
                      <input id="prix" value="' . $consommation['prix_consommation'] . '" type="hidden">
                  </div>
                   <div class="form-group">
                      <label for="qte_service">Quantité <span class="text-danger">*</span>  </label>
                      <input name="qte_service" type="number" value="1" min="1" class="form-control" id="qte_service" value="' . $consommation['quantite_consommation'] . '" required>
                  </div>

                   <div class="form-group">
                      <label for="total_service">Motant total</label>
                      <input readonly name="total" type="text"  class="form-control total_service" id="total_service" value="' . money($total) . '">
                      <input name="consommation" value="' . $consommation['code_consommation'] . '" type="hidden">
                  </div>
              </form>
        ';
        return $output;
    }

    public static function modalDataDetailsVersement($reservations, $services)
    {

        $i = 0;

        $output = '';

        $output .= self::DataDetailsReservation($reservations);
        $output .= self::DataDetailsService($services);

        return $output;
    }

    private static function DataDetailsReservation($reservations)
    {
        $output = '
         <div class="row mb-3 px-3">
        <h2> <i class="fa fa-list"></i>  <span class="text-success">Liste des reservations</span> </h2> 
        
        <hr class="">
         <div class="table-responsive table-responsive-md mb-2" id="sexion_versement">

      <table class="table table-striped table-bordered  table-hover table-sm ">
        <thead class="">
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Client</th>
            <th>N° Chambre</th>
            <th>Prix/Nuit</th>
            <th>Nb jour</th>
            <th>Montant Total</th>
            <th>Enregistrer par</th>
          </tr>
        </thead>
        <tbody> ';

        $i = 0;
        foreach ($reservations as $data) :
            $i++;
            $nbjr = daysBetweenDates(
                $data['date_entree'],
                $data['date_sortie']
            );
            $montantchambre = $data['prix_reservation'] * $nbjr;

            $output .= '
    
                <tr>
                <td>' . $i . '</td>
                <td>' . date_formater($data['created_reservation']) . '</td>
                <td> <a href="' . url("profile-client", ['code' => $data['client_id']]) . '"> <i class="fa fa-eye"></i>  ' . $data['nom_client'] . ' </a> 
                 </td>
                    <td>' . $data['libelle_chambre'] . '</td>
                    <td>' . money($data['prix_reservation']) . '</td>
                <td data-titles="Sejour du ' . date_formater($data['date_entree']) . ' au ' . date_formater($data['date_sortie']) . '">
                    ' . $nbjr . '</td>
            
                <td><span class="text-danger"> ' . money($montantchambre) . ' </span></td>
                <td>' . $data['nom'] . '</td>
                
                </tr>';

        endforeach;

        $output .= '
            </tbody>
         </table>
       </div>
        </div>';

        return $output;
    }

    private static function DataDetailsService($services)
    {
        $output = '
         <div class="row mb-2 px-2">
        <h2> <i class="fa fa-list"></i>  <span class="text-info">Liste des services</span> </h2> 
        
        <hr class="">
         <div class="table-responsive table-responsive-md mb-2" id="">

      <table class="table table-striped table-bordered  table-hover table-sm ">
        <thead class="">
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Client</th>
            <th>Service</th>
            <th>Prix</th>
            <th>Qte</th>
            <th>Montant Total</th>
            <th>Enregistrer par</th>
          </tr>
        </thead>
        <tbody> ';

        $i = 0;
        foreach ($services as $data) :
            $i++;

            $output .= '
    
                <tr>
                <td>' . $i . '</td>
                    <td>' . date_formater($data['created_consommation']) . '</td>
                    <td> <a href="' . url("reservation/details", ['code' => $data['code_reservation']]) . '"> <i class="fa fa-eye"></i> ' . $data['nom_client'] . ' </a> 
                    </td>
                    <td>' . $data['libelle_service'] . '</td>
                    <td>' . money($data['prix_consommation']) . '</td>
                    <td>' . $data['quantite_consommation'] . '</td>
                   
                <td> <span class="text-danger"> ' . money($data['montant_services']) . ' </span> </td>
                <td>' . $data['nom'] . '</td>
                
                </tr>';

        endforeach;

        $output .= '
            </tbody>
         </table>
       </div>
        </div>';

        return $output;
    }


    public static function modalAddDepenseHotel($categories)
    {
        $output = "";
        $output .= '
        <form action="" id="frm_ajouter_depense" method="POST">
            <div class="form-group">
            <label for="categorie">Categorie depense <span class="text-danger">*</span>  </label>
            <select required name="categorie" class="form-control select2">
           <option disabled selected>---CHOISIR---</option>';

        foreach ($categories as $categorie) {
            $output .= '<option value="' . $categorie['code_typedepense'] . '">' . $categorie['libelle_typedepense'] . '</option>';
        }

        $output .= '</select>
                  </div>
                   <div class="form-group">
                      <label for="montant_depense">Montant <span class="text-danger">*</span>  </label>
                      <input name="montant_depense" type="number" min="0" class="form-control" id="montant_depense" required>
                  </div>

                  <div class="form-group">
                      <label for="date_depense">Date <span class="text-danger">*</span>  </label>
                      <input name="date_depense" type="date" value="' . date('Y-m-d') . '" class="form-control" id="date_depense" required>
                  </div>

                   <div class="form-group">
                      <label for="description_depense">Description (200 Caractères)</label>
                      <textarea name="description_depense" rows="4"  maxlength="250" class="form-control"></textarea>
                  </div>
                   <div class="form-group">
                      <label for="confirm">   
                      <input value="1" name="confirm" type="checkbox" id="confirm">
                      <span  class="text-danger">   Confirmer, Cette action est irréversible </span>
                      <br> &nbsp; &nbsp; &nbsp;
                      <span  class="text-danger"> et cela empechera toute modification en cas d\'eurreur ⚠ ! </span>
                      </label>
                  </div>
                  <input name="action" value="btn_ajouter_depense" type="hidden">
              </form>
        ';
        return $output;
    }

    public static function frmUpdateDepense($categories, $depense)
    {
        $output = "";
        $output .= '
        <form action="" id="frm_ajouter_depense" method="POST">
            <div class="form-group">
            <label for="categorie">Categorie depense</label>
            <select name="categorie" class="form-control select">';

        foreach ($categories as $categorie) {
            $output .= '<option ' . selected($depense['typedepense_id'], $categorie['code_typedepense']) . ' value="' . $categorie['code_typedepense'] . '">' . $categorie['libelle_typedepense'] . '</option>';
        }

        $output .= '</select>
              </div>
              <div class="form-group">
                    <label for="montant_depense">Montant <span class="text-danger">*</span>  </label>
                    <input name="montant_depense" type="number" min="0" class="form-control" value="' . $depense['montant_depense'] . '" id="montant_depense">
                </div>

                <div class="form-group">
                    <label for="date_depense">Date <span class="text-danger">*</span>  </label>
                    <input name="date_depense" type="date" value="' . $depense['periode_depense'] . '" class="form-control" id="date_depense" required>
                </div>

               <div class="form-group">
                  <label for="description_depense">Description (200 Caractères)</label>
                  <textarea name="description_depense" rows="4"  maxlength="250" class="form-control">' . $depense['description_depense'] . '</textarea>
            </div>
             <div class="form-group">
                      <label for="confirm">   
                      <input value="1" name="confirm" type="checkbox" id="confirm">
                      <span  class="text-danger">   Confirmer, Cette action est irréversible </span>
                      <br> &nbsp; &nbsp; &nbsp;
                      <span  class="text-danger"> et cela empechera toute modification en cas d\'eurreur ⚠ ! </span>
                      </label>
                  </div>
            <input name="id_depense" value="' . crypter($depense['code_depense']) . '" type="hidden">
            <input name="action" value="btn_modifier_depense" type="hidden">
            </form>
        ';
        return $output;
    }

    public static function depenseDataForSearching($depenses)
    {
        $output = "";

        $i = 0;
        foreach ($depenses as $data) :

            $i++;
            $montantTotal = $data['montant_depense'];
            $output .= '
    
        <tr>
          <th scope="row">  ' . $i . '</th>
          <td class="text-center">' . date_formater($data['created_depense']) . '</td>
          <td class="text-center">' . $data['libelle_depense'] . $data['etat_depense'] . '</td>
          <td class="text-center" data-titles="' . $data['description_depense'] . '">...</td>
          <td class="text-center">' . money($montantTotal) . '</td>
          <td class="text-center" data-titles="' . $data['user_confirm'] . '">' . checkStateDepense($data['etat_depense']) . '</td>
          <td class="text-center">' . $data['user'] . '</td>
          <td class="table_button">
                <div class="dropdown">
                    <button type="button" ' . ($data['etat_depense'] == 1 ? 'disabled' : '') . ' class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown">

                    </button>

                    <div class="dropdown-menu">';
            if (Auth::hasRole(Roles::COMPTATBLE_H)) :
                $output .= '
                        <button class="dropdown-item btn_confirm_depense" data-depense="' . crypter($data['code_depense']) . '"> ✅ Confirmer</button>
                        ';
            endif;
            $output .= '
                        <button class="dropdown-item btn_update_depense" data-depense="' . crypter($data['code_depense']) . '"> 📝 Modifier</button>
                        <button class="dropdown-item btn_annuler_depense" data-depense="' . crypter($data['code_depense']) . '"> ❌ Annuler</button>
                    </div>
                </div>
          </td>
        </tr>';
        endforeach;

        return $output;
    }

    public static function depenseRecaptData($depenses)
    {
        $output = "";

        $i = 0;
        foreach ($depenses as $data) :

            $i++;
            $montantTotal = $data['montant_depense'];
            $output .= '
    
        <tr>
          <th scope="row">  ' . $i . '</th>
          <td class="text-center">' . date_formater($data['created_depense']) . '</td>
          <td class="text-center">' . $data['libelle_depense'] . $data['etat_depense'] . '</td>
          <td class="text-center" data-titles="' . $data['description_depense'] . '">...</td>
          <td class="text-center">' . money($montantTotal) . '</td>
          <td class="text-center" data-titles="' . $data['user_confirm'] . '">' . checkStateDepense($data['etat_depense']) . '</td>
          <td class="text-center">' . $data['user'] . '</td>
          
        </tr>';
        endforeach;

        return $output;
    }

    public static function modalAddSalaireHotel($users)
    {
        $output = "";
        $output .= '
        <form action="" id="frm_ajouter_salaire" method="POST">
            <div class="form-group">
            <label for="user">Employé <span class="text-danger">*</span>  </label>
            <select required name="user" class="form-control select2">
           <option disabled selected>---CHOISIR---</option>';

        foreach ($users as $user) {
            $output .= '<option value="' . $user['code_user'] . '">' . $user['nom'] . ' ' . $user['prenom'] . '</option>';
        }

        $output .= '</select>
                  </div>
                  <div class="form-group">
                      <label for="mois_salaire">Mois <span class="text-danger">*</span>  </label>
                      <input name="mois_salaire" type="month" class="form-control" id="mois_salaire" required>
                  </div>

                   <div class="form-group">
                      <label for="montant_salaire">Montant <span class="text-danger">*</span>  </label>
                      <input name="montant_salaire" type="number" min="0" class="form-control" id="montant_salaire" required>
                  </div>

                   <div class="form-group">
                      <label for="confirm">   
                      <input value="1" name="confirm" type="checkbox" id="confirm">
                      <span  class="text-danger">   Confirmer, Cette action est irréversible </span>
                      <br> &nbsp; &nbsp; &nbsp;
                      <span  class="text-danger"> et cela empechera toute modification en cas d\'eurreur ⚠ ! </span>
                      </label>
                  </div>
                 
                  <input name="action" value="btn_ajouter_salaire" type="hidden">
              </form>
        ';
        return $output;
    }

    public static function frmUpdateSalaireHotel($users, $salaire)
    {
        $output = "";
        $output .= '
        <form action="" id="frm_ajouter_salaire" method="POST">
            <div class="form-group">
            <label for="user">Employé <span class="text-danger">*</span>  </label>
            <select name="user" class="form-control select">';

        foreach ($users as $user) {
            $output .= '<option ' . selected($salaire['user_id'], $user['code_user']) . ' value="' . $user['code_user'] . '">' . $user['nom'] . ' ' . $user['prenom'] . '</option>';
        }

        $output .= '</select>
              </div>
              <div class="form-group">
                    <label for="mois_salaire">Mois <span class="text-danger">*</span>  </label>
                    <input name="mois_salaire" type="month" value="' . $salaire['mois_salaire'] . '" class="form-control" id="mois_salaire" required>
                </div>

              <div class="form-group">
                    <label for="montant_salaire">Montant <span class="text-danger">*</span>  </label>
                    <input name="montant_salaire" type="number" min="0" class="form-control" value="' . $salaire['montant_salaire'] . '" id="montant_salaire">
                </div>

                <div class="form-group">
                      <label for="confirm">   
                      <input value="1" name="confirm" type="checkbox" id="confirm">
                      <span  class="text-danger">   Confirmer, Cette action est irréversible </span>
                      <br> &nbsp; &nbsp; &nbsp;
                      <span  class="text-danger"> et cela empechera toute modification en cas d\'eurreur ⚠ ! </span>
                      </label>
                  </div>

            <input name="id_salaire" value="' . crypter($salaire['code_salaire']) . '" type="hidden">
            <input name="action" value="btn_modifier_salaire" type="hidden">
            </form>
        ';
        return $output;
    }

    public static function salaireDataForSearching($salaires)
    {
        $output = "";

        $i = 0;
        foreach ($salaires as $data) :

            $i++;
            $mois = getFormatMois($data['mois_salaire']);

            //   mois en lettre en français
            // locale_set_default('fr_FR');
            // setlocale(LC_TIME, 'fr_FR.UTF-8');
            // timezone_open('Africa/Abidjan');

            // $mois = (new DateTime($data['mois_salaire']))->format('F');
            $montantTotal = $data['montant_salaire'];
            $output .= '
    
        <tr>
          <th scope="row">  ' . $i . '</th>
          <td data-titles="' . $data['user_created'] . '"> ' . date_formater($data['created_salaire']) . '</td>
          <td>' . $data['user'] . '</td>
          <td>' . $mois . '</td>
          <td class="text-center">' . money($montantTotal) . '</td>
          <td class="text-center" data-titles="' . $data['user_confirm'] . '">' . checkStateDepense($data['etat_salaire']) . '</td>
          <td class="table_button">

           <div class="dropdown">
                    <button type="button" ' . ($data['etat_salaire'] == 1 ? 'disabled' : '') . ' class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown">

                    </button>

                    <div class="dropdown-menu">
                    
                        <button class="dropdown-item btn_confirm_salaire" data-salaire="' . crypter($data['code_salaire']) . '"> ✅ Confirmer</button>
                        <button class="dropdown-item frmModifierSalaire" data-salaire="' . crypter($data['code_salaire']) . '"> 📝 Modifier</button>
                        <button class="dropdown-item btn_delete_salaire" data-salaire="' . crypter($data['code_salaire']) . '"> ❌ Annuler</button>
                    </div>
                </div>
            </td>
        </tr>';
        endforeach;

        return $output;
    }
}
