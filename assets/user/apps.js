const ORIGIN = window.location.origin;
/** obtenir cette structure http://localhost/hotel/ */
// const ORIGIN = (window.location.protocol + '//' + window.location.host);
const URL_HOME = ORIGIN + "/geicg/";
const URL_AJAX = URL_HOME + "app/controllers/ajx.php";

let rolesPermissions = [];
let dataCheck = [];
let charts = {}; // stocker les graphiques par ID
// alert('ghdfhdf');
// ## SEXION CONNEXION

btnLoginUser();

function btnLoginUser() {
    $("body").delegate("#frmLogin", "submit", function (e) {
        e.preventDefault();
        var form = $(this).serialize();

        $.ajax({
            url: URL_AJAX,
            method: 'POST',
            data: form,
            dataType: 'JSON',

            beforeSend: function () {

                $("#btn_login").html(
                    '<i class="fa fa-refresh fa-spin fa-2x"></i> &nbsp; Connexion...'
                );
                $("#btn_login").attr("disabled", "disabled");
            },
            success: function (data) {
                console.log(data);
                $("#btn_login").html(
                    '<i class="fa fa-check-circle"></i> &nbsp; Connexion'
                );
                $("#btn_login").attr("disabled", false);

                if (data.success) {

                    // setAcademicYear();
                    // localStorage.setItem('data-year',data.activityYear);


                    swal("Notification", data.message, "success").then(() => {
                        window.location.href = URL_HOME;
                    });

                } else {

                    $.notify(data.message, "error",);
                }
            }, error: function (err) {
                $.notify('Désolé une erreur est survenue', "error",);

                $("#btn_login").html(
                    '<i class="fa fa-check-circle"></i> &nbsp; Connexion'
                );
                $("#btn_login").attr("disabled", false);
            }
        });
    });
}

// btnRegisterUser();
function btnRegisterUser() {
    $("body").delegate("#frmRegister", "submit", function (e) {
        e.preventDefault();
        var form = $(this).serialize();

        $.ajax({
            url: URL_AJAX,
            method: 'POST',
            data: form,
            dataType: 'JSON',

            beforeSend: function () {

                $("#btn_register").html(
                    '<i class="fa fa-refresh fa-spin fa-2x"></i> &nbsp; Connexion...'
                );
                $("#btn_register").attr("disabled", "disabled");
            },
            success: function (data) {
                console.log(data);


                $("#btn_register").html(
                    '<i class="fa fa-check-circle"></i> &nbsp; Connexion'
                );
                $("#btn_register").attr("disabled", false);

                if (data.code === 200) {
                    $("#frmRegister input").val("");
                    swal("Notification", data.message, "success");
                    // reset form 


                } else {
                    $.notify(data.message, "error",);
                }
            }
        });
    });
}


btnResetPassword();
function btnResetPassword() {
    $("body").delegate("#frmResetPassword", "submit", function (e) {
        e.preventDefault();
        var form = $(this).serialize();

        $.ajax({
            url: URL_AJAX,
            method: 'POST',
            data: form,
            dataType: 'JSON',

            beforeSend: function () {

                $("#btn_reset_password").html(
                    '<i class="fa fa-refresh fa-spin fa-2x"></i> &nbsp; Connexion...'
                );
                $("#btn_reset_password").attr("disabled", "disabled");
            },
            success: function (data) {

                $("#btn_reset_password").html(
                    '<i class="fa fa-check-circle"></i> &nbsp; Connexion'
                );
                $("#btn_reset_password").attr("disabled", false);

                if (data.code === 200) {
                    // setAcademicYear();
                    swal("Notification", data.msg, "success")
                    $("#frmResetPassword input").val("");

                } else {
                    $.notify(data.msg, "error",);
                }
            }
        });
    });
}

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





















































































// NOT USED INSIDE

// ROLE AND PERMISSION

btnCloseModalPermission();

function btnCloseModalPermission() {
    $("body").delegate("#btn-close-modal", "click", function (e) {
        // e.preventDefault();  
        dataCheck = [];

    });
}
menuRole();

function menuRole() {
    $("body").delegate(".toggle-role", "change", function (e) {

        const permissionsDiv = document.querySelector('#permissions-' + this.id);

        const code = $(this).data("role");
        const groupe = $(this).data("groupe");
        const user = $(this).data("user");



        if (this.checked) {

            if (!dataCheck.includes(groupe)) {
                loadDataRole(user, groupe, code, permissionsDiv); // Rendre visible
            } else {

                permissionsDiv.style.maxHeight = permissionsDiv.scrollHeight + 'px'; // Permet de déployer
                permissionsDiv.style.opacity = 1; // Rendre visible
            }

        } else {
            $("#btn-r" + code).prop("disabled", "true")
            permissionsDiv.style.maxHeight = 0; // Réduire à 0 pour effacer
            permissionsDiv.style.opacity = 0; // Rendre invisible
        }

    });
}


function loadDataRole(user, groupe, code, permissionsDiv) {

    $.ajax({
        url: URL_AJAX,
        method: 'POST',
        data: {
            action: 'btn_load_data_role',
            code_user: user,
            code_role: groupe
        },
        dataType: 'JSON',
        success: function (data) {


            if (data.code == 200) {

                $("#sexion-r" + code).html(data.data);
                dataCheck.push(groupe);
                permissionsDiv.style.maxHeight = permissionsDiv.scrollHeight + 'px'; // Permet de déployer
                permissionsDiv.style.opacity = 1;


            }
        }
    });




}

checkPermission();

function checkPermission() {
    $("body").delegate(".perm", "change", function (e) {
        e.preventDefault();

        let row = $(this).closest("tr");
        let coderoleId = row.data("id");


        let show = $("#show" + coderoleId).is(":checked") ? 1 : 0;
        let edit = $("#edit" + coderoleId).is(":checked") ? 1 : 0;
        let create = $("#create" + coderoleId).is(":checked") ? 1 : 0;
        let deleted = $("#delete" + coderoleId).is(":checked") ? 1 : 0;


        let existe = rolesPermissions.some(r => r.role === coderoleId);

        if (!existe) {
            let roleId = rolesPermissions.length + 1;

            rolesPermissions.push({
                id: roleId,
                role: coderoleId,
                create: create,
                show: show,
                edit: edit,
                delete: deleted,
            });
        }


        rolesPermissions = rolesPermissions.map(role => {

            if (role.role === coderoleId) {
                role["create"] = create;
                role["show"] = show;
                role["edit"] = edit;
                role["delete"] = deleted;
            }
            return role;
        });



    });
}

modalRoleUser();

function modalRoleUser() {
    $("body").delegate(".modal_permission_user", "click", function (e) {
        e.preventDefault();
        var code = $(this).data("code");

        userCode = code;
        $.ajax({
            url: URL_AJAX,
            method: 'POST',
            data: {
                action: 'frm_modal_add_permission',
                code_user: code
            },
            dataType: 'JSON',
            beforeSend: function () {
                // $("#spinner").addClass("show");
            },
            success: function (data) {

                // $("#spinner").removeClass("show");
                if (data.code == 200) {

                    $('.data-modal-permission').html(data.data);
                    $('#user-info').text(data.user);
                    $("#role-modal-permission").modal("show");

                }
                //    else{
                //     smartAlert("Notification", data.msg, "error", "");
                //    }
            }
        });

    });
}


savePermission();

function savePermission() {
    $("body").delegate("#btnSavePermissions", "click", function (e) {
        e.preventDefault();

        if (rolesPermissions.length === 0) {
            alert("Notification, Aucune autoristion accordée");
            return;
        } else if (userCode == "") {
            alert("Notification, Veuillez reprendre le processus ");
        }

        $.ajax({
            url: URL_AJAX,
            method: 'POST',
            // dataType: 'JSON',
            data: {
                action: 'btn_add_permission',
                codeuser: userCode,
                roles: JSON.stringify(rolesPermissions)
            },
            beforeSend: function () {
                // $("#spinner").addClass("show");
                // $("#btn_modifier_user").html(
                //   '<i class="fa fa-refresh fa-spin fa-2x"></i> &nbsp; Modification...'
                // );
                // $("#btn_modifier_user").attr("disabled", "disabled");
            },
            success: function (data) {


                // $("#spinner").removeClass("show");

                // $("#btn_modifier_user").html(
                //     '<i class="fa fa-check-circle"></i> &nbsp; Modifier'
                //   );
                // $("#btn_modifier_user").attr("disabled", false);

                if (data.code == 200) {
                    userCode = "";
                    rolesPermissions = [];
                    dataCheck = [];

                    alert(data.message);
                    $("#role-modal-permission").modal("hide");

                } else {
                    alert(data.message);

                }
            }
        });

    });
}















