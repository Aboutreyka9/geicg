<html>
    <head>
        <style>
            body { font-family: Arial; background-color: #fff8f8; padding: 20px; }
            .card { background: white; padding: 20px; border-radius: 8px; border-left: 4px solid #dc3545; }
            .important { color: #dc3545; font-weight: bold; }
        </style>
    </head>
    <body>
        <div class='card'>
            <h2>⚠ Alerte Sécurité</h2>
            <p>Bonjour {$nom},</p>
            <p>Une connexion suspecte a été détectée :</p>
            <ul>
                <li>Date : {$date}</li>
                <li>Adresse IP : {$ip}</li>
            </ul>
            <p class='important'>Si ce n'était pas vous, changez immédiatement votre mot de passe.</p>
        </div>
    </body>
    </html>