
<?php 
  $today = new DateTime();
  // Date 25 jours en arrière
  $past = new DateTime('first day of this month');


  $start = $past->format('Y-m-d 00:00:00');
  $end   = $today->format('Y-m-d 23:59:59');
  $periode = crypter($start."#".$end);

 ?>




<div class="card mt-2" id="recapt-data-depense">

   <div class="row mx-2 mt-4">
    <div class="col-md-5 mt-2 mb-2">
      <h5 class="card-title text-upper">
        <i class="fa fa-list"></i> &nbsp;Liste des depenses
      </h5>
      <span class="pl-4">Date du</span>
      <span class="periode-depense"> <?=  $past->format('d/m/Y').' au '.date('d/m/Y');?> </span>
    </div>

    <div class="col-md-7 mt-2 mb-2">

      <div class="d-flex justify-content-end items-center">

      <div class="form-group">
      <button type="button" data-periode="<?=$periode?>" class="btn btn-default" id="btn_imprimer_liste_depense"> <i class="fa fa-print"></i> IMPRIMER </button>
          
      </div>

      <div  style="position: relative;" class="form-group col-md-5">

      
      <i style="position: absolute; bottom: 20px; right: 15px; font-size: 28px;" class="fa fa-calendar search-date-depense" aria-hidden="true"></i>
        <input type="text" class="form-control search-date-depense" placeholder="Rechercher une periode">

      </div>

      </div>
    </div>
  </div>
  

  <div class="card-body relative mb-5">
     <div class="row d-flex justify-content-between  items-center m-2 p-1">

      <div class="col-md-6">
        <h4 class="text-bold"> <span style="cursor: pointer;" class="synchroniser"><i class="fa fa-redo"></i></span> &nbsp; Liste des depenses [ <span
            id="counter_items">0</span> ] </h4>
      </div>
      <div class="col-sm-12 col-md-4">

        <input type="search" class="form-control" id="searchInput" placeholder="Recherche...">
        </label>
      </div>
    </div>

<div class="row frame-table">
      <div class="col-md-12 content-table">
    <div class="table-responsive table-responsive-md" id="sexion_depense">

      <table class="table table-striped table-bordered  table-hover table-sm "  id="tableData">
        <thead class="">
          <tr>
            <th width="1">#</th>
            <th>Date</th>
            <th>Depense</th>
            <th>Description</th>
            <th>Montant</th>
            <th>Statut</th>
            <th>Enregistré par</th>
          </tr>
        </thead>
        <tbody id="tbody-depense">
          <?= chargerRecaptListeDepense($start,$end) ?>
        </tbody>
      </table>
    </div>

    </div>
    </div>
    <div class="col-md-12 display-result mt-5  pt-3" id="rowCounter">
    </div>
  </div>
</div>


