<div class="card mt-2 bg_light">
  <div class="card-header bg-dark text-white">
    <h5 class="card-title text-upper"> <i class="fa fa-list"></i> &nbsp;Liste employés</h5>

  </div>
  <div class="card-body">
    <div class="table-responsive table-responsive-md">

      <table id="data-table-user_role" class="table table-striped table-bordered  table-hover table-sm table-data">
        <thead class="">
          <tr>
            <th>#</th>
            <th>EMAIL</th>
            <th>NOM</th>
            <th>PRENOMS</th>
            <th>Contact</th>
            <th>Fonction</th>
            <th>OPTION</th>
          </tr>
        </thead>
        <tbody id="sexion_employe">
          <?php
          if (!empty($data['users'])) {
            $users = $data['users'];
            $i = 0;

            // foreach ($users as $key => $data) {
            foreach ($users as $user) {
              $i++; ?>

              <tr>

                <td><?= $i ?></td>
                <td><?= $user['email_user'] ?></td>
                <td><?= $user['nom_user'] ?></td>
                <td><?= $user['prenom_user'] ?></td>
                <td><?= $user['telephone_user'] ?></td>
                <td><?= $user['libelle_fonction'] ?></td>
                <td class="">

                  <button type="button" data-code="<?= $user['code_user'] ?>"
                    class="btn btn-primary btn-sm modal_permission_user" title="Autorisation"> <i class="fa fa-sitemap"></i> &nbsp;
                    PERMISSION
                  </button>

                </td>
              </tr>
          <?php }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>






<!-- Modal -->
<div class="modal fade" id="role-modal-permission" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content bg_light">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel"><i class="fa fa-user-circle"></i> &nbsp; <span class="text-primary" id="user-info"></span> </h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        <div class="row ">
          <div class="col-md-12 data-modal-permission">

          </div>
        </div>
      </div>
      <!-- .modal-footer -->
      <div class="modal-footer">
        <button type="submit" form="frmSavePermission" id="btnSavePermissions" class="btn btn-primary w-25"> <i class="fa fa-check-circle"></i> &nbsp; Attribuer</button>
      </div><!-- /.modal-footer -->
    </div>
  </div>
</div>