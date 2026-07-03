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
  <h3>liste des clients enregisterés </h3>
</header>
<p> <span class="text-start">Date du :</span> <span class="text-end"> <?= $date_debut ?> </span> au <span class="text-start"> <?= $date_fin ?> </span> </p>
<table>
  <thead>
    <tr>
        <th >#</th>
        <th >Nom & prenoms</th>
        <th >Contact</th>
        <th >Civilité</th>
        <th >Pièce</th>
        <th >Enregistré</th>
    </tr>
  </thead>
  <tbody>
  <?php if($clients) : $i = 0; ?>
    <?php foreach($clients as $data) : $i++; ?>
    
    <tr>
            <td scope="row"> <?= $i ?> </td>
            <td> <?= $data["nom_client"] . " " . $data["prenom_client"] ?> </td>
            <td> <?= $data['telephone_client'] ?> </td>
            <td> <?= $data['genre_client'] ?></td>
            <td> <?= $data['type_piece'] ?> </br> <?= $data['piece_client'] ?> </td>
            <td> <?= date_formater($data['created_client']) ?></td>
            </tr>

     <?php endforeach;?>
   
    <?php endif;?>

  </tbody>
</table>
</body>
</html>
