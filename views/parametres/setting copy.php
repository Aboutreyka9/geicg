<div class="row">
    <div class="col-md-12">

        <div class="row">
            <!-- sexion image -->
            <div class="col-md-3 ">
                <div class="card">
                    <div class="card-header">
                        <h5 class="">Logo de l'hotel</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-12 mt-1 mb-3">
                                <img id="btn_trigger_input_file" class="previewImg logo_hotel" src="<?= ASSETS  . $hotel['logo_hotel'] ?>" alt="">
                            </div>
                            <div class="col-md-12 mt-2 mb-1">
                            <form id="uploadForm" enctype="multipart/form-data">
                                <input accept="image/jpeg, image/png, image/jpg" hidden type="file" id="fileInput" class="form-control" name="image_logo">
                                <input type="hidden" name="action" value="btn_upload_logo">
                                <button disabled type="submit" form="uploadForm"  id="btn_update_logo"  class="btn btn-primary btn-sm"><i class="fa fa-camera fa-lg"></i> &nbsp;
                                    Changer</button>
                            </form>
                            </div>
                        </div>
                        <hr>
                        <div class="row text-center">
                            <div class="col-md-12 mt-2 mb-3">
                                <ul class="list-group">
                                    <li class="list-group-item text-bold">ABONEMENT : <span class="badge bg-success"> Activer</span></li>
                                    <li class="list-group-item text-bold"> VALIDITE : <span class=""> 3 ANS</span></li>
                                    <li class="list-group-item text-bold">EXPIRE LE : <span class=""> 10/10/2025</span></li>
                                </ul>
                               
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- sexion information -->
            <div class="col-md-9">

                <div class="card">
                    <form action="" method="post" id="form_update_hotel">
                        <div class="row mx-1">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="libelle_hotel">Nom Hotel</label>
                                    <input type="text" class="form-control" name="libelle_hotel" value="<?= $hotel['libelle_hotel'] ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telephone_hotel">Contact 1 </label>
                                    <input type="text" class="form-control" name="telephone_hotel" value="<?= $hotel['telephone_hotel'] ?>" required>
                                </div>
                            </div>

                        </div>
                        <div class="row mx-1">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telephone_hotel2">Contact 2 </label>
                                    <input type="text" class="form-control" name="telephone_hotel2" value="<?= $hotel['telephone_hotel2'] ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email_hotel">Email Hotel</label>
                                    <input type="text" class="form-control" name="email_hotel" value="<?= $hotel['email_hotel'] ?>">
                                </div>
                            </div>

                        </div>

                        <div class="row mx-1">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="statut_filigramme">
                                        <input value="1" type="checkbox" name="statut_filigramme" id="statut_filigramme" <?= checked( $hotel['statut_filigramme'], 1) ?> >
                                        <span>Activer filigramme</span>
                                    </label>

                                        <input value="<?= $hotel['filigramme'] ?>" type="text" class="form-control" name="filigramme" id="filigramme" maxlength="15" placeholder="Filigramme">
                                </div>
                            </div>
                        </div>

                        <div class="row mx-1">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="adresse_hotel">Adresse Hotel</label>
                                    <textarea name="adresse_hotel" id="adresse_hotel" class="form-control" rows="4"><?= $hotel['adresse_hotel'] ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row mx-3 my-2">
                        <div class="col-md-12 mt-3 mb-3">
                            <input type="hidden" name="action" value="update_hotel">
                            <button disabled type="submit" id="form_update_hotel" class="btn btn-info btn_update_hotel"> <i class="fa fa-save"></i> &nbsp;
                                Enregistrer</button>
                        </div>
                        </div>
                    </form>
                </div>

            </div>

        </div><!-- end row -->
    </div>
</div>