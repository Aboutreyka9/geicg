<div class="card mt-2 initverifictionChambreAble">

  <div class="row mx-2 mt-4">
    <div class="col-md-5 mt-2 mb-2">
      <h5 class="card-title text-upper">
        <i class="fa fa-list"></i> &nbsp;Liste des chambres disponibles
      </h5>
      <span class="pl-4">periode du</span>
      <span class="periode-verif"> <?= date('d-m-Y') ?></span>
    </div>

    <div class="col-md-7 mt-2 mb-2">

      <div class="d-flex justify-content-end items-center">

        <div class="form-group col-md-3">
          <label for="number_day">Nombre de jours</label>
          <input readonly type="text" id="number_day" value="1" class="form-control py-2">
        </div>

        <div style="position: relative;" class="form-group col-md-5">

          <label for="periode">Periode (Debut-Fin) <span class="text-danger">*</span></label>
          <i style="position: absolute; bottom: 20px; right: 15px; font-size: 28px;"
            class="fa fa-calendar search-date-verification" aria-hidden="true"></i>

          <input type="text" class="form-control search-date-verification" placeholder="Rechercher une periode">
        </div>

      </div>
    </div>
  </div>

  <div class="card-body">
    <div class="table-responsive table-responsive-md">

      <table class="table table-striped table-bordered  table-hover table-sm table-data">
        <thead class="">
          <tr>
            <th width="10">#</th>
            <th>Cat/ch</th>
            <th>N° chambre</th>
            <th>Statut</th>
            <th>Prix/Nuit</th>
            <th>Total</th>
            <th width="60">Options</th>
          </tr>
        </thead>
        <tbody id="sexion_chambre">
        </tbody>
      </table>
    </div>
  </div>
</div>





<!-- Modal -->
<div class="modal fade" id="reservation-modal" data-bs-backdrop="static" tabindex="-1" role="dialog"
  aria-labelledby="reservationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="reservationModalLabel"><i class="fa fa-user-circle"></i> &nbsp; <span
            class="text-uppercase">Formulaire de Reservation</span> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row ">

          <div class="col-md-12">
            <ul class="nav nav-tabs pb-2 d-flex justify-content-between">
              <li class="tabs_menu">
                <a class="text-uppercase active show" id="res_btn" data-toggle="tab" href="#reservation"> <i
                    class="fa fa-plus-circle"></i>&nbsp; &nbsp; Nouveau client</a>
              </li>
              <li class="">
                <a class="text-uppercase" id="rec_btn" data-toggle="tab" href="#recherche"> <i class="fa fa-user-circle"></i>&nbsp; &nbsp;
                  Client existant</a>
              </li>
            </ul>
          </div>



          <div class="col-md-12 data-modal5">
            <div class="tab-content">
              <div id="reservation" class="tab-pane fade active show">

                <form action="" id="frm_ajouter_client" method="POST">

                  <div class="form-group">
                    <label for="nom_client">Nom & Prénoms <span class="text-danger">*</span> </label>
                    <input name="nom_client" type="text" class="form-control" id="nom_client">
                  </div>

                  <div class="form-group">
                    <label for="telephone_client">Numéro de Telephne <span class="text-danger">*</span> </label>
                    <input name="telephone_client" type="text" class="form-control telephone" id="telephone_client">
                  </div>

                  <div class="form-group row">
                    <div class="col-md-5">
                      <label for="type_piece">Type pièce</label>
                      <select id="type_piece" name="type_piece" class="form-control">
                        <option value="">--CHOISIR--</option>';
                        <?= chargerTypePiece() ?>
                      </select>
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
                      <?= chargerGenre() ?>
                    </select>
                  </div>

                  <input name="action" value="btn_ajouter_client" type="hidden">

                  <div class="com-md-12 modal_footer">
                     <button type="submit" disabled id="btn_ajouter_client" class="btn btn-primary "> <i
            class="fa fa-check-circle"></i> Enregistrer </button>
                  </div>

                </form>

              </div>

              <div id="recherche" class="tab-pane fade">
                <form action="" method="post" id="frm_ajouter_reservation">
                <div style="position: relative;" class="form-group">
                  <label for="telephone">Numéro de Telephne <span class="text-danger">*</span> </label>
                  <input name="telephone_client" type="text" class="form-control telephone" id="telephone">
                  <button title="Rechercher..." class="btn btn-primary search_number"> <i class="fa fa-search"></i>
                    &nbsp; Recherche</button>

                </div>
                
                <div class="row">
                  
                  <!-- Section affichage resulta recherche -->
                  <input type="hidden"  name="action" value="btn_ajouter_reservation">
                    <div class="col-md-12 show_resultat">

                    </div>

                <div class="com-md-12 modal_footer">
                     <button type="submit"  id="btn_ajouter_reservation" class="btn btn-primary "> <i
            class="fa fa-check-circle"></i> Continuer </button>
                  </div>
                </div>
               </form>


              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- .modal-footer -->
      <div style="height: 80px;" class="modal-footer">
       
      </div><!-- /.modal-footer -->
    </div>
  </div>
</div>