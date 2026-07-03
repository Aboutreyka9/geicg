
<?php 

  $todayOut   = date('Y-m-d');
  $etat = 1;
  $periode = crypter($todayOut."#".$etat);
headerMenuReservation('search-date-reservation',$periode,'btn_imprimer_liste_check_reservation'); 
 ?>

  <div class="card-body relative mb-5">

<?= searchFormTableComon('Liste des reservations') ?>

  <div class="row frame-table">
      <div class="col-md-12 content-table">
    <div class="table-responsive table-responsive-md" id="sexion_reservation">

      <table class="table table-striped table-bordered  table-hover table-sm tableData">
        <thead class="bg-grad-warning">
          <tr>
            <th width="1">#</th>
            <th width="15%">Enregistrer</th>
            <th>Client</th>
            <th>Cat/Chambre</th>
            <th>Periode</th>
            <th>Montant</th>
            <th width="5">Options</th>
          </tr>
        </thead>
        <tbody class="tbody-reservation">
          <?= chargerListeReservationCheckOut($todayOut) ?>
        </tbody>
      </table>
    </div>
       </div>
    </div>
    <div class="col-md-12 display-result mt-5  pt-3 rowCounter">
    </div>
  </div>
