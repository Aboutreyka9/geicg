<div class="sidebar sidebar-style-2" data-background-color="dark2">

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <!-- user connected -->
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <div class="name-user">
                        <span style="font-size: 16px; font-weight: bold;"
                            class=""><?= shortName(auth()->user('nom')) ?></span>
                    </div>
                </div>

                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            <?= (string) auth()->user("nom")
                            ?>
                            <span class="user-level text-success"><?= (string) auth()->user("fonction") ?></span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a class="item-link"
                                    href="<?= route('user.profile', ['code' => auth()->user('id')]) ?>">
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
                        <i style="color: #fff!important;" class="fas fa-home"></i>
                        <p style="color: #fff!important;">TABLEAU DE BORD</p>
                    </a>
                </li>


                <!-- Groupes::Gestion académique  => -->

                <?php //if(auth()->hasGroupe(Groupes::ADMIN)): 
                ?>

                <li class="nav-item">
                    <a data-toggle="collapse" href="#académique">
                        <i class="fas fa-pen-square"></i>
                        <p class="text-upper">Gestion académique</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="académique">
                        <ul class="nav nav-collapse">
                            <!-- 👉 Caissier, Gérant, Admin -->
                            <?php //if(auth()->hasRole(Roles::ADMIN_H)): 
                            ?>
                            <li>
                                <a class="item-link" href="<?= url('filieres') ?>">
                                    <span class="sub-item">Filières</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('niveaux') ?>">
                                    <span class="sub-item">Niveaux</span>
                                </a>
                            </li>

                            <li>
                                <a class="item-link" href="<?= url('matières') ?>">
                                    <span class="sub-item">Matières</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('Niveaux') ?>">
                                    <span class="sub-item">Niveaux</span>
                                </a>
                            </li>
                            <?php //endif; 
                            ?>
                            <?php //if(auth()->hasRole(Roles::ADMIN_H)): 
                            ?>
                            <li>
                                <a class="item-link" href="<?= url('emplois-du-temps') ?>">
                                    <span class="sub-item">Emplois du temps</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('Planification des cours') ?>">
                                    <span class="sub-item">Planification des cours</span>
                                </a>
                            </li>
                            <?php //endif; 
                            ?>
                            <?php //if(auth()->hasRole(Roles::ADMIN_H)): 
                            ?>
                            <li>
                                <a class="item-link" href="<?= url('semestres') ?>">
                                    <span class="sub-item">Semestres</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('annees') ?>">
                                    <span class="sub-item">Années</span>
                                </a>
                            </li>
                            <?php //endif; 
                            ?>

                        </ul>
                    </div>
                </li>
                <?php //endif; 
                ?>


                <!-- Groupes::Étudiants  => -->

                <?php //if(auth()->hasGroupe(Groupes::ADMIN)): 
                ?>

                <li class="nav-item">
                    <a data-toggle="collapse" href="#etudiants">
                        <i class="fas fa-pen-square"></i>
                        <p class="text-upper">Étudiants</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="etudiants">
                        <ul class="nav nav-collapse">
                            <!-- 👉 Caissier, Gérant, Admin -->
                            <?php //if(auth()->hasRole(Roles::ADMIN_H)): 
                            ?>
                            <li>
                                <a class="item-link" href="<?= url('inscriptions') ?>">
                                    <span class="sub-item">Inscriptions</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('reinscriptions') ?>">
                                    <span class="sub-item">Réinscriptions</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('dossiers-etudiants') ?>">
                                    <span class="sub-item">Dossiers étudiants</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('cartes-etudiantes') ?>">
                                    <span class="sub-item">Cartes étudiantes</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('historique-scolaire') ?>">
                                    <span class="sub-item">Historique scolaire</span>
                                </a>
                            </li>
                            <?php //endif; 
                            ?>

                        </ul>
                    </div>
                </li>
                <?php //endif; 
                ?>

                <!-- Groupes::Examens  => -->

                <?php //if(auth()->hasGroupe(Groupes::ADMIN)): 
                ?>

                <li class="nav-item">
                    <a data-toggle="collapse" href="#examens">
                        <i class="fas fa-pen-square"></i>
                        <p class="text-upper">Examens</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="examens">
                        <ul class="nav nav-collapse">
                            <!-- 👉 Caissier, Gérant, Admin -->
                            <?php //if(auth()->hasRole(Roles::ADMIN_H)): 
                            ?>
                            <li>
                                <a class="item-link" href="<?= url('programmation') ?>">
                                    <span class="sub-item"> Programmation</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('Saisie-des-notes') ?>">
                                    <span class="sub-item"> Saisie des notes</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('delibérations') ?>">
                                    <span class="sub-item">Délibérations</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('bulletins') ?>">
                                    <span class="sub-item">Bulletins</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('releves-de-notes') ?>">
                                    <span class="sub-item">Relevés de notes</span>
                                </a>
                            </li>
                            <?php //endif; 
                            ?>

                        </ul>
                    </div>
                </li>
                <?php //endif; 
                ?>

                <!-- Groupes::Finance  => -->

                <?php //if(auth()->hasGroupe(Groupes::ADMIN)): 
                ?>

                <li class="nav-item">
                    <a data-toggle="collapse" href="#finance">
                        <i class="fas fa-pen-square"></i>
                        <p class="text-upper">Finance </p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="finance">
                        <ul class="nav nav-collapse">
                            <!--  Gérant, Admin -->
                            <?php //if(auth()->hasRole(Roles::ADMIN_H)): 
                            ?>
                            <li>
                                <a class="item-link" href="<?= url('frais-de-scolarité') ?>">
                                    <span class="sub-item"> Frais de scolarité</span>
                                </a>
                            </li>

                            <?php //endif; 
                            ?>
                            <!-- 👉 Caissier, Gérant, Admin -->
                            <?php //if(auth()->hasRole(Roles::ADMIN_H)): 
                            ?>
                            <li>
                                <a class="item-link" href="<?= url('paiements') ?>">
                                    <span class="sub-item"> Paiements</span>
                                </a>
                            </li>

                            <?php //endif; 
                            ?>
                            <!-- 👉 Caissier, Gérant, Admin -->
                            <?php //if(auth()->hasRole(Roles::ADMIN_H)): 
                            ?>
                            <li>
                                <a class="item-link" href="<?= url('caisse') ?>">
                                    <span class="sub-item"> Caisse</span>
                                </a>
                            </li>

                            <?php //endif; 
                            ?>
                            <!-- 👉 facturation, Gérant, Admin -->
                            <?php //if(auth()->hasRole(Roles::ADMIN_H)): 
                            ?>
                            <li>
                                <a class="item-link" href="<?= url('facturation') ?>">
                                    <span class="sub-item"> Facturation</span>
                                </a>
                            </li>

                            <?php //endif; 
                            ?>
                            <!-- 👉 facturation, Gérant, Admin -->
                            <?php //if(auth()->hasRole(Roles::ADMIN_H)): 
                            ?>
                            <li>
                                <a class="item-link" href="<?= url('salaires') ?>">
                                    <span class="sub-item"> Salaires</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('historique-salaires') ?>">
                                    <span class="sub-item"> Historique salaires</span>
                                </a>
                            </li>

                            <?php //endif; 
                            ?>

                        </ul>
                    </div>
                </li>
                <?php //endif; 
                ?>

                <!-- Groupes::Ressources humaines  => -->

                <?php //if(auth()->hasGroupe(Groupes::ADMIN)): 
                ?>

                <li class="nav-item">
                    <a data-toggle="collapse" href="#grh">
                        <i class="fas fa-pen-square"></i>
                        <p class="text-upper">Ressources humaines </p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="grh">
                        <ul class="nav nav-collapse">
                            <!--  Gérant, Admin -->
                            <?php //if(auth()->hasRole(Roles::ADMIN_H)): 
                            ?>
                            <li>
                                <a class="item-link" href="<?= url('personnel-enseignants') ?>">
                                    <span class="sub-item"> Personnel Enseignants</span>
                                </a>
                            </li>

                            <?php //endif; 
                            ?>
                            <!-- 👉 Caissier, Gérant, Admin -->
                            <?php //if(auth()->hasRole(Roles::ADMIN_H)): 
                            ?>
                            <li>
                                <a class="item-link" href="<?= url('recrutements/personnel') ?>">
                                    <span class="sub-item"> Recrutement</span>
                                </a>
                            </li>

                            <?php //endif; 
                            ?>
                            <!-- 👉 Caissier, Gérant, Admin -->
                            <?php //if(auth()->hasRole(Roles::ADMIN_H)): 
                            ?>
                            <!-- <li>
                                <a class="item-link" href="<?php // url('congés') 
                                                            ?>">
                                    <span class="sub-item"> Congés</span>
                                </a>
                            </li> -->

                            <?php //endif; 
                            ?>

                        </ul>
                    </div>
                </li>
                <?php //endif; 
                ?>


                <!-- Groupes::Administration  => -->

                <?php //if(auth()->hasGroupe(Groupes::ADMIN)): 
                ?>

                <li class="nav-item">
                    <a data-toggle="collapse" href="#administration">
                        <i class="fas fa-pen-square"></i>
                        <p class="text-upper">Administration </p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="administration">
                        <ul class="nav nav-collapse">
                            <!--  Gérant, Admin -->
                            <?php //if(auth()->hasRole(Roles::ADMIN_H)): 
                            ?>
                            <li>
                                <a class="item-link" href="<?= url('utilisateurs') ?>">
                                    <span class="sub-item"> personnel administratif</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('services-fonctions') ?>">
                                    <span class="sub-item"> Fonctions & services</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('annees-semestres') ?>">
                                    <span class="sub-item"> Années & Semestres</span>
                                </a>
                            </li>

                            <?php //endif; 
                            ?>
                            <!-- 👉 Caissier, Gérant, Admin -->
                            <?php //if(auth()->hasRole(Roles::ADMIN_H)): 
                            ?>
                            <li>
                                <a class="item-link" href="<?= url('roles') ?>">
                                    <span class="sub-item"> Rôles & permissions</span>
                                </a>
                            </li>

                            <?php //endif; 
                            ?>
                            <!-- 👉 Caissier, Gérant, Admin -->
                            <?php //if(auth()->hasRole(Roles::ADMIN_H)): 
                            ?>
                            <li>
                                <a class="item-link" href="<?= url('parametres') ?>">
                                    <span class="sub-item"> Paramètres</span>
                                </a>
                            </li>

                            <?php //endif; 
                            ?>
                            <!-- 👉 Caissier, Gérant, Admin -->
                            <?php //if(auth()->hasRole(Roles::ADMIN_H)): 
                            ?>
                            <li>
                                <a class="item-link" href="<?= url("journaux-activités") ?>">
                                    <span class="sub-item"> Journaux d'activités</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url("sauvegardes") ?>">
                                    <span class="sub-item"> Sauvegardes</span>
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