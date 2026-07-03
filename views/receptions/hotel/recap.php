<?php 
extract($data);
?>


<div class="card mt-2 ">
    <div class="card-header">
      
      
      <div class="row bg-info py-2">
          <div class="col-md-6 text_tile">
              <h5 class="card-title text-upper"> <i class="fa fa-list"></i> &nbsp;Detail reservation
              </h5>
          </div>
          <div class="col-md-6 b_left">
            
                <a target="_blank" href="<?= route('facture', ['code' => $reservation['code_reservation']]) ?>" id="btn_sealrch_chambre" type="submit" class="btn btn-default mr-2 py-2 "> <i class="fa fa-print"></i> &nbsp; IMPRIMER </a>
                <!-- <button id="btn_selarch_chambre" type="submit" class="btn btn-warning mr-2 py-2"> <i class="fa fa-unlock"></i> &nbsp; Liberer</button> -->
                <input type="hidden" value="<?= $reservation['date_sortie'] ?>" id="date_sortie">
        
          </div>

      </div>

    </div>
    <div class="card-body">
      <div class="row">
     <!--  -->
      <div class="col-md-5  text-upper">

      <?= chargerInfoClientReservation($reservation) ?>
       

      </div>
      
     

      <div class="col-md-7 text-upper">
        
      <?= chargerInfoChambreReservation($reservation) ?>

      </div>

      </div>
    </div>
  </div>

  <div class=" mt-4">
<div class="card">
    <div class="card-header">
        <h3>Service client</h3>
        <?php if( $reservation['statut_reservation'] != STATUT_RESERVATION[2]) : ?>

        <a type="button" target="_blank" href="<?= route('facture', ['code' => $reservation['code_reservation']]) ?>" class="btn btn-dark btn-sm pull-right "> <i class="fa fa-print"></i> IMPRIMER </a>
        <button data-reservation="<?= $reservation['code_reservation'] ?>" type="button" class="btn btn-info btn-sm pull-right mr-2 btn_regler_note" > <i class="fa fa-calculator"></i> REGLER LA NOTE </button>
        <?php if($reservation['date_sortie'] >= date('Y-m-d')) : ?>
        
          <button data-reservation="<?= crypter($reservation['code_reservation']) ?>" type="button" class="btn btn-primary btn-sm pull-right mr-2 btn_modal_service_reservation" > <i class="fa fa-calculator"></i> AJOUTER </button>
         <?php endif;?>
         <?php endif;?>

    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
            <div class="table-responsive table-responsive-md" id="sexion_service_recap">
     
     <table class="table table-striped table-bordered  table-hover table-sm">
         <thead class="">
           
         <tr>
             <th width="1">#</th>
             <th>Date</th>
             <th>SERVICE</th>
             <th>PRIX.U</th>
             <th>QTE</th>
             <th >MONTANT TOTAL</th>
             <th>SOLDE</th>
             <th width="5">OPTION</th>
           </tr>
         </thead>
         <tbody >
               <?= chargerListeServiceReservationClient($reservation['code_reservation']) ?>
         </tbody>
       </table>
     </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="service-modifier-modal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="serviceModifierClientModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="serviceModifierClientModalLabel"><i class="fa fa-user-circle"></i> &nbsp; <span class="text-uppercase">Formulaire Service</span>  </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row ">
            <div class="col-md-12 data-service-modifier-modal">
              
            </div>
        </div>
      </div>
        <!-- .modal-footer -->
        <div class="modal-footer">
        <button type="submit" form="frmModifierServiceForReservation" disabled  class="btn btn-primary btn_attr_service"> <i class="fa fa-check-circle"></i> Enregistrer </button>
      </div><!-- /.modal-footer -->
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="regler-note-modal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="reglernoteModifierModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="reglernoteModifierModalLabel"><i class="fa fa-user-circle"></i> &nbsp; <span class="text-uppercase">Facture</span>  </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row ">
            <div class="col-md-12 data-regler-note-modal">
              
            </div>
        </div>
      </div>
        <!-- .modal-footer -->
        <div class="modal-footer">
        <button type="submit" form="frm_facture_service_reservation" id="btn_regler_note_service" class="btn btn-primary "> <i class="fa fa-check-circle"></i> Enregistrer </button>
      </div><!-- /.modal-footer -->
    </div>
  </div>
</div>

<div class="modal fade" id="service-modal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="serviceModifierModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="serviceModifierModalLabel"><i class="fa fa-user-circle"></i> &nbsp; <span class="text-uppercase">Formulaire Service</span>  </h5>
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
        <button type="submit" form="frmAttrServiceForReservation" disabled class="btn btn-primary btn_attr_service"> <i class="fa fa-check-circle"></i> Enregistrer </button>
      </div><!-- /.modal-footer -->
    </div>
  </div>
</div>
