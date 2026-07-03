const URLS = window.origin;
const URL_HOME = URLS + "/gestock/";
const URL_AJAX = URL_HOME + "src/controllers/ajx.php";
// const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
let tables = {};
let schopIdentity = "";

// Configuration globale pour inclure le token CSRF dans les en-têtes AJAX


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});




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


// searchUser();
function searchTestInput() {
    $("body").delegate($('#data-table-produit').DataTable().search(), "keyup", function(e) {
        e.preventDefault();
        var search = $('input[type="search"]').val();
       
        testDatable('aCharger_data_produits','#data-table-produit',search)
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



    getShopIdentity()

function getShopIdentity() {
    shopIdentity = localStorage.getItem("data-shop");
    $("#shopIdentity").text(shopIdentity);

}

function setShopIdentity() {

    $.ajax({
        url: URL_AJAX,
        method: 'POST',
        data: {
            action: 'get_shop_identity'
        },
        dataType: 'JSON',
        success: function (data) {
            console.log(data)

            if (data.code === 200) {
                shopIdentity = data.data;
                localStorage.setItem("data-shop", data.data);
                $("#shopIdentity").text(shopIdentity);
            }
        }
    });
}

activeStatutAnnee();

function activeStatutAnnee() {
    $("body").delegate(".btn_active_annee", "click", function (e) {
        e.preventDefault();

        var code = $(this).data("code");
        
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'btn_active_annee',
                code_annee: code
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
                if (data.code == 200) {
                     setSchopIdentity();
                    sAlert("Notification", data.data, "success");


                }

            }
        });

    });
}

desactiveStatutAnnee();

function desactiveStatutAnnee() {
    $("body").delegate(".btn_desactive_annee", "click", function (e) {
        e.preventDefault();

        var code = $(this).data("code");

         $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'btn_desactive_annee',
                code_annee: code
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
                if (data.code == 200) {
                     setSchopIdentity();
                    sAlert("Notification", data.data, "success");


                }

            }
        });

    });
}


/***
 * menu side link active
 */

activeMenuLink();

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
            link.classList.add("item-link-active");


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

activeTabsMenu();

function activeTabsMenu() {

    // Récupérer l’URL actuelle
    $("body").on("click", ".nav-tabs li", function (e) { 
        $('.nav-tabs li').removeClass('tabs_menu');
          
        $(this).addClass("tabs_menu");
        counterTableDataCommon();
        // setTimeout(counterTableDataCommon, 200);

        
    });
}