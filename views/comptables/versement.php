<?php 
  $today = new DateTime();
  // Date 25 jours en arrière
  $past = (new DateTime())->sub(new DateInterval('P31D'));


  $start = $past->format('Y-m-d 00:00:00');
  $end   = $today->format('Y-m-d 23:59:59');
  $periode = crypter($start."#".$end);

 ?>


<div class="row mt-4 mb-5">
    <div class="col-md-4 mt-1 mb-1">
        <h5 class="text-upper text-title2">
            <i class="fa fa-list"></i> Gestion des caisses et dépôts
        </h5>
    </div>

    <div class="col-md-4 mt-1 mb-1">
        <h4 class="font-weight-bold"> Activité du
            <span class="periode-depot-caisse"> <?= $past->format('d/m/Y').' au '.date('d/m/Y');?></span>
        </h4>
    </div>

    <div class="col-md-4 mt-1 mb-1">

        <div style="position: relative;" class=" d-flex justify-content-end items-center">

            <i style="position: absolute; bottom: 10px; right: 15px; font-size: 25px;"
                class="fa fa-calendar search-date-depot-caisse" aria-hidden="true"></i>
            <input type="text" class="form-control search-date-depot-caisse" placeholder="Selectionner une date">
            <input type="hidden" class="search-periode-depot" value="<?= $periode ?>">

        </div>
    </div>
</div>


<div class="row" id="caisse-depot">
    <div class="col-md-12 mb-2">
        <h3 class="text-primary">
            Etat de la caisse
        </h3>
    </div>

    <?= chargerVersementCaisseDepotComptable($start,$end) ?>


    <div class="col-md-12">
        <hr class="py-1 bg-info">
    </div>
</div>



<div class="card mt-2 bg_light">

    <div class="row mx-2 mt-4">
        <div class="col-md-5 mt-2 mb-2">
            <h5 class=" text-upper">
                <i class="fa fa-list"></i> &nbsp;Historique des versements
            </h5>
        </div>

        <div class="col-md-7 mt-2 mb-2">

            <div class="d-flex justify-content-end items-center">
                <div class="form-group">
                    <button type="button" data-periode="<?=$periode?>" class="btn btn-default"
                        id="btn_imprimer_liste_versement"> <i class="fa fa-print"></i> IMPRIMER </button>
                </div>

            </div>
        </div>
    </div>



    <div class="card-body relative mb-5">
    <?= searchFormTable('Liste des versements') ?>

     <div class="row frame-table">
      <div class="col-md-12 content-table">
        <div class="table-responsive table-responsive-md">

            <table class="table  table-bordered  table-hover table-sm "  id="tableData">
                <thead class="">
                    <tr>
                        <th width="1">#</th>
                        <th>Ouverture</th>
                        <th>Cloture</th>
                        <th>Statut</th>
                        <th>Caisse</th>
                        <th>Recette</th>
                        <th>Depot</th>
                        <th>Versement</th>
                        <th width="5">Options</th>
                    </tr>
                </thead>
                <tbody id="sexion_versement_comptable">
                    <?= chargerListeVersementCaisseDepotUserComptable($start,$end) ?>
                </tbody>
            </table>
        </div>
         </div>
    </div>
    <div class="col-md-12 display-result mt-5  pt-3" id="rowCounter">
    </div>
    </div>
</div>