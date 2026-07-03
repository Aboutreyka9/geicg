<?php $start = date("Y-01-01 00:00:00"); $end = date("Y-12-31 23:59:59"); ?>
<?php if(auth()::hasGroupe(Groupes::SUPER)) : ?>


<div class="row mt-5 mb-2">
    <?= chargerBilanCaisseComptable($start,$end) ?>

</div>
<hr class="bg-info ">

<div class="row mt-2 mb-2">
  <?= chargerDashboardAdmin() ?>
  
</div>
<hr class="bg-grad-secondary py-1">


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
<hr class="py-1">

<?php endif; ?>
<?php if(auth()::hasGroupe(Groupes::RECEPTION)) : ?>
    <div class="row mt-5 mb-2">
    <?= chargerReceptionRecap() ?>

</div>
<hr class="bg-info mb-2">
<?php endif; ?>


<div class="row mt-4">
  <?= chargerDashboardAdminItem() ?>
  
</div>