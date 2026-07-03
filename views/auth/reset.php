
<header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="">G-STOCK</a>
     
    </div>
  </nav>
    </header>
        <div class="login-wrapper">

            <div class="content-left">

                <div class="image-wrapper"></div>
            </div>

            <div class="content-right">

            <!-- main -->


    <div class="wrap-content">
        <div class="logo-wrapper-loing">

            <img src="<?=  ASSETS?>guest/images/profile.jpg" alt="">

        </div>
        <div class="writer-login">
            <div class="title-login">
                <h4>Renitialiser le mot de passe</h4>
            </div>
            <div style="width: 80%; margin-top:15px;" class="notification alert alert-danger d-none"></div>

            <div class="input-wrapper">
                 <!-- Session Status -->

            <form method="POST" id="frmResetPassword">

            <!-- Email Address -->
            <div class="">
                <input id="email" value="t@g.com" class="form-control" type="text" name="email"  placeholder="Entrer votre adresse mail " required/>
            </div>

            <div class="mb-3 mt-4">
                <input type="hidden" value="btn_reset_password" name="action" >
                <button type="submit" id="btn_reset_password" class="btn btn-warning w-100">
                Envoyer <i class="fa fa-log-in"></i>
                </button>
            </div>

            <div>
                <a class="" href="<?= route('login')?>">
                    Se connecter à compte
                </a>
            </div>
            <hr class="divider-login">
            <p class="inscrit-login">
            Copyright © 2024 SMART-CODES. All rights reserved.

            </p>            
            </form>
            </div>

        </div>
    </div>
                <!-- END main -->
            </div>
        </div>
        