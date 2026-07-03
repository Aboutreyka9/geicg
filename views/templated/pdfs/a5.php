
<?php
extract($reserver);
extract($hotel);
extract($services);


$totalMontant = 0;
$nb_jour = daysBetweenDates($date_entree, $date_sortie);
$montantChambre = $prix_chambre * $nb_jour;
$totalMontant += $montantChambre;
$text = $code_reservation."-".$client_id;
$logo = empty($logo_hotel) ? $libelle_hotel :  '<img src="'. ASSETS. $hotel['logo_hotel'] .'" alt="Logo">';
$fil = $statut_filigramme == 1 ?  '<div class="paid">'.$filigramme.'</div> ': "";
// var_dump($reserver);
// return;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <style>
    @page {
      size: A5 portrait; /* Format A5 */
      margin: 20px;
    }
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      color: #333;
      margin: 0;
      padding: 0;
    }
    .receipt-container {
      width: 100%vw;
      height:50%vh;
      padding: 6px;
      /* border: 1px solid #ddd; */
      position: relative;
    }
    .header {
      height:50px;
      position:relative;

    }
    .logo {
      position:absolute;
      /* padding:1px; */
      left:5%;
      line-height:2px;
       width: 55px;
       height: 55px;
       /* border: 1px solid #000; */
       overflow: hidden;
       /* border-radius: 50%; */
       text-align: center;
    }
    .logo img {
      max-width: 100%;
      max-height: 100%;
    }

    .facture {
      position:absolute;
      padding:1px;
      right:5%;
      line-height:2px;
      text-align:center;
      font-size: 13px;
    }


    .info {
      margin: 15px 0;
      font-size: 11px;
      width: 100%;
    }
    .info td {
      padding: 2px 5px;
      vertical-align: top;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 6px;
      font-size: 11px;
    }
    th {
      background: #f5f5f5;
      text-align: left;
    }
    .paid {
      position: absolute;
      top: 25%;
      bottom: 1%;
      left: 25%;
      /* right: 1%; */
      font-size: 60px;
      color: rgba(150, 150, 150, 0.2);
      transform: rotate(-30deg);
      width:100%;
    }
    .totals {
      margin-top: 10px;
      width: 100%;
      font-size: 11px;
    }
    .totals td {
      padding: 3px 5px;
    }
    .payment-methods {
      margin-top: 15px;
      font-size: 11px;
    }
    .payment-methods td {
      padding: 6px 5px;
    }
    
    .footer {
      position:relative;
      margin-top: 20px;
      font-size: 12px;

    }
    .footer p{
      line-height:2px;

    }
    .qrcode{
      padding:0px;
      margin:0px;
      position: absolute;
      top: -25px;
      bottom: 0%;
      right: 2%;
    }
    .end{
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="receipt-container">
    <div class="header">
      <div class="facture">
        <h4>FACTURE N°: </h4>
        <p> <?= rand(01, 999999) ?> </p>
      </div>
     <div class="logo">
     <?= $logo ?>
     
     </div>

      

    </div>

    <table class="info">
      <tr>
        <td><b>Code</b> <?= $user_id ?></td>
        <td><b>Client:</b> <?= $nom_client ?> </td>
      </tr>
      <tr>
        <td><b>Ref-code #:</b> 00-000000</td>
        <td><b>Tél: </b>(+225) <?= $telephone_client ?></td>
      </tr>
      <tr>
        <td><b>DATE:</b><?= date('d-m-Y H:i') ?> </td>
        <td> <b>Reservation</b> <br> <?= $code_reservation ?> </td>
      </tr>
    </table>

    <table>
      <thead>
        <tr>
          <th>CHAMBRE</th>
          <th>DATE D'ARRIVE</th>
          <th>PRIX/NUIT</th>
          <th>NB.JOUR</th>
          <th>MONTANT</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td> <?= $libelle_chambre ?></td>
          <td><?= date_formater($date_entree) ?></td>
          <td><?= money($prix_reservation) ?></td>
          <td><?= $nb_jour ?></td>
          <td><?= money($montantChambre) ?></td>
        </tr>
        <tr>
          <td colspan="5" style="height:10px;"></td>
        </tr>
      </tbody>
    </table>

    <table>
      <thead>
      <tr>
        <td><b>SERVICES</b></td>
      </tr>
        <tr>
          <th>DESCRIPTION</th>
          <th>QTE</th>
          <th>PRIX.U</th>
          <th>MONTANT</th>
        </tr>
      </thead>
      <tbody>
        <?php if(!empty($services)) : ?>
        <?php foreach ($services as $service):
          $totalMontant += $service['total'];
          ?>
        <tr>
          <td><?= $service['libelle_service'] ?></td>
          <td><?= $service['qte'] ?></td>
          <td><?= money($service['prix']) ?></td>
          <td><?= money($service['total']) ?></td>
        </tr>
       <?php endforeach; ?>
       <?php else : ?>
       <tr>
        <td colspan="4" style="text-align:center;">Aucun service</td>
       </tr>
       <?php endif; ?>
        </tbody>
    </table>

    <?= $fil ?>
    

    <table class="payment-methods">
      <tr>
        <td><b>PAYMENT</b></td>
      </tr>
      <tr>
      
      <td>
      <input type="checkbox" checked> <span class="check">EN ESPECE</span> </td>
      <td> 
      <label><input class="check" type="checkbox"> MOBILE MONEY </label></td>
      <td>
      <label><input class="check" type="checkbox"> CARTE BANCAIRE </label> </td>
      </tr>
    </table>

    <table class="totals">
      <tr>
        <td style="text-align:right; width:80%;">MONTANT HORS TAXE:</td>
        <td><?= money($totalMontant) ?></td>
      </tr>
      <tr>
        <td style="text-align:right;">TAXE:</td>
        <td>0%</td>
      </tr>
      <tr>
        <td style="text-align:right;">MONTANT TAXE:</td>
        <td>0.00</td>
      </tr>
      <tr>
        <td style="text-align:right; font-weight:bold;">TOTAL:</td>
        <td style="font-weight:bold;"><?= money($totalMontant) ?></td>
      </tr>
    </table>

    <div class="footer">
      <p class="text-uppercase"> <?= $hotel['libelle_hotel'] ?> </p>
      <p>Service client : (+225) <?= $hotel['telephone_hotel'] ?> </p>
      <p> <?= $hotel['adresse_hotel'] ?> </p>
      <div class="qrcode"> 
      <img src="<?= gqr()->qrReserve($text,80,2); ?>" alt="Mon image" />

      </div>
      <h3 class="end">Merci d'avoir choisir notre hotel</h3>
    </div>
  </div>
</body>
</html>
