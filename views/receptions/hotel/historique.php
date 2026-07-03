
<?php 
  $today = new DateTime();
  // Date 25 jours en arrière
  $past = (new DateTime())->sub(new DateInterval('P31D'));


  $start = $past->format('Y-m-d 00:00:00');
  $end   = $today->format('Y-m-d 23:59:59');
  $periode = crypter($start."#".$end);
headerMenuReservation('search-date-reservation',$periode,'btn_imprimer_liste_reservation');
 ?>

  
  <div class="card-body relative mb-5">

<?= searchFormTableComon('Liste des reservations') ?>

  <div class="row frame-table">
      <div class="col-md-12 content-table">
    <div class="table-responsive table-responsive-md" id="sexion_reservation">

      <table class="table table-striped table-bordered  table-hover table-sm tableData">
        <thead class="bg-grad-primary">
          <tr>
            <th width="1">#</th>
            <th width="15%">Date</th>
            <th>statut</th>
            <th>Client</th>
            <th>Chambre</th>
            <th>Service</th>
            <th>Montant</th>
            <th width="5">Options</th>
          </tr>
        </thead>
        <tbody class="tbody-reservation">
          <?= chargerListeReservation() ?>
        </tbody>
      </table>
    </div>
       </div>
    </div>
    <div class="col-md-12 display-result mt-5  pt-3 rowCounter">
    </div>
  </div>

