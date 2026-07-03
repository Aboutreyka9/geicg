
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?= $data['title'] ?? "Mon espace" ?> || <?= getDataEnv('APP_NAME') ?> APPLICATION</title>
   <?php include "src/includes/style.php" ?>

    <!-- CSS Just for demo purpose, don't include it in your project -->
</head>

<body data-background-color="bg3">

    <div class="loader_backdrop2">
        <div class="loader_content2">
           <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    </div>

    <div class="wrapper sidebar_minimize">
        <!-- header -->
        <?php include "src/includes/navbar.php" ?>
        <!-- end header -->

        <!-- Sidebar -->
        <?php include "src/includes/sidebar.php" ?>
        <!-- end sidebar -->


        <!-- contenu principal -->
        <div class="main-panel">
            <div class="content">
                <div class="page-inner">

                    <!-- breakcrumb -->
                    <div class="page-header">
                        <h4 class="page-title"><?= getDataEnv('APP_NAME') ?></h4>
                        <ul class="breadcrumbs">
                            <li class="nav-home">
                                <a href="<?= route('home')?>">
                                    <i class="flaticon-home"></i>
                                </a>
                            </li>
                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item">
                                <a class="back" href="#">Retour</a>
                            </li>
                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item">
                                <a class="current-page" href="#"></a>
                            </li>
                        </ul>
                    </div>
                    <!-- end breakcrumb -->

                    <div class="row">
                        <div class="col-md-12">
                            <?php include $viewFile; // Charger la vue spécifique ?>
                        </div>
                    </div>
                    <div id="2qrcode"></div>
                </div>
            </div>
            <!-- end content -->

            <!-- footer -->
            <footer class="footer">
                <div class="container-fluid">
                    <nav class="pull-left">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    SMART CODES
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Aide
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Licenses
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <div class="copyright ml-auto">
                        2025, developpé <i class="fa fa-heart heart text-danger"></i> par <a
                            href="#"><?= getDataEnv('APP_ENTITY') ?></a>
                    </div>
                </div>
            </footer>
            <!-- end footer -->
        </div>


    </div>

    <!-- Modal -->
<div class="modal fade" id="password-modal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="passwordModalLabel"><i class="fas fa-key"></i> &nbsp; <span class="text-uppercase">Changer mot de passe</span>  </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row ">
            <div class="col-md-12">
                <form method="post" id="frmChangePassword">
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" class="form-control password" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirmer mot de passe</label>
                        <input type="password" class="form-control password" id="confirm-password" name="confirm_password">
                          <input type="hidden" value="changer_password" id="btn_password" name="action">
                    </div>

                     <div class="form-group">
                      <label for="show-password">   
                      <input type="checkbox" id="show-password">
                      <span  class=""> Afficher mot de passe </span>
                      </label>
                  </div>
                </form>
            </div>
        </div>
      </div>
        <!-- .modal-footer -->
        <div class="modal-footer">
        <button type="submit" form="frmChangePassword" id="btn_change_password" class="btn btn-primary "> <i class="fa fa-save"></i> Enregistrer </button>
      </div><!-- /.modal-footer -->
    </div>
  </div>
</div>


    <!--   Core JS Files   -->
    <?php include 'src/includes/script.php' ?>
     <!-- QRCode.js (librairie légère pour générer les QR codes côté navigateur) -->
  <script src="<?= ASSETS ?>js/qrcode.min.js"></script>

    <script>
        $(function () {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function (start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' +
                    end.format('YYYY-MM-DD'));
            });
        });
    </script>

    <script>
        $(function () {
            $(".table-data").dataTable();
        });

    </script>
 

 <script>
    $(document).ready(function() {
        $('.select2').select2({
            tags: "false",
            placeholder: "----CHOISIR----",
            allowClear: true,
            language: {
                noResults: function () {
                    return "Aucun résultat";
                }
            },
            createTag: function (params) {
            return null; // empêche toujours la création
             }
          });
    });
 </script>

<script>
function imprimer() {
  window.print();
}
</script>

<script type="text/javascript">
var qrcode = new QRCode(document.getElementById("qrcode"), {
	text: "http://jindo.dev.naver.com/collie",
	width: 128,
	height: 128,
	colorDark : "#000000",
	colorLight : "#ffffff",
	correctLevel : QRCode.CorrectLevel.H
});
</script>


</body>

</html>

<?php 
// cmpt a: 5sYep
//cmpt t: ta29z
// auth()->logout();
 // var_dump($_SESSION);
// var_dump(session_destroy()); 
// $_SESSION[auth()->getAuthKey()]['hotel'] = "65465GHG" ; 
// foreach (GROUPES_ROLES as $nom_groupe => $infos) {
//   echo "Groupe : <br> $nom_groupe\n <br>";
//   foreach ($infos["roles"] as $role) {
//       echo " - $role \n";
//   }
// }
 ?>

<!-- <div class="dropdown">
    <button type="button" '.($data['etat_depense'] == 1 ? 'disabled' : '').' class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown">

    </button>

    <div class="dropdown-menu">
    
        <button class="dropdown-item btn_confirm_depense" data-depense="'. crypter($data['code_depense']) .'"> ✅ Confirmer</button>
        <button class="dropdown-item btn_update_depense" data-depense="'. crypter($data['code_depense']) .'"> 📝 Modifier</button>
        <button class="dropdown-item btn_annuler_depense" data-depense="'. crypter($data['code_depense']) .'"> ❌ Annuler</button>
    </div>
</div> -->


<!-- Comptes de test :

Admin: admin@hotel.com / admin123

Réception: reception@hotel.com / reception123

Client: client@hotel.com / client123 -->