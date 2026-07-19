<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <button style="border: none;" type="button" class="btn btn-outline-dark w-50 btn_reload"><i
                        class="fas fa-sync"></i> &nbsp; Mettre à jour</button>
            </div>
            <div class="col-md-8 d-flex justify-content-end ">
                <button class="btn btn-dark mr-3"> <i class="fa fa-print"></i> &nbsp; <span
                        class="text_button text-uppercase">Imprimer</span></button>
                <button class="btn btn-info  btn_utilisateur_addModal"> <i class="fa fa-plus-circle fa-2"></i> &nbsp;
                    <span class="text_button text-uppercase">Ajouter</span>
                </button>

            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">

        <div class="table-responsive " id="sexion_user">
            <table id="data-table-utilisateur" class="table table-striped table-bordered  table-hover ">
                <thead class="">
                    <tr>
                        <th>#</th>
                        <th>STATUT</th>
                        <th>NOM</th>
                        <th>PRENOMS</th>
                        <th>CONTACT</th>
                        <th>FONCTION</th>
                        <th>OPTIONS</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>



<!-- Modal add and update user -->
<div class="modal fade" data-backdrop="static" id="user-modal" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="userModalLabel"><i class="fa fa-user-circle"></i> &nbsp; <span
                        class="text-uppercase">Formulaire d'enregistrement</span> </h5>
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

            </div><!-- /.modal-footer -->
        </div>
    </div>
</div>

<!-- /end modal user -->

<!-- Modal roles permission -->
<div class="modal fade" data-backdrop="static" id="role-permission-modal" data-bs-backdrop="static" tabindex="-1"
    role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="roleModalLabel"><i class="fa fa-user-circle"></i> &nbsp; <span
                        class="text-uppercase" id="user-info">Formulaire ...</span> </h5>
                <button type="button" class="close" id="btn-close-modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row ">
                    <div class="col-md-12 role-permission-data-modal">

                    </div>
                </div>
            </div>
            <!-- .modal-footer -->
            <div class="modal-footer">
                <button type="submit" form="frmSavePermission" id="btnSavePermissions" class="btn btn-secondary w-25">
                    <i class="fa fa-check-circle"></i> &nbsp; Attribuer</button>
                <button type="button" id="btn-close-modal" class="btn btn-light dismiss_modal">Fermer</button>
            </div><!-- /.modal-footer -->
        </div>
    </div>
</div>