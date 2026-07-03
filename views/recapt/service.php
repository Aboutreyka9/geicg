<div class="card mt-2 bg_light">
    <div class="card-header">
      <h5 class="card-title text-upper"> <i class="fa fa-list"></i> &nbsp;Liste des services
    </h5>
    <button class="btn btn-dark pull-right" id="btn_print_recapt_services" > <i class="fa fa-print"></i>&nbsp; &nbsp; Imprimer</button>
      
      
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
            </tr>
          </thead>
          <tbody>
                <?= chargerRecaptListeServices() ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>


