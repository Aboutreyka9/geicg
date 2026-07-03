// const URL_HOME = "http://localhost/ghotel/online/";
// const URL_PAGE = URL_HOME + "index.php/?p=";
// const URL_AJAX = URL_HOME + "cnt/ajx.php";
// const URLS = window.origin;
// const URL_HOME = URLS + "/hotel/";
// const URL_AJAX = URL_HOME + "src/controllers/ajx.php";
// moment.locale('fr');
const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');



let rolesPermissions = [];
let dataCheck = [];
let services = [];
const labels = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin','Juillet','Août','Septembre','Octobre','Novembre','Decembre'];

const START_DATE = "date_debut";
const END_DATE = "date_fin";
let charts = {}; // stocker les graphiques par ID

let interval;
let dataReservation = {
    start: null,
    end: null,
    days: null
};
let formChanged = false;
const $form = $('form');
let initialData = $form.serialize(); // capture les valeurs initiales
let formBtn = '';

    // Détection d’un changement sur n’importe quel champ
function detectChangeForms() {

    // $('button[type="submit"]').prop("disabled", true);

    $('body').on('input change', 'form :input', function() {
        const $input = $(this);
        const $form = $input.closest('form');
       
        

        if ($form.serialize() !== initialData) {
            formChanged = true;
            if(formBtn !== ''){
                $(formBtn).prop('disabled', false);
            }else{
                $form.find('button[type="submit"], input[type="submit"]').prop('disabled', false);
            }
        } else {
            formChanged = false;
            if(formBtn !== ''){
                $(formBtn).prop('disabled', true);
            }else{
                $form.find('button[type="submit"], input[type="submit"]').prop('disabled', true);
            }
        }
        

    });
}

detectChangeForms();

loading();

function loading() {
    window.onload = function() {
        $(".loader_backdrop2").css('display', "none");
    }
}

function btnReq(selector, message = 'Chargement...', icon = "fa-redo fa-spin") {
    $(selector).html(`
        <i class="fa ${icon}"></i> &nbsp; ${message}
        `);
    $(selector).attr("disabled", "disabled");
}


function btnRes(selector, message = 'Ajouter', icon = "fa-plus-circle") {
    $(selector).html(` <i class="fa ${icon}"></i> &nbsp; ${message}`);
    $(selector).attr("disabled", false);
}

menuNav();
function menuNav() {
    const pages = window.location.pathname.split("/");
    var currentPage = pages[2];
    if (currentPage) {
        $(".current-page").text(currentPage.toUpperCase());
    }
    
    

    // var te = window.pathname.
    $("body").on('click', '.back', function () {
    history.back();
});
}


synchronisation();

function synchronisation(params) {
    $("body").on("click" ,".synchroniser", function(e) {
        e.preventDefault();
        document.location.reload();
    });
}

counterTableData();

function counterTableData() {
    const $table = $("#tableData tbody");
    const $count = $("#counter_items");
    const $rowCount = $("#rowCounter");
    var nbr = $table.find("tr").length;
    var res = 0;
    var search = $("#searchInput");
    // Fonction de filtrage
     
    $count.text(nbr);
    
    res = nbr > 0 ? `<h5 class="text-bold">Resultat trouvé : 1 - ${nbr}</h5>`  : `<h5 class="text-danger text-bold">Aucun resultat trouvé</h5>`;
    $rowCount.html(res);
    


    if (search.length > 0 && search.val() != "") {
         let value = search.val().toLowerCase();
    let visibleRows = 0;

    // Parcourir toutes les lignes du tableau
    $table.find("tr").each(function() {
      const text = $(this).text().toLowerCase();
      const match = text.indexOf(value) > -1;

      $(this).toggle(match); // afficher/masquer la ligne
      if (match) visibleRows++;
    });

      // Afficher le nombre de lignes visibles
       res = visibleRows > 0 ? `<h5 class="text-bold">Resultat trouvé : 1 - ${visibleRows}</h5>`  : `<h5 class="text-danger text-bold">Aucun resultat trouvé</h5>`;
    $rowCount.html(res);
    }


    
  $("#searchInput").on("keyup", function() {
    let value = $(this).val().toLowerCase();
    let visibleRows = 0;

    // Parcourir toutes les lignes du tableau
    $table.find("tr").each(function() {
      const text = $(this).text().toLowerCase();
      const match = text.indexOf(value) > -1;

      $(this).toggle(match); // afficher/masquer la ligne
      if (match) visibleRows++;
    });

      // Afficher le nombre de lignes visibles
       res = visibleRows > 0 ? `<h5 class="text-bold">Resultat trouvé : 1 - ${visibleRows}</h5>`  : `<h5 class="text-danger text-bold">Aucun resultat trouvé</h5>`;
    $rowCount.html(res);
  });
    
   
    
}

counterTableData();

counterTableDataCommon();

function counterTableDataCommon() {
   
    if ($('.tableData:visible').length <= 0) return;
    setTimeout(function () { 

    const $table = $(".tableData:visible tbody");
    console.log($('.tableData').length,$table);
    const $count = $(".counter_items:visible");
    const $rowCount = $(".rowCounter:visible");
    var nbr = $table.find("tr").length;
    var res = 0;
    var search = $(".searchInput:visible");
    // Fonction de filtrage
     
    $count.text(nbr);
    
    res = nbr > 0 ? `<h5 class="text-bold">Resultat trouvé : 1 - ${nbr}</h5>`  : `<h5 class="text-danger text-bold">Aucun resultat trouvé</h5>`;
    $rowCount.html(res);
    


    if (search.length > 0 && search.val() != "") {
         let value = search.val().toLowerCase();
    let visibleRows = 0;

    // Parcourir toutes les lignes du tableau
    $table.find("tr").each(function() {
      const text = $(this).text().toLowerCase();
      const match = text.indexOf(value) > -1;

      $(this).toggle(match); // afficher/masquer la ligne
      if (match) visibleRows++;
    });

      // Afficher le nombre de lignes visibles
       res = visibleRows > 0 ? `<h5 class="text-bold">Resultat trouvé : 1 - ${visibleRows}</h5>`  : `<h5 class="text-danger text-bold">Aucun resultat trouvé</h5>`;
    $rowCount.html(res);
    }


    
  $(".searchInput:visible").on("keyup", function() {
    let value = $(this).val().toLowerCase();
    let visibleRows = 0;

    // Parcourir toutes les lignes du tableau
    $table.find("tr").each(function() {
      const text = $(this).text().toLowerCase();
      const match = text.indexOf(value) > -1;

      $(this).toggle(match); // afficher/masquer la ligne
      if (match) visibleRows++;
    });

      // Afficher le nombre de lignes visibles
       res = visibleRows > 0 ? `<h5 class="text-bold">Resultat trouvé : 1 - ${visibleRows}</h5>`  : `<h5 class="text-danger text-bold">Aucun resultat trouvé</h5>`;
    $rowCount.html(res);
  });
    
   }, 200);
    
}


function initDataTable() {
    $('.table-data').DataTable();
}


// initTable("#table-liste1");
// initTable("#table-liste2");


function initTable(selector) {
    $(selector).DataTable();
}

function resetDataTable(selector = '.table-data') {
    if ($.fn.DataTable.isDataTable(selector)) {
        $(selector).DataTable().clear().destroy();
    }
}

function money(val) {
    return val.toLocaleString('fr-FR', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    })
}

formatPhoneNumber();

function formatPhoneNumber() {
    $("body").delegate('.telephone', 'input', function(e) {
        let value = e.target.value;

        // Supprimer tout sauf chiffres
        let digits = value.replace(/\D/g, '');

        // Supprimer l'indicatif s'il est tapé manuellement
        if (digits.startsWith("225")) {
            digits = digits.slice(3);
        } else if (digits.startsWith("00225")) {
            digits = digits.slice(5);
        }

        // Ajouter le zéro obligatoire
        if (!digits.startsWith('0')) {
            digits = '0' + digits;
        }

        // Limiter à 10 chiffres après le zéro
        digits = digits.substring(0, 10);

        // Ajout d'espaces tous les 2 chiffres
        let formatted = digits.match(/.{1,2}/g) ?.join(' ') ?? '';

        // Mettre à jour le champ
        e.target.value = '(+225) ' + formatted;
    });
}
/**bloc search */

// const input = document.getElementById("search_input");
// const searchBtn = document.getElementById("search_btn");

// const expand = () => {
//   searchBtn.classList.toggle("search_close");
//   input.classList.toggle("search_square");
// };

// searchBtn.addEventListener("click", expand);
/**bloc search */

// RESERVATION
initverifictionChambreAble();

function initverifictionChambreAble() {
    var init = $('.initverifictionChambreAble').length;
    var dstart = moment().format('YYYY-MM-DD H:mm:ss');
    var dend = moment().endOf('day').format('YYYY-MM-DD H:mm:ss');
    if (init > 0) {
        if (dstart == null || dend == null) {
            return
        }

        checkDataChambreAblle(dstart, dend);
    };
}


function checkDataChambreAblle(start, end) {
    $.ajax({
        method: "POST",
        url: URL_AJAX,
        data: {
            action: 'btn_search_chambre',
            date_debut: start,
            date_fin: end
        },
        dataType: "JSON",
        beforeSend: function() {
            $(".loader_backdrop2").css('display', "block");
        },
        success: function(data) {
            ;

            $(".loader_backdrop2").css('display', "none");
            if (data.code == 200) {

                $.notify(data.message, "success");
                $("#sexion_chambre").html(data.data);

            } else {
                $("#sexion_chambre").html("");
                $.notify(data.message);
            }
        }
    });
}

verifictionNumber();

function verifictionNumber() {
    $("body").delegate(".search_number", "click", function(e) {
        e.preventDefault();
        var tel = $("#telephone").val();

        if (!tel || tel.length < 9) return swal("Notification", "Veuillez entrer un numéro de telephon valide", "warning");



        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'btn_search_telephone',
                telephone: tel
            },
            dataType: "JSON",
            beforeSend: function () {
                // console.log($(".search_number"));
                
                btnReq('.search_number', 'Recherche...');
                // $(".loader_backdrop2").css('display',"block");

            },
            success: function(data) {
                ;

                // $(".loader_backdrop2").css('display', "none");
                btnRes('.search_number', 'Recherche','fa-search');
                

                if (data.code == 200) {
                    $(".show_resultat").html(data.data);

                } else {
                    $(".show_resultat").html(data.message);

                }
            }
        });
    });
}

AjouterClient();

function AjouterClient() {
    $("body").delegate("#frm_ajouter_client", "submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: data,
            dataType: "JSON",
            beforeSend: function () {
                
                // $(".loader_backdrop2").css('display', "block");

            },
            success: function(data) {
                // $(".loader_backdrop2").css('display', "none");

                if (data.code == 200) {
                    // $('#sexion_chambre').html('');
                    $("#rec_btn").trigger('click');
                    $(".show_resultat").html(data.data);
                    $('#frm_ajouter_client')[0].reset();
                    $.notify(data.message, 'success');
                    console.log("okokkkkkk");
                    

                }else {
                    $.notify(data.message);
                }
            }
        })
    });
}


AjouterReservation();

function AjouterReservation() {
    $("body").delegate("#frm_ajouter_reservation", "submit", function(e) {
        e.preventDefault();
         var data = $(this).serialize();
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: data,
            dataType: "JSON",
            beforeSend: function () {
                
                // $(".loader_backdrop2").css('display', "block");

            },
            success: function(data) {
                // $(".loader_backdrop2").css('display', "none");

                if (data.code == 200) {
                    $.notify(data.message, 'success');
                    $('#sexion_chambre').html('');
                    $('#reservation-modal').modal('hide');                    

                } else {
                    $.notify(data.message);
                }
            }
        })
       
    });
}

function recaptListeReservations(debut, fin) {

    $.ajax({
        method: "POST",
        url: URL_AJAX,
        data: {
            action: 'btn_recapt_liste_reservations',
            date_debut: debut,
            date_fin: fin
        },
        dataType: "JSON",
        beforeSend: function() {
            $(".loader_backdrop2").css('display', "block");

        },
        success: function(data) {
            
            $(".loader_backdrop2").css('display', "none");

            if (data.code == 200) {
                $.notify(data.message, "success");
                $("#btn_imprimer_liste_reservation").prop('disabled', false);
                $("#btn_imprimer_liste_reservation").data('periode', data.periode);
                $(".tbody-reservation").html(data.data);

            } else {
                $(".tbody-reservation").html(data.data);
                $("#btn_imprimer_liste_reservation").prop('disabled', true);

                $.notify(data.message);
            }
            counterTableData();
        }
    });
}

function listeReservationsActive(debut, fin) {

    $.ajax({
        method: "POST",
        url: URL_AJAX,
        data: {
            action: 'btn_liste_reservations_active',
            date_debut: debut,
            date_fin: fin
        },
        dataType: "JSON",
        beforeSend: function() {
            $(".loader_backdrop2").css('display', "block");

        },
        success: function(data) {
            console.log(data) 
            $(".loader_backdrop2").css('display', "none");

            if (data.code == 200) {
                $.notify(data.message, "success");
                $("#btn_imprimer_liste_reservation_active").prop('disabled', false);

                $("#btn_imprimer_liste_reservation_active").data('periode', data.periode);
                $(".tbody-reservation:visible").html(data.data);

            } else {
                $(".tbody-reservation:visible").html(data.data);
                $("#btn_imprimer_liste_reservation_active").prop('disabled', true);
                $.notify(data.message);
            }
            counterTableDataCommon();
        }
    });
}

function listeReservationsArrive(debut, fin) {

    $.ajax({
        method: "POST",
        url: URL_AJAX,
        data: {
            action: 'btn_liste_reservations_arrive',
            date_debut: debut,
            date_fin: fin
        },
        dataType: "JSON",
        beforeSend: function() {
            $(".loader_backdrop2").css('display', "block");

        },
        success: function(data) {
            console.log(data) 
            $(".loader_backdrop2").css('display', "none");

            if (data.code == 200) {
                $.notify(data.message, "success");
                $("#btn_imprimer_liste_reservation_arrive").prop('disabled', false);

                $("#btn_imprimer_liste_reservation_arrive").data('periode', data.periode);
                $(".tbody-reservation:visible").html(data.data);

            } else {
                $(".tbody-reservation:visible").html(data.data);
                $("#btn_imprimer_liste_reservation_arrive").prop('disabled', true);
                $.notify(data.message);
            }
            counterTableDataCommon();
        }
    });
}

function listeReservations(debut, fin) {

    $.ajax({
        method: "POST",
        url: URL_AJAX,
        data: {
            action: 'btn_liste_reservations',
            date_debut: debut,
            date_fin: fin
        },
        dataType: "JSON",
        beforeSend: function() {
            $(".loader_backdrop2").css('display', "block");

        },
        success: function(data) {
            
            $(".loader_backdrop2").css('display', "none");

            if (data.code == 200) {
                $.notify(data.message, "success");
                $("#btn_imprimer_liste_reservation").prop('disabled', false);

                $("#btn_imprimer_liste_reservation").data('periode', data.periode);
                $(".tbody-reservation").html(data.data);

            } else {
                $(".tbody-reservation").html(data.data);
                $("#btn_imprimer_liste_reservation").prop('disabled', true);
                $.notify(data.message);
            }
            counterTableData();
        }
    });
}

deleteReservation();

function deleteReservation() {
    $("body").delegate(".btn_annuler_reservation", "click", function(e) {
        e.preventDefault();
        var code = $(this).data("reservation");
        
        swal({
                title: "Notification",
                text: "Etes vous sûr de vouloir annuler cette reservation?",
                icon: "warning",
                dangerMode: true,
                closeOnClickOutside: false,
                buttons: {
                    cancel: true,
                    confirm: "Confirmer",
                },
            })
            .then(willDelete => {
                if (willDelete) {


                    $.ajax({
                        url: URL_AJAX,
                        method: 'POST',
                        data: {
                            action: 'btn_delete_reservation',
                            code_reservation: code
                        },
                        dataType: 'JSON',
                        beforeSend: function() {},
                        success: function(data) {
                            ;
                            if (data.code == 200) {
                                $.notify(data.message, "success");
                                $("#sexion_reservation").load(" #sexion_reservation > *");
                            } else {
                                $.notify(data.message);
                            }
                        }
                    });;
                }
            });


    });
}

checkMontantPayer();

function checkMontantPayer() {
    $("body").delegate("#montant_payer", "keyup", function(e) {
        e.preventDefault();
        var montantntPayer = Number($(this).val());
        var montantTotal = Number($("#montant_total").val());
        var rest = "";
        if (isNaN(montantTotal) || isNaN(montantntPayer)) {
            $.notify("montant invalide");
            return
        } else if (montantntPayer < montantTotal) {
            $("#montant_rendu").val(rest);

            return
        } else {
            rest = (montantntPayer - montantTotal);
            rest = money(rest);
            $("#montant_rendu").val(rest);
        }

        if (dataReservation.days == null) {
            return
        }

        checkDataChambreAblle(dataReservation.start, dataReservation.end);
    });
}

confirmReservation();

function confirmReservation() {
    $("body").delegate(".btn_modal_confirme", "click", function(e) {
        e.preventDefault();
        var codeReservation = $(this).data('reservation');
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'btn_modal_confirme',
                code_reservation: codeReservation
            },
            dataType: "JSON",
            beforeSend: function() {
                $(".loader_backdrop2").css('display', "block");

            },
            success: function(data) {
                ;
                $(".loader_backdrop2").css('display', "none");

                if (data.code == 200) {
                    $(".data-modal").html(data.data);
                    $("#reservation-modal").modal('show');
                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}

modalServiceReservation();

function modalServiceReservation() {
    $("body").delegate(".btn_modal_service_reservation", "click", function(e) {
        e.preventDefault();
        var codeReservation = $(this).data('reservation');
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'frm_modal_service_reservation',
                code_reservation: codeReservation
            },
            dataType: "JSON",
            beforeSend: function() {
                $(".loader_backdrop2").css('display', "block");

            },
            success: function(data) {
                ;
                $(".loader_backdrop2").css('display', "none");

                if (data.code == 200) {
                    services = data.services;
                    $(".data-service-modal").html(data.data);
                    $("#service-modal").modal('show');
                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}

checkMontantService();

function checkMontantService() {

    $("body").delegate("#service", "change", function(e) {
        e.preventDefault();

        var code = $(this).val();
        var qte = $("#qte_service").val();
        var prix = "";
        var total = 0;


        services.map(sv => {

            if (sv.code_service === code) {
                prix = sv.prix_service;
                $("#prix").val(prix);

                total = money(qte * prix) + " FCFA";
                prix_s = money(prix) + " FCFA";
                $("#prix_service").val(prix_s);
                $("#total_service").val(total);

            }
            // return prix;
        });

        if (qte == "" || qte <= 0) {
            $(".btn_attr_service").prop("disabled", true);
        } else {
            $(".btn_attr_service").prop("disabled", false);
        }


    });

    $("body").delegate("#qte_service", "keyup", function(e) {
        e.preventDefault();

        var total = 0;
        var qte = $(this).val();
        var prix = $("#prix").val();
        total = money(prix * qte) + " FCFA";
        $("#total_service").val(total);

        if (qte == "" || qte <= 0) {
            $(".btn_attr_service").prop("disabled", true);
        } else {
            $(".btn_attr_service").prop("disabled", false);
        }

    });
}

effectuerServiceReservation();

function effectuerServiceReservation() {
    $("body").delegate("#frmAttrServiceForReservation", "submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: data,
            dataType: "JSON",
            beforeSend: function() {
                btnReq(".btn_attr_service", "Enregistrement...");
            },
            success: function(data) {
                ;
                btnRes(".btn_attr_service", "Enregistrer");
                if (data.code == 200) {
                    $.notify(data.message, "success");
                    $("#service-modal").modal("hide");

                    $("#sexion_reservation").load(" #sexion_reservation > *");
                    $("#sexion_service_recap").load(" #sexion_service_recap > *");

                } else {
                    $.notify(data.message);
                }
            }
        });
    });
}

modalModifierServiceForReservation();

function modalModifierServiceForReservation() {
    $("body").delegate(".btn_modal_modifier_service_reservation", "click", function(e) {
        e.preventDefault();
        var codeConsommation = $(this).data('consommation');

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'frm_modal_modifier_service_reservation',
                code: codeConsommation
            },
            dataType: "JSON",
            beforeSend: function() {
                $(".loader_backdrop2").css('display', "block");

            },
            success: function(data) {
                ;
                $(".loader_backdrop2").css('display', "none");

                if (data.code == 200) {
                    services = data.services;
                    $(".data-service-modifier-modal").html(data.data);
                    $("#service-modifier-modal").modal('show');
                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}

ModifierServiceForReservation();

function ModifierServiceForReservation() {
    $("body").delegate("#frmModifierServiceForReservation", "submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: data,
            dataType: "JSON",
            beforeSend: function() {
                btnReq(".btn_attr_service", "Enregistrement...");
            },
            success: function(data) {
                ;
                btnRes(".btn_attr_service", "Enregistrer");
                if (data.code == 200) {
                    $.notify(data.message, "success");
                    $("#service-modifier-modal").modal("hide");
                    $("#sexion_service_recap").load(" #sexion_service_recap > *");

                } else {
                    $.notify(data.message);
                }
            }
        });
    });
}

deleteServiceForReservation();

function deleteServiceForReservation() {
    $("body").delegate(".btn_modal_supprimer_service_reservation", "click", function(e) {
        e.preventDefault();
        var code = $(this).data("consommation");
        
        swal({
                title: "Notification",
                text: "Etes vous sûr de vouloir ennuler cet element?",
                icon: "warning",
                dangerMode: true,
                closeOnClickOutside: false,
                buttons: {
                    cancel: "Non",
                    confirm: "Oui",
                },
            })
            .then(willDelete => {
                if (willDelete) {


                    $.ajax({
                        url: URL_AJAX,
                        method: 'POST',
                        data: {
                            action: 'btn_delete_service_reservation',
                            code_consommation: code
                        },
                        dataType: 'JSON',
                        beforeSend: function() {},
                        success: function(data) {

                            if (data.code == 200) {
                                $.notify(data.message, "success");
                                $("#sexion_service_recap").load(" #sexion_service_recap > *");
                            } else {
                                $.notify(data.message);
                            }
                        }
                    });;
                }
            });


    });
}

modalReglerNoteServiceForReservation();

function modalReglerNoteServiceForReservation() {
    $("body").delegate(".btn_regler_note", "click", function(e) {
        e.preventDefault();
        var codeReservation = $(this).data('reservation');

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'frm_modal_reglernote_service_reservation',
                code: codeReservation
            },
            dataType: "JSON",
            beforeSend: function() {
                $(".loader_backdrop2").css('display', "block");

            },
            success: function(data) {
                ;
                $(".loader_backdrop2").css('display', "none");

                if (data.code == 200) {
                    services = data.services;
                    $(".data-regler-note-modal").html(data.data);
                    $("#regler-note-modal").modal('show');
                } else {
                    $.notify(data.message, 'info');
                }
            }
        })
    });
}

btnReglerNoteServiceForReservation();

function btnReglerNoteServiceForReservation() {
    $("body").delegate("#frm_facture_service_reservation", "submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: data,
            dataType: "JSON",
            beforeSend: function() {
                btnReq("#btn_regler_note_service", "Enregistrement...");
            },
            success: function(data) {
                ;
                btnRes("#btn_regler_note_service", "Enregistrer");
                if (data.code == 200) {
                    $.notify(data.message, "success");
                    $("#regler-note-modal").modal("hide");
                    $("#sexion_service_recap").load(" #sexion_service_recap > *");

                } else {
                    $.notify(data.message);
                }
            }
        });
    });
}

modalModifierReservation();

function modalModifierReservation() {
    $("body").delegate(".btn_modal_modifier", "click", function(e) {
        e.preventDefault();
        var codeReservation = $(this).data('reservation');
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'btn_modal_modifier_reservation',
                code_reservation: codeReservation
            },
            dataType: "JSON",
            beforeSend: function() {
                $(".loader_backdrop2").css('display', "block");

            },
            success: function(data) {
                ;
                $(".loader_backdrop2").css('display', "none");

                if (data.code == 200) {
                    $(".data-modofier-modal").html(data.data);
                    $("#reservation-modifier-modal").modal('show');
                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}

btnCaisse();

function btnCaisse() {
    // ouverture de caisse
    $("body").delegate("#btn_ouverture_caisse", "click", function(e) {
        e.preventDefault();

        $.ajax({
            url: URL_AJAX,
            method: 'POST',
            data: {
                action: 'btn_ouvrir_caisse',
            },
            dataType: 'JSON',
            beforeSend: function() {
                btnReq("#btn_ouverture_caisse", "Ouverture...");
            },
            success: function(data) {
                ;
                if (data.code == 200) {
                    $.notify(data.message, "success");
                    var html = `<button id="btn_fermeture_caisse" type="button" class="btn btn-info"> <i class="fa fa-fa-briefcase"></i> &nbsp; FERMER MA CAISSE</button>`;

                    $("#sexion_caisse").html(html);
                    $('#sexion_versement').load(" #sexion_versement > *");
                } else {
                    btnRes("#btn_ouverture_caisse", "OUVRIR MA CAISSE", 'fa-briefcase');
                    $.notify(data.message);
                }
            }
        });



    });

    // fermeture de caisse
    $("body").delegate("#btn_fermeture_caisse", "click", function(e) {
        e.preventDefault();

        swal({
                title: "Notification",
                text: "Etes vous sure de vouloir cloturer la caisse?",
                icon: "warning",
                dangerMode: true,
                closeOnClickOutside: false,
                buttons: {
                    cancel: "Annuler",
                    confirm: "Confirmer",
                },
            })
            .then(willDelete => {
                if (willDelete) {


                    $.ajax({
                        url: URL_AJAX,
                        method: 'POST',
                        data: {
                            action: 'btn_fermer_caisse',
                        },
                        dataType: 'JSON',
                        beforeSend: function() {
                            btnReq("#btn_fermeture_caisse", "Fermeture...");

                        },
                        success: function(data) {
                            if (data.code == 200) {
                                $.notify(data.message, "success");
                                var html = ` <button id="btn_ouverture_caisse" type="button" class="btn btn-info"> <i class="fa fa-fa-briefcase"></i> &nbsp; OUVRIR MA CAISSE</button>`;

                                $("#sexion_caisse").html(html);
                                $('#sexion_versement').load(" #sexion_versement > *");
                                $("#statut_versement").load(" #statut_versement > *");
                            } else {
                                btnRes("#btn_fermeture_caisse", "FERMER MA CAISSE", 'fa-briefcase');

                                $.notify(data.message);
                            }
                        }
                    });;
                }
            });


    });
}

/**
 * CAISSE COmPTABLE
 */

confirmDepotUserComptable();
function confirmDepotUserComptable() {
    $("body").delegate(".btn_confirm_depot", "click", function(e) {
        e.preventDefault();
        var codeVersement = $(this).data('versement');
        var periode = $(".search-periode-depot").val();

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'btn_confirm_depot_user_comptable',
                code_versement: codeVersement,
                periode: periode
            },
            dataType: "JSON",
            beforeSend: function() {
                $(".loader_backdrop2").css('display', "block");

            },
            success: function(data) {
                ;
                $(".loader_backdrop2").css('display', "none");

                if (data.code == 200) {

                    $.notify(data.message,"success");

                    $("#sexion_versement_comptable").html(data.data);
                    $("#caisseComptable").text(data.caisse);
                    $("#factureStandbyComptable").text(data.facture);
                   
                } else {
                    $.notify(data.message);
                }
                counterTableData();
            }
        })
    });
}

function listeDepotCaisseComptable(debut, fin) {

    $.ajax({
        method: "POST",
        url: URL_AJAX,
        data: {
            action: 'btn_liste_depot_caisse_comptable',
            date_debut: debut,
            date_fin: fin
        },
        dataType: "JSON",
        beforeSend: function() {
            $(".loader_backdrop2").css('display', "block");

        },
        success: function(data) {
            
            $(".loader_backdrop2").css('display', "none");

            if (data.code == 200) {
                $.notify(data.message, "success");
                $("#sexion_versement_comptable").html(data.data);
                $("#caisseComptable").text(data.facture_encaisse);
                $("#factureStandbyComptable").text(data.facture_standby);
                $("#caisseOpenComptable").text(data.caisse_open);
                $("#btn_imprimer_liste_versement").prop('disabled',false);
                $("#btn_imprimer_liste_versement").data('periode',data.periode);

            } else {
                $("#sexion_versement_comptable").html(data.data);
                $("#caisseComptable").text(data.facture_encaisse);
                $("#factureStandbyComptable").text(data.facture_standby);
                $("#caisseOpenComptable").text(data.caisse_open);
                $("#btn_imprimer_liste_versement").prop('disabled',true);

                $.notify(data.message);
            }
            counterTableData();
        }
    });
}

// Bilan caisse comptable

function listeBilanCaisseComptable(debut, fin) {

    $.ajax({
        method: "POST",
        url: URL_AJAX,
        data: {
            action: 'btn_liste_bilant_caisse_comptable',
            date_debut: debut,
            date_fin: fin
        },
         dataType: "JSON",
        beforeSend: function() {
            $(".loader_backdrop2").css('display', "block");

        },
        success: function(data) {
            
            $(".loader_backdrop2").css('display', "none");
            

            if (data.code == 200) {
                
                $.notify(data.message, "success");
                var html = `<h3 class="${data.color} " > ${data.montant_disponible} 
                </h3>`;
                $("#totalDisponibleComptable").html(html);
                $("#totalDepenseComptable").text(data.montant_depense);
                $("#totalCaisseComptable").text(data.montant_caisse);

                $("#reservationCaisseComptable").text(data.data_details.montant_reservation);
                $("#serviceCaisseComptable").text(data.data_details.montant_service);
                $("#countReservationNonRegler").text(data.data_details.countReservationNonRegler);
                $("#montantReservationNonRegler").text(data.data_details.montantNotOk);
                $("#countReservationEnnuler").text(data.data_details.countReservationEnnuler);
                $("#montantReservationEnnuler").text(data.data_details.montantReservationEnnuler);
                $("#countServiceEnnuler").text(data.data_details.countServiceEnnuler);
                $("#montantServiceEnnuler").text(data.data_details.montantServiceEnnuler);

               

            } else {
               
                $.notify(data.message);
            }
        }
    });
}

// DEBUT CLIENT 

function recaptListeCLient(debut, fin) {

    $.ajax({
        method: "POST",
        url: URL_AJAX,
        data: {
            action: 'btn_recapt_liste_clients',
            date_debut: debut,
            date_fin: fin
        },
        dataType: "JSON",
        beforeSend: function() {
            $(".loader_backdrop2").css('display', "block");

        },
        success: function(data) {
            
            $(".loader_backdrop2").css('display', "none");

     
            
            if (data.code == 200) {
                $.notify(data.message, "success");
                $(".tbody-client").html(data.data);
                $("#btn_imprimer_liste_client").prop("disabled", false);
                $("#btn_imprimer_liste_client").data("periode", data.periode);

            } else {
                $(".tbody-client").html(data.data);
                $.notify(data.message);
                $("#btn_imprimer_liste_client").prop("disabled", true);

            }
            counterTableData();

        }
    });
}

function listeCLient(debut, fin) {

    $.ajax({
        method: "POST",
        url: URL_AJAX,
        data: {
            action: 'btn_liste_clients',
            date_debut: debut,
            date_fin: fin
        },
        dataType: "JSON",
        beforeSend: function() {
            $(".loader_backdrop2").css('display', "block");

        },
        success: function(data) {
            
            $(".loader_backdrop2").css('display', "none");

            if (data.code == 200) {
                $.notify(data.message, "success");
                $(".tbody-client").html(data.data);
                $("#btn_imprimer_liste_client").prop("disabled", false);
                $("#btn_imprimer_liste_client").data("periode", data.periode);

            } else {
                $(".tbody-client").html(data.data);
                $("#btn_imprimer_liste_client").prop("disabled", true);
                $.notify(data.message);
            }
            counterTableData();
        }
    });
}

updateClient();
function updateClient() {

    $("body").delegate("#form_update_client", "submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        
        $.ajax({
            url: URL_AJAX,
            method: 'POST',
            data: data,
            dataType: 'JSON',
            beforeSend: function() {
                btnReq(".btn_update_client", "Traitement...");
            },
            success: function(data) {
                ;
                
                btnRes(".btn_update_client", "Enregistrer", "fa-save");
                if (data.code == 200) {
                    $.notify(data.message, 'success');
                    initialData = $("form").serialize();
                    $("#btn_update_client").prop("disabled", true);
                }else{
                   $.notify(data.message, 'error')
                }
            }
        });

    });

    
}

// detectChangeForms();




/**ttttttt */

// FIN CLIENT
// FIN RESERVATION

// DEBUT VERSEMENT

detailVersementUser();

function detailVersementUser() {
    $("body").delegate(".btn_detail_versement", "click", function(e) {
        e.preventDefault();
        var codeCaisse = $(this).data('caisse');

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'frm_modal_detail_versement',
                code: codeCaisse
            },
            dataType: "JSON",
            beforeSend: function() {
                $(".loader_backdrop2").css('display', "block");

            },
            success: function(data) {
                ;
                $(".loader_backdrop2").css('display', "none");

                if (data.code == 200) {
                    services = data.services;
                    $(".data-modal").html(data.data);
                    $("#details-versement-modal").modal('show');
                } else {
                    $.notify(data.message, 'info');
                }
            }
        })
    });
}
// FIN VERSEMENT

// FONCTION

modalAddFonction();

function modalAddFonction() {
    $("body").delegate(".btn_modal_fonction", "click", function(e) {
        e.preventDefault();

        $.ajax({
            url: URL_AJAX,
            method: 'POST',
            data: {
                action: "frm_modal_fonction"
            },
            dataType: 'JSON',
            beforeSend: function() {
                btnReq(".btn_modal_fonction", "Chargement...");
            },
            success: function(data) {
                btnRes(".btn_modal_fonction", "Enregistrer employé");
                ;
                if (data.code == 200) {
                    $('.data-modal').html(data.data);
                    $("#fonction-modal").modal("show");
                }
                //    else{
                //    }
            }
        });

    });
}

btnAddFonction();

function btnAddFonction() {
    $("body").delegate("#frmAddFonction", "submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: data,
            dataType: "JSON",
            beforeSend: function() {
                btnReq("#btn_add_fonction", "Enregistrement...");
            },
            success: function(data) {
                btnRes("#btn_add_fonction", "Enregistrer");
                ;
                if (data.code == 200) {
                    // resetDataTable();
                    $.notify(data.message, "success");
                    $("#fonction-modal").modal("hide");
                    $("#sexion_fonction").load(" #sexion_fonction > *");
                    // setTimeout(initDataTable, 120);


                } else {
                    $.notify(data.message);
                }
            }
        });
    });
}

modalUpdateFonction();

function modalUpdateFonction() {
    $("body").delegate(".frm_modifier_fonction", "click", function(e) {
        e.preventDefault();
        var codeFonction = $(this).data("code");
        var id = $(this).attr("id");

        $.ajax({
            url: URL_AJAX,
            method: 'POST',
            data: {
                action: "frm_update_fonction",
                code_fonction: codeFonction
            },
            dataType: 'JSON',
            beforeSend: function() {
                btnReq("#" + id, "Chargement...");
            },
            success: function(data) {
                btnRes("#" + id, "Modifier", 'fa-edit');

                if (data.code == 200) {
                    $('.data-modal').html(data.data);
                    $("#fonction-modal").modal("show");
                } else {
                    $.notify('erreur de chargement');
                }
            }
        });

    });
}

deleteFonction();

function deleteFonction() {
    $("body").delegate(".btn_delete_fonction", "click", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        var id = $(this).attr("id");
        swal({
                title: "Notification",
                text: "Etes vous sûr de vouloir supprimer cet element?",
                icon: "warning",
                dangerMode: true,
                closeOnClickOutside: false,
                buttons: {
                    cancel: true,
                    confirm: "Supprimer",
                },
            })
            .then(willDelete => {
                if (willDelete) {


                    $.ajax({
                        url: URL_AJAX,
                        method: 'POST',
                        data: {
                            action: 'btn_delete_fonction',
                            code_fonction: code
                        },
                        dataType: 'JSON',
                        beforeSend: function() {
                            btnReq("#" + id, "Traitement...");
                        },
                        success: function(data) {
                            btnRes("#" + id, "Supprimer", 'fa-trash');

                            if (data.code == 200) {

                                resetDataTable();
                                $.notify(data.message, "success");
                                $("#sexion_fonction").load(" #sexion_fonction > *");
                                setTimeout(initDataTable, 120);

                            } else {
                                $.notify(data.message);
                            }
                        }
                    });;
                }
            });


    });
}

//fin fonction


// Debut depense

function recaptListeDepense(debut, fin) {

    $.ajax({
        method: "POST",
        url: URL_AJAX,
        data: {
            action: 'btn_recapt_liste_depense',
            date_debut: debut,
            date_fin: fin
        },
         dataType: "JSON",
        beforeSend: function() {
            $(".loader_backdrop2").css('display', "block");

        },
        success: function(data) {
            
            $(".loader_backdrop2").css('display', "none");
            console.log(data);
            
            if (data.code == 200) {
                
                // resetDataTable();
                // $(".tbody-depense").html(data.data);
                
                $("#btn_imprimer_liste_depense").prop('disabled', false);
                $("#btn_imprimer_liste_depense").data('periode', data.periode);
                $("#tbody-depense").html(data.data);
                $.notify(data.message, 'success')

            } else {
                $(".tbody-depense").html(data.data);
                $("#btn_imprimer_liste_depense").prop('disabled', true);
                $.notify(data.message);

            }
            counterTableData();

        }
    });
}


function listeDepense(debut, fin) {

    $.ajax({
        method: "POST",
        url: URL_AJAX,
        data: {
            action: 'btn_liste_depense',
            date_debut: debut,
            date_fin: fin
        },
         dataType: "JSON",
        beforeSend: function() {
            $(".loader_backdrop2").css('display', "block");

        },
        success: function(data) {
            
            $(".loader_backdrop2").css('display', "none");
            console.log(data);
            

            if (data.code == 200) {
                
                // resetDataTable();
                $(".tbody-depense").html(data.data);
                $("#totalDepenseCaisse").text(data.totalDepenseCaisse);
                $("#totalDepenseEnAttente").text(data.totalDepenseEnAttente);
                $("#totalDepenseMois").text(data.totalDepenseMois);
                $("#btn_imprimer_liste_depense").prop('disabled', false);
                $("#btn_imprimer_liste_depense").data('periode', data.periode);
                $.notify(data.message, 'success')

            } else {

                $(".tbody-depense").html(data.data);
                $("#totalDepenseCaisse").text(data.totalDepenseCaisse);
                $("#totalDepenseEnAttente").text(data.totalDepenseEnAttente);
                $("#totalDepenseMois").text(data.totalDepenseMois);
                $("#btn_imprimer_liste_depense").prop('disabled', true);
                $.notify(data.message);

            }
            counterTableData();

        }
    });
}

openModalAddDepense();

function openModalAddDepense() {
    $("body").delegate("#btn_ajouter_depense", "click", function(e) {
        e.preventDefault();

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'btn_showmodal_depense'
            },
            dataType: "JSON",
            beforeSend: function() {

                $(".loader_backdrop2").css('display', "block");
            },
            success: function(data) {
                ;
                
                if (data.code == 200) {
                    $(".data-modal").html(data.data);
                    $("#depense-modal").modal("show");
                    $(".loader_backdrop2").css('display', "none");

                }
                else{
                    $.notify(data.message);
                }

            }
        })
    });
}

ajouter_depense();

function ajouter_depense() {
    $("body").delegate("#frm_ajouter_depense", "submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: data,
            dataType: "json",
            beforeSend: function() {
                btnReq("#btn_add_depense", "Traitement...");

            },
            success: function(data) {
                btnRes("#btn_add_depense", "Enregistrer", "fa-check-circle");
                if (data.code == 200) {
                    // resetDataTable();
                    $.notify(data.message, "success");
                    $("#depense-modal").modal("hide");
                    $("#sexion_depense").load(" #sexion_depense > *");
                    $("#charger-depense").load(" #charger-depense > *");
                        // setTimeout(initDataTable, 200)


                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}

openModalUpdateDepense();

function openModalUpdateDepense() {
    $("body").delegate(".btn_update_depense", "click", function(e) {
        e.preventDefault();
        var id = $(this).data("depense");

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'frm_update_depense',
                id_depense: id
            },
            dataType: "json",
            beforeSend: function() {

                $(".loader_backdrop2").css('display', "block");

            },
            success: function(data) {
                ;

                if (data.code == 200) {
                    $(".data-modal").html(data.data);
                    $("#depense-modal").modal("show");
                    $(".loader_backdrop2").css('display', "none");

                }

            }
        })
    });
}

confirm_depense();
function confirm_depense() {
    $("body").delegate(".btn_confirm_depense", "click", function(e) {
        e.preventDefault();
        var code = $(this).data("depense");
        var periode = $(".search-periode-depense").val();

       
               
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'btn_confirm_depense',
                code_depense: code,
                periode: periode
            },
            dataType: "json",
            beforeSend: function() {
                $(".loader_backdrop2").css('display', "block");
            },
            success: function(data) {
                $(".loader_backdrop2").css('display', "none");
                if (data.code == 200) {
                    $(".tbody-depense").html(data.data);
                    $("#totalDepenseCaisse").text(data.totalDepenseCaisse);
                    $("#totalDepenseEnAttente").text(data.totalDepenseEnAttente);
                    $("#totalDepenseMois").text(data.totalDepenseMois);

                    $.notify(data.message, "success");
                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}


supprimer_depense();

function supprimer_depense() {
    $("body").delegate(".btn_annuler_depense", "click", function(e) {
        e.preventDefault();
        var code = $(this).data("depense");
        var periode = $(".search-periode-depense").val();

        

        swal({
            title: "Êtes vous sûr ?",
            text: "Voulez-vous vraiment annuler cette depense ?",
            type: "warning",
            buttons: {
                cancel: {
                    visible: true,
                    text: "Non",
                    className: 'btn btn-default'
                },
                confirm: {
                    text: 'Oui',
                    className: 'btn btn-danger'
                }
            }

        }).then(function(result) {
            if (result) {

                $.ajax({
                    method: "POST",
                    url: URL_AJAX,
                    data: {
                        action: 'btn_delete_depense',
                        id_depense: code,
                        periode: periode
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $(".loader_backdrop2").css('display', "block");
                    },
                    success: function(data) {
                        ;
                        $(".loader_backdrop2").css('display', "none");
                        if (data.code == 200) {
                           
                            $(".tbody-depense").html(data.data);

                            $("#totalDepenseCaisse").text(data.totalDepenseCaisse);
                            $("#totalDepenseEnAttente").text(data.totalDepenseEnAttente);
                            $("#totalDepenseMois").text(data.totalDepenseMois);
                            $.notify(data.message, 'success')
                           
                        } else {
                            $.notify(data.message)
                        }
                    }
                })
            }

        })


    });
}
// FIN Depense

// Debut Salaire

function listeSalaire(debut, fin) {

    $.ajax({
        method: "POST",
        url: URL_AJAX,
        data: {
            action: 'btn_liste_salaire',
            date_debut: debut,
            date_fin: fin
        },
         dataType: "JSON",
        beforeSend: function() {
            $(".loader_backdrop2").css('display', "block");

        },
        success: function(data) {
           
            $(".loader_backdrop2").css('display', "none");
            

            if (data.code == 200) {
                // resetDataTable();
                
                $(".tbody-salaire").html(data.data);
                $("#totalSalaireCaisse").text(data.totalSalaireCaisse);
                $("#totalSalaireEnAttente").text(data.totalSalaireEnAttente);
                $("#totalSalaireMois").text(data.totalSalaireMois);
                $("#btn_imprimer_liste_salaire").prop('disabled', false);
                $("#btn_imprimer_liste_salaire").data('periode', data.periode);

                $.notify(data.message, 'success')

                

            } else {
                $(".tbody-salaire").html(data.data);
                $("#btn_imprimer_liste_salaire").prop('disabled', true);
                $.notify(data.message);
            }
            counterTableData();

        }
    });
}



//225*
openModalAddSalaire();

function openModalAddSalaire() {
    $("body").delegate("#btn_ajouter_salaire", "click", function(e) {
        e.preventDefault();
        
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'btn_showmodal_salaire'
            },
            dataType: "JSON",
            beforeSend: function() {

                $(".loader_backdrop2").css('display', "block");
            },
            success: function(data) {
                ;
                
                $(".loader_backdrop2").css('display', "none");
                if (data.code == 200) {
                    $(".data-modal").html(data.data);
                    $("#salaire-modal").modal("show");
                    initialData = $('#frm_ajouter_salaire').serialize();
                    formBtn = "#btn_add_salaire";

                    
                    
                }
                else{
                    $.notify(data.message);
                }

            }
        })
    });
}

ajouter_salaire();

function ajouter_salaire() {
    $("body").delegate("#frm_ajouter_salaire", "submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();
     
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: data,
            dataType: "json",
            beforeSend: function() {
                btnReq("#btn_add_salaire", "Traitement...");

            },
            success: function(data) {
                btnRes("#btn_add_salaire", "Enregistrer", "fa-check-circle");
                
                ;
                if (data.code == 200) {
                    resetDataTable();
                    $.notify(data.message, "success");
                    $("#salaire-modal").modal("hide");
                    $("#sexion_salaire").load(" #sexion_salaire > *");
                    $("#charger-salaire").load(" #charger-salaire > *");
                  
                    setTimeout(initDataTable, 200)


                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}

openModalUpdateSalaire();

function openModalUpdateSalaire() {
    $("body").delegate(".frmModifierSalaire", "click", function(e) {
        e.preventDefault();
        var id = $(this).data("salaire");

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'frm_update_salaire',
                id_salaire: id
            },
            dataType: "json",
            beforeSend: function() {

                $(".loader_backdrop2").css('display', "block");

            },
            success: function(data) {
                ;

                if (data.code == 200) {
                    $(".data-modal").html(data.data);
                    $("#salaire-modal").modal("show");
                    $(".loader_backdrop2").css('display', "none");

                }

            }
        })
    });
}


confirm_salaire();
function confirm_salaire() {
    $("body").delegate(".btn_confirm_salaire", "click", function(e) {
        e.preventDefault();
        var code = $(this).data("salaire");
        var periode = $(".search-periode-salaire").val();

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'btn_confirm_salaire',
                code_salaire: code,
                periode: periode
            },
            dataType: "json",
            beforeSend: function() {
                $(".loader_backdrop2").css('display', "block");
            },
            success: function(data) {
                $(".loader_backdrop2").css('display', "none");

                if (data.code == 200) {
                    $(".tbody-salaire").html(data.data);
                    $("#totalSalaireCaisse").text(data.totalSalaireCaisse);
                    $("#totalSalaireEnAttente").text(data.totalSalaireEnAttente);
                    $("#totalSalaireMois").text(data.totalSalaireMois);


                    $.notify(data.message, "success");
                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}

supprimer_salaire();

function supprimer_salaire() {
    $("body").delegate(".btn_delete_salaire", "click", function(e) {
        e.preventDefault();
        var code = $(this).data("salaire");
        var periode = $(".search-periode-salaire").val();

        

        swal({
            title: "Êtes vous sûr ?",
            text: "Voulez-vous vraiment annuler cette depense ?",
            type: "warning",
            buttons: {
                cancel: {
                    visible: true,
                    text: "Non",
                    className: 'btn btn-default'
                },
                confirm: {
                    text: 'Oui',
                    className: 'btn btn-danger'
                }
            }

        }).then(function(result) {
            if (result) {

                $.ajax({
                    method: "POST",
                    url: URL_AJAX,
                    data: {
                        action: 'btn_delete_salaire',
                        id_salaire: code,
                        periode: periode
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $(".loader_backdrop2").css('display', "block");
                    },
                    success: function(data) {
                        ;
                        $(".loader_backdrop2").css('display', "none");
                        if (data.code == 200) {
                           
                            $(".tbody-salaire").html(data.data);
                            $("#totalSalaireCaisse").text(data.totalSalaireCaisse);
                            $("#totalSalaireEnAttente").text(data.totalSalaireEnAttente);
                            $("#totalSalaireMois").text(data.totalSalaireMois);

                            $.notify(data.message, 'success')
                           
                        } else {
                            $.notify(data.message)
                        }
                    }
                })
            }

        })


    });
}
// FIN Depense

//END FONCTION


showAndHidePassword();

function showAndHidePassword() {
    $('body').on('click', '#show-password', function (e) {
        if ($(this).prop('checked')) {
            $('.password').prop('type', 'text');
        } else {
            $('.password').prop('type', 'password');
            
        }

    });
}







// FIN EMPLOYE

// DATE PEEKER
// TRUE
datePek(".search-date-verification");

function datePek(selector) {
    $(selector).daterangepicker({
        "showWeekNumbers": true,
        "showISOWeekNumbers": true,
        "locale": {
            "format": "DD/MM/YYYY",
            "separator": " - ",
            "applyLabel": "Valider",
            "cancelLabel": "Annuler",
            "fromLabel": "From",
            "toLabel": "To",
            "customRangeLabel": "Custom",
            "weekLabel": "W",
            "daysOfWeek": [
                "DIM",
                "LUN",
                "MAR",
                "MER",
                "JEU",
                "VEN",
                "SAM"
            ],
            "monthNames": [
                "Janvier",
                "Fevrier",
                "Mars",
                "Avril",
                "Mai",
                "Juin",
                "Juillet",
                "Août",
                "Septembre",
                "Octobre",
                "Novembre",
                "Decembre"
            ],
            "firstDay": 1
        },
        "startDate": new Date(),
        "endDate": new Date()
    }, function(start, end, label) {

        dataReservation.start = start.format('YYYY-MM-DD H:mm:ss');
        dataReservation.end = end.endOf('day').format('YYYY-MM-DD H:mm:ss');

        var a = moment(end.format('YYYY-MM-DD'));
        var b = moment(start.format('YYYY-MM-DD'));

        dataReservation.days = a.diff(b, 'days') + 1;



    });

    $(selector).on('apply.daterangepicker', function(ev, picker) {
        $("#number_day").val(dataReservation.days);
        var periode = picker.startDate.format('DD/MM/YYYY') + ' au ' + picker.endDate.format('DD/MM/YYYY');
        $(".periode-verif").text(periode);

        checkDataChambreAblle(dataReservation.start, dataReservation.end);


    });

    $(selector).on('cancel.daterangepicker', function(ev, picker) {
        // $(this).val('');
    });


}

datePekEmptyReservation(".search-date-reservation");


function datePekEmptyReservation(selector) {

    $(selector).daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $(selector).on('apply.daterangepicker', function(ev, picker) {

        $('#search-date-reservation').val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        var periode = picker.startDate.format('DD/MM/YYYY') + ' au ' + picker.endDate.format('DD/MM/YYYY');
        $(".periode-reservation").text(periode);
        var date_debut = picker.startDate.format('YYYY-MM-DD 00:00:00'); // date debut
        date_finut = picker.endDate.format('YYYY-MM-DD 23:59:59');

        if($("#recapt-data-reservation").length){
            recaptListeReservations(date_debut, date_finut);
        }else{
            listeReservations(date_debut, date_finut);
        }



    });

    $(selector).on('cancel.daterangepicker', function(ev, picker) {
        $("#search-date-reservation").val('');
    });
}

datePekEmptyReservationActive(".search-date-reservation-active");


function datePekEmptyReservationActive(selector) {

    $(selector).daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $(selector).on('apply.daterangepicker', function(ev, picker) {

        $('#search-date-reservation-active').val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        var periode = picker.startDate.format('DD/MM/YYYY') + ' au ' + picker.endDate.format('DD/MM/YYYY');
        $(".periode-reservation").text(periode);
        var date_debut = picker.startDate.format('YYYY-MM-DD 00:00:00'); // date debut
        date_finut = picker.endDate.format('YYYY-MM-DD 23:59:59');

        // if($("#recapt-data-reservation").length){
        //     // recaptListeReservations(date_debut, date_finut);
        // }else{
            listeReservationsActive(date_debut, date_finut);
        // }



    });

    $(selector).on('cancel.daterangepicker', function(ev, picker) {
        // $("#search-date-reservation").val('');
    });
}

datePekEmptyReservationArrive(".search-date-reservation-arrive");

function datePekEmptyReservationArrive(selector) {

    $(selector).daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $(selector).on('apply.daterangepicker', function(ev, picker) {

        $('#search-date-reservation-arrive').val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        var periode = picker.startDate.format('DD/MM/YYYY') + ' au ' + picker.endDate.format('DD/MM/YYYY');
        $(".periode-reservation").text(periode);
        var date_debut = picker.startDate.format('YYYY-MM-DD 00:00:00'); // date debut
        date_finut = picker.endDate.format('YYYY-MM-DD 23:59:59');

        // if($("#recapt-data-reservation").length){
        //     // recaptListeReservations(date_debut, date_finut);
        // }else{
            listeReservationsArrive(date_debut, date_finut);
        // }



    });

    $(selector).on('cancel.daterangepicker', function(ev, picker) {
        // $("#search-date-reservation").val('');
    });
}

datePekEmptyClient(".search-date-client");

function datePekEmptyClient(selector) {

    $(selector).daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $(selector).on('apply.daterangepicker', function(ev, picker) {

        $('#search-date-client').val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        var periode = picker.startDate.format('DD/MM/YYYY') + ' au ' + picker.endDate.format('DD/MM/YYYY');
        $(".periode-client").text(periode);
        var date_debut = picker.startDate.format('YYYY-MM-DD 00:00:00'); // date debut
        date_finut = picker.endDate.format('YYYY-MM-DD 23:59:59');

        if($('#recapt-data-client').length){
            recaptListeCLient(date_debut, date_finut);
        }else{
            listeCLient(date_debut, date_finut);
        }

    });

    $(selector).on('cancel.daterangepicker', function(ev, picker) {
        $("#search-date-client").val('');
    });
}

datePekDepotCaisseComptable(".search-date-depot-caisse");

function datePekDepotCaisseComptable(selector) {

    $(selector).daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $(selector).on('apply.daterangepicker', function(ev, picker) {

        $('#search-date-depot-caisse').val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        var periode = picker.startDate.format('DD/MM/YYYY') + ' au ' + picker.endDate.format('DD/MM/YYYY');
        $(".periode-depot-caisse").text(periode);
        var date_debut = picker.startDate.format('YYYY-MM-DD 00:00:00'); // date debut
        date_finut = picker.endDate.format('YYYY-MM-DD 23:59:59');
        
        listeDepotCaisseComptable(date_debut, date_finut);


    });

    $(selector).on('cancel.daterangepicker', function(ev, picker) {
        $("#search-date-depot-caisse").val('');
    });
}

datePekBilanCaisseComptable(".search-date-bilan-caisse");

function datePekBilanCaisseComptable(selector) {

    $(selector).daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $(selector).on('apply.daterangepicker', function(ev, picker) {

        $('#search-date-bilan-caisse').val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        var periode = picker.startDate.format('DD/MM/YYYY') + ' au ' + picker.endDate.format('DD/MM/YYYY');
        $(".periode-caisse").text(periode);
        var date_debut = picker.startDate.format('YYYY-MM-DD 00:00:00'); // date debut
        date_finut = picker.endDate.format('YYYY-MM-DD 23:59:59');
       
        listeBilanCaisseComptable(date_debut, date_finut);


    });

    $(selector).on('cancel.daterangepicker', function(ev, picker) {
        $("#search-date-bilan-caisse").val('');
    });
}

datePekDepense(".search-date-depense");

function datePekDepense(selector) {

    $(selector).daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $(selector).on('apply.daterangepicker', function(ev, picker) {

        $('#search-date-depense').val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        var periode = picker.startDate.format('DD/MM/YYYY') + ' au ' + picker.endDate.format('DD/MM/YYYY');
        $(".periode-depense").text(periode);
        var date_debut = picker.startDate.format('YYYY-MM-DD 00:00:00'); // date debut
        date_finut = picker.endDate.format('YYYY-MM-DD 23:59:59');
        

        if($("#recapt-data-depense").length){
            recaptListeDepense(date_debut, date_finut);
        }else{
            listeDepense(date_debut, date_finut);
        }
      

    });

    $(selector).on('cancel.daterangepicker', function(ev, picker) {
        $("#search-date-depense").val('');
    });
}

datePekSalaire(".search-date-salaire");

function datePekSalaire(selector) {

    $(selector).daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $(selector).on('apply.daterangepicker', function(ev, picker) {

        $('#search-date-salaire').val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        var periode = picker.startDate.format('DD/MM/YYYY') + ' au ' + picker.endDate.format('DD/MM/YYYY');
        $(".periode-salaire").text(periode);
        var date_debut = picker.startDate.format('YYYY-MM-DD 00:00:00'); // date debut
        date_finut = picker.endDate.format('YYYY-MM-DD 23:59:59');
        
        listeSalaire(date_debut, date_finut);


    });

    $(selector).on('cancel.daterangepicker', function(ev, picker) {
        $("#search-date-salaire").val('');
    });
}



// DEBUT SERVICE

openModalAddService();

function openModalAddService() {
    $('#serviceAddModal').click(function(e) {
        e.preventDefault();
        

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'btn_showmodal_service'
            },
            dataType: "JSON",
            beforeSend: function() {
                $(".loader_backdrop2").css('display', "block");
                btnReq("#serviceAddModal", "Traitement...");

            },
            success: function(data) {
                btnRes("#serviceAddModal");
                ;

                if (data.code == 200) {
                    $(".data-modal").html(data.data);
                    $("#service-modal").modal("show");
                    $(".loader_backdrop2").css('display', "none");


                }

            }
        })
    });
}

ajouterService();

function ajouterService() {
    $("body").delegate("#frmAddService", "submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: data,
            dataType: "JSON",
            beforeSend: function() {
                btnReq("#btn_ajouter_service", "Enregistrement...");
            },
            success: function(data) {
                

                btnRes("#btn_ajouter_service");
                if (data.code == 200) {
                    // resetDataTable();
                    $.notify(data.message, "success");
                    $("#service-modal").modal("hide");
                    $("#sexion_service").load(" #sexion_service > *");
                    // setInterval(initDataTable, 120);

                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}

openModalUpdateService();

function openModalUpdateService() {
    $("body").delegate(".frmModifierService", "click", function(e) {
        e.preventDefault();
        var codeService = $(this).data("service");
        var id = $(this).attr("id");

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'modal_modifier_service',
                code: codeService
            },
            dataType: "JSON",
            beforeSend: function() {
                $(".loader_backdrop2").css('display', "block");
                btnReq("#" + id, "Traitement...");

            },
            success: function(data) {
                btnRes("#" + id, 'Modifier', 'fa-edit');
                if (data.code == 200) {
                    $(".data-modal").html(data.data);
                    $("#service-modal").modal("show");
                    $(".loader_backdrop2").css('display', "none");
                } else {
                    $.notify("Erreur lors du traitement", "error");
                }

            }
        })
    });
}


supprimerService();

function supprimerService() {
    $("body").delegate(".serviceDelete", "click", function(e) {
        e.preventDefault();
        var code = $(this).data("service");

        swal({
            title: "Êtes vous sûr ?",
            text: "Cela entrainera la suppression de plusieurs données",
            type: "warning",
            buttons: {
                cancel: {
                    visible: true,
                    text: "Annuler",
                    className: 'btn btn-default'
                },
                confirm: {
                    text: 'Confirmer',
                    className: 'btn btn-danger'
                }
            }

        }).then(function(result) {
            if (result) {

                $.ajax({
                    method: "POST",
                    url: URL_AJAX,
                    data: {
                        action: 'btn_delete_service',
                        id_service: code
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $(".loader_backdrop2").css('display', "block");

                    },
                    success: function(data) {
                        
                        if (data.code == 200) {
                            resetDataTable();
                            $.notify(data.message, "success");
                            $("#sexion_service").load(" #sexion_service > *");
                            $(".loader_backdrop2").css('display', "none");
                            setTimeout(initDataTable, 200);


                        } else {
                            $.notify(data.message, "error");
                        }
                    }
                })
            }

        })


    });
}

// FIN SERVICE

// CATEGORIE
openModalAddCategorie();

function openModalAddCategorie() {
    $('#categorieAddModal').click(function(e) {
        e.preventDefault();
        

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'btn_showmodal_categorie'
            },
            dataType: "JSON",
            beforeSend: function() {
                $(".loader_backdrop2").css('display', "block");
                btnReq("#categorieAddModal", "Traitement...");

            },
            success: function(data) {
                btnRes("#categorieAddModal");
                ;

                if (data.code == 200) {
                    $(".data-modal").html(data.data);
                    $("#categorie-modal").modal("show");
                    $(".loader_backdrop2").css('display', "none");


                }

            }
        })
    });
}

// ajouter_categorie();

// function ajouter_categorie() {
//     $("body").delegate("#frmAddCategorie", "submit", function(e) {
//         e.preventDefault();
//         var data = $(this).serialize();
        
//         $.ajax({
//             method: "POST",
//             url: URL_AJAX,
//             data: data,
//             dataType: "json",
//             beforeSend: function() {
//                 btnReq("#btn_ajouter_categorie", "Enregistrement...");
//             },
//             success: function(data) {
//                 console.log(data);
                
//                 btnRes("#btn_ajouter_categorie");
//                 if (data.code == 200) {
//                     // resetDataTable();
//                     $.notify(data.message, "success");
//                     $("#categorie-modal").modal("hide");
//                     $("#sexion_categorie").load(" #sexion_categorie > *");
//                     // setInterval(initDataTable, 120);

//                 } else {
//                     $.notify(data.message);
//                 }
//             }
//         })
//     });
// }

openModalUpdateCategorie();

function openModalUpdateCategorie() {
    $("body").delegate(".frmModifierCategorie", "click", function(e) {
        e.preventDefault();
        var codeTypehambre = $(this).data("categorie");
        var id = $(this).attr("id");

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'modal_modifier_categorie',
                code: codeTypehambre
            },
            dataType: "JSON",
            beforeSend: function() {
                $(".loader_backdrop2").css('display', "block");
                btnReq("#" + id, "Traitement...");

            },
            success: function(data) {
                btnRes("#" + id, 'Modifier', 'fa-edit');
                if (data.code == 200) {
                    $(".data-modal").html(data.data);
                    $("#categorie-modal").modal("show");
                    $(".loader_backdrop2").css('display', "none");
                } else {
                    $.notify("Erreur lors du traitement", "error");
                }

            }
        })
    });
}

// modifier_categorie();
function modifier_categorie() {
    $("body").delegate("#frmUpdateCategorie", "submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: data,
            dataType: "json",
            beforeSend: function() {
                btnReq("#btn_modifier_categorie", "Enregistrement...");
            },
            success: function(data) {
                btnRes("#btn_modifier_categorie", 'Enregistrer');

                if (data.code == 200) {

                    resetDataTable();
                    $.notify(data.message, "success");
                    $("#categorie-modal").modal("hide");
                    $("#sexion_categorie").load(" #sexion_categorie > *");
                    setTimeout(initDataTable, 200);

                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}


supprimer_categorie();

function supprimer_categorie() {
    $("body").delegate(".categorieDelete", "click", function(e) {
        e.preventDefault();
        var code = $(this).data("categorie");
        var id = $(this).attr("id");

        swal({
            title: "Êtes vous sûr ?",
            text: "Cela entrainera la suppression de plusieurs données",
            type: "warning",
            buttons: {
                cancel: {
                    visible: true,
                    text: "Annuler",
                    className: 'btn btn-default'
                },
                confirm: {
                    text: 'Confirmer',
                    className: 'btn btn-danger'
                }
            }

        }).then(function(result) {
            if (result) {

                $.ajax({
                    method: "POST",
                    url: URL_AJAX,
                    data: {
                        action: 'btn_delete_categorie',
                        id_categorie: code
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $(".loader_backdrop2").css('display', "block");
                        btnReq("#" + id, "Traitement...");

                    },
                    success: function(data) {
                        btnRes("#" + id, 'Supprimer', 'fa-trash');
                        if (data.code == 200) {
                            resetDataTable();
                            $.notify(data.message, "success");
                            $("#sexion_categorie").load(" #sexion_categorie > *");
                            $(".loader_backdrop2").css('display', "none");
                            setTimeout(initDataTable, 200);
                        

                        } else {
                            $.notify(data.message, "error");
                        }
                    }
                })
            }

        })


    });
}
// FIN CATEGORIE




// CHAMBRE

openModalAddChambre();

function openModalAddChambre() {
    $('#chambreAddModal').click(function(e) {
        e.preventDefault();
        

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'btn_showmodal_chambre'
            },
            dataType: "JSON",
            beforeSend: function() {

                $(".loader_backdrop2").css('display', "block");
            },
            success: function(data) {

                if (data.code == 200) {
                    $(".data-modal").html(data.data);
                    $("#chambre-modal").modal("show");
                    $(".loader_backdrop2").css('display', "none");

                }

            }
        })
    });
}

ajouter_chambre();

function ajouter_chambre() {
    $("body").delegate("#frmAddAhambre", "submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: data,
            dataType: "json",
            beforeSend: function() {
                btnReq("#btn_ajouter_chambre", "Traitement...");

            },
            success: function(data) {
                btnRes("#btn_ajouter_chambre", "Enregistrer", "fa-check-circle");
                if (data.code == 200) {
                    // resetDataTable();
                    $.notify(data.message, "success");
                    $("#chambre-modal").modal("hide");
                    $("#sexion_chambre").load(" #sexion_chambre > *");
                    // setInterval(initDataTable, 120);

                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}

openModalUpdateChambre();

function openModalUpdateChambre() {
    $("body").delegate(".chambreUpdateModal", "click", function(e) {
        e.preventDefault();
        var id = $(this).data("chambre");

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'frm_update_chambre',
                id_chambre: id
            },
            dataType: "json",
            beforeSend: function() {

                $(".loader_backdrop2").css('display', "block");

            },
            success: function(data) {
                ;

                if (data.code == 200) {
                    $(".data-modal").html(data.data);
                    $("#chambre-modal").modal("show");
                    $(".loader_backdrop2").css('display', "none");

                }

            }
        })
    });
}

supprimer_chambre();

function supprimer_chambre() {
    $("body").delegate(".chambreDelete", "click", function(e) {
        e.preventDefault();
        var id = $(this).data("chambre");
        swal({
            title: "Êtes vous sûr ?",
            text: "Cela entrainera la suppression de plusieurs données",
            type: "warning",
            buttons: {
                cancel: {
                    visible: true,
                    text: "Annuler",
                    className: 'btn btn-default'
                },
                confirm: {
                    text: 'Confirmer',
                    className: 'btn btn-danger'
                }
            }

        }).then(function(result) {
            if (result) {

                $.ajax({
                    method: "POST",
                    url: URL_AJAX,
                    data: {
                        action: 'btn_delete_chambre',
                        id_chambre: id
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $(".loader_backdrop2").css('display', "block");
                    },
                    success: function(data) {
                        ;

                        if (data.code == 200) {
                            resetDataTable();
                            $.notify(data.message, 'success')
                            $("#sexion_chambre").load(" #sexion_chambre > *");
                            setTimeout(initDataTable, 200);
                            $(".loader_backdrop2").css('display', "none");
                        } else {
                            $.notify(data.message)
                        }
                    }
                });
            }

        })


    });
}
// FIN CHAMBRE

// modifier hotel

updateInfoHotel();
function updateInfoHotel() {

    $("body").delegate("#form_update_hotel", "submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        
        $.ajax({
            url: URL_AJAX,
            method: 'POST',
            data: data,
            dataType: 'JSON',
            beforeSend: function() {
                btnReq(".btn_update_hotel", "Traitement...");
            },
            success: function(data) {
                ;
                
                btnRes(".btn_update_hotel", "Enregistrer", "fa-save");
                if (data.code == 200) {
                    $.notify(data.message, 'success')
                }else{
                   $.notify(data.message, 'error')
                }
            }
        });

    });

    
}

// trigger open input file


btbTriggerUploadLogo();
function btbTriggerUploadLogo() {

    // to trigger input file clieck
    $("body").delegate("#btn_trigger_input_file", "click", function(e) {
        e.preventDefault();
        
        $('#fileInput').trigger('click');
    });

    // to detect on change
    $("body").delegate("#fileInput", "change", function(e) {
        e.preventDefault();
        const file = e.target.files[0];
        if (file) {
            $('.previewImg').attr('src', URL.createObjectURL(file)).show();
            $("#btn_update_logo").prop('disabled', false);
        }

    });

    // to save on database
    $("body").delegate("#uploadForm", "submit", function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        $.ajax({
            url: URL_AJAX,
            method: 'POST',
            data: formData,
            contentType: false,       // important
            processData: false,  
            dataType: 'JSON',
            beforeSend: function() {
                $("#btn_update_logo").prop('disabled', true);
                btnReq("#btn_update_logo", "Traitement...");
            },
            success: function(data) {
                ;
               
                btnRes("#btn_update_logo", "Changer", "fa-camera fa-lg");
                if (data.code == 200) {
                    $("#btn_update_logo").prop('disabled', true);
                    $.notify(data.message, 'success')
                }else{
                   $.notify(data.message);
                   $("#btn_update_logo").prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                $("#btn_update_logo").prop('disabled', false);
                // $.notify(error);
              }
        });

    });
}

// fin modifier horel


openModalUpdateReservation();

function openModalUpdateReservation() {
    $("body").delegate(".reservationUpdateModal", "click", function(e) {
        e.preventDefault();
        var id = $(this).data("chambre");
        var mt = $(this).data("montant");
        

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'btn_showmodal_reservation',
                id_chambre: id,
                montant: mt
            },
            dataType: "JSON",
            beforeSend: function() {

                $(".loader_backdrop2").css('display', "block");

            },
            success: function(data) {
                ;
                
                $(".loader_backdrop2").css('display', "none");
                if (data.code == 200) {
                    $('#frm_ajouter_client')[0].reset();
                    $('#frm_ajouter_reservation')[0].reset();
                    $('.show_resultat').html('');

                    $(".data-modal").html(data.data);
                    $("#reservation-modal").modal("show");

                } else {
                    $.notify(data.message);
                }

            }
        })
    });
}

DateGoOut();

function DateGoOut() {

    var r = $("#countdown").html() === undefined;
    if (!r) {
        var result = "";
        var today = moment().format('YYYY-MM-DD');
        var date_sortie = $('#date_sortie').val();
        result = (today < date_sortie) ?
            moment(date_sortie).endOf('day').fromNow() :
            moment(date_sortie).endOf('day').fromNow();

        $('#countdown').text(result);
    }
}

function countdown(targetDate) {
    const countDownDate = new Date(targetDate).getTime();

    interval = setInterval(() => {
        const now = new Date().getTime();
        const distance = countDownDate - now;

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        let countdownText = "";

        if (days > 0 && days > 1) {
            countdownText += `${days.toString().padStart(2, '0')} Jours, `;
        } else if (days > 0) {
            countdownText += `${days.toString().padStart(2, '0')} Jour, `;

        }

        if (hours > 0) {
            countdownText += `${hours.toString().padStart(2, '0')} : `;
        }

        if (minutes > 0) {
            countdownText += `${minutes.toString().padStart(2, '0')} :`;
        }
        


        countdownText += ` ${seconds.toString().padStart(2, '0')} `;

        $('#countdown').text(countdownText);
        // $('#countdown').fadeOut(500, function() {
        //     $(this).text(countdownText).fadeIn(500);
        // });

        if (distance < 0) {
            clearInterval(interval);
            $('#countdown').text("Temps écoulé!");
            // $('#countdown').fadeOut(500, function() {
            //     $(this).text("Temps écoulé!").fadeIn(500);
            // });
        }
        

    }, 1000);
}


// DEBUT SEXION IMPRIMER DATA

printListeClient();

function printListeClient() {
    $("body").delegate("#btn_imprimer_liste_client", "click", function(e) {
        e.preventDefault();
        var periode = $(this).data('periode');

        window.open(URL_HOME + "print/liste-client/" + periode, "_blank");

    });
}

printListeReservation();

function printListeReservation() {
    $("body").delegate("#btn_imprimer_liste_reservation", "click", function(e) {
        e.preventDefault();
        var periode = $(this).data('periode');

        window.open(URL_HOME + "print/liste-reservation/" + periode, "_blank");

    });
}

printListeCheckReservation();

function printListeCheckReservation() {
    $("body").delegate("#btn_imprimer_liste_check_reservation", "click", function(e) {
        e.preventDefault();
        var periode = $(this).data('periode');

        window.open(URL_HOME + "print/liste-check-reservation/" + periode, "_blank");

    });
}

printListeDepense();

function printListeDepense() {
    $("body").delegate("#btn_imprimer_liste_depense", "click", function(e) {
        e.preventDefault();
        var periode = $(this).data('periode');

        window.open(URL_HOME + "print/liste-depense/" + periode, "_blank");

    });
}

printListeSalaire();

function printListeSalaire() {
    $("body").delegate("#btn_imprimer_liste_salaire", "click", function(e) {
        e.preventDefault();
        var periode = $(this).data('periode');

        window.open(URL_HOME + "print/liste-salaire/" + periode, "_blank");

    });
}


printRecaptListechambres();

function printRecaptListechambres() {
    $("body").delegate("#btn_print_recapt_chambre", "click", function(e) {
        e.preventDefault();


        window.open(URL_HOME + "print/liste-chambres", "_blank");

    });
}

printRecaptListeServices();

function printRecaptListeServices() {
    $("body").delegate("#btn_print_recapt_services", "click", function(e) {
        e.preventDefault();


        window.open(URL_HOME + "print/liste-services", "_blank");

    });
}

printListVersement();

function printListVersement() {
    $("body").delegate("#btn_imprimer_liste_versement", "click", function(e) {
        e.preventDefault();
        var periode = $(this).data('periode');

        window.open(URL_HOME + "print/liste-versement/" + periode, "_blank");

    });
}

// FIN SEXION INPRIMER DATA


// Exemple d'utilisation: Démarrer un compte à rebours jusqu'au 1er janvier 2025
// countdown("2025-09-15 03:45:00");

// showCountDown();



function showCountDown() {

    var r = $("#countdown").html() === undefined;
    if (!r) {
        var date_end = $("#date_end").text();
        var newDateEnd = date_end + " 23:59:00";
        

        // var timeEnd =new Date(newDateEnd).getTime();
        // const timeNow = new Date().getTime();
        // if (timeEnd < timeNow) {
        //     return;
        // }

        countdown(newDateEnd);
        $(document).on("visibilitychange", function() {

            if (document.hidden) {
                // Page cachée : arrêter l'animation
                clearInterval(interval);
            } else {
                // Page visible : redémarrer l'animation

                countdown(newDateEnd);


            }
        });
    }
}

// function afficherAlerte(titre, texte, icone) {
//     Swal.fire({
//         title: titre,
//         text: texte,
//         icon: icone, // 'success', 'error', 'warning', 'info', or 'question'
//         confirmButtonText: 'OK'
//     });
// }


// function showConfirmation() {
//     Swal.fire({
//         title: 'Es-tu sûr?',
//         text: "Tu ne pourras pas revenir en arrière!",
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Oui, confirme-le!',
//         cancelButtonText: 'Annuler'
//     }).then((result) => {
//         if (result.isConfirmed) {
//             Swal.fire(
//                 'Confirmé!',
//                 'Ton action a été confirmée.',
//                 'success'
//             );
//         }
//     });
// }


// function showAlert() {
//     swal({
//         title: 'Are you sure?',
//         text: "You won't be able to revert this!",
//         type: 'warning'

//     }).then(function(){

//     })
// }

// swal({
//     title: 'Are you sure?',
//     text: "You won't be able to revert this!",
//     type: 'warning',
//     buttons:{
//         confirm: {
//             text : 'Yes, delete it!',
//             className : 'btn btn-success'
//         },
//         cancel: {
//             visible: true,
//             className: 'btn btn-danger'
//         }
//     }
// })



/**** SEXION CHART ******/

selectYearDashboard();
function selectYearDashboard(){
    $('body').delegate("#search-year-activity", 'change', function (e) {
        
        var val = $(this).val();
    if (val != undefined || val != "") {
    
            ajaxBilanDashoard(val);
            
    }});

}

getCanvasMonthData();
function getCanvasMonthData() {
    if ($("#dashboard-bilan").length > 0) {
        
         var year  = localStorage.getItem('data-year');
         
         var selectActivityYear = year !== null ? year : moment().format('YYYY');
         $('#search-year-activity').html(showInputYear(selectActivityYear));        

        ajaxBilanDashoard();
    }
}



function ajaxBilanDashoard(year =null) {

     $.ajax({
        method: "POST",
        url: URL_AJAX,
        data: {
            action: 'chart_bilan_dashboard',
            annee:year
        },
        dataType: "json",
        beforeSend: function() {
            $(".loader_backdrop2").css('display', "block");
        },
        success: function(data) {
            ;
            var res = null;
      
            $(".loader_backdrop2").css('display', "none");

            if (data.code == 200) {
                // var vente = JSON.parse(data);
                var val = data.data;
                // Créer t3 avec des zéros par défaut
                 res = labels.map((mois, index) => {
                // Trouver si le mois existe dans t1 (mois = index + 1)
                const data = val.find(item => item.mois === index + 1);
                // Si trouvé, retourner le montant_total converti en nombre, sinon 0
                return data ? parseFloat(data.montant_total) : 0;
                });

            }else{
                $.notify(data.message)
            }
            monthCanvasDashboard('mycanva',res);
        }
    });

}



function monthCanvasDashboard(canvasId,total){

    // Données du graphique
    if (charts[canvasId]) {
        charts[canvasId].destroy();
    }

    var canvas = $('#'+canvasId)[0].getContext('2d');
    let gradient = canvas.createLinearGradient(0,0,0,400);
    gradient.addColorStop(0,'rgba(58,123,213,1)');
    gradient.addColorStop(1,'rgba(0,210,255,0.5)');
 
        
    const data = {
        labels: labels,
        datasets: [
          {
            label: 'Total recette',
            data:total,
            backgroundColor: gradient, // bleu
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            borderRadius: 5
          }
        ]
      };

 // Configuration du graphique
 const config = {
    type: 'bar',
    data: data,
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Montant total (FCFA)'
          }
        },
        x: {
          title: {
            display: false,
            text: 'Mois'
          }
        }
      },
      plugins: {
        legend: {
          position: 'top'
        },
        title: {
          display: true,
          text: 'Total recete (Janvier - Decembre)'
        }
      }
    },
  };

    charts[canvasId] = new Chart(canvas,config);

}

function showInputYear(year){
    var output = '';
    var begin = moment().format('YYYY');
    
    if(begin == year) return `<option value="${begin}">${begin}</option>`;

    for (let i = begin; i < year; i--) {
        output += `<option value="${begin}">${begin}</option>`;
        
    }
    return output;
}










