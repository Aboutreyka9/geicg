
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
                <h4>Nouveau mot de passe</h4>
            </div>
            <div style="width: 80%; margin-top:15px;" class="notification alert alert-danger d-none"></div>

            <div class="input-wrapper">
                 <!-- Session Status -->

            <form method="POST" id="frmChangePassword">

            <!-- Email Address -->
            <div class="">
                <input id="password" value="12345" class="form-control" type="password" name="password"  placeholder="E-mail ou Numéro de telephone " required/>
            </div>

            <!-- Password -->
            <div class="input-control md-5">
                <input id="password_confirm" value="12345" class="form-control" type="password" name="password_confirm" placeholder="Mot de passe" required />
            </div>

            <div class="mb-3 mt-4">
                <input type="hidden" value="btnLogin" name="action" >
                <button type="submit" id="btn_change_password" class="btn btn-warning w-100">
                Modifier <i class="fa fa-edit"></i>
                </button>
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
        