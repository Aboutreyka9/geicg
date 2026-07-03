<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="">G-EICG</a>

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

            <div class="writer-login">
                <div class="title-login">
                    <h3>Se connecter</h3>
                    <p>à mon espace</p>
                </div>
                <div style="width: 80%; margin-top:15px;" class="notification alert alert-danger d-none"></div>

                <div class="input-wrapper">
                    <!-- Session Status -->

                    <form method="POST" id="frmLogin">

                        <!-- Email Address -->
                        <div class="">
                            <input id="email" class="form-control" type="email" name="email" placeholder="Adresse email" required />
                        </div>

                        <!-- Password -->
                        <div class="input-control md-5">
                            <input id="password" class="form-control password" type="password" name="password"
                                placeholder="Mot de passe" required />
                        </div>

                        <div class="mb-3 mt-4">
                            <input type="hidden" value="btnLogin" name="action">
                            <button type="submit" id="btn_login" class="btn btn-warning w-100">
                                Connexion <i class="fa fa-log-in"></i>
                            </button>
                        </div>
                        <div class="">
                            <label for="show-password">
                                <input type="checkbox" id="show-password">
                                <span class=""> Afficher mot de passe </span>
                            </label>
                        </div>

                        <div>
                            <a class="" href="<?= url('') ?>">
                                Mot de passe oublié?
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