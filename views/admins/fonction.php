<div class="row service-fonction">
    <div class="col-md-12">
        <div style="position: relative;" class="card">
            <div class="card-header">
                <ul class="nav nav-pills nav-secondary" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-fonction-tab" data-toggle="pill" href="#pills-fonction"
                            role="tab" aria-controls="pills-fonction" aria-selected="true">
                            &nbsp; &nbsp;
                            <i class="fa fa-user-plus"></i> &nbsp;
                            FONCTIONS
                            &nbsp; &nbsp;
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                            aria-controls="pills-profile" aria-selected="false"> &nbsp; &nbsp;
                            <i class="fa fa-home"></i> &nbsp;
                            SERVICES
                            &nbsp; &nbsp;
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">

                <div class="tab-content mt-2 mb-3" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-fonction" role="tabpanel"
                        aria-labelledby="pills-fonction-tab">
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="button" id="btn_fonction_addModal"
                                    class="btn btn-primary mb-3 w-25 text-uppercase" title="Ajouter fonction"
                                    aria-label="Close"> <i class="fa fa-plus-circle"></i> &nbsp;
                                    Créer</button>

                            </div>
                            <div class="table-responsive">
                                <!-- .table -->
                                <table id="data-table-fonction" class="table table-striped table-hover bg-light">
                                    <!-- thead -->
                                    <thead class="bg-light">
                                        <tr>
                                            <th> # </th>
                                            <th> STATUT </th>
                                            <th> LIBELLE </th>
                                            <th> DESCRIPTION </th>
                                            <th> ENREGISTRER </th>
                                            <th> ACTION </th>
                                        </tr>
                                    </thead><!-- /thead -->
                                </table><!-- /.table -->
                            </div><!-- /.table-responsive -->
                        </div>

                    </div>
                    <div class="tab-pane fade " id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button style="position:absolute" type="button" id="btn_service_addModal"
                                    class="btn btn-primary mb-3 w-25 text-uppercase" title="Ajouter service"
                                    aria-label="Close"> <i class="fa fa-plus-circle"></i> &nbsp;
                                    Créer</button>

                            </div>
                            <div class="table-responsive">
                                <!-- .table -->
                                <table id="data-table-service" class="table table-striped table-hover bg-light">
                                    <!-- thead -->
                                    <thead class="bg-light">
                                        <tr>
                                            <th> # </th>
                                            <th> STATUT </th>
                                            <th> LIBELLE </th>
                                            <th> DESCRIPTION </th>
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




<!-- Modal FONCTION-->
<div class="modal fade" data-backdrop="static" id="fonction-modal" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="fonctionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="fonctionModalLabel"><i class="fa fa-user-circle"></i> &nbsp; <span
                        class="text-uppercase">Formulaire d'enregistrement</span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="data-fonction-modal">

                </div>
            </div>
            <!-- .modal-footer -->
            <div class="modal-footer">

            </div><!-- /.modal-footer -->
        </div>
    </div>
</div>


<!-- Modal SERVICE-->
<div class="modal fade" data-backdrop="static" id="service-modal" data-bs-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="serviceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="serviceModalLabel"><i class="fa fa-user-circle"></i> &nbsp; <span
                        class="text-uppercase">Formulaire d'enregistrement</span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="data-service-modal">

                </div>
            </div>
            <!-- .modal-footer -->
            <div class="modal-footer">

            </div><!-- /.modal-footer -->
        </div>
    </div>
</div>