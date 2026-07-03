<?php

// use Configs\Sexe;

// Sexe
// if(session_status() == PHP_SESSION_NONE){
    // session_start();
// }

// if(empty($_SESSION['user_id']))
// header("location:".HOME."/log-in");
// use Configs\Role;
?>

<?php include 'src/includes/style.php' ?>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
        <?php include_once 'src/includes/sidebar.php' ?>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
        <?php include_once 'src/includes/navbar.php' ?>
             
            <!-- Navbar End -->
             <!-- conntent data -->

             <?php include $viewFile; // Charger la vue spécifique ?>
             <!-- End content data  -->

            <!-- Footer Start -->
            <?php include_once 'src/includes/footer.php'?>
            <!-- Footer End -->
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

   <!-- include scripts -->
    <?php include 'src/includes/script.php' ?>
</body>

<!-- <div class="btn-group dropstart">
  <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
    Dropstart
  </button>
  <ul class="dropdown-menu dropdown-menu-dark">
    <li><button class="dropdown-item" type="button">Action</button></li>
    <li><button class="dropdown-item" type="button">Another action</button></li>
    <li><button class="dropdown-item" type="button">Something else here</button></li>
 
  </ul>
</div> -->

</html>