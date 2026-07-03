<html>

<head>
    <style>
        body {
            font-family: Arial;
            background-color: #f9f9f9;
            padding: 5px;
        }

        .container {
            background: white;
            margin: 15px 30px;
            padding: 10px 15px;
            border: #c5c5c5 solid 1px;
            border-radius: 10px;
        }

        .text-center {
            text-align: center;
        }

        h2 {
            color: #1DA5AAFF;
            text-align: center;
        }

        p {
            margin: 12px 10px;
            font-size: 17px;
        }

        .text-bold {
            font-weight: bold;
            color: #000;
        }

        .user-name {
            text-transform: uppercase;
        }

        .card {
            background: #e9e6e6;
            padding: 8px;
            border-radius: 8px;
            font-size: 19px;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            color: #fff !important;
            background: #2ad6e2;
            font-size: 19px;
            text-decoration: none;
            border-radius: 5px;
            transition: ease-in 5.0s;
        }

        .btn:hover {
            background: #27c3ce;
            transition: ease-out 3.0s;
        }

        .text-red {
            color: #da1c1c;
        }

        .important {
            font-weight: bold;
        }

        /* .sexion1{margin-bottom: 25px;}
            .sexion2{margin-bottom: 15px;}*/
        .sexion3 {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="sexion1">
            <h2> Votre compte a été créé avec succès </h2>
            <p> Bonjour <span class="text-bold user-name"> <?= $nom ?></span>, </p>

            <p>
                Nous avons le plaisir de vous informer que votre compte sur la plateforme <span class="text-bold"> <?= $appName ?> </span> a été créé avec succès.
            </p>

            <p>
                Voici vos identifiants de connexion :
            </p>

        </div>

        <div class="card">
            <p> <span class="text-bold"> </span> <?= $libelle_structure ?> </p>
            <p> <span class="text-bold"> Identifiant (email) : </span> <?= $email ?> </p>
            <p> <span class="text-bold"> Mot de passe temporaire : </span> <?= $password ?> </p>

            <p>Veuillez cliquez sur le bouton ci-dessous pour activer votre compte</p>

            <p class="text-center"><a href="<?= $lienActivation ?>" class='btn'>Activer mon compte</a></p>
        </div>

        <div class="sexion2">
            <p class="text-red">
                <span class="important">Important : </span> Pour garantir la sécurité de votre compte, veuillez modifier ce mot de passe lors de votre première connexion.
            </p>

            <p>
                En cas de difficultés ou de questions, notre équipe reste à votre disposition pour vous accompagner.
            </p>
        </div>

        <div class="sexion3">
            <p>
                Cordialement,<br> L’équipe <?= $appName ?>
            </p>

            <p> SUPPORT <?= $appName ?> - Tél : (+225) 07 87 46 11 37 / 05 75 44 47 57</p>

        </div>

    </div>
</body>

</html>