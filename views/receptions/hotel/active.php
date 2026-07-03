
<?php 
  $today = new DateTime();
  // Date 25 jours en arrière
  $past = (new DateTime())->sub(new DateInterval('P31D'));


  $start = $past->format('Y-m-d 00:00:00');
  $end   = $today->format('Y-m-d 23:59:59');
  $periode = crypter($start."#".$end);

  headerMenuReservation('search-date-reservation-active',$periode,'btn_imprimer_liste_reservation_active'); 

 ?>

  <div class="card-body relative mb-5">

<?= searchFormTableComon('Liste des reservations') ?>

  <div class="row frame-table">
      <div class="col-md-12 content-table">
    <div class="table-responsive table-responsive-md" id="sexion_reservation">

      <table class="table table-striped table-bordered  table-hover table-sm tableData">
        <thead class="">
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
          <?= chargerListeReservationActive() ?>
        </tbody>
      </table>
    </div>
       </div>
    </div>
    <div class="col-md-12 display-result mt-5  pt-3 rowCounter">
    </div>
  </div>





<!-- Modal -->
<div class="modal fade" id="reservation-modal" data-bs-backdrop="static" tabindex="-1" role="dialog"
  aria-labelledby="reservationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="reservationModalLabel"><i class="fa fa-user-circle"></i> &nbsp; <span
            class="text-uppercase">Formulaire de Reservation</span> </h5>
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
        <button type="submit" form="frm_ajouter_reservation" id="btn_confirme_reservation" class="btn btn-primary "> <i
            class="fa fa-check-circle"></i> Enregistrer </button>
      </div><!-- /.modal-footer -->
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="reservation-modifier-modal" data-bs-backdrop="static" tabindex="-1" role="dialog"
  aria-labelledby="reservationModifierModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="reservationModifierModalLabel"><i class="fa fa-user-circle"></i> &nbsp;
          <span class="text-uppercase">Formulaire de Reservation</span> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row ">
          <div class="col-md-12 data-modifier-modal">

          </div>
        </div>
      </div>
      <!-- .modal-footer -->
      <div class="modal-footer">
        <button type="submit" form="frm_modfier_reservation" id="btn_modifier_reservation" class="btn btn-primary "> <i
            class="fa fa-check-circle"></i> Enregistrer </button>
      </div><!-- /.modal-footer -->
    </div>
  </div>
</div>

<div class="modal fade" id="service-modal" data-bs-backdrop="static" tabindex="-1" role="dialog"
  aria-labelledby="serviceModifierModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="serviceModifierModalLabel"><i class="fa fa-user-circle"></i> &nbsp; <span
            class="text-uppercase">Formulaire Service</span> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row ">
          <div class="col-md-12 data-service-modal">

          </div>
        </div>
      </div>
      <!-- .modal-footer -->
      <div class="modal-footer">
        <button type="submit" form="frmAttrServiceForReservation" disabled class="btn btn-primary btn_attr_service"> <i
            class="fa fa-check-circle"></i> Enregistrer </button>
      </div><!-- /.modal-footer -->
    </div>
  </div>
</div>