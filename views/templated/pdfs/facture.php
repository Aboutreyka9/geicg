<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<title>Facture</title>
<style>
  body { font-family: Arial, sans-serif; margin: 40px; }
  header { text-align: center; margin-bottom: 40px; }
  h1 { color: #333; }
  table { width: 100%; border-collapse: collapse; }
  th, td { padding: 12px; border: 1px solid #ddd; }
  th { background-color: #f8f8f8; }
  .total { text-align: right; font-weight: bold; padding-right: 20px; }
</style>
</head>
<body>

<header>
  <h1>Facture</h1>
  <p>Client : Monsieur Jean Dupont</p>
  <p>Date : 13 août 2025</p>
  <p>Facture N° : 2025-008</p>
</header>

<table>
  <thead>
    <tr>
      <th>Description</th>
      <th>Quantité</th>
      <th>Prix Unitaire</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>Licence logicielle</td><td>1</td><td>1000 €</td><td>1000 €</td></tr>
    <tr><td>Maintenance 1 an</td><td>1</td><td>200 €</td><td>200 €</td></tr>
    <tr><td>Formation</td><td>3</td><td>150 €</td><td>450 €</td></tr>
  </tbody>
</table>

<p class="total">Montant Total : 1650 €</p>

<footer>
  <p>Merci pour votre confiance.</p>
</footer>

</body>
</html>
