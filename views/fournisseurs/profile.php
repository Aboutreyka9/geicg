<div class="mt-2 mb-4">
    <div class="card">
        <div class="card-header">
            <h3>Profile</h3>
        </div>
        <div class="card-body">
            <form method="post" action="" id="form_update_client">
                <div class="row">
                    <div class="col-md-8 mb-2 mt-2">

                        <label class="mb-1" for="nom">Nom client <i class="fa fa-user"></i> </label>
                        <input type="text" name="nom" class="form-control" value="<?= $client['nom_client']; ?>">

                    </div>
                    <div class="col-md-4 mb-2 mt-2">

                        <label class="mb-1" for="telephone">Contact <i class="fa fa-phone"></i> </label>
                        <input type="text" name="telephone" class="form-control telephone"
                            value="<?= $client['telephone_client']; ?>">

                    </div>
                    <div class="col-md-4 mb-2 mt-2">
                        <label class="mb-1" for="type_piece">Type piece <i class="fa fa-id-card"></i> </label>
                        <select name="type_piece" class="form-control select" id="">
                            <option value="">---CHOISIR---</option>
                            <?php foreach (PIECES_DATA as $tp) : ?>
                                <option <?= selected($client['type_piece'], $tp) ?> value="<?= $tp; ?>"><?= $tp; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-2 mt-2">

                        <label class="mb-1" for="piece">Piece <i class="fa fa-id-card"></i> </label>
                        <input type="text" name="piece" class="form-control" value="<?= $client['piece_client']; ?>">

                    </div>


                    <div class="col-md-4 mb-2 mt-2">
                        <label class="mb-1" for="genre">Genre <i class="fa fa-id-card"></i> </label>
                        <select name="genre" class="form-control select" id="">
                            <option value="">---CHOISIR---</option>
                            <?php foreach (SEXEP as $genre) : ?>
                                <option <?= selected($client['genre_client'], $genre) ?> value="<?= $genre; ?>"><?= $genre; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mt-3 mb-2">
                        <input type="hidden" name="code_client" value="<?= $client['code_client']; ?>">
                        <input type="hidden" name="action" value="btn_update_client">
                        <button disabled type="submit" class="btn btn-info w-75" form="form_update_client" id="btn_update_client"> <i class="fa fa-save"> Enregistrer</i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <hr class="bg-warning py-1">
    </div>
</div>

<div class=" mt-4">
    <div class="card">
        <div class="card-header ">
            <h3>Liste des reservations</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive table-responsive-md" id="">

                        <table class="table table-striped table-bordered  table-hover table-sm">
                            <thead class="">

                                <tr>
                                    <th width="1">#</th>
                                    <th width="15%">Date</th>
                                    <th>statut</th>
                                    <th>Chambre</th>
                                    <th>Service</th>
                                    <th>Montant</th>
                                    <th width="5">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?= chargerListeReservationClient($client['code_client']) ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="reservation-modal" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="reservationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="reservationModalLabel"><i class="fa fa-user-circle"></i> &nbsp; <span
                        class="text-uppercase">Formulaire de Reservation</span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row ">
                    <div class="col-md-12 data-modal">

                    </div>
                </div>
            </div>
            <!-- .modal-footer -->
            <div class="modal-footer">
                <button type="submit" form="frm_ajouter_reservation" id="btn_confirme_reservation" class="btn btn-primary "> <i
                        class="fa fa-check-circle"></i> Enregistrer </button>
            </div><!-- /.modal-footer -->
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
                    <span class="text-uppercase">Formulaire de Reservation</span>
                </h5>
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

<div class="modal fade" id="service-modal" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="serviceModifierModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="serviceModifierModalLabel"><i class="fa fa-user-circle"></i> &nbsp; <span
                        class="text-uppercase">Formulaire Service</span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row ">
                    <div class="col-md-12 data-service-modal">

                    </div>
                </div>
            </div>
            <!-- .modal-footer -->
            <div class="modal-footer">
                <button type="submit" form="frmAttrServiceForReservation" disabled class="btn btn-primary btn_attr_service"> <i
                        class="fa fa-check-circle"></i> Enregistrer </button>
            </div><!-- /.modal-footer -->
        </div>
    </div>
</div>