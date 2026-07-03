
/** DEBUT SECTION BOUTIQUE */

loadDataTable('data-table-boutique', '#data-table-boutique', 'bcharger_data_boutiques');

bopenModalAddBoutique();
function bopenModalAddBoutique() {
    $('#BoutiqueAddModal').click(function (e) {
        e.preventDefault();

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'btn_showmodal_boutique_add'
            },
            dataType: "JSON",
            beforeSend: function () {
                $(".loader_backdrop2").css('display', "block");
                // btnReq("#ClientAddModal", "Traitement...");

            },
            success: function (data) {
                // btnRes("#ClientAddModal", 'Ajouter un client', 'fa-plus');
                // ;
                console.log(data);
                

                if (data.code == 200) {
                    $(".data-modal").html(data.data);
                    $("#boutique-modal").modal("show");
                    $(".loader_backdrop2").css('display', "none");


                }

            }
        })
    });
}

bAjouterBoutique();
function bAjouterBoutique() {
    $("body").delegate("#frmAddBoutiqueData", "submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: data,
           dataType: "json",
            beforeSend: function () {
                $(".loader_backdrop2").css('display', "block");
                
                btnReq(".modal_footer", "Enregistrement...");
            },
            success: function(data) {
                console.log(data);
                    $(".loader_backdrop2").css('display', "none");

                btnRes(".modal_footer", "Ajouter le boutique", "fa-save");
                if (data.code == 200) {
                    tables['data-table-boutique'].ajax.reload(null, false);
                    $.notify(data.message, "success");
                    $("#boutique-modal").modal("hide");
                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}

bOpenModalUpdateBoutique();
function bOpenModalUpdateBoutique() { 
    $("body").delegate(".frmModifierBoutiqueData", "click", function (e) { 
        var code_boutique = $(this).data("boutique");
        console.log(code_boutique);
       
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'frm_modal_modifier_boutique',
                codeBoutique: code_boutique
            },
            dataType: "JSON",
            beforeSend: function() {
                $(".loader_backdrop2").css('display', "block");
                // btnReq(".modal_footer", "Traitement...");

            },
            success: function(data) {
                // btnRes(".modal_footer", 'Enregistrer le fournisseur', 'fa-save');
                $(".loader_backdrop2").css('display', "none");
                if (data.code == 200) {
                    $(".data-modal").html(data.data);
                    $("#boutique-modal").modal("show");
                } else {
                    $.notify("Erreur lors du traitement", "error");
                }

            }
        })
    }
    );
}

bUpdateBoutique();
function bUpdateBoutique() {
    $("body").delegate("#frmUpdateBoutiqueData", "submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();


        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: data,
            dataType: "json",
            beforeSend: function () {
                $(".loader_backdrop2").css('display', "block");
                
                btnReq(".modal_footer", "Mise à jour en cours...");
            },
            success: function(data) {
                console.log(data);
                $(".loader_backdrop2").css('display', "none");

                btnRes(".modal_footer", "Mettre à jour le boutique", "fa-edit");
                if (data.code == 200) {
                    tables['data-table-boutique'].ajax.reload(null, false);
                    $.notify(data.message, "success");
                    $("#boutique-modal").modal("hide");

                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}

/** FIN SECTION CLIENT */



