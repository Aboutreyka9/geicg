<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<title>Bulletin de Notes</title>
<style>
  body { font-family: DejaVu Sans, sans-serif; margin: 20px; }
  h1 { color: #004080; text-align: center; }
  table { width: 100%; border-collapse: collapse; margin-top: 20px; }
  th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
  th { background-color: #f0f8ff; }
</style>
</head>
<body>
  <h1>Bulletin de Notes - Année scolaire {{annee}}</h1>
  <p><strong>Élève :</strong> {{eleve_nom}}</p>
  <p><strong>Classe :</strong> {{classe}}</p>

  <table>
    <thead>
      <tr>
        <th>Matière</th>
        <th>Note</th>
        <th>Coefficient</th>
        <th>Remarque</th>
      </tr>
    </thead>
    <tbody>
      {{#matieres}}
        <tr>
          <td>{{matiere}}</td>
          <td>{{note}}</td>
          <td>{{coef}}</td>
          <td>{{remarque}}</td>
        </tr>
      {{/matieres}}
    </tbody>
  </table>

  {{#commentaire}}
  <p><strong>Commentaire : </strong>{{commentaire}}</p>
  {{/commentaire}}

  <p><strong>Moyenne Générale :</strong> {{moyenne}}</p>
</body>
</html>
