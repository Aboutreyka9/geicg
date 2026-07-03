<div class="row" id="statut_versement">
<?= chargerStatutVersementUser() ?>
</div>


<div class="card mt-2 bg_light">

  <div class="row mx-2 mt-4">
    <div class="col-md-5 mt-2 mb-2">
      <h5 class="card-title text-upper">
        <i class="fa fa-list"></i> &nbsp;Historique des versements
      </h5>
      
    </div>

    <div class="col-md-7 mt-2 mb-2">

      <div class="d-flex justify-content-end items-center">
     
      <div class="form-group" id="sexion_caisse">

          <?php if(auth()->user('caisse') == null) : ?>
            <button id="btn_ouverture_caisse" type="button" class="btn btn-info"> <i class="fa fa-briefcase"></i> &nbsp; OUVRIR MA CAISSE</button>
            
           <?php else : ?>
            <button id="btn_fermeture_caisse" type="button" class="btn btn-info"> <i class="fa fa-briefcase"></i> &nbsp; FERMER MA CAISSE</button>
          
          
           <?php endif;?>

      </div>
      </div>
    </div>
  </div>

  

  <div class="card-body">

    <div class="table-responsive table-responsive-md" id="sexion_versement">

      <table class="table  table-bordered  table-hover table-sm ">
        <thead class="">
          <tr>
            <th width="1">#</th>
            <th>Ouverture</th>
            <th>Cloture</th>
            <th>Statut</th>
            <th>Recette</th>
            <th width="5">Options</th>
          </tr>
        </thead>
        <tbody>
          <?= chargerListeVersementUser() ?>
        </tbody>
      </table>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="details-versement-modal" data-bs-backdrop="static" tabindex="-1" role="dialog"
  aria-labelledby="detailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="detailsModalLabel"><i class="fa fa-user-circle"></i> &nbsp; <span
            class="text-uppercase">Detail versement</span> </h5>
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
    
    </div>
  </div>
</div>

