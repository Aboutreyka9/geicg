
<?php 
  $today = new DateTime();
  // Date 25 jours en arrière
  $past = new DateTime('first day of this month');


  $start = $past->format('Y-m-d 00:00:00');
  $end   = $today->format('Y-m-d 23:59:59');
  $periode = crypter($start."#".$end);

 ?>

<div class="row mt-4 mb-4">
    <div class="col-md-4 mt-1 mb-1">
        <h5 class="text-upper text-title2">
            <i class="fa fa-list"></i> Gestion des Dépenses
        </h5>
    </div>

    <div class="col-md-4 mt-1 mb-1">
        <h4 class="font-weight-bold"> Activité du
            <span class="periode-depense"> <?=  $past->format('d/m/Y').' au '.date('d/m/Y');?></span>
        </h4>
    </div>

    <div class="col-md-4 mt-1 mb-1">

        <div style="position: relative;" class=" d-flex justify-content-end items-center">

               
      <i style="position: absolute; bottom: 10px; right: 15px; font-size: 25px;" class="fa fa-calendar search-date-depense" aria-hidden="true"></i>
        <input type="text" class="form-control search-date-depense" placeholder="Rechercher une periode">
        <input type="hidden" class="search-periode-depense" value="<?= $periode ?>">

        </div>
    </div>
</div>

<div class="row" id="charger-depense">

    <?= chargerBilanDepense($start,$end) ?>
    

    <div class="col-md-12">
    <hr class="py-1 bg-success">
    </div>
</div>

<div class="card mt-2 bg_light">

  <div class="row mx-2 mt-4">

    <div class="col-md-12 mt-2 mb-2">

      <div class="d-flex justify-content-end items-center">

      <div class="form-group">
      <button type="button" data-periode="<?=$periode?>" class="btn btn-default" id="btn_imprimer_liste_depense"> <i class="fa fa-print"></i> IMPRIMER </button>
          
      </div>

      <div class="form-group">
      <button type="button" class="btn btn-info " id="btn_ajouter_depense"> <i
          class="fa fa-plus-circle"></i>&nbsp; &nbsp; Ajouter</button>
      </div>

      </div>
    </div>
  </div>

  

  <div class="card-body  relative mb-5">
    <?= searchFormTable('Liste des depenses') ?>


<div class="row frame-table">
      <div class="col-md-12 content-table">
    <div class="table-responsive table-responsive-md" id="sexion_depense">

      <table class="table table-striped table-bordered  table-hover table-sm " id="tableData">
        <thead class="">
          <tr>
            <th width="1">#</th>
            <th>Date</th>
            <th>Depense</th>
            <th>Description</th>
            <th>Montant</th>
            <th>Statut</th>
            <th>Enregistré par</th>
            <th width="5">Options</th>
          </tr>
        </thead>
        <tbody class="tbody-depense">
          <?= chargerListeDepense($start,$end) ?>
        </tbody>
      </table>
    </div>

     </div>
    </div>
    <div class="col-md-12 display-result mt-5  pt-3" id="rowCounter">
    </div>

  </div>
</div>




<!-- Modal -->
<div class="modal fade" id="depense-modal" data-bs-backdrop="static" tabindex="-1" role="dialog"
  aria-labelledby="depenseModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="depenseModalLabel"><i class="fa fa-user-circle"></i> &nbsp; <span
            class="text-uppercase">Formulaire de Depense</span> </h5>
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
        <button type="submit" form="frm_ajouter_depense" id="btn_add_depense" class="btn btn-primary "> <i
            class="fa fa-check-circle"></i> Enregistrer </button>
      </div><!-- /.modal-footer -->
    </div>
  </div>
</div>

