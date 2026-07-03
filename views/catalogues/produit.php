<div class="card mt-2 bg_light">
  <div class="card-header">
    <div class="table_row_header">
      <div class="table_row_header_left">
        <h4 class=" text-upper"> <i class="fa fa-list"></i> &nbsp; Liste des produits </h4>
      </div>
      <div class="table_row_header_right">
        <button class="btn btn-dark "> <i class="fa fa-print"></i> &nbsp; <span class=" text-uppercase">Imprimer</span></button>
        <button type="button" class="btn btn-info " id="produitAddModal"> <i class="fa fa-plus-circle fa-2"></i> &nbsp; <span class=" text-uppercase">Ajouter produit</span></button>
      </div>

    </div>
  </div>


  <div class="card-body">
    <div class="table-responsive table-responsive-md" id="sexion_produit">

      <table id="data-table-produit" class="table table-striped table-bordered  table-hover table-sm table-data">
        <thead class="">
          <tr>
            <th class="text-center" width="2px">#</th>
            <th class="text-center">Produit</th>
            <th class="text-center">Marque</th>
            <th class="text-center">Categorie</th>
            <th class="text-center">Prix Achat</th>
            <th class="text-center">Prix Vente</th>
            <th class="text-center">Stock</th>
            <th class="text-center" width="25px">Options</th>
          </tr>
        </thead>

      </table>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="produit-modal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="produitModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="produitModalLabel"><i class="fa fa-user-circle"></i> &nbsp; <span class="text-uppercase">Espace Produit</span> </h5>
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