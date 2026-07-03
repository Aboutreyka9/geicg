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
  td:nth-last-child(4) { text-align: center; font-weight: bold; color: #0A0A0AFF;}
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
  <h3> Liste des services </h3>
</header>

<table>
  <thead>
    <tr>
        <th>#</th>
        <th>Libelle service</th>
        <th>Description</th>
        <th>Prix</th>
    </tr>
  </thead>
  <tbody>
  <?php if($services) : $i = 0; ?>
    <?php foreach($services as $data) :
     $i++; 
     
    ?>
    
    <tr>
            <td scope="row"> <?= $i ?> </td>
            <td> <?= $data['libelle_service'] ?></td>
            <td> <?= $data['description_service'] ?></td>
            <td> <?= money($data['prix_service']) ?></td>
            </tr>

     <?php endforeach;?>
   
    <?php endif;?>

  </tbody>
</table>
</body>
</html>
