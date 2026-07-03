<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<title>Facture</title>
<style>
  body { font-family: Arial, sans-serif; margin: 2px; font-size: 13px; }
  header { text-align: center; text-transform: uppercase; text-decoration: underline; letter-spacing: 2px; border: solid 1px #333; height: 49px;}
  h3 { color: #333; }
  table { width: 100%; border-collapse: collapse; }
  th, td { padding: 10px; border: 1px solid #ddd; }
  th { background-color: #F0EDEDFF; text-transform: uppercase; }
  tbody tr:nth-child(even) { background-color: #f8f8f8; }
  tbody tr { text-align:center; }
  td:nth-last-child(1) { text-align: center; font-weight: bold; color: #0A0A0AFF;}
  input[type=checkbox] { width: 20px; height: 20px; color: #21D472FF; }
  .times { color: red; font-size: 25px; }
  .text-end { text-align: right; 
  font-weight: bold;
  color: #0A0A0AFF;
  font-size: 15px;
  text-transform: uppercase;
  margin-right: 20px;
}
.text-start { text-align: left; 
  font-weight: bold;
  color: #0A0A0AFF;
  font-size: 15px;
  text-transform: uppercase;
  margin-left: 20px;
}
</style>
</head>
<body>

<header>
  <h3>liste des reservations enregisterées </h3>
</header>
<p>
<span class="text-start">Du :</span> <span class="text-end"> <?= $date_debut ?> </span> au <span class="text-start"> <?= $date_fin ?> </span> </p>
<table>
  <thead>
    <tr>
        <th>#</th>
        <th>Enregistré</th>
        <th># Chambre</th>
        <th>Sejour</th>
        <th>Client</th>
        <th>Chambre</th>
        <th>Service</th>
        <th>Montant</th>
    </tr>
  </thead>
  <tbody>
  <?php if($reservations) : $i = 0; $montantTotalCaisse= 0; ?>
    <?php foreach($reservations as $data) :
     $i++; 
    
     $nbjr = daysBetweenDates(
      $data['date_entree'], 
      $data['date_sortie']);
      $montantchambre = $data['prix_reservation'] * $nbjr;
      $montantTotal = $montantchambre + $data['montant_services'];
      $montantTotalCaisse += $montantTotal;

    ?>
    
    <tr>
            <td scope="row"> <?= $i ?> </td>
            <td> <?= date_formater($data['created_reservation']) ?> </td>
            <td> <?=$data['libelle_chambre']?>   </td>
            <td>(<?= $nbjr ?> Jrs)   
            Du <?= date_formater($data['date_entree']) ?> <br/> 
            au <?= date_formater($data['date_sortie']) ?> </td>
            <td> <?= $data['nom_client'] ?></td>
            <td> <?= money($montantchambre) ?></td>
            <td> <?= money($data['montant_services']) ?></td>
            <td> <?= money($montantTotal) ?></td>
            </tr>

     <?php endforeach;?>
     <tr>
        <td colspan="7" class="text-start">Total</td>
        <td  class="text-start" ><?= money($montantTotalCaisse); ?></td>
        <td></td>
    </tr>
   
    <?php endif;?>

  </tbody>
</table>
</body>
</html>
