<div class="sidebar sidebar-style-2" data-background-color="dark2">

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <!-- user connected -->
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <div class="name-user">
                        <span style="font-size: 16px; font-weight: bold;" class=""><?= shortName(auth()->user('nom')) ?></span>
                    </div>
                </div>

                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            <?= (string) auth()->user("nom")
                            ?>
                            <span class="user-level text-success"><?= (string) auth()->user("fonction")
                                                                    ?></span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a class="item-link" href="<?= route('user.profile', ['code' => auth()->user('id')]) ?>">
                                    <span class="link-collapse">Profile</span>
                                </a>
                            </li>
                            <li>
                                <a class="btn_deconnect" href="javascript:void();">
                                    <span class="link-collapse">Deconnexion</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
            <!-- menu lateral -->
            <!-- START ADMIN MENU -->

            <ul class="nav nav-primary">
                <li class="nav-item">
                    <a style="background: #db241df1;" class="" href="<?= route('home') ?>">
                        <i  style="color: #fff!important;" class="fas fa-home"></i>
                        <p style="color: #fff!important;">TABLEAU DE BORD</p>
                    </a>
                </li>


                 <!-- Groupes::FINANCE  => -->

                <?php //if(auth()->hasGroupe(Groupes::ADMIN)): 
                ?>

                <li class="nav-item">
                    <a data-toggle="collapse" href="#finance">
                        <i class="fas fa-pen-square"></i>
                        <p class="text-upper">Configuration</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="finance">
                        <ul class="nav nav-collapse">
                            <!-- 👉 Caissier, Gérant, Admin -->
                            <?php //if(auth()->hasRole(Roles::ADMIN_H)): 
                            ?>
                            <li>
                                <a class="item-link" href="<?= url('client/liste') ?>">
                                    <span class="sub-item">➕ Comptabilite</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('client/liste') ?>">
                                    <span class="sub-item">➕ Caisse</span>
                                </a>
                            </li>

                             <li>
                                <a class="item-link" href="<?= url('client/liste') ?>">
                                    <span class="sub-item">➕ Depense</span>
                                </a>
                            </li>
                            <?php //endif; 
                            ?>

                        </ul>
                    </div>
                </li>
                <?php //endif; 
                ?>
                
                
                <!-- Groupes::ressources humaines  => -->

                <?php //if(auth()->hasGroupe(Groupes::ADMIN)): 
                ?>

                <li class="nav-item">
                    <a data-toggle="collapse" href="#grh">
                        <i class="fas fa-pen-square"></i>
                        <p class="text-upper">ressources humaines</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="grh">
                        <ul class="nav nav-collapse">
                            <!-- 👉 Caissier, Gérant, Admin -->
                            <?php //if(auth()->hasRole(Roles::ADMIN_H)): 
                            ?>
                            <li>
                                <a class="item-link" href="<?= url('client/liste') ?>">
                                    <span class="sub-item">➕ Nouvelle vente</span>
                                </a>
                            </li>
                            <?php //endif; 
                            ?>

                        </ul>
                    </div>
                </li>
                <?php //endif; 
                ?>
                

                <!-- Groupes::Configuration  => -->

                <?php //if(auth()->hasGroupe(Groupes::ADMIN)): 
                ?>

                <li class="nav-item">
                    <a data-toggle="collapse" href="#parametre">
                        <i class="fas fa-pen-square"></i>
                        <p class="text-upper">Configuration</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="parametre">
                        <ul class="nav nav-collapse">
                            <!-- 👉 Caissier, Gérant, Admin -->
                            <?php //if(auth()->hasRole(Roles::ADMIN_H)): 
                            ?>
                            <li>
                                <a class="item-link" href="<?= url('client/liste') ?>">
                                    <span class="sub-item">➕ Etablissement</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('client/liste') ?>">
                                    <span class="sub-item">➕ Semestre</span>
                                </a>
                            </li>
                            <?php //endif; 
                            ?>

                        </ul>
                    </div>
                </li>
                <?php //endif; 
                ?>
                


            </ul>

            <!-- END ADMIN SEXION -->
        </div>
    </div>
</div>