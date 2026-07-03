<?php 
  $today = new DateTime();
  // Date 1 jour du mois
  $firstDay = new DateTime('first day of this month');

//   $past = (new DateTime())->sub(new DateInterval('P31D'));


  $start = $firstDay->format('Y-m-d 00:00:00');
  $end   = $today->format('Y-m-d 23:59:59');
  $periode = crypter($start."#".$end);

 ?>


<div class="row mt-4 mb-5" >
    <div class="col-md-4 mt-1 mb-1">
        <h5 class="text-upper text-title2">
            <i class="fa fa-list"></i> Gestion des caisses
        </h5>
    </div>

    <div class="col-md-4 mt-1 mb-1">
        <h4 class="font-weight-bold"> Activité du
            <span class="periode-caisse"> <?= $firstDay->format('d/m/Y').' au '.date('d/m/Y');?></span>
        </h4>
    </div>

    <div class="col-md-4 mt-1 mb-1">

        <div style="position: relative;" class=" d-flex justify-content-end items-center">

            <i style="position: absolute; bottom: 10px; right: 15px; font-size: 25px;"
                class="fa fa-calendar search-date-bilan-caisse" aria-hidden="true"></i>
            <input type="text" class="form-control search-date-bilan-caisse" placeholder="Selectionner une date">

        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12 mb-2">
        <h3 class="text-primary">
             Etat de la caisse
        </h3>
    </div>

    <?= chargerBilanCaisseComptable($start,$end) ?>
    

    <div class="col-md-12">
    <hr class="py-1 bg-info">
    </div>
</div>

<div class="row mt-2 mb-2">
<div class="col-md-12 mb-2">
        <h3 class="text-primary">
             Etat des caisse reservations & services
        </h3>
    </div>

    <?= chargerDetailsBilanCaisseComptable($start,$end) ?>
    
</div>
<hr class="py-2 bg-info">

<!-- CHART JS SEXION -->

<div class="row pt-3 pb-5" id="dashboard-bilan">
    <div  class="col-md-12 pt-3 pb-5">
        <div style="background-color: #ffe;" class="card ">
            <div class="card-body p-5 ">
                <div class="mb-3">
                    <label for=""> Selectioner l'année d'activité</label>
                    <select style="border: solid #c5c5c5 1px;" id="search-year-activity"  class="form-control" name="" id="">
                        <option value="2022">2022</option>
                        <option value="2025">2025</option>
                    </select>

                </div>
                <div class="chart-containe" style="height:500px">
                    <canvas id="mycanva"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>



