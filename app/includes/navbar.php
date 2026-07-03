<div class="main-header">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">

        <a href="<?= route('home') ?>" class="logo">


            <span style="color: #fff; font-size:18px" class="navbar-brand"><?= getDataEnv('APP_NAME') ?></span>

        </a>
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
            data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="icon-menu"></i>
            </span>
        </button>
        <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="icon-menu"></i>
            </button>
        </div>
    </div>
    <!-- End Logo Header -->

    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-expand-lg" data-background-color="dark2">

        <div class="container-fluid">

            <div class="collapse" id="search-nav">
                <marquee behavior="" scrollamount="2" direction="">
                    <h3 class="text-light text-uppercase"> Espace : <span id="schopIdentity">Boutique 002</span> </h3>
                </marquee>
                <!-- <form class="navbar-left navbar-form nav-search mr-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search pr-1">
                                        <i class="fa fa-search search-icon"></i>
                                    </button>
                                </div>
                                <input type="text" placeholder="Search ..." class="form-control">
                            </div>
                        </form> -->
            </div>

            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">

                <li class="nav-item toggle-nav-search hidden-caret">
                    <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button"
                        aria-expanded="false" aria-controls="search-nav">
                        <i class="fa fa-search"></i>
                    </a>
                </li>

                <?php //if(auth()->hasGroupe(Groupes::RECEPTION)) : 
                ?>
                <li class="nav-item dropdown hidden-caret">
                    <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        <span class="notification"></span>
                    </a>
                    <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                        <li>
                            <div class="dropdown-title">Notifications</div>
                        </li>
                        <li>
                            <div class="notif-center">
                                <a href="<?= route('facture.attente') ?>">
                                    <div class="notif-icon notif-primary"> <i class="fa fa-user-plus"></i>
                                    </div>
                                    <div class="notif-content">
                                        <span class="block">
                                            Factures non reglées
                                        </span>
                                    </div>
                                </a>
                            </div>
                        </li>

                    </ul>
                </li>
                <?php //endif; 
                ?>

                <?php //if(auth()->hasGroupe(Groupes::ADMIN) || auth()->hasGroupe(Groupes::COMPTABLE)) : 
                ?>


                <li class="nav-item dropdown hidden-caret">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fas fa-layer-group"></i>
                    </a>
                    <div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">

                        <div class="quick-actions-scroll scrollbar-outer">
                            <div class="quick-actions-items">
                                <div class="row m-0">
                                    <a class="col-6 col-md-4 p-0" href="<?= route('liste.clients') ?>">
                                        <div class="quick-actions-item">
                                            <i class="flaticon-file-1"></i>
                                            <span class="text"> Clients</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="<?= route('liste.reservations') ?>">
                                        <div class="quick-actions-item">
                                            <i class="flaticon-list"></i>
                                            <span class="text">Reservations</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="<?= route('liste.chambres') ?>">
                                        <div class="quick-actions-item">
                                            <i class="flaticon-list"></i>
                                            <span class="text">Chambres</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="<?= route('liste.services') ?>">
                                        <div class="quick-actions-item">
                                            <i class="flaticon-list"></i>
                                            <span class="text">Service</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="<?= route('liste.depenses') ?>">
                                        <div class="quick-actions-item">
                                            <i class="flaticon-list"></i>
                                            <span class="text">Depenses</span>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <?php //endif; 
                ?>
                <li class="nav-item dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"
                        aria-expanded="false">
                        <div class="name-user">
                            <span style="font-size: 16px; font-weight: bold;" class=""><?= shortName(auth()->user('nom')) 
                                                                                        ?></span>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <a class="dropdown-item" href="<?= url('user',['code'=> auth()->user('id')]) 
                                                                ?>"> <?= auth()->user('nom') ?>
                                </a>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" id="btn_reset_password" href="javascript:void(0);"> <i class="fas fa-key"></i> Changer mot de passe</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item btn_deconnect btn btn-info" href="javascript:void(0);"> <i class="fas fa-sign-out-alt"></i> Se deconnecter</a>
                            </li>
                        </div>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>