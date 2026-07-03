<html>
    <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: Arial; background-color: #f9f9f9; padding: 20px; }
            .card { background: white; padding: 20px; border-radius: 8px; }
            .btn { display: inline-block; padding: 10px 15px; color: white; background: #007bff; text-decoration: none; border-radius: 5px; }
        </style>
    </head>
    <body>
        <div class='card'>
            <h2>Bonjour <?= $nom ?> </h2>
            <p>Vous avez demandé à réinitialiser votre mot de passe.</p>
            <p>
                Voici votre nouveau mot de passe temporaire : <strong> <?= $password ?>  </strong> </p>
            <p> <a href="<?= $lienReset ?>" class='btn'> Cliquer sur ce buton pour acceder à la page de connexion </a> <p>
            <p>Si vous n'êtes pas à l'origine de cette demande, ignorez cet email.</p>
        </div>
    </body>
    </html>