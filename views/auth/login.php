<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="">G-EICG</a>

        </div>
    </nav>
</header>
<div style="position: relative;" class="login-wrapper">

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

                        <!-- section log in with google compte -->
                        <div>

                            <a href="<?= url('auth') ?>" style="width: 100%;" id="submit_google" type="submit"
                                class="btn btn-outline-danger">
                                <svg width="30px" class="google-icon" viewBox="0 0 48 48" aria-hidden="true">
                                    <path fill="#EA4335"
                                        d="M24 9.5c3.4 0 6.4 1.2 8.8 3.2l6.6-6.6C35.6 2.5 30.2 0 24 0 14.6 0 6.6 5.8 2.8 14.1l7.7 6C12.3 13.2 17.6 9.5 24 9.5z" />
                                    <path fill="#4285F4"
                                        d="M46.1 24.5c0-1.7-.2-3.4-.5-5H24v9.5h12.4c-.5 2.6-2 4.8-4.2 6.3l6.5 5c3.8-3.5 7.4-8.7 7.4-15.8z" />
                                    <path fill="#FBBC05"
                                        d="M10.5 28.1c-1-2.9-1-6.1 0-9l-7.7-6C.9 17 .9 23 2.8 27.9l7.7-5.8z" />
                                    <path fill="#34A853"
                                        d="M24 48c6.5 0 12-2.1 16-5.7l-6.5-5c-2 1.4-4.6 2.2-9.5 2.2-6.4 0-11.7-3.7-13.6-8.6l-7.7 5.8C6.6 42.2 14.6 48 24 48z" />
                                </svg>
                                <span style=" width: max-content; max-width: 100%; ">Se connecter avec Google</span>
                            </a>

                            <hr style="margin: 30px 0 10px;">
                        </div>

                        <!-- Email Address -->
                        <div class="">
                            <input id="email" class="form-control" type="email" name="email" placeholder="Adresse email"
                                required />
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