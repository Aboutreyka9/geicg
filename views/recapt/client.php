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
<div class="card mt-2 bg_light" id="recapt-data-client">
   
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

      <div class="form-group">
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#chambre-modal"> <i class="fa fa-file-excel"></i> EXCEL </button>
          
      </div>

      <div class="form-group">
      <button type="button" data-periode="<?=$periode?>" class="btn btn-default" id="btn_imprimer_liste_client"> <i class="fa fa-print"></i> IMPRIMER </button>
          
      </div>

      <div  style="position: relative;" class="form-group col-md-5">
    
      <i style="position: absolute; bottom: 20px; right: 15px; font-size: 28px;" class="fa fa-calendar search-date-client" aria-hidden="true"></i>
      
        <input type="text" class="form-control search-date-client" placeholder="Rechercher une periode">
      </div>
      
      </div>
    </div>
    </div>

    <div class="card-body relative mb-5">

    <div class="row d-flex justify-content-between  items-center m-2 p-1">

      <div class="col-md-6">
        <h4 class="text-bold"> <span style="cursor: pointer;" class="synchroniser"><i class="fa fa-redo"></i></span> &nbsp; Liste des clients [ <span
            id="counter_items">0</span> ] </h4>
      </div>
      <div class="col-sm-12 col-md-4">

        <input type="search" class="form-control" id="searchInput" placeholder="Recherche...">
        </label>
      </div>
    </div>

    
<div class="row frame-table">
      <div class="col-md-12 content-table">
      <div class="table-responsive table-responsive-md"  id="sexion_client">
     
      <table class="table table-striped table-bordered table-sm "  id="tableData">
          <thead class="">
          <tr>
              <th >#</th>
              <th >Nom & prenoms</th>
              <th >Contact</th>
              <th >Civilité</th>
              <th >Piece</th>
              <th >Enregistrer</th>
            </tr>
          </thead>
          <tbody class="tbody-client">
                <?= chargerRecaptListeClient() ?>
          </tbody>
        </table>
      </div>

      </div>
    </div>
    <div class="col-md-12 display-result mt-5  pt-3" id="rowCounter">
    </div>
    </div>
  </div>






