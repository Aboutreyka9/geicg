
<?php 

  $todayIn   = date('Y-m-d');
  $etat = 0;
  $periode = crypter($todayIn."#".$etat);

  headerMenuReservation('search-date-reservation',$periode,'btn_imprimer_liste_check_reservation');
 ?>


  <div class="card-body relative mb-5">

<?= searchFormTableComon('Liste des reservations') ?>

  <div class="row frame-table">
      <div class="col-md-12 content-table">
    <div class="table-responsive table-responsive-md" id="sexion_reservation">

      <table class="table table-striped table-bordered  table-hover table-sm tableData">
        <thead class="bg-grad-success">
          <tr>
            <th width="1">#</th>
             <th width="15%">Enregistrer</th>
            <th>statut</th>
            <th>Nom client</th>
            <th>Contact</th>
            <th>Chambre</th>
            <th>Nb jours</th>
            <th>Montant</th>
            <th width="5">Options</th>
          </tr>
        </thead>
        <tbody class="tbody-reservation">
          <?= chargerListeReservationArrive() ?>
        </tbody>
      </table>
    </div>
       </div>
    </div>
    <div class="col-md-12 display-result mt-5  pt-3 rowCounter">
    </div>
  </div>

<!-- </div> -->


