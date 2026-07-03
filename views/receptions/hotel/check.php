<?php 
  $today = new DateTime();
  // Date 25 jours en arrière
  $past = (new DateTime())->sub(new DateInterval('P31D'));


  $start = $past->format('Y-m-d 00:00:00');
  $end   = $today->format('Y-m-d 23:59:59');
  // $periode = crypter($start."#".$end);

  $today   = date('Y-m-d');
  $etat = 0;
  $periode = crypter($start."#".$end."#".$etat);

 ?>

<div class="card mt-2 bg_light h-300">

  <div class="row">
    <div class="col-md-12">
      <ul class="nav nav-tabs mx-3 mt-4 pb-2">
        <li class="<?= showHtmlElement($data['show'],'in','tabs_menu') ?>" >
          <a class="text-uppercase" data-toggle="tab" href="#checkIn"> <i
          class="fa fa-plus-circle"></i>&nbsp; &nbsp; arrivées</a>
        </li>
         <li class="<?= showHtmlElement($data['show'],'out','tabs_menu') ?>">
          <a class="text-uppercase " data-toggle="tab" href="#checkOut"> <i
          class="fa fa-plus-circle"></i>&nbsp; &nbsp; sorties</a>
        </li>
        <li class="<?= showHtmlElement($data['show'],'history','tabs_menu') ?>">
          <a class="text-uppercase " data-toggle="tab"  href="#checkHistory"> <i
          class="fa fa-plus-circle"></i>&nbsp; &nbsp; histiriques</a>
        </li>
        <li class="bg-grad-primary">
          <a class="text-uppercase " href="<?=  route('hotel.add.reservation')?>"><i
          class="fa fa-plus-circle"></i>&nbsp; &nbsp; Enregistrer</a>
        </li>
      </ul>

      <div class="tab-content">
        <div id="checkIn" class="tab-pane fade <?= showHtmlElement($data['show'],'in') ?>">
          <?php include 'checkin.php' ?>

        </div>
        <div id="checkOut" class="tab-pane fade <?= showHtmlElement($data['show'],'out') ?>">
          <?php include 'checkout.php' ?>

        </div>
        <div id="checkHistory" class="tab-pane fade <?= showHtmlElement($data['show'],'history') ?>">
          <?php  include 'historique_reservation.php' ?>

        </div>
      </div>

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
