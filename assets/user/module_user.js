// alert("Hello world!");
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
                btnReq("#btnSubmitForm", "Connexion...");
            },
            success: function (data) {
                
                console.log(data);
                btnRes("#btnSubmitForm", "Connexion",'fa-log-in');

                if (data.code === 200) {
                    // setSchopIdentity();
                    localStorage.setItem('data-shop',data.activityYear);


                    swal("Notification", data.msg,"success").then(() => {
                        history.go(0);
                    });

                } else {
                    $.notify(data.msg, "error",);
                }
            }
        });
    });
}

deconnecter();
function deconnecter() {  
    $('.btn_deconnect').click(function(e) {
        e.preventDefault();
      
        $.ajax({
            url: URL_AJAX,
            method: 'POST',
            dataType: "JSON",
            data: {
                action: "btn_user_Deconnect"
            },
            beforeSend: function() {
                $(".loader_backdrop2").css('display', "block");
            },
            success: function (data) {
                console.log(data);
                $(".loader_backdrop2").css('display', "none");
                if (data.code == 200) {
                        window.location.href = URL_HOME+"login";
                }
            }
        })
    });
}

//employer  
0

// modifier_employe();

function modifier_employe() {
    $('#frm_update_employe').submit(function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        // 
        // return;
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: data,
            dataType: "json",
            beforeSend: function () {
                $(".loader_backdrop2").css('display', "block");
                $("#btn_update_user").prop('disabled', true);
            },
            success: function(data) {
                $(".loader_backdrop2").css('display', "none");
                
                if (data.code == 200) {
                    $.notify(data.message, 'success')
                } else {
                    $("#btn_update_user").prop('disabled', false);
                    $.notify(data.message)
                }
            }
        })
    });
}

// openModalResetPassword();

function openModalResetPassword() {
    $('#btn_reset_password').click(function(e) {
        e.preventDefault();
        $("#password-modal").modal("show");
    });
}

// ResetPassword();

function ResetPassword() {
    $("body").delegate("#frmChangePassword", "submit", function(e) {
        e.preventDefault();
        var data = $(this).serialize();

        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: data,
            dataType: "JSON",
            beforeSend: function() {
                btnReq("#btn_change_password", "Traitement...");
            },
            success: function(data) {
                

                btnRes("#btn_change_password",'Enregistrer','fa-save');
                if (data.code == 200) {
                    $.notify(data.message, "success");
                    $("#password-modal").modal("hide");
                } else {
                    $.notify(data.message);
                }
            }
        })
    });
}

loadDataTable('data-table-user', '#data-table-user', 'bcharger_data_users');





// EMPLOYE
// Show modal add USER
modalAddUser();

function modalAddUser() {
    $("body").delegate(".btn_modal_user", "click", function(e) {
        e.preventDefault();
      
        $.ajax({
            url: URL_AJAX,
            method: 'POST',
            data: {
                action: "frm_modal_user"
            },
            dataType: 'JSON',
            beforeSend: function() {
                $(".loader_backdrop2").css('display', "block");
            },
            success: function(data) {
                console.log(data);
                $(".loader_backdrop2").css('display', "none");
                if (data.code == 200) {
                    $('.data-modal').html(data.data);
                    $("#user-modal").modal("show");
                }else{
                    $.notify(data.message, "error");
                }
            }
        });

    });
}

btnAddUser();

function btnAddUser() {
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
            success: function (data) {
                console.log(data);
                $(".loader_backdrop2").css('display', "none");
                btnRes(".modal_footer", "Enregistrer", "fa-save");
                // return
                if (data.code == 200) {
                    $.notify(data.message, "success");
                    tables['data-table-user'].ajax.reload(null, false);
                    $("#user-modal").modal("hide");
                } else {
                    $.notify(data.message, "error");
                }
            }
        });
    });
}

disableUser();

function disableUser() {
    $("body").delegate(".btn_disable_user", "click", function(e) {
        e.preventDefault();
        var id = $(this).data("user");
        
        
        swal({
            title: "Êtes vous sûr ?",
            text: "De vouloir desactiver ce compte?",
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
                        action: 'btn_disable_user',
                        id_user: id
                    },
                    dataType: "json",
                    beforeSend: function() {
                        
                        $(".loader_backdrop2").css('display', "block");
                    },
                    success: function(data) {
                        ;

                        if (data.code == 200) {
                            resetDataTable();
                            $.notify(data.message, 'success');
                            $("#sexion_user").load(" #sexion_user > *");
                            setTimeout(initDataTable, 200);
                            $(".loader_backdrop2").css('display', "none");
                        } else {
                            $.notify(data.message)
                        }
                    }
                })
            }

        })


    });
}

enableUser();

function enableUser() {
    $("body").delegate(".btn_enable_user", "click", function(e) {
        e.preventDefault();
        var id = $(this).data("user");
        
        
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'btn_enable_user',
                id_user: id
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
                    $("#sexion_user").load(" #sexion_user > *");
                    setTimeout(initDataTable, 200);
                    $(".loader_backdrop2").css('display', "none");
                } else {
                    $.notify(data.message)
                }
            }
        });


    });
}

renvoyerMail();

function renvoyerMail() {
    $("body").delegate(".btn_send_mail", "click", function(e) {
        e.preventDefault();
        var id = $(this).data("user");
        
        
        $.ajax({
            method: "POST",
            url: URL_AJAX,
            data: {
                action: 'btn_send_mail_activation',
                id_user: id
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
                    $("#sexion_user").load(" #sexion_user > *");
                    setTimeout(initDataTable, 200);
                    $(".loader_backdrop2").css('display', "none");
                } else {
                    $.notify(data.message)
                }
            }
        });


    });
}



btnRegisterUser();
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
                    swal("Notification", data.message,"success");
                    // reset form 
                    

                } else {
                    $.notify(data.message, "error",);
                }
            }
        });
    });
}



// ROLE AND PERMISSION

btnCloseModalPermission();

function btnCloseModalPermission() {
    $("body").delegate("#btn-close-modal", "click", function(e) {
        // e.preventDefault();  
        dataCheck = [];

    });
}
menuRole();

function menuRole() {
    $("body").delegate(".toggle-role", "change", function(e) {

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
        // dataType: 'JSON',
        success: function (data) {
            console.log(data);
            

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
    $("body").delegate(".perm", "change", function(e) {
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
    $("body").delegate(".modal_permission_user", "click", function(e) {
        e.preventDefault();
        var code = $(this).data("code");
        
        $.ajax({
            url: URL_AJAX,
            method: 'POST',
            data: {
                action: 'frm_modal_add_permission',
                code_user: code
            },
            dataType: 'JSON',
            beforeSend: function () {
                $(".loader_backdrop2").css('display', "block");
            },
            success: function(data) {

                console.log(data);
                $(".loader_backdrop2").css('display', "none");
                
                if (data.code == 200) {

                    $('.data-modal-permission').html(data.data);
                    $('#user-info').text(data.user);
                    $("#role-modal-permission").modal("show");

                }
                //    else{
                //    }
            }
        });

    });
}


savePermission();

function savePermission() {
    $("body").delegate("#btnSavePermissions", "click", function(e) {
        e.preventDefault();

        if (rolesPermissions.length === 0) {
            $.notify('Aucune autoristion accordée')
            return;
        } else if (userCode == "") {
            $.notify("Veuillez reprendre le processus")
        }

        $.ajax({
            url: URL_AJAX,
            method: 'POST',
            dataType: 'JSON',
            data: {
                action: 'btn_add_permission',
                codeuser: userCode,
                roles: JSON.stringify(rolesPermissions)
            },
            beforeSend: function() {
                // $("#spinner").addClass("show");
                // $("#btn_modifier_user").html(
                //   '<i class="fa fa-refresh fa-spin fa-2x"></i> &nbsp; Modification...'
                // );
                // $("#btn_modifier_user").attr("disabled", "disabled");
            },
            success: function(data) {

                
                // $("#spinner").removeClass("show");

                // $("#btn_modifier_user").html(
                //     '<i class="fa fa-check-circle"></i> &nbsp; Modifier'
                //   );
                // $("#btn_modifier_user").attr("disabled", false);

                if (data.code == 200) {
                    userCode = "";
                    rolesPermissions = [];
                    dataCheck = [];

                    $.notify(data.message, "success");
                    $("#role-modal-permission").modal("hide");

                } else {
                    $.notify(data.message, "error");

                }
            }
        });

    });
}

