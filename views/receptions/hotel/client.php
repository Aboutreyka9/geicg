<?php 

    $today = new DateTime();
    // Date 25 jours en arrière
    $past = (new DateTime())->sub(new DateInterval('P31D'));
    $start = $past->format('Y-m-d 00:00:00');
    $end   = $today->format('Y-m-d 23:59:59');
    $periode = crypter($start."#".$end);

// $dateDebut

// (new DateTime('first day of this month'))->format('d-m-Y').' au '.date('d-m-Y');
 ?>
<div class="card mt-2 bg_light">

  <div class="row mx-2 mt-4">
    <div class="col-md-5 mt-2 mb-2">
      <h5 class="card-title text-upper">
        <i class="fa fa-list"></i> &nbsp;Liste des clients
      </h5>
      <span class="pl-4">periode du</span>
      <span class="periode-client"> <?= $past->format('d-m-Y').' au '.date('d-m-Y');?></span>
    </div>

    <div class="col-md-7 mt-2 mb-2">

      <div class="d-flex justify-content-end items-center">

        <!-- <div class="form-group">
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#chambre-modal"> <i class="fa fa-file-excel"></i> EXCEL </button>
          
      </div> -->

        <div class="form-group">
          <button type="button" data-periode="<?=$periode?>" class="btn btn-default" id="btn_imprimer_liste_client"> <i
              class="fa fa-print"></i> IMPRIMER </button>

        </div>

        <div style="position: relative;" class="form-group col-md-5">

          <i style="position: absolute; bottom: 20px; right: 15px; font-size: 28px;"
            class="fa fa-calendar search-date-client" aria-hidden="true"></i>

          <input type="text" class="form-control search-date-client" placeholder="Rechercher une periode">
        </div>

      </div>
    </div>
  </div>

  <div class="card-body relative mb-5">
    <?= searchFormTable('Liste des clients') ?>

    <div class="row frame-table">
      <div class="col-md-12 content-table">
        <div class="table-responsive table-responsive-md" id="sexion_client">

          <table class="table table-striped table-bordered table-sm " id="tableData">
            <thead class="">
              <tr>
                <th>#</th>
                <th>Nom & prenoms</th>
                <th>Contact</th>
                <th>Civilité</th>
                <th>Piece</th>
                <th>Enregistrer</th>
                <th width="6%">Options</th>
              </tr>
            </thead>
            <tbody class="tbody-client">
              <?= chargerListeClient($start,$end) ?>
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
<div class="modal fade" id="chambre-modal" data-bs-backdrop="static" tabindex="-1" role="dialog"
  aria-labelledby="chambreModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="chambreModalLabel"><i class="fa fa-user-circle"></i> &nbsp; <span
            class="text-uppercase">Chambre</span> </h5>
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
        <button type="submit" form="frmAddAhambre" id="btn_ajouter_chambre" class="btn btn-primary "> <i
            class="fa fa-check-circle"></i> Enregistrer </button>
      </div><!-- /.modal-footer -->
    </div>
  </div>
</div>