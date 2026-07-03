


<div class="row mt-4 mb-4">
    <div class="col-md-12 mt-1 mb-1">
        <h5 class="text-upper text-title2">
            <i class="fa fa-list"></i> Liste des reservations annulées
        </h5>
    </div>

</div>



<div class="card mt-1 bg_light">

  <div class="card-body">

    <div class="table-responsive table-responsive-md" >

      <table class="table table-striped table-bordered  table-hover table-sm table-data">
        <thead class="">
          <tr>
           <th>#</th>
            <th>Date</th>
            <th>Client</th>
            <th>N° Chambre</th>
            <th>Prix/Nuit</th>
            <th>Nb jour</th>
            <th>Montant Total</th>
            <th>Enregistrer par</th>
          </tr>
        </thead>
        <tbody>
          <?= chargerListeReservationAnnuler() ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

