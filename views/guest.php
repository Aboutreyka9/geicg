<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.101.0">

  <title><?= strtoupper($data['title'] ?? "Mon espace")  ?> || G-ECOLE APPLICATION</title>
  <link rel="icon" href="<?= ASSETS ?>img/icon.ico" type="image/x-icon" />

  <!-- CSS only -->
  <link rel="stylesheet" href="<?= ASSETS ?>user/bootstrap.min.css">
  <link rel="stylesheet" href="<?= ASSETS ?>user/style.css">

</head>

<body class="bg-login">
  <div class="main-container ">
    <?php include $viewFile; // Charger la vue spécifique 
    ?>
  </div>





  <script src="<?= ASSETS ?>user/jquery.js"></script>
  <script src="<?= ASSETS ?>user/bootstrap.min.js"></script>
  <script src="<?= ASSETS ?>user/bootstrap.bundle.js"></script>
  <script src="<?= ASSETS ?>js/plugin/sweetalert/sweetalert.min.js"></script>
  <script src="<?= ASSETS ?>js/notify.js"></script>

  <script src="<?= ASSETS ?>user/apps.js"></script>
<!-- 
  <script src="<?= ASSETS ?>js/module_share.js"></script>
  <script src="<?= ASSETS ?>user/module_user.js"></script> -->



</body>

</html>

<?php
// auth()->disconect();
// var_dump($_SESSION); 
// var_dump(auth()->getAuthKey()); 
//  var_dump(session_destroy()); 

// foreach (GROUPES_ROLES as $nom_groupe => $infos) {
//   echo "Groupe : <br> $nom_groupe\n <br>";
//   foreach ($infos["roles"] as $role) {
//       echo " - $role \n";
//   }
// }
?>