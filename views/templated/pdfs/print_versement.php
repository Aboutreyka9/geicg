<?php
extract($reservations);
extract($hotel);
// extract($services);
$logo = empty($logo_hotel) ? $libelle_hotel :  '<img src="'. ASSETS. $hotel['logo_hotel'] .'" alt="Logo">';
$fil = $statut_filigramme == 1 ?  '<div class="paid">'.$filigramme.'</div> ': "";
$synthese = [];

foreach ($reserveCount as $r) : 

  $nb_jour = daysBetweenDates($r['date_entree'], $r['date_sortie']);
  $montantChambre = $r['prix_reservation'] * $nb_jour;
  $key = $r['libelle_typechambre'];

  if(key_exists($key, $synthese)) {
    $cnt = $synthese[$key]['nbre'];
    // $chambre = $synthese[$key]['chambre'];
    $montant = $synthese[$key]['montant'];
    // $type = $synthese[$key]['type'];

    $synthese[$key]['nbre'] = $cnt+1;
    $synthese[$key]['montant'] = $montant + $montantChambre;

  }else{
      $synthese[$key]['nbre'] = 1;
      $synthese[$key]['chambre'] = $r['libelle_chambre'];
      $synthese[$key]['montant'] = $montantChambre;
      $synthese[$key]['type'] = $key;
  }

  endforeach;

// var_dump($synthese);
// return;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">

  <style>
    body {
      font-family: Arial, sans-serif;
      margin: -25px -20;
      padding-bottom: 5px;
      font-size: 13px;
    }
    .clearfix{
      margin: 20px 0px;
    }

    h3 {
      color: #333;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      padding: 10px;
      border: 1px solid #ddd;
    }

    th {
      background-color: #F0EDEDFF;
      text-transform: uppercase;
    }

    tbody tr:nth-child(even) {
      background-color: #f8f8f8;
    }

    tbody tr {
      text-align: center;
    }

    /* td:nth-last-child(1) {
      text-align: center;
      font-weight: bold;
      color: #0A0A0AFF;
    } */

   .important{
      /* text-align: center; */
      font-weight: bold;
      color: #0A0A0AFF;
    }

    input[type=checkbox] {
      width: 20px;
      height: 20px;
      color: #21D472FF;
    }

    .times {
      color: red;
      font-size: 25px;
    }

    .text-end {
      text-align: right;
      text-transform: uppercase;
      margin-right: 20px;
    }

    .text-start {
      text-align: left;
      text-transform: uppercase;
      margin-left: 20px;
    }

    .header {

      margin-top: -50px;
      margin-bottom: 25px;
      height: 150px;
      padding: 10px;
    }

    .header>.left {
      position: relative;
      float: left;

    }

   .p{
      font-size: 12px;
      margin: 2;
      padding: 0;
      /* left: 55px; */
      color: #333;
    }

    .header>.right {
      position: relative;
      float: right;
      width: 70%;

    }

    .right>.sexion-info {
      position: absolute;
      font-size: 12px;
      right: 9em;
    }

    .qrcode {
      padding: 0px;
      margin: 0px;
      position: absolute;
      top: 40px;
      right: 1%;
    }
  </style>
</head>

<body>
  <div class="header">
    <div class="left text-start">
      <h4>Reçu de versement</h4>
      <div class="sexion-hotel">
        <p class="p"> <?= $libelle_hotel ?></p>
        <p class="p">***********</p>
        <p class="p">Tél: <?= $telephone_hotel ?>
        </p>
        <p class="p"> ************</p>
        <p class="p">  <?= $adresse_hotel ?> </p>

      </div>
    </div>

    <div class="right text-end">
      <h4>Ciasse N°<span> <?= $infoVersement['code_versement'] ?></span> </h4>
      <div class="qrcode">
        <img src="<?= gqr()->qrReserve("text",80,2); ?>" alt="Mon image" />
      </div>
      <div class="sexion-info">
        <p class="p"> Date/Heure d'Ouverture : <?= date_formater($infoVersement['ouverture'],true,true) ?></p>
        <p class="p">Date/Heure de Clôture : <?= date_formater($infoVersement['cloture'],true,true) ?></p>
        <p class="p important">Montant total : <?= money($infoVersement['montant_total']) ?></p>
        <p class="p important"> Monnaie Réel: <?= money($infoVersement['montant_cloture']) ?></p>
      </div>

    </div>
  </div>
  <div class="clearfix"></div>
  <div class="receipt-container">

    <table>
   
        <tr>
          <td class="text-start"> <span class="important">Imprimer par : </span> <?= auth()->user('nom') ?> <br>
          <span class="important"> Date d’impression: </span> <?= date('d/m/Y H:i:s') ?>
          </td>
          <td class="text-start"><span class="important">Caissier(ère):</span> <?= $infoVersement['user'] ?>
            <br>
           <span class="important"> Comptable : </span> <?= $infoVersement['cmpt'] ?>
          </td>
        </tr>

      
    </table>

    <div class="clearfix"></div>

    <h3>Répartition par mode de paiement</h3>
    <table>
      <thead>
        <tr>
          <th width="1">#</th>
          <th>Moyen de paiement</th>
          <th>Nombre d'occurence</th>
          <th>Montant</th>
        </tr>
      </thead>
      <tbody>

        <?php $i = 0; foreach ($modep as $data) : 

        $i += 1;
       
          ?>
        <tr>
          <td><?= $i ?></td>
          <td> <?= $data['mode_paiement'] ?> </td>
          <td> <?= $data['nbre'] ?> </td>

          <td class="important"><?= money($data['montant_total']) ?></td>
        </tr>
        <?php endforeach; ?>
      
      </tbody>
    </table>

    
    <div class="clearfix"></div>

    <h3>Répartition par Reservation</h3>
    <table>
      <thead>
        <tr>
          <th width="1">#</th>

          <th>Type chambre</th>
          <th>Chambre</th>
          <th>Nombre d'occurence</th>
          <th>Montant</th>
        </tr>
      </thead>
      <tbody>
       
        <?php $i = 0; foreach ($synthese as $r) : 
        $i += 1;
       
          ?>
        <tr>
          <td><?= $i ?></td>

          <td> <?= $r['type'] ?> </td>
          <td> <?= $r['chambre'] ?> </td>
          <td> <?= $r['nbre'] ?> </td>

          <td><?= money($r['montant']) ?></td>
        </tr>
        <?php endforeach; ?>
   
      </tbody>
    </table>

    <div class="clearfix"></div>

    <h3>Répartition par prestation</h3>
    <table>
      <thead>
        <tr>
          <th width="1">#</th>

          <th>Prestation</th>
          <th>Nombre d'occurence</th>
          <th>Montant</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 0; foreach ($services as $service) : 
     
        $i += 1;
       
          ?>
        <tr>
          <td><?= $i ?></td>

          <td> <?= $service['libelle_service'] ?> </td>
          <td> <?= $service['nbre'] ?> </td>

          <td><?= money($service['montant_total']) ?></td>
        </tr>
        <?php endforeach; ?>
       
      </tbody>
    </table>

    <div class="clearfix"></div>

    <h3>Détails des factures</h3>
    <table>
      <thead>
        <tr>
          <th width="1">#</th>
          <th width="15%">Date</th>

          <th>Client</th>
          <th>Chambre</th>
          <th>Service</th>
          <th>Montant</th>
          <th>Caisse</th>
        </tr>
      </thead>
      <tbody>
      
        <?php $i = 0; foreach ($reservations as $reservation) : 
        $nb_jour = daysBetweenDates($reservation['date_entree'], $reservation['date_sortie']);
        $montantChambre = $reservation['prix_reservation'] * $nb_jour;
        $montantServices = $reservation['montant_services'];
        $i += 1;
       
          ?>
        <tr>
          <td><?= $i ?></td>
          <td><?= date_formater($reservation['created_reservation']) ?> </td>

          <td> <?= $reservation['nom_client'] ?> </td>

          <td><?= money($montantChambre) ?></td>
          <td><?= money($montantServices) ?></td>
          <td><?= money($montantChambre + $montantServices) ?></td>
          <td> <?= $reservation['nom'] ?> </td>

        </tr>
        <?php endforeach; ?>
        
      </tbody>
    </table>

    <?php // $fil ?>


  </div>
</body>

</html>