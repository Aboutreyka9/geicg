<?php

use App\Models\Factory;

 extract($data);
// echo $result;

$fc = new Factory();
// var_dump($fc->updateServiceClient('QdEMhygNYxiqHnZZninlxqUaNm5ND8'));
 ?>



<style>
body {
  font-family: Arial, sans-serif;
}

/* ✅ Zone à imprimer */
#print-zone {
  border: 2px solid #000;
  padding: 20px;
  width: 350px;
  margin: 20px auto;
  background: #fff;
}

/* ❌ Tout ce qui ne doit pas apparaître à l’impression */
@media print {
  body * {
    visibility: hidden; /* on cache tout */
  }

  #print-zone, #print-zone * {
    visibility: visible; /* sauf notre cadre */
  }

  #print-zone {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
  }

  #btn-print {
    display: none;
  }
}
</style>


<img src="<?= $result; ?>" alt="Mon image" />

<select name="categorie" class="form-control select2">
<option disabled selected>---CHOISIR---</option>
<option value="1">Option 1</option>
<option value="2">Option 2</option>
<option value="3">Option 3</option>
</select>


<div id="print-zone">
  <h2>Fiche élève</h2>
  <p><strong>Nom :</strong> Koné Ibrahim</p>
  <p><strong>Classe :</strong> 3ème A</p>
  <p><strong>Matricule :</strong> ELV2025-001</p>
  <img src="qrcode.png" width="100">
</div>

<button id="btn-print" onclick="imprimer()">🖨️ Imprimer</button>



