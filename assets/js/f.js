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