<?php



// require_once("./fonctions.php");

use App\Core\Auth;
use App\Models\Catalogue;
use App\Models\Factory;
use App\Models\Personne;
use App\Services\Service;

function bTest()
{
  echo "test";
}

function aTest()
{
  return true;
}
function chargerDashboardAdmin()
{

  $fc = new Factory();


  $user = $fc->getUserWithFoction();
  $chambre = $fc->getAllChambresWithCategorie();
  $service = $fc->getAllServices();
  $chambreOccuper = $fc->getCountChambreOccuper(date('Y-m-d 23:59:59'));

?>

  <div class="col-md-3 ">
    <div class="card bg-grad-default">
      <div class="card-body text-center ">
        <div class="card-title">
          <h4> 👨‍🦲 Total employés </h4>
        </div>
        <div class="card-title">
          <h2> <?= count($user) ?> </h2>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3 ">
    <div class="card bg-grad-default">
      <div class="card-body text-center ">
        <div class="card-title">
          <h4> 🏙 Total chambres </h4>
        </div>
        <div class="card-title">
          <h2> <?= count($chambre) ?> </h2>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3 ">
    <div class="card bg-grad-default">
      <div class="card-body text-center ">
        <div class="card-title">
          <h4> 🏙 Chambres occupées</h4>
        </div>
        <div class="card-title">
          <h2> <?= $chambreOccuper ?> </h2>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card bg-grad-default">
      <div class="card-body text-center ">
        <div class="card-title">
          <h4> 🛒 Total services </h4>
        </div>
        <div class="card-title">
          <h2> <?= count($service) ?> </h2>
        </div>
      </div>
    </div>
  </div>


  <?php

}

function chargerDashboardAdminItem()
{

  $fc = new Factory();

  $groupes = $fc->getGroupesAndRolesUser(Auth::user("id"));

  $roles = [];
  foreach ($groupes as $g) {
    $roles[$g['groupe']][] = $g['role_id'];
  }

  foreach ($roles as $k => $r):
  ?>

    <div class="col-md-4 ">
      <div class="card bg-grad-default">
        <div class="card-body text-center card-dash">
          <h4><?= dashlabel($k) ?></h4>
          <ul style="text-align: center; ">
            <?php foreach ($r as $role): ?>
              <li class="dashlink"><a href="<?= dashlink($role) ?>"><?= dashlinkLabel($role) ?>
                </a></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>

    <?php
  endforeach;
}

function chargerListeRolesPermissionUser($code_user)
{
  $roles = (new Factory())->getUserRoles($code_user);

  // var_dump($roles);

  if (!empty($roles)) {
    $i = 0;

    foreach ($roles as $data) {
      if ($data['create_permission'] == 1 || $data['edit_permission'] == 1 || $data['show_permission'] == 1 || $data['delete_permission'] == 1) {
        $i++;
    ?>

        <tr>
          <th><?= $i ?></th>

          <td><?= $data['name'] ?></td>
          <td><?= $data['description'] ?></td>
          <td><?= $data['create_permission'] == 1 ? '✅' : '' ?></td>
          <td><?= $data['edit_permission'] == 1 ? '✅' : '' ?></td>
          <td><?= $data['show_permission'] == 1 ? '✅' : '' ?></td>
          <td><?= $data['delete_permission'] == 1 ? '✅' : '' ?></td>

        </tr>
      <?php }
    }
  } else {
    echo "<tr>
      <td colspan='7' class='text-center text-danger'>Aucune information</td> </tr>";
  }
}

function chargerListeSalaireHistoriqueUser($code_user)
{
  $salaires = (new Factory())->getAllSalaireForUser($code_user);

  // var_dump($roles);

  if (!empty($salaires)) {
    $i = 0;

    foreach ($salaires as $data) {
      $i++;
      $mois = getFormatMois($data['mois_salaire']);
      $montantTotal = $data['montant_salaire'];

      ?>
      <tr>
        <th scope="row"> <?= $i ?></th>
        <td data-titles="<?= $data['user_created'] ?>"> <?= date_formater($data['created_salaire']) ?></td>
        <td><?= $data['user'] ?></td>
        <td><?= $mois ?></td>
        <td class="text-center"><?= money($montantTotal) ?></td>
        <td class="text-center" data-titles="<?= $data['user_confirm'] ?>"><?= checkStateDepense($data['etat_salaire']) ?></td>
        <td class="table_button">

          <div class="dropdown">
            <button type="button" <?= ($data['etat_salaire'] == 1 ? 'disabled' : '') ?> class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown">

            </button>

            <div class="dropdown-menu">

              <button class="dropdown-item btn_confirm_salaire" data-salaire="<?= crypter($data['code_salaire']) ?>"> ✅ Confirmer</button>
              <button class="dropdown-item frmModifierSalaire" data-salaire="<?= crypter($data['code_salaire']) ?>"> 📝 Modifier</button>
              <button class="dropdown-item btn_delete_salaire" data-salaire="<?= crypter($data['code_salaire']) ?>"> ❌ Annuler</button>
            </div>
          </div>
        </td>
      </tr>

    <?php }
  } else {
    echo "<tr>
      <td colspan='7' class='text-center text-danger'>Aucune information</td> </tr>";
  }
}
function chargerCategorie()
{

  $output = "";
  $categories = (new Factory())->getAllCategoriesChambre();

  if ($categories) {

    $output .= '
              <div class="form-group col-md-3">
              <label for="categorie">Categorie chambre</label>
              <select name="categorie" class="form-control">
              <option value=""></option>';

    foreach ($categories as $categorie) {
      $output .= '<option value="' . $categorie['code_typechambre'] . '">' . $categorie['libelle_typechambre'] . '</option>';
    }

    $output .= '</select>
                </div>

                
              
          ';
    return $output;
  }
}

function chargerTypePiece()
{

  $output = "";

  foreach (PIECES_DATA as $tp) {
    $output .= '<option value="' . $tp . '">' . $tp . '</option>';
  }

  return $output;
}

function chargerGenre()
{

  $output = "";

  foreach (SEXEP as $genre) {
    $output .= '<option value="' . $genre . '">' . $genre . '</option>';
  }

  return $output;
}

function chargerStatutChambre()
{

  $output = "";

  $output .= '
            <div class="form-group col-md-3">
            <label for="categorie">Statut chambre</label>
            <select name="etat_chambre" class="form-control">';

  foreach (STATUT_CHAMBRE as $st) {
    $output .= '<option value="' . $st . '">' . strtoupper($st) . '</option>';
  }

  $output .= '</select>
              </div>
        ';
  return $output;
}

function chargerListeUser()
{
  $fc = new Factory();
  $users = $fc->getUserWithFoction();

  if (!empty($users)) {

    $i = 0;

    foreach ($users as $data) {
      $i++;
      $etat = $data['etat_user'] == 1 ? '<span class="badge badge-success"> ✅ Actif</span>' : '<span class="badge badge-danger"> ❌ Desactivé</span>';
    ?>

      <tr>

        <td><?= $i ?></td>
        <td><?= $data['email'] ?></td>
        <td><?= $data['nom'] ?></td>
        <td><?= $data['prenom'] ?></td>
        <td><?= $data['telephone'] ?></td>
        <td><?= $data['libelle_fonction'] ?></td>
        <td><?= $etat ?></td>
        <td class="">
          <span hidden> <?= $data['code_user'] ?> </span>

          <div class="dropdown">
            <button class="btn btn-dark dropdown-toggle" data-toggle="dropdown">
              Action
            </button>
            <div class="dropdown-menu">

              <?php if (!empty($data['token']) && $data['etat_user'] == 0) : ?>
                <button data-user="<?= crypter($data['code_user']) ?>" class="dropdown-item btn_send_mail"> 📧 Renvoyer mail </button>
              <?php endif; ?>

              <a href="#" class="dropdown-item " data-user="<?= crypter($data['code_user']) ?>
        "> <i class="fa fa-print"></i> Imprimer </a>

              <a href="<?= route('profile.employe', ['code' => crypter($data['code_user'])]) ?>
        " class="dropdown-item " data-user="<?= crypter($data['code_user']) ?>
        "> 👁‍🗨 Voir </a>

              <?php if (empty($data['token'])) : ?>
                <?php if ($data['etat_user']) : ?>

                  <button class="dropdown-item btn_disable_user" data-user="<?= crypter($data['code_user']) ?>"> ❌ Desactiver compte</button>
                <?php else : ?>
                  <button class="dropdown-item btn_enable_user" data-user="<?= crypter($data['code_user']) ?>"> ✅ Activer compte</button>

                <?php endif; ?>

              <?php endif; ?>
            </div>
          </div>

        </td>
      </tr>
    <?php }
  } else {
    echo "<tr><td colspan='8' class='text-center'>Aucun utilisateur trouvé</td></tr>";
  }
}

function chargerListeReservationAnnuler()
{

  $fc = new Factory();
  $reservations = $fc->getAllDetailesReservationsAnnulers();
  // var_dump($reservations);
  // return;
  $output = '';


  if (!empty($reservations)) {
    $i = 0;
    foreach ($reservations as $data) :
      $i++;
      $nbjr = daysBetweenDates(
        $data['date_entree'],
        $data['date_sortie']
      );
      $montantchambre = $data['prix_reservation'] * $nbjr;

      $output .= '
    
                <tr>
                <td>' . $i . '</td>
                <td>' . date_formater($data['created_reservation']) . '</td>
                <td>  ' . $data['nom_client'] . ' </td>
                <td>' . $data['libelle_chambre'] . '</td>
                <td>' . money($data['prix_reservation']) . '</td>
                <td data-titles="Sejour du ' . date_formater($data['date_entree']) . ' au ' . date_formater($data['date_sortie']) . '">
                    ' . $nbjr . '</td>
            
                <td><span class="text-danger"> ' . money($montantchambre) . ' </span></td>
                <td>' . $data['user'] . '</td>
                
                </tr>';

    endforeach;
    return $output;
  } else {
    echo "<tr>
      <td colspan='8' class='text-center text-danger'>Aucune information disponible </td> </tr>";
  }
}

function chargerListeServiceAnnuler()
{

  $fc = new Factory();
  $services = $fc->getAllDetailsServicesAnnulers();
  // var_dump($services);
  // return;
  $output = '';


  if (!empty($services)) {
    $i = 0;
    foreach ($services as $data) :
      $i++;

      $output .= '
    
                <tr>
                <td>' . $i . '</td>
                    <td>' . date_formater($data['created_consommation']) . '</td>
                    <td> ' . $data['nom_client'] . '</td>
                    <td>' . $data['libelle_service'] . '</td>
                    <td>' . money($data['prix_consommation']) . '</td>
                    <td>' . $data['quantite_consommation'] . '</td>
                   
                <td> <span class="text-danger"> ' . money($data['montant_services']) . ' </span> </td>
                <td>' . $data['user'] . '</td>
                
                </tr>';

    endforeach;
    return $output;
  } else {
    echo "<tr>
      <td colspan='8' class='text-center text-danger'>Aucune information disponible </td> </tr>";
  }
}




function aChargerListeCategories()
{
  // 👉 récupère le compte et la boutique courante (à adapter selon ton système)

  $categorieModel = new Catalogue();

  $categories = $categorieModel->getAllCategorieByCompteBoutique(COMPTE_CODE, BOUTIQUE_CODE, ETAT_ACTIF);
  if (!empty($categories)) {
    $i = 0;
    foreach ($categories as $data) {
      $i++; ?>

      <tr>
        <th scope="row"><?= $i ?></th>

        <!-- libellé -->
        <td class="text-center">
          <?= ($data['libelle_categorie']) ?>
        </td>

        <!-- description fictive (design conservé) -->
        <td class="text-center" data-titles="<?= ($data['description_categorie']) ?>">
          ...
        </td>

        <td class="table_button">
          <button
            id="frmModifierCategorie<?= $i ?>"
            type="button"
            class="btn btn-primary btn-sm mr-2 frmModifierCategorie"
            data-categorie="<?= ($data['code_categorie']) ?>">
            <i class="fa fa-edit"></i> Modifier
          </button>

          <button
            id="categorieDeleteCategorie<?= $i ?>"
            type="button"
            class="btn btn-danger btn-sm categorieDeleteCategorie"
            data-categorie="<?= ($data['code_categorie']) ?>">
            <i class="fa fa-trash"></i> Supprimer
          </button>
        </td>
      </tr>

    <?php }
  } else {
    echo "
        <tr>
            <td colspan='5' class='text-center text-danger'>
                Aucune categorie enregistrée
            </td>
        </tr>";
  }
}
function aChargerListeProduits()
{
    // 👉 récupère le compte et la boutique courante
    $produitModel = new Catalogue();

    $produits = $produitModel->getAllProduitByCompteBoutique(
        COMPTE_CODE,
        BOUTIQUE_CODE,
        ETAT_ACTIF
    );

    if (!empty($produits)) {
        $i = 0;
        foreach ($produits as $data) {
            $i++; ?>

            <tr>
                <th scope="row"><?= $i ?></th>

                <!-- Libellé produit -->
                <td class="text-center">
                    <?= $data['libelle_produit'] ?>
                </td>

                <!-- Prix achat -->
                <td class="text-center">
                    <?= number_format($data['prix_achat'], 0, ',', ' ') ?>
                </td>

                <!-- Prix vente -->
                <td class="text-center">
                    <?= number_format($data['prix_vente'], 0, ',', ' ') ?>
                </td>

                <!-- Stock -->
                <td class="text-center">
                    <?= $data['stock_produit'] ?>
                </td>

                <!-- Actions -->
                <td class="table_button">
                    <button
                        id="frmModifierProduit<?= $i ?>"
                        type="button"
                        class="btn btn-primary btn-sm mr-2 frmModifierProduit"
                        data-produit="<?= $data['code_produit'] ?>">
                        <i class="fa fa-edit"></i> Modifier
                    </button>

                    <button
                        id="produitDeleteProduit<?= $i ?>"
                        type="button"
                        class="btn btn-danger btn-sm produitDeleteProduit"
                        data-produit="<?= $data['code_produit'] ?>">
                        <i class="fa fa-trash"></i> Supprimer
                    </button>
                </td>
            </tr>

        <?php }
    } else {
        echo "
        <tr>
            <td colspan='6' class='text-center text-danger'>
                Aucun produit enregistré
            </td>
        </tr>";
    }
}
function aChargerListeMark()
{
  // 👉 récupère le compte et la boutique courante (à adapter selon ton système)

  $markModel = new Catalogue();

  $marks = $markModel->getAllMarkByCompteBoutique(COMPTE_CODE, BOUTIQUE_CODE, ETAT_ACTIF);
  if (!empty($marks)) {
    $i = 0;
    foreach ($marks as $data) {
      $i++; ?>

      <tr>
        <th scope="row"><?= $i ?></th>

        <!-- libellé -->
        <td class="text-center">
          <?= ($data['libelle_mark']) ?>
        </td>

        <td class="table_button">
          <button
            id="frmModifiermark<?= $i ?>"
            type="button"
            class="btn btn-primary btn-sm mr-2 frmModifierMark"
            data-mark="<?= ($data['code_mark']) ?>">
            <i class="fa fa-edit"></i> Modifier
          </button>

          <button
            id="markDeleteMark<?= $i ?>"
            type="button"
            class="btn btn-danger btn-sm markDeleteMark"
            data-mark="<?= ($data['code_mark']) ?>">
            <i class="fa fa-trash"></i> Supprimer
          </button>
        </td>
      </tr>

    <?php }
  } else {
    echo "
        <tr>
            <td colspan='5' class='text-center text-danger'>
                Aucune mark enregistrée
            </td>
        </tr>";
  }
}
function aChargerListeUnite()
{
  // 👉 récupère le compte et la boutique courante (à adapter selon ton système)

  $uniteModel = new Catalogue();

  $unites = $uniteModel->getAllUniteByCompteBoutique(COMPTE_CODE, BOUTIQUE_CODE, ETAT_ACTIF);
  if (!empty($unites)) {
    $i = 0;
    foreach ($unites as $data) {
      $i++; ?>

      <tr>
        <th scope="row"><?= $i ?></th>

        <!-- libellé -->
        <td class="text-center">
          <?= ($data['libelle_unite']) ?>
        </td>

        <td class="table_button">
          <button
            id="frmModifierUnite<?= $i ?>"
            type="button"
            class="btn btn-primary btn-sm mr-2 frmModifierUnite"
            data-unite="<?= ($data['code_unite']) ?>">
            <i class="fa fa-edit"></i> Modifier
          </button>

          <button
            id="uniteDeleteUnite<?= $i ?>"
            type="button"
            class="btn btn-danger btn-sm uniteDeleteUnite"
            data-unite="<?= ($data['code_unite']) ?>">
            <i class="fa fa-trash"></i> Supprimer
          </button>
        </td>
      </tr>

    <?php }
  } else {
    echo "
        <tr>
            <td colspan='5' class='text-center text-danger'>
                Aucune unite enregistrée
            </td>
        </tr>";
  }
}


function chargerListeServices()
{
  $services = (new Factory())->getAllServices();

  if (!empty($services)) {
    $i = 0;
    foreach ($services as $data) {
      $i++; ?>

      <tr>
        <th scope="row"><?= $i ?></th>
        <td class="text-center"><?= $data['libelle_service'] ?></td>
        <td class="text-center" data-titles="<?= $data['description_service'] ?>">...</td>
        <td class="text-center"><?= money($data['prix_service']) ?></td>
        <td class="table_button">
          <button id="frmModifierService<?= $i ?>" type="button" class="btn btn-primary btn-sm mr-2 frmModifierService"
            data-service="=<?= crypter($data['code_service']) ?>"><i class="fa fa-edit"></i> Modifier </button>
          <button id="serviceDelete<?= $i ?>" type="button" class="btn btn-danger btn-sm serviceDelete"
            data-service="=<?= crypter($data['code_service']) ?>"><i class="fa fa-trash"></i> Supprimer </button>
        </td>
      </tr>
    <?php }
  } else {
    echo "<tr>
      <td colspan='5' class='text-center text-danger'>Aucun service enregistré</td> </tr>";
  }
}

function chargerListeChambre()
{
  $chambres = (new Factory())->getAllChambresWithCategorie();
  if (!empty($chambres)) {
    $i = 0;
    foreach ($chambres as $data) {
      $i++; ?>

      <tr>
        <th scope="row"><?= $i ?></th>
        <td><img width="50" src="<?= ASSETS ?>images/categorie/<?= $data["image_chambre"] ?>" alt="" srcset=""></td>

        <td class="text-center"><?= $data["libelle_chambre"] ?></td>
        <td class="text-center"><?= $data['categorie'] ?></td>
        <td class="text-center"><?= money($data['prix_chambre']) ?></td>
        <td class="table_button">

          <button type="button" class="btn btn-primary btn-sm mr-2 chambreUpdateModal"
            data-chambre="=<?= crypter($data['code_chambre']) ?>"><i class="fa fa-edit"></i> Modifier </button>
          <button type="button" class="btn btn-danger btn-sm chambreDelete"
            data-chambre="=<?= crypter($data['code_chambre']) ?>"><i class="fa fa-trash"></i> Supprimer </button>
        </td>
      </tr>
    <?php }
  } else {
    echo "<tr>
      <td colspan='6' class='text-center text-danger'>Aucune chambre enregistrée</td> </tr>";
  }
}

function chargerListeVersementUser()
{

  $fc = new Factory();
  $versements = $fc->getAllVersementForUser(Auth::user('id'));

  if (!empty($versements)) {
    $i = 0;
    foreach ($versements as $data) {
      $i++;
      $cloture = $data['cloture'];
      $montant = $cloture != null ?  money($data['montant_facture']) : '...';
      $statut = $cloture != null ?  '✅ Clôturé' : '🔂 En cours';
      $date_cloture = $cloture != null ?  date_formater($data['cloture']) : '...';

    ?>

      <tr>
        <th scope="row"><?= $i ?></th>
        <td><?= date_formater($data['ouverture']) ?></td>
        <td><?= $date_cloture ?></td>
        <td><?= $statut ?></td>
        <td class="bg-dark text-white"> <?= $montant ?> </td>
        <td>
          <button class="btn btn-primary btn-sm btn_detail_versement" title="Voir les details du versement"
            data-caisse="<?= $data['code_versement'] ?>"> <i class="fa fa-eye"></i> Detail</button>
        </td>

      </tr>
  <?php }
  } else {
    echo "<tr>
      <td colspan='9' class='text-center text-danger'>Aucune information disponible </td> </tr>";
  }
}

function chargerListeVersementCaisseDepotUserComptable($start, $end)
{

  $fc = new Factory();
  $versements = $fc->getAllVersementUserCaisseDepotComptable($start, $end);

  if (!empty($versements)) {

    return Service::depotUserForCaisseComptable($versements);
  } else {
    echo "";
  }
}

function chargerListeVersemenHistoriqueUser($user)
{

  $fc = new Factory();
  $versements = $fc->getHistoriqueVersementUser($user);

  if (!empty($versements)) {

    return Service::depotUserForCaisseComptable($versements);
  } else {
    echo "<tr>
      <td colspan='9' class='text-center text-danger'>Aucune information disponible </td> </tr>";
  }
}

function chargerStatutVersementUser()
{

  $montant_reservation = 0;
  $montant_service = 0;
  $montant_attendu = 0;
  $montant_facture = 0;
  $fc = new Factory();
  if (Auth::user('caisse') != null) {

    $facture = $fc->getRecapFactureForUserCompte(Auth::user('caisse'));
    $reservations = $fc->getRecapReservationForUserCompte(Auth::user('caisse'));
    $caisseReservationsEnAttente = $fc->getRecaptReservationForUserCompteEnAttente(Auth::user('caisse'));
    $services = $fc->getRecapServiceForUserCompte(Auth::user('caisse'));
    $CaisseServices = $fc->getRecapCaisseServiceForUserCompte(Auth::user('caisse'));
    $montant_service = $services ?? 0;
    $montant_facture = $facture ?? 0;
    // reservation deja confirmer
    if (!empty($reservations)) {
      foreach ($reservations as $r) {
        $day = daysBetweenDates($r['date_entree'], $r['date_sortie']);
        $montant_reservation += $day * $r['prix_reservation'];
      }
    }

    // reservation en cours
    if (!empty($caisseReservationsEnAttente)) {
      foreach ($caisseReservationsEnAttente as $r) {
        $day = daysBetweenDates($r['date_entree'], $r['date_sortie']);
        $montant_attendu += $day * $r['prix_reservation'];
      }
    }

    if (!empty($CaisseServices)) {
      $montant_attendu += $CaisseServices;
    }
  }

  // if (!empty($versements)) {
  //   return $versements[0]['cloture'] == null ? 1 : 0;
  // }
  ?>
  <div class="col-md-3 ">
    <div class="card bg-grad-info">
      <div class="card-body text-center ">
        <div class="card-title">
          <h5> 📊 Montant de reservation </h5>
        </div>
        <div class="card-title">
          <h4><?= money($montant_reservation) ?></h4>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3 ">
    <div class="card bg-grad-info">
      <div class="card-body text-center ">
        <div class="card-title">
          <h5> 📊 Montant service </h5>
        </div>
        <div class="card-title">
          <h4><?= money($montant_service) ?></h4>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card bg-grad-info">
      <div class="card-body text-center ">
        <div class="card-title">
          <h5> 📊 Montant attendu </h5>
        </div>
        <div class="card-title">
          <h4><?= money($montant_attendu) ?></h4>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card bg-grad-info">
      <div class="card-body text-center ">
        <div class="card-title">
          <h5> 💰 Montant en caisse </h5>
        </div>
        <div class="card-title">
          <h4><?= money($montant_facture) ?></h4>
        </div>
      </div>
    </div>
  </div>

<?php

}


function chargerVersementCaisseDepotComptable($start, $end)
{

  $fc = new Factory();
  $facture = $fc->getTotalFactureStandByCaisseComptable($start, $end);
  $caisse = $fc->getTotalFactureEncaisseCaisseComptable($start, $end);
  $caisseOpen = $fc->getTotalFactureOpenCaisseComptable($start, $end);
  $montantStandBy = $facture ?? 0;
  $montantCaisse = $caisse ?? 0;
  $montantOpen = $caisseOpen ?? 0;



?>

  <div class="col-md-4 ">
    <div class="card bg-grad-info">
      <div class="card-body text-center ">
        <div class="card-title">
          <h4> 💰 Montant total en caissé </h4>
        </div>
        <div class="card-title">
          <h3 id="caisseComptable"><?= money($montantCaisse) ?></h3>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4 ">
    <div class="card bg-grad-info">
      <div class="card-body text-center ">
        <div class="card-title">
          <h4> 💰 Montant de caisse [ <span class="text-success">ouverte</span> ] </h4>
        </div>
        <div class="card-title">
          <h3 id="caisseOpenComptable"><?= money($montantOpen) ?></h3>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card bg-grad-info">
      <div class="card-body text-center ">
        <div class="card-title">
          <h4> ❓ Recette en attente </h4>
        </div>
        <div class="card-title">
          <h3 id="factureStandbyComptable"> <?= money($montantStandBy) ?> </h3>
        </div>
      </div>
    </div>
  </div>

<?php

}

function chargerBilanCaisseComptable($start, $end)
{

  $fc = new Factory();

  $montantDepense = 0;

  $totalcaisse = $fc->getTotalFactureEncaisseCaisseComptable($start, $end);
  $caisseDepense = $fc->getTotalDepenseCaisseComptable($start, $end);
  $caisseSalaire = $fc->getTotalSalaireCaisseComptable($start, $end);
  $montantCaisse = $totalcaisse ?? 0;
  $montantDepense = $caisseDepense + $caisseSalaire;
  $montantDisponible = $montantCaisse - $montantDepense;
  $colorMontant = $montantDisponible > 0 ? 'text-success' : 'text-danger';



?>

  <div class="col-md-4 ">
    <div class="card bg-grad-info">
      <div class="card-body text-center ">
        <div class="card-title">
          <h4> 💰 Montant total en caissé </h4>
        </div>
        <div class="card-title">
          <h3 id="totalCaisseComptable"> <?= money($montantCaisse) ?> </h3>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4 ">
    <div class="card bg-grad-info">
      <div class="card-body text-center ">
        <div class="card-title">
          <h4> 💰 Montant total depensé </h4>
        </div>
        <div class="card-title">
          <h3 class="text-danger" id="totalDepenseComptable"> <?= money($montantDepense) ?> </h3>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card bg-grad-info">
      <div class="card-body text-center ">
        <div class="card-title">
          <h4> 💰 Montant total disponible </h4>
        </div>
        <div class="card-title" id="totalDisponibleComptable">
          <h3 class="<?= $colorMontant ?>"> <?= money($montantDisponible) ?> </h3>
        </div>
      </div>
    </div>
  </div>


<?php

}

function chargerDetailsBilanCaisseComptable($start, $end)
{

  $fc = new Factory();

  $detailsReservation = $fc->getDetailsBilanCaisseComptableReservation($start, $end);
  $service = $fc->getDeatailsBilanCaisseComptableService($start, $end);
  $reservationNonRegler = $fc->CaisseComptableReservationNonRegler();
  $serviceNonRegler = $fc->CaisseComptableServiceNonRegler();
  $reservationEnnuler = $fc->getDetailsBilanCaisseComptableReservationEnnuler($start, $end);
  $serviceEnnuler = $fc->getDetailsBilanCaisseComptableServiceEnnuler($start, $end);

  $data = loadDataBilanCaisseComptable($detailsReservation, $service, $reservationNonRegler, $serviceNonRegler, $reservationEnnuler, $serviceEnnuler);

?>

  <div class="col-md-4">
    <div class="card bg-grad-dark">
      <div class="card-body text-center ">
        <div class="card-title">
          <h4 class="text-white"> 📊 Montant reservations </h4>
        </div>
        <div class="card-title">
          <h3 class="text-white" id="reservationCaisseComptable"><?= $data['montant_reservation'] ?></h3>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card bg-grad-dark">
      <div class="card-body text-center ">
        <div class="card-title">
          <h4 class="text-white"> 📊 Montant services </h4>
        </div>
        <div class="card-title">
          <h3 class="text-white" id="serviceCaisseComptable"><?= $data['montant_service'] ?></h3>
        </div>
      </div>
    </div>
  </div>


  <div class="col-md-4">
    <div class="card bg-grad-dark">
      <div class="card-body text-center ">
        <div class="card-title">
          <h4 class="text-white"> <a class="text-white" href="<?= route('facture.attente') ?>"> ❓ Total Non regles <span class="text-white" id="countReservationNonRegler">(<?= $data['countReservation'] ?>)</span></a> </h4>
        </div>
        <div class="card-title">
          <h3 class="text-danger" id="montantReservationNonRegler"><?= $data['montantNotOk'] ?></h3>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card bg-grad-dark">
      <div class="card-body text-center">
        <div class="card-title">
          <h4 class="text-white"> <a class="text-white" href="<?= route('reservation.annuler') ?>">❌ Reservations ennulées <span class="text-white" id="countReservationEnnuler"><?= $data['countReservationEnnuler'] ?></span> </a> </h4>
        </div>
        <div class="card-title">
          <h3 class="text-danger" id="montantReservationEnnuler"><?= $data['montantReservationEnnuler'] ?></h3>

        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card bg-grad-dark">
      <div class="card-body text-center">
        <div class="card-title">
          <h4 class="text-white"> <a class="text-white" href="<?= route('service.annuler') ?>">❌ Services ennulés <span class="text-white" id="countServiceEnnuler"><?= $data['countServiceEnnuler'] ?></span> </a> </h4>
        </div>
        <div class="card-title">
          <h3 class="text-danger" id="montantServiceEnnuler"><?= $data['montantServiceEnnuler'] ?></h3>
        </div>
      </div>
    </div>
  </div>



<?php

}

function chargerBilanSalaire($start, $end)
{

  $fc = new Factory();

  $caisseSalaire = $fc->getTotalSalaireCaisseComptable($start, $end);
  $caisseSalaireEnAttente = $fc->getTotalSalaireCaisseComptable($start, $end, 0);
  $totalSalaireMois = $fc->getTotalSalaireCaisseComptable($start, $end);

?>

  <div class="col-md-4">
    <div class="card bg-grad-info">
      <div class="card-body text-center ">
        <div class="card-title">
          <h4> 📊 Total Montant salaire </h4>
        </div>
        <div class="card-title">
          <h3 id="totalSalaireCaisse"> <?= money($caisseSalaire ?? 0) ?> </h3>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card bg-grad-info">
      <div class="card-body text-center ">
        <div class="card-title">
          <h4> ⏳ Total salaire en attente </h4>
        </div>
        <div class="card-title">
          <h3 class="text-danger" id="totalSalaireEnAttente"> <?= money($caisseSalaireEnAttente ?? 0) ?> </h3>
        </div>
      </div>
    </div>
  </div>


  <div class="col-md-4">
    <div class="card bg-grad-info">
      <div class="card-body text-center ">
        <div class="card-title">
          <h4> 💰 Total salaire du mois </h4>
        </div>
        <div class="card-title">
          <h3 class="text-success" id="totalSalaireMois"> <?= money($totalSalaireMois ?? 0) ?> </h3>
        </div>
      </div>
    </div>
  </div>

<?php

}

function chargerBilanDepense($start, $end)
{

  $fc = new Factory();

  $caisseDepense = $fc->getTotalDepenseCaisseComptable($start, $end);
  $caisseDepenseEnAttente = $fc->getTotalDepenseCaisseComptable($start, $end, 0);
  $totalDepenseMois = $fc->getTotalDepenseCaisseComptable($start, $end);


?>

  <div class="col-md-4">
    <div class="card bg-grad-info">
      <div class="card-body text-center ">
        <div class="card-title">
          <h4> 📊 Total Montant depense </h4>
        </div>
        <div class="card-title">
          <h3 id="totalDepenseCaisse"> <?= money($caisseDepense ?? 0) ?> </h3>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card bg-grad-info">
      <div class="card-body text-center ">
        <div class="card-title">
          <h4> ⏳ Total depense en attente </h4>
        </div>
        <div class="card-title">
          <h3 class="text-danger" id="totalDepenseEnAttente"> <?= money($caisseDepenseEnAttente ?? 0) ?> </h3>
        </div>
      </div>
    </div>
  </div>


  <div class="col-md-4">
    <div class="card bg-grad-info">
      <div class="card-body text-center ">
        <div class="card-title">
          <h4> 💰 Total depense du mois </h4>
        </div>
        <div class="card-title">
          <h3 class="text-success" id="totalDepenseMois"> <?= money($totalDepenseMois ?? 0) ?> </h3>
        </div>
      </div>
    </div>
  </div>

<?php

}

function chargerReceptionRecap()
{

  $fc = new Factory();

  $montantDepense = 0;

?>

  <div class="col-md-4 ">
    <a class="recept-link" href="<?= route('reservation.check', ['code' => 'in']) ?>
       ">
      <div class="card bg-grad-success h-recept">
        <div class="card-body text-center ">
          <div class="card-title">
            <h2> <span style="font-size:25px"> ➡</span> Check in </h2>
          </div>
        </div>
      </div>
    </a>
  </div>

  <div class="col-md-4 ">
    <a class="recept-link" href="<?= route('reservation.check', ['code' => 'out']) ?>">
      <div class="card bg-grad-warning h-recept">
        <div class="card-body text-center ">
          <div class="card-title">
            <h2><span style="font-size:25px"> ⬅</span> Check out </h2>
          </div>
        </div>
      </div>
    </a>
  </div>

  <div class="col-md-4">
    <a class="recept-link" href="<?= route('reservation.check', ['code' => 'history']) ?>">
      <div class="card bg-grad-primary h-recept">
        <div class="card-body text-center ">
          <div class="card-title">
            <h2> 🕓 Historiques Reservations</h2>
          </div>
        </div>
      </div>
    </a>
  </div>


  <?php

}


function chargerListeReservation()
{
  $date = date("Y-m-d 23:59:59");
  //   $today = new DateTime();
  // // Date 25 jours en arrière
  // $past = (new DateTime())->sub(new DateInterval('P31D'));
  //  = $past->format('Y-m-d 00:00:00');
  // $end   = $today->format('Y-m-d 23:59:59');

  $reservation = (new Factory())->getAllReservationsActive($date);
  if (empty($reservation)) {
    echo "";
    return;
  }

  return service()::reservationsActive($reservation);
}

function chargerListeReservationActive()
{
  $date = date("Y-m-d 23:59:59");
  //   $today = new DateTime();
  // // Date 25 jours en arrière
  // $past = (new DateTime())->sub(new DateInterval('P31D'));
  //  = $past->format('Y-m-d 00:00:00');
  // $end   = $today->format('Y-m-d 23:59:59');

  $reservation = (new Factory())->getAllReservationsActive($date);
  if (empty($reservation)) {
    echo "";
    return;
  }

  return service()::reservationsActive($reservation);
}

function chargerListeReservationArrive()
{
  $date = date("Y-m-d 23:59:59");
  //   $today = new DateTime();
  // // Date 25 jours en arrière
  // $past = (new DateTime())->sub(new DateInterval('P31D'));
  //  = $past->format('Y-m-d 00:00:00');
  // $end   = $today->format('Y-m-d 23:59:59');

  $reservation = (new Factory())->getAllReservationsArrive($date);
  if (empty($reservation)) {
    echo "";
    return;
  }

  return service()::reservationsArrive($reservation);
}

function chargerListeReservationCheckOut($date)
{


  $reservation = (new Factory())->getAllReservationsCheckOut($date);

  if (empty($reservation)) {
    echo "";
    return;
  }
  return service()::checkForReservationOut($reservation);
}

function chargerListeReservationNonRegler()
{
  // $date = date("Y-m");
  $today = new DateTime();
  // Date 25 jours en arrière
  $past = (new DateTime())->sub(new DateInterval('P31D'));
  $start = $past->format('Y-m-d 00:00:00');
  $end   = $today->format('Y-m-d 23:59:59');

  $reservation = (new Factory())->getAllReservationsNonRegler();
  if (empty($reservation)) {
    echo "<tr>
      <td colspan='8' class='text-center text-danger'>Aucune reservation enregistrée</td> </tr>";
    return;
  }
  return service()::reservationDataForSearching($reservation);
}
function chargerListeReservationClient($client)
{

  $fc = new Factory();
  $reservations = $fc->clientDataReservation($client);


  if (!empty($reservations)) {
    $i = 0;
    $total = 0;
    foreach ($reservations as $data) {
      $state = $data['statut_reservation'];
      $i++;
      $nbjr = daysBetweenDates(
        $data['date_entree'],
        $data['date_sortie']
      );
      $montantchambre = $data['prix_reservation'] * $nbjr;
      $montantTotal = $montantchambre + $data['montant_services'];

      $total += $montantTotal;

  ?>

      <tr>
        <th scope="row">
          <span hidden> <?= $data['code_reservation'] ?> </span>
          <?= $i ?>
        </th>
        <td><?= date_formater($data['created_reservation']) ?></td>
        <td
          data-titles="Sejour de <?= $nbjr ?> jour(s), du <?= date_formater($data['date_entree']) ?> au <?= date_formater($data['date_sortie']) ?>">
          <?= checkState($state) ?></td>

        <td><?= money($montantchambre) ?></td>
        <td><?= money($data['montant_services']) ?></td>
        <td class="bg-dark text-white"><?= money($montantTotal) ?></td>
        <td class="table_button">
          <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
              Action
            </button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="<?= route('reservation.details', ['code' => $data['code_reservation']]) ?>"> <i
                  class="fa fa-eye text-dark"> </i> &nbsp; Detail</a>

              <?php if ($data['date_entree'] >= date('Y-m-d') && $data['etat_reservation'] == 0 && $state != STATUT_RESERVATION[2]) : ?>

                <button class="dropdown-item btn_modal_modifier" data-code="<?= $data['code_reservation'] ?>"> <i
                    class="fa fa-edit text-primary"> </i> &nbsp; Modifier</button>
                <?php if ($data['montant_services'] <= 0) : ?>

                  <button class="dropdown-item btn_annuler_reservation"
                    data-reservation="<?= crypter($data['code_reservation']) ?>"> <i class="fa fa-times text-danger"> </i> &nbsp;
                    Ennuler</button>
                <?php endif; ?>
              <?php endif; ?>

              <?php if ($state == STATUT_RESERVATION[0]) : ?>
                <button class="dropdown-item btn_modal_confirmement"
                  data-reservation="<?= crypter($data['code_reservation']) ?>">
                  <i class="fa fa-check text-success"> </i> &nbsp; Confirmer</button>
              <?php endif; ?>

              <?php if ($data['date_sortie'] >= date('Y-m-d') && $state != STATUT_RESERVATION[2]) : ?>

                <button class="dropdown-item btn_modal_service_reservation"
                  data-reservation="<?= crypter($data['code_reservation']) ?>"> <i class="fa fa-check text-success"> </i> &nbsp;
                  Operation</button>
              <?php endif; ?>
              <?php if ($state != STATUT_RESERVATION[2]) : ?>

                <button class="dropdown-item btn_modal_confirme" data-reservation="<?= crypter($data['code_reservation']) ?>">
                  <i class="fa fa-check text-success"> </i> &nbsp; Regler facture</button>
                <a class="dropdown-item" target="_blank" href="<?= route('facture', ['code' => $data['code_reservation']]) ?>">
                  <i class="fa fa-print text-dark"> </i> &nbsp; IMPRIMER</a>
              <?php endif; ?>

            </div>
          </div>
        </td>
      </tr>
    <?php }
    echo "<tr>
<td colspan='5' class='text-left'> <span class='font-weight-bold text-uppercase text-dark'>Montant total</span> </td>
<td colspan='4' class=' text-left'><span class='font-weight-bold text-uppercase text-dark'>" . money($total) . " </span> </td>
</tr>";
  } else {
    echo "<tr>
      <td colspan='9' class='text-center'>Aucune reservation active</td> </tr>";
  }
}

function chargerListeServiceReservationClient($reservation)
{


  $reservation = (new Factory())->getAllServicesOfReservationsroom($reservation);

  if (!empty($reservation)) {
    $total = 0;
    $montant = 0;
    $i = 0;
    foreach ($reservation as $data) {
      $state = $data['etat_consommation'] == 1 ? '<span class="badge badge-success">OUI</span>' : '<span class="badge badge-danger">NON</span>';
      $montant = $data['prix_consommation'] * $data['quantite_consommation'];
      if ($data['etat_consommation'] == 1) {

        $total += $montant;
      }

      $i++;
    ?>

      <tr>
        <th scope="row"><?= $i ?></th>
        <td><?= date_formater($data['created_consommation']) ?></td>
        <td><?= $data["libelle_service"] ?></td>

        <td><?= money($data['prix_consommation']) ?></td>
        <td><?= $data['quantite_consommation'] ?></td>
        <td><?= money($montant) ?></td>
        <td>

          <?= $state ?>
        </td>
        <td class="table_button">
          <?php if ($data['etat_consommation'] != 2) : ?>
            <?php if ($data['date_sortie'] >= date('Y-m-d') && ($data['etat_consommation'] != 1)) : ?>

              <button class="btn btn-primary btn-sm btn_modal_modifier_service_reservation"
                data-consommation="<?= $data['code_consommation'] ?>"> <i class="fa fa-edit"> </i> Modifier </button>
              <button class="btn btn-danger btn-sm ml-2 btn_modal_supprimer_service_reservation"
                data-consommation="<?= $data['code_consommation'] ?>"> <i class="fa fa-trash"> </i> Ennuler </button>
            <?php else :  ?>
              <button disabled class="btn btn-primary btn-sm "> <i class="fa fa-edit"> </i> Modifier </button>
              <button disabled class="btn btn-danger btn-sm ml-2 "> <i class="fa fa-trash"> </i> Ennuler </button>
            <?php endif; ?>
          <?php else : ?>

            <button disabled class="btn btn-primary  btn-sm "> <i class="fa fa-edit"> </i> Modifier </button>
            <button disabled class="btn btn-danger  btn-sm ml-2 "> <i class="fa fa-trash"> </i> Ennuler </button>
          <?php endif; ?>
        </td>
      </tr>
    <?php }
    echo "<tr class='bg-primary'>
<td colspan='5' class='text-left'> <span class='font-italic text-uppercase text-white text-title'>Montant total</span> </td>
<td colspan='4' class=' text-left'><span class=' font-italic text-uppercase text-white text-title'>" . money($total) . " </span> </td>
</tr>";
  } else {
    echo "<tr>
      <td colspan='9' class='text-center text-danger'>Aucune donnée disponible</td>
      </tr>";
  }
}


function daysBetweenDates($dateDebut, $dateFin)
{
  // Convertir les dates en objets DateTime
  $debut = new DateTime($dateDebut);
  $fin = new DateTime($dateFin);

  // Calculer la différence entre les deux dates
  $intervalle = $debut->diff($fin);

  // Retourner le nombre de jours
  return $intervalle->days + 1;
}
function bchargerListeClient()
{

  $personne = new Personne();
  $clients = $personne->getFieldsForParams(TABLES::CLIENTS, ['boutique_code' => BOUTIQUE_CODE], [], 'fetchAll', ['nom_client ASC']);
  if (!empty($clients))

    return personneService()::clientDataService($clients);
}

function chargerListeClient($start, $end)
{


  $fc = new Factory();
  $clients = $fc->getAllClient($start, $end);
  // **

  if (empty($clients)) {
    echo "<tr>
        <td colspan='9' class='text-center text-danger'>Aucun client disponible</td> 
        </tr>";
    return;
  }
  return service()::clientDataForSearching($clients);
}

function chargerInfoClientReservation($client)
{
  return ' 

<ul class="list-group b_shadow">
  <li class="list-group-item title">
    <h3> <i class="fa fa-user-circle"></i> &nbsp; Info client</h3>
  </li>

  <li class="list-group-item">
    <span class="text_row"> Code :</span>' . $client['code_client'] . '
  </li>

  <li class="list-group-item">
    <span class="text_row"> NOM & PRENONS :</span>' . $client['nom_client'] . '
  </li>

  <li class="list-group-item">
    <span class="text_row">CONTACT :</span>' . $client['telephone_client'] . '
  </li>

  <li class="list-group-item">
    <span class="text_row">SEXE :</span>' . $client['genre_client'] . '
  </li>

  <li class="list-group-item">
    <span class="text_row">PIECE :</span>' . $client['piece_client'] . '
  </li>
</ul>

';
}

function chargerInfoChambreReservation($reservation)
{
  $days = daysBetweenDates($reservation['date_entree'], $reservation['date_sortie']);
  $totalMontant = $reservation['prix_chambre'] * $days;

  $facture = $reservation['etat_reservation'] == 1 ? '<span class="badge badge-success">Facture Reglée</span>' : '<span class="badge badge-danger">Facture Non Reglée</span> ';

  $statut = $reservation['date_sortie'] >= date('Y-m-d 23:59:59') ? '<span class="badge badge-success">🔂 en cour </span>' : '<span class="badge badge-danger">❌ Expirée</span> ';

  return '

<ul class="list-group b_shadow">
  <li class="list-group-item title" style="display: flex; justify-content: space-between; flex-wrap: nowrap;">
    <h3> <i class="fa fa-list"></i> &nbsp; Details du sejour
    </h3>
    <h4 class=" pull-right text-danger" style="padding: 1px 5px;" id="countdown"></h4>
  </li>

  <li class="list-group-item">
    <span class="text_row">CATEGORIE :</span>' .  $reservation['categorie'] . '
  </li>

  <li class="list-group-item">
    <span class="text_row">CHAMBRE :</span>' .  $reservation['libelle_chambre'] . '
  </li>

  <li class="list-group-item d-flex justify-content-between">
    <span class="text_row">PRIX :</span>' .  money($reservation['prix_chambre']) . '
   &nbsp; &nbsp; <span class="text_row">#ENREGISTER LE  :</span>' .  date_formater($reservation['created_reservation'], true, true) . '
  </li>

  <li class="list-group-item">
    <span class="text_row">Date d\'entrée <i class="fa fa-clock text-info"></i></span> &nbsp; <span
      id="date_start">' .  date_formater($reservation['date_entree']) . '</span>
    <span class="text_row ml-3"> - &nbsp; &nbsp; Date de sortie <i class="fa fa-clock text-danger"></i></span> &nbsp;
    <span>' .  date_formater($reservation['date_sortie']) . '</span>
    <span hidden id="date_end">' .  $reservation['date_sortie'] . '</span>
  </li>

  <li class="list-group-item">
    <span class="text_row">NOMBRE DE JOUR :</span> ' .  $days . ' ' . $statut . '
  </li>

  <li class="list-group-item">
    <span class="text_row">MONTANT TOTAL :</span> ' .  money($totalMontant) . ' 
    ' . $facture . '  </li>
</ul>

';
}

function chargerListeFonction()
{
  $fonctions = (new Factory())
    ->select("fonctions")->where('hotel_id', Auth::user('hotel_id'))
    ->where('etat_fonction', '1')->All();

  if (!empty($fonctions)) {
    $i = 0;

    foreach ($fonctions as $data) {
      $i++; ?>

      <tr>
        <th><?= $i ?></th>

        <td><?= $data['libelle_fonction'] ?></td>
        <td>... <span class="desc-show"> <?= $data['description_fonction'] ?></span></td>
        <td class="table_button">

          <div class="btn_inligne">
            <button id="frm_modifier_fonction<?= $i ?>" data-code="<?= crypter($data['code_fonction']) ?>"
              class="btn btn-primary btn-sm frm_modifier_fonction" title="Modifier"> <i class="fa fa-edit"></i>
              Modifier</button>

            <button id="btn_delete_fonction<?= $i ?>" data-code="<?= crypter($data['code_fonction']) ?>"
              class="btn btn btn-danger btn-sm btn_delete_fonction" title="Supprimer"> <i class="fa fa-trash"></i>
              Supprimer</button>
          </div>
        </td>
      </tr>
  <?php }
  } else {
    echo "<tr>
      <td colspan='4' class='text-center text-danger'>Aucune fonction enregistrée</td> </tr>";
  }
}

function searchFormTable($title)
{
  ?>
  <div class="row d-flex justify-content-between  items-center m-2 p-1">

    <div class="col-md-6">
      <h4 class="text-bold"> <span style="cursor: pointer;" class="synchroniser"><i class="fa fa-redo"></i></span> &nbsp; <?= $title ?>
        [ <span
          id="counter_items">0</span> ] </h4>
    </div>
    <div class="col-sm-12 col-md-4">

      <input type="search" class="form-control" id="searchInput" placeholder="Recherche...">
      </label>
    </div>
  </div>
<?php
}

function searchFormTableComon($title)
{
?>
  <div class="row d-flex justify-content-between  items-center m-2 p-1">

    <div class="col-md-6">
      <h4 class="text-bold"> <span style="cursor: pointer;" class="synchroniser"><i class="fa fa-redo"></i></span> &nbsp; <?= $title ?>
        [ <span
          class="counter_items">0</span> ] </h4>
    </div>
    <div class="col-sm-12 col-md-4">

      <input type="search" class="form-control searchInput" placeholder="Recherche...">
      </label>
    </div>
  </div>
<?php
}

function headerMenuReservation($searchSelector, $periode, $printSelector)
{
?>
  <div class="row mx-2 mt-4">
    <div style="position: relative;" class="col-md-6 mt-2 mb-2">

      <i style="position: absolute; bottom: 30px; left: 17px; font-size: 26px;" class="fa fa-calendar <?= $searchSelector ?>
      " aria-hidden="true"></i>
      <input type="text" class="form-control <?= $searchSelector ?>
         w-50 pl-5" placeholder="Rechercher une periode">

    </div>

    <div class="col-md-6 mt-2 mb-2">

      <div class="d-flex justify-content-end items-center">

        <div class="form-group">
          <button type="button" data-periode="<?= $periode ?>" class="btn btn-default" id="<?= $searchSelector ?>"> <i class="fa fa-print"></i> IMPRIMER </button>

        </div>

      </div>
    </div>
  </div>

  <?php
}

function chargerListeDepense($start, $end)
{

  $depenses = (new Factory())->getAllDepenseForSearching($start, $end);
  if (empty($depenses)) {
    echo "";
    return;
  }
  return service()::depenseDataForSearching($depenses);
}

function chargerListeSalaire($start, $end)
{


  $salaire = (new Factory())->getAllSalaireForSearching($start, $end);

  if (empty($salaire)) {
    echo "";
    return;
  }
  return service()::salaireDataForSearching($salaire);
}

/** abc ***/

function chargerRecaptListeChambre()
{
  $chambres = (new Factory())->getAllChambresWithCategorie();
  if (!empty($chambres)) {
    $i = 0;
    foreach ($chambres as $data) {
      $i++; ?>

      <tr>
        <th scope="row"><?= $i ?></th>
        <td class="text-center"><?= $data["libelle_chambre"] ?></td>
        <td class="text-center"><?= $data['categorie'] ?></td>
        <td class="text-center"><?= money($data['prix_chambre']) ?></td>
      </tr>
    <?php }
  } else {
    echo "<tr>
      <td colspan='5' class='text-center text-danger'>Aucune chambre enregistrée</td> </tr>";
  }
}

function chargerRecaptListeReservation()
{
  // $date = date("Y-m");
  $today = new DateTime();
  // Date 25 jours en arrière
  $past = (new DateTime())->sub(new DateInterval('P31D'));
  $start = $past->format('Y-m-d 00:00:00');
  $end   = $today->format('Y-m-d 23:59:59');

  $reservation = (new Factory())->getAllReservations($start, $end);
  if (empty($reservation)) {
    echo "<tr>
      <td colspan='7' class='text-center text-danger'>Aucune reservation enregistrée</td> </tr>";
    return;
  }
  return service()::reservationRecaptData($reservation);
}



function chargerRecaptListeClient()
{

  // $date = date("Y-m");
  $today = new DateTime();
  // Date 25 jours en arrière
  $past = (new DateTime())->sub(new DateInterval('P31D'));
  $start = $past->format('Y-m-d 00:00:00');
  $end   = $today->format('Y-m-d 23:59:59');

  $fc = new Factory();
  $clients = $fc->getAllClient($start, $end);
  // **

  if (empty($clients)) {
    echo "<tr>
        <td colspan='8' class='text-center text-danger'>Aucun client disponible</td> 
        </tr>";
    return;
  }
  return service()::clientRecaptData($clients);
}


function chargerRecaptListeServices()
{
  $services = (new Factory())->getAllServices();

  if (!empty($services)) {
    $i = 0;
    foreach ($services as $data) {
      $i++; ?>

      <tr>
        <th scope="row"><?= $i ?></th>
        <td class="text-center"><?= $data['libelle_service'] ?></td>
        <td class="text-center" data-titles="<?= $data['description_service'] ?>">...</td>
        <td class="text-center"><?= money($data['prix_service']) ?></td>

      </tr>
<?php }
  } else {
    echo "<tr>
      <td colspan='4' class='text-center text-danger'>Aucun service enregistré</td> </tr>";
  }
}


function chargerRecaptListeDepense($start, $end)
{

  $depenses = (new Factory())->getAllDepenseForSearching($start, $end);
  if (empty($depenses)) {
    echo "<tr>
      <td colspan='7' class='text-center text-danger'>Aucune information disponible </td> </tr>";
    return;
  }
  return service()::depenseRecaptData($depenses);
}


























?>