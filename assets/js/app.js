const ORIGIN = window.location.origin;
/** obtenir cette structure http://localhost/hotel/ */
// const ORIGIN = (window.location.protocol + '//' + window.location.host);
const URL_HOME =ORIGIN +"/geicg/";
const URL_AJAX = URL_HOME + "app/controllers/ajx.php";
let tables = {};
let formChanged = false;
const $form = $('form');
let initialData = $form.serialize(); // capture les valeurs initiales
let formBtn = '';


detectChangeForms();

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

   // RESET FORM
    function resetForm() {
        // $(".reset").click(function(){
        $("form").trigger("reset");
        // $("form")[0].reset()
        $("input[type='text']").val('');
        $("input[type='number']").val('');
        // $("form").remove();
        // $(selector)[0].reset()
        //   });
    }

    // CLOSE MODAL
    closeModal();

    function closeModal() {
        $('body').on( 'click','.dismiss_modal', function (e) {
            e.preventDefault();
            resetForm();
            $(".modal").modal('hide');

        })
    }


// searchUser();
function searchTestInput() {
    $("body").on( "keyup",$('#data-table-utilisateur').DataTable().search(), function(e) {
        e.preventDefault();
        var search = $('input[type="search"]').val();
       
        testDatable('bcharger_data_utilisateurs','#data-table-utilisateur',search)
        // loadDataTable('data-table-user', '#data-table-user', 'bcharger_data_users');
    });
}

// searchTestInput();


function testDatable(action, selector,search = "") {
    // var se = $(selector).DataTable().search().value;
    $.ajax({
        method: "POST",
        url: URL_AJAX,
        data: {
            action: action,
            length: 20,
            start: 0,
            search: search,
            draw: 1
        },
        // dataType: "JSON",
        beforeSend: function () {
            // $(".loader_backdrop2").css('display', "block");
            // btnReq("#" + id, "Traitement...");
        },
        success: function (data) {
            console.log("test", data);

        }
    });
}



function loadDataTable(tableId,selector,action) {


    if ($(selector + ':visible').length) {
        console.log(selector,tableId,action);

        // testDatable(action, selector);

        // return;
        
        tables[tableId] = $(selector).DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": URL_AJAX,
                "type": "POST",
                "data": {
                    action: action
                }
            }
        });
    }
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

function money(val) {
    if (isNaN(val) || val <= 0) return val;
    val = Number(val);
        return val.toLocaleString('fr-FR', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        })
    }
    
    function formatMontant(montant) {
        return new Intl.NumberFormat('fr-FR').format(montant) + ' FCFA';
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


/***
 * menu side link active
 */

// activeMenuLink();

function activeMenuLink() {

    // Récupérer l’URL actuelle
    const currentPage = window.location.pathname.split("/").pop();

    // Récupérer tous les liens de menu
    const menuLinks = document.querySelectorAll(".item-link");

    // Parcourir tous les liens de menu
    menuLinks.forEach((link) => {
        // Récupérer l’URL du lien de menu
        const menuLinkUrl = link.getAttribute("href").split("/").pop();

        // Si l’URL du lien de menu correspond au URL actuelle
        if (menuLinkUrl === currentPage) {
            // ajouter la class active au parent de l'element link active 
            // const parent2 = link.parentElement.parentElement.parentElement.parentElement;
            const parent = link.closest(".nav-item");
            const parentMenu = link.closest(".collapse");


            parent.classList.add("active")
            parent.classList.add("submenu");
            parent.getElementsByTagName("a")[0].setAttribute("aria-expanded", "true");

            // activer aussi le parent menu si existe
            if (parentMenu) {
                parentMenu.classList.add("show");
            }
            // Ajouter la classe "active" au lien de menu
            // link.classList.add("item-link-active");
            link.classList.add("active");


            // // Si le lien est dans un menu déroulant
            // $(this).closest(".has-treeview").addClass("menu-open");
            // $(this).closest(".has-treeview").children("a").addClass("active");

        }
    });


    // For sidebar menu
    // $('ul.sidebar a').filter(function() {
    //     return this.href === url;
    // }).addClass('active').parent().parent().addClass('menu-open');


}


/*toggle sideba */

    sidebarToggler();
    function sidebarToggler() {
        // Sidebar Toggler
// alert('sidebarToggler');
        $('.sidebar-toggler').click(function () {
            $('.sidebar, .content').toggleClass("open");
            return false;
        });

        $('.sidebar-toggler').on('click', function () {
            $('body').toggleClass('sidebar-expanded');
            $('.sidebar-toggler i').toggleClass('fa-times fa-bars');
        }
        );
    }

    
toggleSideBar();

function toggleSideBar() {
    var saveOption = localStorage.getItem("toggleSideBar");
    if (saveOption == 'true') {
        $(".toggle-sidebar").removeClass("toggled");
        $(".wrapper").removeClass("sidebar_minimize");
    }
}

// activeTabsMenu();

function activeTabsMenu() {

    // Récupérer l’URL actuelle
    // $("body").on("click", ".nav-tabs li", function (e) { 
    //     $('.nav-tabs li').removeClass('tabs_menu');
          
    //     $(this).addClass("tabs_menu");
    //     counterTableDataCommon();
    //     // setTimeout(counterTableDataCommon, 200);

        
    // });
}

    // debut des fonctions

    
deconnecter();

function deconnecter() {
    $('.btn_deconnect').click(function(e) {
        e.preventDefault();
        alert("deconnecter");
        $.ajax({
            url: URL_AJAX,
            method: 'POST',
            dataType: "JSON",
            data: {
                action: "btn_user_deconnect"
            },
            beforeSend: function() {
                $(".loader_backdrop2").css('display', "block");
            },
            success: function(data) {
                console.log(data);
                
                $(".loader_backdrop2").css('display', "none");

                if (data.success) {
                    history.go(0);
                }
            }
        })
    });
}


/** DEBUT SECTION UTILISATEUR */

loadDataTable('data-table-utilisateur', '#data-table-utilisateur', 'bcharger_data_utilisateurs');

openModalAddUtilisateur();
function openModalAddUtilisateur() {
    $('.btn_utilisateur_addModal').click(function (e) {
        e.preventDefault();

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'btn_showmodal_utilisateur_add'
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
               

                $(".loader_backdrop2").css('display', "none");
                if (data.success) {
                    var output = data.data;
                    $(".data-modal").html(output.data);
                    $("#user-modal").modal("show");


                }else{
                    $.notify(data.message);

                }

            }
        })
    });
}

ajouterUtilisateur();
function ajouterUtilisateur() {
    $("body").delegate("#frmAddUser", "submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: data,
            dataType: "JSON",
            beforeSend: function () {
                $(".loader_backdrop2").css('display', "block");
                
                btnReq(".modal_footer", "Enregistrement...");
            },
            success: function(data) {
                console.log(data);
                    $(".loader_backdrop2").css('display', "none");

                btnRes(".modal_footer", "Enregistrer", "fa-save");
                if (data.success) {
                    tables['data-table-utilisateur'].ajax.reload(null, false);
                    $.notify(data.message, "success");
                    $("#user-modal").modal("hide");
                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}

bOpenModalUpdatedUtilisateurr();
function bOpenModalUpdatedUtilisateurr() { 
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

bUpdatedUtilisateur();
function bUpdatedUtilisateur() {
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

/** FIN SECTION UTILISATEUR */

/** DEBUT SECTION FONCTION */

loadDataTable('data-table-fonction', '#data-table-fonction', 'bcharger_data_fonctions');


ajouterFonction();
function ajouterFonction() {
    $("body").delegate("#frmAddFonction", "submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: data,
            // dataType: "JSON",
            beforeSend: function () {
                $(".loader_backdrop2").css('display', "block");
                
                btnReq("#btnSubmitFormFonction", "Enregistrement...");
            },
            success: function(data) {
                console.log(data);
                    $(".loader_backdrop2").css('display', "none");

                btnRes(".modal_footer", "Enregistrer", "fa-save");
                return;
                if (data.success) {
                    tables['data-table-utilisateur'].ajax.reload(null, false);
                    $.notify(data.message, "success");
                    $("#user-modal").modal("hide");
                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}

bOpenModalUpdatedFonction();
function bOpenModalUpdatedFonction() { 
    $("body").on( "click",".frmModifierFonctionData", function (e) { 
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

bUpdatedFonction();
function bUpdatedFonction() {
    $("body").delegate("#frmUpdateFonctionData", "submit", function(e) {
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

/** FIN SECTION FONCTION */

