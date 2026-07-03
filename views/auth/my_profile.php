<?php extract($user);?>




<div class="card mt-3 mb-3">

    <!-- sexion information -->
    <div class="card-body">
        <div class="card-header">
            <h5 class="text-title">Employé : <?= $code_user ?> </h5>
        </div>
        <form method="post" action=""> 
        <div class="row mt-2 p-3">

            <div class="col-md-4">
                <div class="form-group">
                    <label>Nom </label>
                    <input type="text" class="form-control" value="<?= $nom ?>" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="telephone_hotel">Prenoms </label>
                    <input type="text" class="form-control" value="<?= $prenom ?>" readonly>
                </div>
            </div>
              <div class="col-md-4">
                <div class="form-group">
                    <label>Contact </label>
                    <input type="text" class="form-control telephone" value="(+225) <?= $telephone ?>" readonly>
                </div>
            </div>

            <div class="col-md-4 ">
                <div class="form-group">
                    <label>Fonction </label>
                    <input type="text" class="form-control" value="<?= $libelle_fonction ?>" readonly>
                </div>
            </div>

          

            <div class="col-md-4">
                <div class="form-group">
                    <label>Matricule </label>
                    <input type="text" class="form-control" value="<?= $matricule ?>" readonly>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Genre </label>
                    <input type="text" class="form-control" value="<?= $sexe ?>" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div style="position: relative;" class="form-group">

                    <label>Email Hotel</label>
                    <i style="position: absolute; right:12px; bottom: 25px;" class=" fa fa-edit fa-lg text-primary"></i>
                    <input type="email" class="form-control" name="email_hotel" value="<?= $email ?>" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>#Reference </label>
                    <input type="text" class="form-control" value="<?= $code_user ?>" readonly>
                </div>
            </div>


        </div>
</form>
    </div>

</div>