
<style>
    body { font-family: DejaVu Sans, sans-serif; }
    h2 { text-align:center; }
    table { width:100%; border-collapse: collapse; margin-top:20px; }
    th, td { border:1px solid #000; padding:8px; text-align:left; }
    .total { font-weight:bold; background:#f0f0f0; }
    </style>
    
    <h2>FACTURE HÔTEL</h2>
    
    <p><strong>Client :</strong> {{prenom}} {{nom}} <br>
    <strong>Téléphone :</strong> {{telephone}} <br>
    <strong>Chambre :</strong> {{chambre}} 54</p>
    
    <p><strong>Date d\'arrivée :</strong> {{entree}} <br>
    <strong>Date de départ :</strong> {{sortie}} <br>
    <strong>Nombre de jours :</strong> {{nbjour}} </p>
    
    <table>
        <tr>
            <th>Description</th>
            <th>Montant</th>
        </tr>
        <tr>
            <td>Hébergement ('.$facture['nb_jours'].' nuits x '.$facture['prix_nuit'].' Fcfa)</td>
            <td>'.number_format($facture['total_chambre'], 2, ",", " ").' Fcfa</td>
        </tr>
        <tr>
            <td>Services</td>
            <td>'.number_format($facture['total_services'], 2, ",", " ").' Fcfa</td>
        </tr>
        <tr class="total">
            <td>Total à payer</td>
            <td>'.number_format($facture['montant_total'], 2, ",", " ").' Fcfa</td>
        </tr>
    </table>
    <p style="text-align:center;margin-top:30px;">Merci pour votre séjour !</p>
    