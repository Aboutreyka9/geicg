<div class="card mt-2 bg_light">
  <div class="card-header bg-dark text-light">
    <div class="table_row_header">
      <div class="table_row_header_left">
        <h5 class=" text-upper"> <i class="fa fa-list"></i> &nbsp; Liste employés</h5>
      </div>
      <div class="table_row_header_right">
        <button class="btn btn-primary btn-sm"> <i class="fa fa-print"></i> &nbsp; <span class="text_button text-uppercase">Imprimer</span></button>
        <button class="btn btn-info btn-sm btn_modal_user"> <i class="fa fa-plus-circle fa-2"></i> &nbsp; <span class="text_button text-uppercase">Enregistrer employé</span></button>

      </div>

    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive table-responsive-md " id="sexion_user">

      <table class="table table-striped table-bordered  table-hover table-sm table-data">
        <thead class="">
          <tr>
            <th>#</th>
            <th>EMAIL</th>
            <th>NOM</th>
            <th>PRENOMS</th>
            <th>Contact</th>
            <th>Fonction</th>
            <th>STATUT</th>
            <th>OPTION</th>
          </tr>
        </thead>
        <tbody>
          <?= chargerListeUser() ?>
        </tbody>
      </table>
    </div>
  </div>
</div>






<!-- Modal -->
<div class="modal fade" id="user-modal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="userModalLabel"><i class="fa fa-user-circle"></i> &nbsp; <span class="text-uppercase">Formulaire d'enregistrement</span> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row ">
          <div class="col-md-12 data-modal">

          </div>
        </div>
      </div>
      <!-- .modal-footer -->
      <div class="modal-footer">
        <button type="submit" form="frmAddUser" id="btn_add_user" class="btn btn-primary w-25"> <i class="fa fa-check-circle"></i> &nbsp; Enregistrer</button>
      </div><!-- /.modal-footer -->
    </div>
  </div>
</div>