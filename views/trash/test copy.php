<?php 
var_dump($data);
?>
<!DOCTYPE html> 
<html lang="fr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Bulletin CP1 - CP2 - École Lotaci - Iron</title>
<style>
  @page {
    size: A4 portrait;
    margin: 2cm;
  }
  body {
    font-family: 'Calibri', 'Arial', sans-serif;
    background: white;
    color: #333;
    margin: 0;
    padding: 0;
  }
  .container {
    width: 17cm; /* A4 largeur 21cm - 4cm marges */
    height: 25.7cm; /* A4 hauteur 29.7cm - 4cm marges */
    margin: 1.5cm auto;
    padding: 0;
    box-sizing: border-box;
  }
  header {
    text-align: center;
    border-bottom: 2px solid #005a9c;
    padding-bottom: 8px;
    margin-bottom: 15px;
    position: relative;
  }
  header img.logo {
    position: absolute;
    top: 0;
    left: 0;
    width: 60px;
    height: auto;
  }
  header h1 {
    margin: 0;
    font-size: 14pt;
    color: #005a9c;
    font-weight: bold;
    text-transform: uppercase;
  }
  header h2 {
    margin: 5px 0 0 0;
    font-size: 12pt;
    font-weight: normal;
  }
  header p.school-info {
    margin: 5px 0 0;
    font-style: italic;
    font-size: 9pt;
    color: #444;
  }
  section.infos-eleve {
    margin-bottom: 15px;
    border: 1px solid #005a9c;
    padding: 10px 15px;
    border-radius: 4px;
    background: #e9f0f8;
    font-size: 9pt;
  }
  section.infos-eleve table {
    width: 100%;
    border-collapse: collapse;
  }
  section.infos-eleve td {
    padding: 3px 6px;
    vertical-align: middle;
  }
  section.infos-eleve td.label {
    font-weight: bold;
    width: 28%;
    color: #004080;
  }
  table.matiere-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
    font-size: 9pt;
  }
  table.matiere-table thead {
    background-color: #005a9c;
    color: white;
  }
  table.matiere-table th, table.matiere-table td {
    padding: 5px 6px;
    border: 1px solid #ccc;
    text-align: center;
  }
  table.matiere-table td.matiere-name {
    text-align: left;
    font-weight: 600;
    color: #003366;
  }
  section.recap {
    margin-bottom: 12px;
    font-size: 10pt;
  }
  section.recap p {
    font-weight: bold;
    color: #004080;
    border: 1px solid #004080;
    padding: 8px 10px;
    border-radius: 4px;
    background: #e0e8f6;
    margin: 0;
  }
  section.distinctions {
    border: 1px solid #005a9c;
    padding: 10px 15px;
    border-radius: 4px;
    background: #e9f0f8;
    margin-bottom: 12px;
    font-size: 9pt;
  }
  section.distinctions h3 {
    margin-top: 0;
    color: #004080;
    margin-bottom: 10px;
    font-weight: bold;
    font-size: 11pt;
  }
  section.distinctions ul {
    list-style: none;
    padding-left: 0;
    font-weight: 600;
    margin: 0;
  }
  section.distinctions ul li {
    margin-bottom: 4px;
  }
  section.appreciation {
    margin-bottom: 20px;
    font-size: 9pt;
  }
  section.appreciation label {
    font-weight: bold;
    color: #004080;
    display: block;
    margin-bottom: 6px;
  }
  section.appreciation textarea {
    width: 100%;
    height: 50px;
    resize: none;
    padding: 6px;
    font-size: 9pt;
    box-sizing: border-box;
  }
  section.signatures {
    display: flex;
    justify-content: space-between;
    margin-bottom: 12px;
    font-size: 9pt;
  }
  section.signatures div {
    width: 30%;
    text-align: center;
  }
  section.signatures div.signature-line {
    border-top: 1.2px solid #004080;
    margin-top: 50px;
  }
  section.admission {
    font-weight: bold;
    color: #b22222;
    text-align: center;
    font-size: 10pt;
  }
</style>
</head>
<body>
  <div class="container">
    <header>
      <img src="https://upload.wikimedia.org/wikipedia/commons/8/8c/Emblem_of_Cote_d%27Ivoire.svg" alt="Logo Ministère" class="logo" />
      <h1>Ministère de l'Éducation Nationale de Côte d'Ivoire</h1>
      <h2>École Lotaci - Iron</h2>
      <p class="school-info">Année scolaire : ___________________</p>
    </header>

    <section class="infos-eleve" aria-label="Informations de l'élève">
      <table>
        <tr><td class="label">Nom de l'élève :</td><td>__________________</td><td class="label">Sexe :</td><td>__________________</td></tr>
        <tr><td class="label">Prénoms :</td><td>__________________</td><td class="label">Date de naissance :</td><td>__________________</td></tr>
        <tr><td class="label">Lieu de naissance :</td><td>__________________</td><td class="label">Classe :</td><td>__________________</td></tr>
        <tr><td class="label">Effectif :</td><td>__________________</td><td class="label">Redoublant (Oui/Non) :</td><td>__________________</td></tr>
      </table>
    </section>

    <table class="matiere-table" aria-label="Tableau des notes des matières">
      <thead>
        <tr>
          <th>Matière</th>
          <th>Moyenne</th>
          <th>Rang</th>
          <th>Appréciation</th>
          <th>Observations</th>
        </tr>
      </thead>
      <tbody>
        <tr><td class="matiere-name">Écriture</td><td></td><td></td><td></td><td></td></tr>
        <tr><td class="matiere-name">Copie</td><td></td><td></td><td></td><td></td></tr>
        <tr><td class="matiere-name">Orthographe</td><td></td><td></td><td></td><td></td></tr>
        <tr><td class="matiere-name">Expression écrite</td><td></td><td></td><td></td><td></td></tr>
        <tr><td class="matiere-name">EDHC</td><td></td><td></td><td></td><td></td></tr>
        <tr><td class="matiere-name">Mathématiques</td><td></td><td></td><td></td><td></td></tr>
        <tr><td class="matiere-name">AEC</td><td></td><td></td><td></td><td></td></tr>
        <tr><td class="matiere-name">Lecture</td><td></td><td></td><td></td><td></td></tr>
        <tr><td class="matiere-name">Poésie / Chant</td><td></td><td></td><td></td><td></td></tr>
        <tr><td class="matiere-name">Informatique</td><td></td><td></td><td></td><td></td></tr>
        <tr><td class="matiere-name">EPS</td><td></td><td></td><td></td><td></td></tr>
        <tr><td class="matiere-name"><strong>Total des points</strong></td><td></td><td></td><td></td><td></td></tr>
        <tr><td class="matiere-name"><strong>Moyenne CP</strong></td><td></td><td></td><td></td><td></td></tr>
      </tbody>
    </table>

    <section class="recap" aria-label="Récapitulatif des résultats">
      <p>Moyenne Générale (MGA), Rang sur …, Meilleure Moyenne, Plus Faible Moyenne</p>
    </section>

    <section class="distinctions" aria-label="Distinctions">
      <h3>Distinctions</h3>
      <ul>
        <li>Tableau d’honneur</li>
        <li>Félicitations</li>
        <li>Travail bien</li>
        <li>Assez bien</li>
        <li>Passable</li>
        <li>Médiocre</li>
        <li>Mauvais travail</li>
      </ul>
    </section>

    <section class="appreciation" aria-label="Appréciation générale">
      <label for="appreciation-text">Appréciation générale :</label>
      <textarea id="appreciation-text" placeholder="Tapez l'appréciation ici..."></textarea>
    </section>

    <section class="signatures" aria-label="Signatures">
      <div>
        <div class="signature-line"></div>
        Visa du maître
      </div>
      <div>
        <div class="signature-line"></div>
        Visa du père / mère / tuteur
      </div>
      <div>
        <div class="signature-line"></div>
        Visa du directeur
      </div>
    </section>
    <section class="admission" aria-label="Mention admission ou refus">
      Mention : Admission / Refus (rayer la mention inutile)
    </section>
  </div>
</body>
</html>
