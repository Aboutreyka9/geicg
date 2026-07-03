
<div class="container-fluid pt-4 px-3">

  <!-- Entête -->
  <div class="d-flex justify-content-between align-items-center mb-3">
   
  </div>


  <div class="col-md-12">
    <div class="bg-light rounded box-b-black h-100 p-4">
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
         
            <button class="nav-link" id="nav-add-role-tab" data-bs-toggle="tab" data-bs-target="#nav-add-role" type="button"
            role="tab" aria-controls="nav-add-role" aria-selected="false"> <i class="fa fa-list"></i> ROLE & PERMISSION</button>
        </div>
      </nav>

      <div class="tab-content pt-3" id="nav-tabContent">

        <div style="min-height: 500px;" class="tab-pane fade active" id="nav-add-role" role="tabpanel"
          aria-labelledby="nav-add-role-tab">

          <div class="card">
            <div class="card-body">
              <div class="row">

                <div class="bg-light rounded h-100 p-2 mt-2">

                  <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered" id="table-liste2">
                      <thead class="bg-red200">
                        <tr>
                          <th width="5">matricule</th>
                          <th >Nom</th>
                          <th >Prenom</th>
                          
                          <th >Contact</th>
                          <th class="text-center">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                      $i = 0;
                       foreach ($data['users'] as $key => $data) {
      $i++; ?>

<tr>
  
  <td><?= $data['matricule'] ?></td>
  <td><?= $data['nom'] ?></td>
  <td><?= $data['prenom'] ?></td>
  <td><?= $data['telephone'] ?></td>
  <td class="table_button">

    <div class="btn_inligne">
      <a href="javascript:void(0)" data-code="<?= $data['code_user'] ?>" class="modal_permission_user" title="Autorisation" > <i
          class="fa fa-sitemap"></i> &nbsp; PERMISSION
        </a>

    </div>
  </td>
</tr>
<?php }

  

                       ?>

                      </tbody>

                    </table>
                  </div>

                </div>

              </div>
            </div>
          </div>

        </div>


      </div>
    </div>
  </div>


</div>




<!-- *************** SEXION MODAL *******************  -->


<!-- .modal Add USer -->

<div class="modal fade" data-bs-backdrop="static" id="user-modal" tabindex="-1" role="dialog"
  aria-labelledby="userModalLabel" aria-hidden="true">
  <!-- .modal-dialog -->
  <div class="modal-dialog modal-lg" role="document">
    <!-- .modal-content -->
    <div class="modal-content box-b-blue">
      <!-- .modal-header -->
      <div class="modal-header">
        <h6 class="modal-title inline-editable" id="userModalLabel"> <i class="fa fa-user-circle"></i> &nbsp;
        </h6>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
      </div><!-- /.modal-header -->

      <!-- .modal-body -->
      <div class="modal-body">
        <!-- .form-row -->
        <div class="form-row data-modal">

        </div><!-- /.form-row -->
      </div><!-- /.modal-body -->
      <!-- .modal-footer -->
      <div class="modal-footer">
        <button type="submit" form="frmAddUser" id="btn_add_user" class="btn btn-primary w-50"> <i
            class="fa fa-check-circle"></i> &nbsp; Enregistrer</button>
      </div><!-- /.modal-footer -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.m -->
<!-- /.modal -->

<!-- .modal -->

<div class="modal fade" data-bs-backdrop="static" id="user-modal-modifier" tabindex="-1" role="dialog"
  aria-labelledby="userModalLabel" aria-hidden="true">
  <!-- .modal-dialog -->
  <div class="modal-dialog modal-lg" role="document">
    <!-- .modal-content -->
    <div class="modal-content box-b-blue">
      <!-- .modal-header -->
      <div class="modal-header">
        <h6 class="modal-title inline-editable" id="userModalLabel"> <i class="fa fa-user-circle"></i> &nbsp;
        </h6>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
      </div><!-- /.modal-header -->

      <!-- .modal-body -->
      <div class="modal-body">
        <!-- .form-row -->
        <div class="form-row data-modal-modifier">

        </div><!-- /.form-row -->
      </div><!-- /.modal-body -->
      <!-- .modal-footer -->
      <div class="modal-footer">
        <button type="submit" form="frmModifierUser" id="btn_modifier_user" class="btn btn-primary w-50"> <i class="fa fa-check-circle"></i> &nbsp; Modifier</button>
      </div><!-- /.modal-footer -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.m -->
<!-- /.modal -->

<!-- ################################################ -->

<!-- .modal Role & Permission-->

<div class="modal fade" data-bs-backdrop="static" id="role-modal-permission" tabindex="-1" role="dialog"
  aria-labelledby="userModalLabel" aria-hidden="true">
  <!-- .modal-dialog -->
  <div class="modal-dialog modal-lg" role="document">
    <!-- .modal-content -->
    <div class="modal-content box-b-blue">
      <!-- .modal-header -->
      <div class="modal-header">
        <h6 class="modal-title inline-editable" id="userModalLabel"> <i class="fa fa-user-circle"></i> &nbsp; <span class="text-danger" id="user-info"></span>
        </h6>
        <button type="button" id="btn-close-modal" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
      </div><!-- /.modal-header -->

      <!-- .modal-body -->
      <div class="modal-body">
        <!-- .form-row -->
        <div class="form-row data-modal-permission">

        </div><!-- /.form-row -->
      </div><!-- /.modal-body -->
      <!-- .modal-footer -->
      <div class="modal-footer">
        <button type="submit" form="frmSavePermission" id="btnSavePermissions" class="btn btn-primary w-25"> <i class="fa fa-check-circle"></i> &nbsp; Attribuer</button>
      </div><!-- /.modal-footer -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.m -->
<!-- /.modal -->

<!-- ################################################ -->



 <!-- *************** END SEXION MODAL ***************  -->