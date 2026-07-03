<div class="card mt-2 bg_light">
    <div class="card-header bg-dark text-light">
      <div class="table_row_header">
        <div class="table_row_header_left">
            <h5 class=" text-upper"> <i class="fa fa-list"></i> &nbsp; Liste employés</h5>
        </div>
      <div class="table_row_header_right">
          <button class="btn btn-primary"> <i class="fa fa-print"></i> &nbsp; <span class="text_button text-uppercase" >Imprimer</span></button>
            <button class="btn btn-info btn_modal_fonction"> <i class="fa fa-plus-circle"></i> &nbsp; <span class="text_button text-uppercase" >Enregistrer employé</span></button>
            
        </div>
      
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive table-responsive-md " id="sexion_fonction">
     
      <table class="table table-striped table-bordered  table-hover table-sm table-data">
          <thead class="">
            <tr>
              <th>#</th>
              <th>FONCTION</th>
              <th>DESCRIPTION</th>
              <th >OPTION</th>
            </tr>
          </thead>
          <tbody >
                <?= chargerListeFonction() ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>





  
<!-- Modal -->
<div class="modal fade" id="fonction-modal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="fonctionModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="fonctionModalLabel"><i class="fa fa-user-circle"></i> &nbsp; <span class="text-uppercase">FONCTION</span>  </h5>
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
        <button type="submit" form="frmAddFonction" id="btn_add_fonction" class="btn btn-primary "> <i class="fa fa-check-circle"></i> Enregistrer </button>
      </div><!-- /.modal-footer -->
    </div>
  </div>
</div>

