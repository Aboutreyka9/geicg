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
  td:nth-last-child(2) { text-align: center; font-weight: bold; color: #0A0A0AFF;}
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
  <h3> Liste des versements </h3>
</header>
<p><span class="text-start">Montant total :</span> <span class="text-end"> <?= money(array_sum(array_column($versements, 'montant_cloture'))); ?> </span> &nbsp; | &nbsp; <span class="text-start">Du :</span> <span class="text-end"> <?= $date_debut ?> </span> au <span class="text-start"> <?= $date_fin ?> </span> </p>
<table>
  <thead>
    <tr>
        <th>#</th>
        <th>Ouverture</th>
        <th>Cloture</th>
        <th>Statut</th>
        <th>Caisse</th>
        <th>Recette</th>
        <th>Depot</th>
        <th>Versement</th>
    </tr>
  </thead>
  <tbody>
  <?php if($versements) : $i = 0; ?>
    <?php foreach($versements as $data) :
        $i++; 
        $cloture = $data['cloture'];
        $montant = $cloture != null ?  money($data['montant_cloture']) : '...';
        $statut = $cloture != null ?  'Clôturée' : '...';
        $confirm = $data['etat_versement'] == 1 ?  'Confirmé' : 'En cours';
        $user = $data['nom'];
        $caisse = $cloture != null ?  money($data['montant_total']) : '...';
        $date_cloture = $cloture != null ?  date_formater($data['cloture']) : '...';
        $cmpt = $data['etat_versement'] == 1 ? $data['cmpt'] : '...';
     
    ?>
    
    <tr>
            <td scope="row"> <?= $i ?> </td>
            <td> <?=date_formater($data['ouverture']) ?> </td>
            <td> <?= $date_cloture ?></td>
            <td> <?= $statut ?></td>
            <td> <?= $user ?></td>
            <td> <?= $caisse ?></td>
            <td> <?= $montant ?></td>
            <td> <?= $cmpt ?></td>
            </tr>

     <?php endforeach;?>
   
    <?php endif;?>

  </tbody>
</table>
</body>
</html>
