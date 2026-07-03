<div class="card mt-2 bg_light">
    <div class="card-header">
        <div class="table_row_header">
            <div class="table_row_header_left">
                <h4 class=" text-upper"> <i class="fa fa-list"></i> &nbsp; Liste des utilisateurs</h4>
            </div>
            <div class="table_row_header_right">
                <button class="btn btn-primary "> <i class="fa fa-print"></i> &nbsp; <span class="text_button text-uppercase">Imprimer</span></button>
                <button class="btn btn-info  btn_modal_user"> <i class="fa fa-plus-circle fa-2"></i> &nbsp; <span class="text_button text-uppercase">Enregistrer utilisateur</span></button>

            </div>

        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive table-responsive-md " id="sexion_user">

            <table id="data-table-user" class="table table-striped table-bordered  table-hover table-sm table-data">
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

            </div><!-- /.modal-footer -->
        </div>
    </div>
</div>