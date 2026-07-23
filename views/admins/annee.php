<div class="row semestre-annee">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-pills nav-secondary" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-annee-tab" data-toggle="pill" href="#pills-annee"
                            role="tab" aria-controls="pills-annee" aria-selected="true">
                            &nbsp; &nbsp;
                            <i class="fa fa-calendar"></i> &nbsp;
                            ANNEES
                            &nbsp; &nbsp;
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                            aria-controls="pills-profile" aria-selected="false"> &nbsp; &nbsp;
                            <i class="fa fa-home"></i> &nbsp;
                            SEMESTRES
                            &nbsp; &nbsp;
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">

                <div class="tab-content mt-2 mb-3" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-annee" role="tabpanel"
                        aria-labelledby="pills-annee-tab">
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="button" id="btn_annee_addModal"
                                    class="btn btn-primary mb-3 w-25 text-uppercase" title="Ajouter annee"
                                    aria-label="Close"> <i class="fa fa-plus-circle"></i> &nbsp;
                                    Créer</button>

                            </div>
                            <div class="table-responsive">
                                <!-- .table -->
                                <table id="data-table-annee" class="table table-striped table-hover bg-light">
                                    <!-- thead -->
                                    <thead class="bg-light">
                                        <tr>
                                            <th> # </th>
                                            <th> STATUT </th>
                                            <th> LIBELLE </th>
                                            <th> DEBUT </th>
                                            <th> FIN </th>
                                            <th> ENREGISTRER </th>
                                            <th> ACTION </th>
                                        </tr>
                                    </thead><!-- /thead -->
                                </table><!-- /.table -->
                            </div><!-- /.table-responsive -->
                        </div>

                    </div>
                    <div class="tab-pane fade " id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="row pb-4">
                            <div class="col-md-9 d-flex gap-5 check-semestre-search ">
                                <div class="form-inlign">
                                    <label for="">Annee</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-inlign">
                                    <label for="">Annee</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-inlign">
                                    <label for="">Annee</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3 d-flex justify-content-end">
                                <div class="form-inlign">
                                    <button type="button" id="btn_semestre_addModal"
                                        class="btn btn-primary  text-uppercase" title="Ajouter semestre"
                                        aria-label="Close"> <i class="fa fa-plus-circle"></i> &nbsp;
                                        Créer</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <!-- .table -->
                                <table id="data-table-semestre" class="table table-striped table-hover bg-light">
                                    <!-- thead -->
                                    <thead class="bg-light">
                                        <tr>
                                            <th> # </th>
                                            <th> STATUT </th>
                                            <th> ANNEE </th>
                                            <th> LIBELLE </th>
                                            <th> DEBUT </th>
                                            <th> FIN </th>
                                            <th> ENREGISTRER </th>
                                            <th> ACTION </th>
                                        </tr>
                                    </thead><!-- /thead -->


                                </table><!-- /.table -->
                            </div><!-- /.table-responsive -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>




<!-- Modal annee-->
<div class="modal fade" data-backdrop="static" id="annee-modal" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="anneeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="anneeModalLabel"><i class="fa fa-user-circle"></i> &nbsp; <span
                        class="text-uppercase">Formulaire d'enregistrement</span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="data-annee-modal">

                </div>
            </div>
            <!-- .modal-footer -->
            <div class="modal-footer">

            </div><!-- /.modal-footer -->
        </div>
    </div>
</div>


<!-- Modal semestre-->
<div class="modal fade" data-backdrop="static" id="semestre-modal" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="semestreModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="semestreModalLabel"><i class="fa fa-user-circle"></i> &nbsp; <span
                        class="text-uppercase">Formulaire d'enregistrement</span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="data-semestre-modal">

                </div>
            </div>
            <!-- .modal-footer -->
            <div class="modal-footer">

            </div><!-- /.modal-footer -->
        </div>
    </div>
</div>