<?php extract($user);?>




<div class="card mt-3 mb-3">

    <!-- sexion information -->
    <div class="card-body">
        <div class="card-header">
            <h5 class="text-title">Employé #<?= $code_user ?></h5>
        </div>
        <form action="" method="post" id="frm_update_employe" >
            <div class="row mt-2 p-3 mb-3">

                <div class="col-md-4 form-group ">
                    <label>Nom </label>
                    <input type="text" class="form-control" name="nom" value="<?= $nom ?>" >
                </div>

                <div class="col-md-4 form-group ">
                    <label for="telephone_hotel">Prenoms </label>
                    <input type="text" class="form-control" name="prenom" value="<?= $prenom ?>" >
                </div>

                 <div class="col-md-4 form-group ">
                    <label>Email Hotel</label>
                    <input type="email" class="form-control" name="email" value="<?= $email ?>" >
                </div>

                 <div class="col-md-4 form-group ">
                    <label>Contact </label>
                    <input type="text" class="form-control telephone" id="telephone" name="telephone" value="(+225) <?= $telephone ?>" >
                </div>

                <div class="col-md-4 form-group ">
                    <label>Fonction </label>
                     <select class="form-control" name="fonction" id="">
                        <?php foreach($fonctions as $fonction) : ?>
                        <option <?= selected($fonction['code_fonction'],$fonction_id) ?> value="<?= $fonction['code_fonction'] ?>"><?= $fonction['libelle_fonction'] ?></option>
                        <?php endforeach ;?>
                    </select>
                </div>

                <div class="col-md-4 form-group ">
                    <label>Genre </label>
                    <select class="form-control" name="genre" id="">
                        <?php foreach(SEXEP as $sexe) : ?>
                        <option <?= selected($sexe,$sexe) ?> value="<?= $sexe ?>"><?= $sexe ?></option>
                        <?php endforeach ;?>
                    </select>
                </div>

                <div class="col-md-6 form-group ">
                    <label>Matricule </label>
                    <input type="text" class="form-control" value="<?= $matricule ?>" readonly>
                    <input type="hidden" name="code" value="<?= $code_user ?>">
                </div>

                <div class="col-md-6 form-group ">
                    <label>Reference </label>
                    <input type="text" class="form-control" value="<?= $code_user ?>" readonly>
                </div>

                <div class="col-md-12 my-3">
                    <input type="hidden" name="action" value="btn_update_user" >

                    <button disabled type="submit" class="btn btn-info" id="btn_update_user"> <i class="fa fa-save"></i> Enregistrer</button>
                </div>

            </div>
        </form>

        <hr class="bg-primary py-1 mb-3">
        <div class="row mt-3">
            <div class="col-md-12">
                <h1 class="text-title">Roles & Permissions</h1>
            </div>
            <div class="col-md-12">
                <div class="table-responsive table-responsive-md">
                    <table class="table table-condensed table-striped table-bordered  table-hover table-sm table-data">
                        <thead class="">
                            <tr>
                                <th>#</th>
                                <th>ROLE</th>
                                <th>DESCRIPTION</th>
                                <th>➕ AJOUTER</th>
                                <th>👁️ VOIR</th>
                                <th>✏️ MODIFIER</th>
                                <th>📦 SUPPRIMER</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?= chargerListeRolesPermissionUser($code_user) ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="card mt-5 bg_light">

    <div class="row mx-2 mt-4">
        <div class="col-md-5 mt-2 mb-2">
            <h5 class=" text-upper">
                <i class="fa fa-list"></i> &nbsp;Historique des versements
            </h5>
        </div>
    </div>



    <div class="card-body">

        <div class="table-responsive table-responsive-md">

            <table class="table  table-bordered  table-hover table-sm table-data">
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
                    <?= chargerListeVersemenHistoriqueUser($code_user) ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card mt-5 bg_light">

    <div class="row mx-2 mt-4">
        <div class="col-md-5 mt-2 mb-2">
            <h5 class=" text-upper">
                <i class="fa fa-list"></i> &nbsp;Historique des Salaires
            </h5>
        </div>
    </div>



    <div class="card-body">

        <div class="table-responsive table-responsive-md">

            <table class="table  table-bordered  table-hover table-sm table-data">
                <thead class="">
                    <tr>
                        <th width="1">#</th>
                        <th>Enregistrer</th>
                        <th>Employé</th>
                        <th>Mois</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th width="5">Options</th>
                    </tr>
                </thead>
                <tbody id="sexion_versement_comptable">
                    <?= chargerListeSalaireHistoriqueUser($code_user) ?>
                </tbody>
            </table>
        </div>
    </div>
</div> 