<div class="card mt-2 bg_light">
    <div class="card-header">
      <h5 class="card-title text-upper"> <i class="fa fa-list"></i> &nbsp;Liste des Chambres
    </h5>
    <button class="btn btn-dark pull-right" id="btn_print_recapt_chambre" > <i class="fa fa-print"></i>&nbsp; &nbsp; Imprimer</button>
      
      
    </div>
    <div class="card-body">
      <div class="table-responsive table-responsive-md"  id="sexion_chambre">
     
      <table class="table table-striped table-bordered  table-hover table-sm table-data">
          <thead class="">
          <tr>
              <th class="text-center" width="2px" >#</th>
              <th class="text-center" >N° chambre</th>
              <th class="text-center" >Categorie chambre</th>
              <th class="text-center" >Prix/Nuit</th>
            </tr>
          </thead>
          <tbody>
                <?= chargerRecaptListeChambre() ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>




