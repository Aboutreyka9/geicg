<?php 
  $today = new DateTime();
  // Date 25 jours en arrière
  $past = (new DateTime())->sub(new DateInterval('P31D'));


  $start = $past->format('Y-m-d 00:00:00');
  $end   = $today->format('Y-m-d 23:59:59');
  $periode = crypter($start."#".$end);

 ?>

<div class="card mt-2 bg_light h-300">

  <div class="row mx-2 mt-2">
    <div class="col-md-6 mt-2 mb-2">
      <h5 class="card-title text-upper">
        <i class="fa fa-list"></i> &nbsp;Espace Reservations
      </h5>
      <span class="pl-4">periode du</span>
      <span class="periode-reservation"> <?= $past->format('d-m-Y').' au '.date('d-m-Y');?></span>
    </div>

    <div class="col-md-6 mt-2 mb-2">

      <div class="d-flex justify-content-end items-center">

        <div class="form-group">
          <a href="<?=  route('hotel.add.reservation')?>" class="btn btn-info "> <i class="fa fa-plus-circle"></i>&nbsp;
            &nbsp; Enregistrer</a>
        </div>

      </div>
    </div>

  </div>


  <div class="row">
    <div class="col-md-12">
      <ul class="nav nav-tabs mx-3 mt-4 pb-2">
         <li class="<?= showHtmlElement($data['show'],'','tabs_menu') ?>" >
          <a class="text-uppercase" data-toggle="tab" href="#enCour"> <i
          class="fa fa-plus-circle"></i>&nbsp; &nbsp; en cour</a>
        </li>
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
      </ul>

      <div class="tab-content">
        <div id="enCour" class="tab-pane fade <?= showHtmlElement($data['show'],'') ?>">
          <?php include 'active.php' ?>

        </div>
        <div id="checkIn" class="tab-pane fade <?= showHtmlElement($data['show'],'in') ?>">
          <?php include 'arrive.php' ?>

        </div>
        <div id="checkOut" class="tab-pane fade <?= showHtmlElement($data['show'],'out') ?>">
          <?php include 'sortie.php' ?>

        </div>
        <div id="checkHistory" class="tab-pane fade <?= showHtmlElement($data['show'],'history') ?>">
          <?php  include 'historique.php' ?>

        </div>
      </div>

    </div>
  </div>

</div>