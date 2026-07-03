<div class="card mt-2 bg_light">

    <div class="card-header">
        <div class="table_row_header">
            <div class="table_row_header_left">
                <h4 class=" text-upper"> <i class="fa fa-list"></i> &nbsp; Bon de commande</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group px-3">
                <label for="">Fournisseur</label>
                <select class="form-control" style="height: 50px !important; border-radius: 5px; background-color: #eeeeeeff; font-size: 18px !important;" name="" id="">
                    <option value="">Selectionner un fournisseur</option>
                    <option value="1">fournisseur 1</option>
                    <option value="2">fournisseur 2</option>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="">Produit</label>
                <select class="form-control" name="" id="">
                    <option value="">Selectionner un produit</option>
                    <option value="1">produit 1</option>
                    <option value="2">produit 2</option>
                </select>
            </div>
        </div>
    </div>

    <hr class="my-2 bg-dark">


    <div class="card-body">
        <div class="table-responsive table-responsive-md" id="sexion_categorie">

            <table id="data-table-fournisseur" class="table table-striped table-bordered  table-hover table-sm table-data">
                <thead class="">
                    <tr>
                        <th>#</th>
                        <th>Nom & prenoms</th>
                        <th>Contact</th>
                        <th>Civilité</th>
                        <th>Enregistrer</th>
                        <th width="6%">Options</th>
                    </tr>
                </thead>

            </table>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="fournisseur-modal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="fournisseurModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div style="position: relative;" class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="fournisseurModalLabel"><i class="fa fa-user-circle"></i> &nbsp; <span class="text-uppercase">Fournisseur</span> </h5>
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