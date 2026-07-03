
/** DEBUT SECTION CLIENT */

loadDataTable('data-table-client', '#data-table-client', 'bcharger_data_clients');

bopenModalAddClient();
function bopenModalAddClient() {
    $('#ClientAddModal').click(function (e) {
        e.preventDefault();

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'btn_showmodal_client_add'
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
                    $("#client-modal").modal("show");
                    $(".loader_backdrop2").css('display', "none");


                }

            }
        });
    });
}

bAjouterClient();
function bAjouterClient() {
    $("body").delegate("#frmAddClientData", "submit", function(e) {
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

                btnRes(".modal_footer", "Ajouter le client", "fa-save");
                if (data.code == 200) {
                    tables['data-table-client'].ajax.reload(null, false);
                    $.notify(data.message, "success");
                    $("#client-modal").modal("hide");

                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}

bOpenModalUpdateClient();
function bOpenModalUpdateClient() { 
    $("body").delegate(".frmModifierClientData", "click", function (e) { 
        var code_client = $(this).data("client");
        console.log(code_client);
       
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'frm_modal_modifier_client',
                codeClient: code_client
            },
            dataType: "JSON",
            beforeSend: function() {
                $(".loader_backdrop2").css('display', "block");
                // btnReq(".modal_footer", "Traitement...");

            },
            success: function(data) {
                // btnRes(".modal_footer", 'Enregistrer le client', 'fa-save');
                $(".loader_backdrop2").css('display', "none");
                if (data.code == 200) {
                    $(".data-modal").html(data.data);
                    $("#client-modal").modal("show");
                } else {
                    $.notify("Erreur lors du traitement", "error");
                }

            }
        })
    }
    );
}

bUpdateClient();
function bUpdateClient() {
    $("body").delegate("#frmUpdateClientData", "submit", function(e) {
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

                btnRes(".modal_footer", "Mettre à jour le client", "fa-edit");
                if (data.code == 200) {
                    tables['data-table-client'].ajax.reload(null, false);
                    $.notify(data.message, "success");
                    $("#client-modal").modal("hide");

                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}

/** FIN SECTION CLIENT */




/** DEBUT SECTION FOURNISSEUR */

loadDataTable('data-table-fournisseur', '#data-table-fournisseur', 'bcharger_data_fournisseurs');

bopenModalAddFournisseur();
function bopenModalAddFournisseur() {
    $('#FournisseurAddModal').click(function (e) {
        e.preventDefault();

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'btn_showmodal_fournisseur_add'
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
                    $("#fournisseur-modal").modal("show");
                    $(".loader_backdrop2").css('display', "none");


                }

            }
        })
    });
}

bAjouterFournisseur();
function bAjouterFournisseur() {
    $("body").delegate("#frmAddFournisseurData", "submit", function(e) {
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

                btnRes(".modal_footer", "Ajouter le fournisseur", "fa-save");
                if (data.code == 200) {
                    tables['data-table-fournisseur'].ajax.reload(null, false);
                    $.notify(data.message, "success");
                    $("#fournisseur-modal").modal("hide");
                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}

bOpenModalUpdateFournisseur();
function bOpenModalUpdateFournisseur() { 
    $("body").delegate(".frmModifierFournisseurData", "click", function (e) { 
        var code_fournisseur = $(this).data("fournisseur");
        console.log(code_fournisseur);
       
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'frm_modal_modifier_fournisseur',
                codeFournisseur: code_fournisseur
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
                    $("#fournisseur-modal").modal("show");
                } else {
                    $.notify("Erreur lors du traitement", "error");
                }

            }
        })
    }
    );
}

bUpdateFournisseur();
function bUpdateFournisseur() {
    $("body").delegate("#frmUpdateFournisseurData", "submit", function(e) {
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

                btnRes(".modal_footer", "Mettre à jour le fournisseur", "fa-edit");
                if (data.code == 200) {
                    tables['data-table-fournisseur'].ajax.reload(null, false);
                    $.notify(data.message, "success");
                    $("#fournisseur-modal").modal("hide");

                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}

/** FIN SECTION CLIENT */



