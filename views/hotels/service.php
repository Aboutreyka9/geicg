<div class="card mt-2 bg_light">
    <div class="card-header">
      <h5 class="card-title text-upper"> <i class="fa fa-list"></i> &nbsp;Liste des services
    </h5>
    <button class="btn btn-info pull-right" id="serviceAddModal" > <i class="fa fa-plus-circle"></i>&nbsp; &nbsp; Ajouter</button>
      
      
    </div>
    <div class="card-body">
      <div class="table-responsive table-responsive-md" id="sexion_service">
     
      <table class="table table-striped table-bordered  table-hover table-sm table-data">
          <thead class="">
          <tr>
              <th class="text-center" width="2px" >#</th>
              <th class="text-center" >Service</th>
              <th class="text-center" >Description</th>
              <th class="text-center" >Prix service</th>
              <th class="text-center" width="25px" >Options</th>
            </tr>
          </thead>
          <tbody>
                <?= chargerListeServices() ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>




<!-- Modal -->
<div class="modal fade" id="service-modal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="serviceModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="serviceModalLabel"><i class="fa fa-user-circle"></i> &nbsp; <span class="text-uppercase">Service</span>  </h5>
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
        <button type="submit" form="frmAddService" id="btn_add_service" class="btn btn-primary "> <i class="fa fa-check-circle"></i> Enregistrer </button>
      </div><!-- /.modal-footer -->
    </div>
  </div>
</div>


