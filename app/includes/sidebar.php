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
                    <a style="background: #8debfcf1;" class="" href="<?= route('home') ?>">
                        <i class="fas fa-home"></i>
                        <p>ACCUEIL</p>
                    </a>
                </li>

                <!-- Groupes::Ventes => -->

                <?php //if(auth()->hasGroupe(Groupes::ADMIN)): 
                ?>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#ventes">
                        <i class="fas fa-pen-square"></i>
                        <p class="text-upper">Ventes</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="ventes">
                        <ul class="nav nav-collapse">
                            <!-- 👉 Caissier, Gérant, Admin -->
                            <?php //if(auth()->hasRole(Roles::ADMIN_H)): 
                            ?>
                            <li>
                                <a class="item-link" href="<?= url('client/liste') ?>">
                                    <span class="sub-item">➕ Nouvelle vente</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('boutique/liste') ?>">
                                    <span class="sub-item">📄 Factures</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('fournisseur/liste') ?>">
                                    <span class="sub-item">🔄 Retours / Avoirs</span>
                                </a>
                            </li>

                            <li>
                                <a class="item-link" href="<?= url('user/liste') ?>">
                                    <span class="sub-item">💳 Paiements</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= route('setting.fonctions') ?>">
                                    <span class="sub-item">🧾 Ventes à crédit</span>
                                </a>
                            </li>
                            <?php //endif; 
                            ?>
                            <?php //if(auth()->hasRole(Roles::DASHBOARD_H)): 
                            ?>

                            <?php //endif; 
                            ?>

                        </ul>
                    </div>
                </li>
                <?php //endif; 
                ?>

                <!-- Groupes::Stock => -->
                <!-- 👉 Magasinier, Gérant, Admin -->
                <?php //if(auth()->hasGroupe(Groupes::COMPTABLE)): 
                ?>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#stock">
                        <i class="fas fa-pen-square"></i>
                        <p class="text-upper">Stock</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="stock">
                        <ul class="nav nav-collapse">
                            <?php //if(auth()->hasRole(Roles::COMPTATBLE_H)): 
                            ?>

                            <li>
                                <a class="item-link" href="<?= route('comptable.versement') ?>">
                                    <span class="sub-item">📥 Entrées de stock</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= route('comptable.versement') ?>">
                                    <span class="sub-item">📤 Sorties de stock</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= route('comptable.versement') ?>">
                                    <span class="sub-item">🔁 Ajustements / Inventaire</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= route('comptable.versement') ?>">
                                    <span class="sub-item">⚠️ Stock faible</span>
                                </a>
                            </li>

                            <?php //endif; 
                            ?>

                            <?php //if(auth()->hasRole(Roles::SALAIRE_H)): 
                            ?>


                            <?php //endif; 
                            ?>

                        </ul>
                    </div>
                </li>
                <?php //endif; 
                ?>

                <!-- Groupes::Produits => -->
                <!-- 👉 Gérant, Magasinier -->
                <?php //if(auth()->hasGroupe(Groupes::HOTEL)): 
                ?>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#produits">
                        <i class="fas fa-table"></i>
                        <p class="text-upper">Produits</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="produits">
                        <ul class="nav nav-collapse">
                            <?php //if(auth()->hasRole(Roles::DEPENSE_H)) :
                            ?>

                            <li>
                                <a class="item-link" href="<?= url('produit') ?>">
                                    <span class="sub-item">📋 Liste des produits</span>
                                </a>
                            </li>

                            <li>
                                <a class="item-link" href="<?= url('categorie') ?>">
                                    <span class="sub-item">🧱 Catégories</span>
                                </a>
                            </li>
                            <?php //endif; 
                            ?>


                            <?php //if(auth()->hasRole(Roles::MANAGER_H)): 
                            ?>
                            <li>
                                <a class="item-link" href="<?= url('mark') ?>">
                                    <span class="sub-item">🏷️ Marques</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('unite') ?>">
                                    <span class="sub-item">🔢Unité</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('united') ?>">
                                    <span class="sub-item"> 📚 Références / OEM</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('unitef') ?>">
                                    <span class="sub-item">📷 Codes-barres</span>
                                </a>
                            </li>
                            <?php //endif; 
                            ?>

                        </ul>
                    </div>
                </li>
                <?php //endif; 
                ?>



                <!-- Groupes::fournisseur => -->
                <!-- 👉 Gérant, Admin -->
                <?php //if(auth()->hasGroupe(Groupes::RECEPTION)): 
                ?>

                <li class="nav-item">
                    <a data-toggle="collapse" href="#fournisseurs">
                        <i class="fas fa-th-list"></i>
                        <p class="text-uppercase">Fournisseurs</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="fournisseurs">
                        <ul class="nav nav-collapse">
                            <?php //if(auth()->hasRole(Roles::RECEPTION_H)): 
                            ?>
                            <li>
                                <a class="item-link" href="<?= url('fournisseur')  ?>">
                                    <span class="sub-item">➕ Ajouter fournisseur</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('fournisseur/order') ?>">
                                    <span class="sub-item">📦 Commandes</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('fournisseur/historique') ?>">
                                    <span class="sub-item"> 📑 Historique achats</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('fournisseur/dette') ?>">
                                    <span class="sub-item">💰 Dettes fournisseurs</span>
                                </a>
                            </li>
                            <?php //endif; 
                            ?>


                        </ul>
                    </div>
                </li>
                <?php //endif; 
                ?>



                <!-- Groupes::rapport => -->
                <!-- 👉 Gérant, Admin -->
                <?php //if(auth()->hasGroupe(Groupes::PARAMETRE)): 
                ?>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#rapports">
                        <i class="fas fa-boxes"></i>
                        <p class="text-uppercase">Rapports</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="rapports">
                        <ul class="nav nav-collapse">
                            <?php //if(auth()->hasRole(Roles::COMPTATBLE_H)): 
                            ?>

                            <li>
                                <a class="item-link" href="<?= url('rapports') ?>">
                                    <span class="sub-item">📈 Ventes (jour / mois / année)</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('profit') ?>">
                                    <span class="sub-item">📉 Profits & marges</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('mouvement_stock') ?>">
                                    <span class="sub-item">📦 Mouvement de stock</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('rapport') ?>">
                                    <span class="sub-item">🧾 Rapport caisse</span>
                                </a>
                            </li>

                            <?php //endif; 
                            ?>

                            <?php //if(auth()->hasRole(Roles::SALAIRE_H)): 
                            ?>

                            <li>
                                <a class="item-link" href="<?= url('salaire') ?>">
                                    <span class="sub-item">📤 Export Excel / PDF</span>
                                </a>
                            </li>
                            <?php //endif; 
                            ?>

                        </ul>
                    </div>
                </li>

                <?php //endif; 
                ?>

                <!-- Groupes::boutique  => -->
                <!-- 👉 Admin / Propriétaire  -->
                <?php //if(auth()->hasGroupe(Groupes::boutique)): 
                ?>

                <li class="nav-item">
                    <a data-toggle="collapse" href="#boutiques">
                        <i class="fas fa-pen-square"></i>
                        <p class="text-uppercase">Entrepos</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="boutiques">
                        <ul class="nav nav-collapse">
                            <?php //if(auth()->hasRole(Roles::PARAMETRE)): 
                            ?>

                            <li>
                                <a class="item-link" href="<?= route('setting.home') ?>">
                                    <span class="sub-item">📍 Liste des boutiques</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= route('setting.home') ?>">
                                    <span class="sub-item">➕ Nouvelle boutique</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= route('setting.home') ?>">
                                    <span class="sub-item">🔄 Changer de boutique</span>
                                </a>
                            </li>

                            <?php //endif; 
                            ?>


                        </ul>
                    </div>
                </li>
                <?php //endif; 
                ?>

                <!-- Groupes::user => -->
                <!-- 👉 Admin / Gérant -->
                <?php //if(auth()->hasGroupe(Groupes::user)): 
                ?>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#utilisateurs">
                        <i class="fas fa-boxes"></i>
                        <p class="text-uppercase">Utilisateurs</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="utilisateurs">
                        <ul class="nav nav-collapse">
                            <?php //if(auth()->hasRole(Roles::COMPTATBLE_H)): 
                            ?>

                            <li>
                                <a class="item-link" href="<?= url('user/listes') ?>">
                                    <span class="sub-item">👤 Utilisateurs</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('role') ?>">
                                    <span class="sub-item">🔐 Rôles & permissions</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('historique/connexion') ?>">
                                    <span class="sub-item">🔄 Historique connexions</span>
                                </a>
                            </li>

                            <?php //endif; 
                            ?>

                            <?php //if(auth()->hasRole(Roles::SALAIRE_H)): 
                            ?>

                            <li>
                                <a class="item-link" href="<?= url('historique.salaire') ?>">
                                    <span class="sub-item">Salaires</span>
                                </a>
                            </li>
                            <?php //endif; 
                            ?>

                        </ul>
                    </div>
                </li>
                <?php //endif; 
                ?>

                <!-- Groupes::securite => -->
                <!-- 👉 Admin -->
                <?php //if(auth()->hasGroupe(Groupes::securite)): 
                ?>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#securite">
                        <i class="fas fa-boxes"></i>
                        <p class="text-uppercase">Journal & Sécurité</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="securite">
                        <ul class="nav nav-collapse">
                            <?php //if(auth()->hasRole(Roles::COMPTATBLE_H)): 
                            ?>

                            <li>
                                <a class="item-link" href="<?= url('journal') ?>">
                                    <span class="sub-item">🕵️ Journal d’activité</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('actions') ?>">
                                    <span class="sub-item">🔔 Actions sensibles</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('auth/connexions') ?>">
                                    <span class="sub-item">🔐 Tentatives de connexion</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('auth/backup') ?>">
                                    <span class="sub-item">💾 Sauvegardes (backup)</span>
                                </a>
                            </li>

                            <?php //endif; 
                            ?>

                            <?php //if(auth()->hasRole(Roles::SALAIRE_H)): 
                            ?>

                            <li>
                                <a class="item-link" href="<?= url('salaire') ?>">
                                    <span class="sub-item">Salaires</span>
                                </a>
                            </li>
                            <?php //endif; 
                            ?>

                        </ul>
                    </div>
                </li>
                <?php //endif; 
                ?>

                <!-- Groupes::parametres => -->
                <!-- 👉 Tous (selon permissions) -->
                <?php //if(auth()->hasGroupe(Groupes::parametres)): 
                ?>
                <li class="nav-item">
                    <a data-toggle="collapse" href="#parametres">
                        <i class="fas fa-boxes"></i>
                        <p class="text-uppercase">Paramètres</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="parametres">
                        <ul class="nav nav-collapse">
                            <?php //if(auth()->hasRole(Roles::COMPTATBLE_H)): 
                            ?>

                            <li>
                                <a class="item-link" href="<?= url('hotel/parametres') ?>">
                                    <span class="sub-item">🏢 Infos entreprise</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('boutique/parametres') ?>">
                                    <span class="sub-item">🏪 Paramètres boutique</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('parametres/devises') ?>">
                                    <span class="sub-item">💵 Devises & taxes</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('impression') ?>">
                                    <span class="sub-item">🖨️ Impression factures</span>
                                </a>
                            </li>

                            <?php //endif; 
                            ?>

                            <?php //if(auth()->hasRole(Roles::SALAIRE_H)): 
                            ?>

                            <li>
                                <a class="item-link" href="<?= url('parametres/notifications') ?>">
                                    <span class="sub-item">🔔 Notifications</span>
                                </a>
                            </li>
                            <li>
                                <a class="item-link" href="<?= url('parametres/sauvegarde') ?>">
                                    <span class="sub-item">🔄 Sauvegarde & restauration</span>
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