loadDataTable('data-table-categorie', '#data-table-categorie', 'aCharger_data_categories');
loadDataTable('data-table-mark', '#data-table-mark', 'aCharger_data_marks');
loadDataTable('data-table-unite', '#data-table-unite', 'aCharger_data_unites');
loadDataTable('data-table-produit', '#data-table-produit', 'aCharger_data_produits');

aSupprimer_categorie();

function aSupprimer_categorie() {
    $("body").delegate(".categorieDeleteCategorie", "click", function(e) {
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
                        code_categorie: code
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $(".loader_backdrop2").css('display', "block");
                        btnReq("#" + id, "Traitement...");

                    },
                    success: function(data) {
                        
                        $(".loader_backdrop2").css('display', "none");
                        btnRes("#" + id, 'Supprimer', 'fa-trash');
                        if (data.code == 200) {
                            tables['data-table-categorie'].ajax.reload(null, false);

                            $.notify(data.message, "success");
                        

                        } else {
                            $.notify(data.message, "error");
                        }
                    }
                })
            }

        })


    });
}

aOpenModalUpdateCategorie();

function aOpenModalUpdateCategorie() {
    $("body").delegate(".frmModifierCategorie", "click", function(e) {
        e.preventDefault();
        var code_categorie = $(this).data("categorie");
        var id = $(this).attr("id");
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'modal_modifier_categorie',
                code: code_categorie
            },
            dataType: "JSON",
            beforeSend: function() {
                $(".loader_backdrop2").css('display', "block");
                btnReq("#" + id, "Traitement...");

            },
            success: function(data) {
                
                btnRes("#" + id, 'Modifier', 'fa-edit');
                $(".loader_backdrop2").css('display', "none");
                if (data.code == 200) {
                    $(".data-modal").html(data.data);
                    $("#categorie-modal").modal("show");
                } else {
                    $.notify("Erreur lors du traitement", "error");
                }

            }
        })
    });
}


// CATEGORIE
aOpenModalAddCategorie();

function aOpenModalAddCategorie() {
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

                $(".loader_backdrop2").css('display', "none");
                if (data.code == 200) {
                    $(".data-modal").html(data.data);
                    $("#categorie-modal").modal("show");

                }

            }
        })
    });
}


aAjouter_categorie();
function aAjouter_categorie() {
    $("body").delegate("#frmAddCategorie", "submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: data,
            dataType: "json",
            beforeSend: function() {
                btnReq("#btn_ajouter_categorie", "Enregistrement...");
            },
            success: function(data) {
                
                btnRes("#btn_ajouter_categorie");
                $(".loader_backdrop2").css('display', "none");
                if (data.code == 200) {
                    tables['data-table-categorie'].ajax.reload(null, false);
                    $.notify(data.message, "success");
                    $("#categorie-modal").modal("hide");

                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}
// FIN CATEGORIE


// mark

aSupprimer_mark();
function aSupprimer_mark() {
    $("body").delegate(".markDeleteMark", "click", function(e) {
        e.preventDefault();
        var code = $(this).data("mark");
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
                        action: 'btn_delete_mark',
                        code_mark: code
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $(".loader_backdrop2").css('display', "block");
                        btnReq("#" + id, "Traitement...");

                    },
                    success: function(data) {
                        btnRes("#" + id, 'Supprimer', 'fa-trash');
                        $(".loader_backdrop2").css('display', "none");
                        if (data.code == 200) {
                            tables['data-table-mark'].ajax.reload(null, false);
                            $.notify(data.message, "success");

                        } else {
                            $.notify(data.message, "error");
                        }
                    }
                })
            }

        })


    });
}

aOpenModalUpdateMark();

function aOpenModalUpdateMark() {
    $("body").delegate(".frmModifierMark", "click", function(e) {
        e.preventDefault();
        var code_mark = $(this).data("mark");
        var id = $(this).attr("id");

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'modal_modifier_mark',
                code: code_mark
            },
            dataType: "JSON",
            beforeSend: function() {
                $(".loader_backdrop2").css('display', "block");
                btnReq("#" + id, "Traitement...");

            },
            success: function(data) {
                
                btnRes("#" + id, 'Modifier', 'fa-edit');
                $(".loader_backdrop2").css('display', "none");
                if (data.code == 200) {
                    $(".data-modal").html(data.data);
                    $("#mark-modal").modal("show");
                } else {
                    $.notify("Erreur lors du traitement", "error");
                }

            }
        })
    });
}

aOpenModalAddmark();

function aOpenModalAddmark() {
    $('#markAddModal').click(function(e) {
        e.preventDefault();
        

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'btn_showmodal_mark'
            },
            dataType: "JSON",
            beforeSend: function() {
                $(".loader_backdrop2").css('display', "block");
                btnReq("#markAddModal", "Traitement...");

            },
            success: function(data) {

                btnRes("#markAddModal");
                ;

                $(".loader_backdrop2").css('display', "none");
                if (data.code == 200) {
                    $(".data-modal").html(data.data);
                    $("#mark-modal").modal("show");


                }

            }
        })
    });
}


aAjouter_mark();
function aAjouter_mark() {
    $("body").delegate("#frmAddMark", "submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: data,
            dataType: "json",
            beforeSend: function() {
                btnReq("#btn_ajouter_mark", "Enregistrement...");
            },
            success: function(data) {
                
                btnRes("#btn_ajouter_mark");
                $(".loader_backdrop2").css('display', "none");
                if (data.code == 200) {
                    tables['data-table-mark'].ajax.reload(null, false);
                    $.notify(data.message, "success");
                    $("#mark-modal").modal("hide");

                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}
// FIN mark
// unite

aSupprimer_unite();
function aSupprimer_unite() {
    $("body").delegate(".uniteDeleteUnite", "click", function(e) {
        e.preventDefault();
        var code = $(this).data("unite");
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
                        action: 'btn_delete_unite',
                        code_unite: code
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $(".loader_backdrop2").css('display', "block");
                        btnReq("#" + id, "Traitement...");

                    },
                    success: function(data) {
                        btnRes("#" + id, 'Supprimer', 'fa-trash');
                        $(".loader_backdrop2").css('display', "none");
                        if (data.code == 200) {
                            tables['data-table-unite'].ajax.reload(null, false);
                            $.notify(data.message, "success");

                        } else {
                            $.notify(data.message, "error");
                        }
                    }
                })
            }

        })


    });
}

aOpenModalUpdateUnite();

function aOpenModalUpdateUnite() {
    $("body").delegate(".frmModifierUnite", "click", function(e) {
        e.preventDefault();
        var code_unite = $(this).data("unite");
        var id = $(this).attr("id");

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'modal_modifier_unite',
                code: code_unite
            },
            dataType: "JSON",
            beforeSend: function() {
                $(".loader_backdrop2").css('display', "block");
                btnReq("#" + id, "Traitement...");

            },
            success: function(data) {
                
                btnRes("#" + id, 'Modifier', 'fa-edit');
                $(".loader_backdrop2").css('display', "none");
                if (data.code == 200) {
                    $(".data-modal").html(data.data);
                    $("#unite-modal").modal("show");
                } else {
                    $.notify("Erreur lors du traitement", "error");
                }

            }
        })
    });
}

aOpenModalAddUnite();

function aOpenModalAddUnite() {
    $('#uniteAddModal').click(function(e) {
        e.preventDefault();
        

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'btn_showmodal_unite'
            },
            dataType: "JSON",
            beforeSend: function() {
                $(".loader_backdrop2").css('display', "block");
                btnReq("#uniteAddModal", "Traitement...");

            },
            success: function(data) {

                btnRes("#uniteAddModal");
                $(".loader_backdrop2").css('display', "none");
                if (data.code == 200) {
                    $(".data-modal").html(data.data);
                    $("#unite-modal").modal("show");


                }

            }
        })
    });
}


aAjouter_unite();
function aAjouter_unite() {
    $("body").delegate("#frmAddUnite", "submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: data,
            dataType: "json",
            beforeSend: function() {
                btnReq("#btn_ajouter_unite", "Enregistrement...");
            },
            success: function(data) {
                
                btnRes("#btn_ajouter_unite");
                $(".loader_backdrop2").css('display', "none");

                if (data.code == 200) {
                    tables['data-table-unite'].ajax.reload(null, false);
                    $.notify(data.message, "success");
                    $("#unite-modal").modal("hide");

                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}
// FIN unite


aSupprimer_produit();

function aSupprimer_produit() {
    $("body").delegate(".produitDeleteProduit", "click", function(e) {
        e.preventDefault();
        var code = $(this).data("produit");
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
                        action: 'btn_delete_produit',
                        code_produit: code
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $(".loader_backdrop2").css('display', "block");
                        btnReq("#" + id, "Traitement...");

                    },
                    success: function(data) {
                        
                        btnRes("#" + id, 'Supprimer', 'fa-trash');
                        $(".loader_backdrop2").css('display', "none");
                        if (data.code == 200) {
                            tables['data-table-produit'].ajax.reload(null, false);
                            $.notify(data.message, "success");
                        
                        } else {
                            $.notify(data.message, "error");
                        }
                    }
                })
            }

        })


    });
}

// produit
aOpenModalAddProduit();
function aOpenModalAddProduit() {
    $('#produitAddModal').click(function(e) {
        e.preventDefault();
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'btn_showmodal_produit'
            },
            dataType: "JSON",
            beforeSend: function() {                
                $(".loader_backdrop2").css('display', "block");
                btnReq("#produitAddModal", "Traitement...");

            },
            success: function(data) {

                btnRes("#produitAddModal");

                $(".loader_backdrop2").css('display', "none");
                if (data.code == 200) {
                    $(".data-modal").html(data.data);
                    $("#produit-modal").modal("show");


                }

            }
        })
    });
}


aAjouter_produit();
function aAjouter_produit() {
    $("body").delegate("#frmAddProduit", "submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        // console.log(data);
        
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: data,
            dataType: "json",
            beforeSend: function() {
                btnReq("#btn_ajouter_produit", "Enregistrement...");
            },
            success: function(data) {
                console.log(data);
                
                btnRes("#btn_ajouter_produit");
                $(".loader_backdrop2").css('display', "none");

                if (data.code == 200) {
                    tables['data-table-produit'].ajax.reload(null, false);
                    $.notify(data.message, "success");
                    $("#produit-modal").modal("hide");

                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}

aOpenModalUpdateProduit();
function aOpenModalUpdateProduit() {
    $("body").delegate(".frmModifierProduit", "click", function(e) {
        e.preventDefault();
        var code_produit = $(this).data("produit");
        var id = $(this).attr("id");

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'modal_modifier_produit',
                code: code_produit
            },
            dataType: "JSON",
            beforeSend: function() {
                $(".loader_backdrop2").css('display', "block");
                btnReq("#" + id, "Traitement...");

            },
            success: function(data) {
                console.log(data);
                
                btnRes("#" + id, 'Modifier', 'fa-edit');
                $(".loader_backdrop2").css('display', "none");
                if (data.code == 200) {
                    $(".data-modal").html(data.data);
                    $("#produit-modal").modal("show");
                } else {
                    $.notify("Erreur lors du traitement", "error");
                }

            }
        })
    });

}

aModifier_produit();
function aModifier_produit() {
    $("body").delegate("#frmUpdateProduit", "submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        console.log(data);
        
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: data,
            dataType: "json",
            beforeSend: function() {
                btnReq("#btn_ajouter_produit", "Enregistrement...");
            },
            success: function(data) {
                console.log(data);
                
                btnRes("#btn_ajouter_produit");
                $(".loader_backdrop2").css('display', "none");

                if (data.code == 200) {
                    tables['data-table-produit'].ajax.reload(null, false);
                    $.notify(data.message, "success");
                    $("#produit-modal").modal("hide");

                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}

// FIN produit

