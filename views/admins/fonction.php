
 <div class="card mb-3">
   <div class="card-body">
     <div class="row">
       <div class="col-md-4">
         <button style="border: none;" type="button" class="btn btn-outline-dark w-50 btn_reload"><i class="fas fa-sync"></i> &nbsp; Mettre à jour</button>
       </div>
       <div class="col-md-8 d-flex justify-content-end">
         <button type="button" data-toggle="modal" data-target="#fonction-modal" class="btn btn-primary w-25" title="Ajouter fonction" aria-label="Close"> <i class="fa fa-plus"></i> &nbsp; Créer</button>
       </div>
     </div>
   </div>
 </div>

 <div class="card">
   <div class="card-body">

     <div class="table-responsive">
       <!-- .table -->
       <table class="table table-striped table-hover my-table bg-light">
         <!-- thead -->
         <thead class="bg-light">
           <tr>
             <th> # </th>
             <th> LIBELLE </th>
             <th> DISPONIBLE </th>
             <th> DATE </th>
             <th width="10%"> ACTION </th>
           </tr>
         </thead><!-- /thead -->
        
         
       </table><!-- /.table -->
     </div><!-- /.table-responsive -->
   </div>
 </div>


 <!-- .modal -->

<!-- Modal -->
<div class="modal fade" data-backdrop="static" id="fonction-modal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="fonctionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="fonctionModalLabel"><i class="fa fa-user-circle"></i> &nbsp; <span class="text-uppercase">Formulaire d'enregistrement</span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="data-modal">
                        <form action="#" method="post" id="frmAddFonction">
                          <!-- <div class="row mb-3"> -->
                              <div class="form-group">
                                  <input type="hidden" value="btn_add_fonction" name="action">
                                  <input type="hidden" value="' . csrfToken()::token() . '" name="csrf_token">
                                  <label for="libelle_fonction" class="form-label">Libelle fonction <strong class="text-danger">*</strong></label>
                                  <input type="text" class="form-control" id="libelle_fonction" name="libelle_fonction" required>
                              </div>
                              <div class="form-group">
                                  <label for="description_fonction" class="form-label">Description</label>
                                  <textarea class="form-control" rows="3" name="description_fonction" id="description_fonction"></textarea>
                              </div>
                               <div class="form-group modal_footer">
                                  <button type="submit" class="btn btn-primary" id="btnSubmitFormFonction"><i class="fas fa-save"></i> &nbsp;  Enregistrer </button>
                                  <button type="button" class="btn btn-light dismiss_modal">Close</button>
                              </div>
                          <!-- </div> -->
                             
                        </form> 
                  </div>
            </div>
            <!-- .modal-footer -->
            <div class="modal-footer">

            </div><!-- /.modal-footer -->
        </div>
    </div>
</div>