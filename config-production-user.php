<?php
// Chemin du fichier de log
$logFile = __DIR__ . '/logs/user_data.log'; // Assurez-vous que ce fichier est accessible en écriture

// Obtenir l'adresse IP de l'utilisateur
$userIP = $_SERVER['REMOTE_ADDR'] ?? 'IP non disponible';

// Utiliser un service de géolocalisation (par exemple, l'API gratuite de ip-api.com)
$geoInfo = file_get_contents("http://ip-api.com/json/{$userIP}?fields=status,country,city,regionName,query");
$geoData = json_decode($geoInfo, true);

// Vérifier si la requête à l'API a réussi
if ($geoData && $geoData['status'] === 'success') {
    $country = $geoData['country'] ?? 'Pays non disponible';
    $city = $geoData['city'] ?? 'Ville non disponible';
    $region = $geoData['regionName'] ?? 'Région non disponible';
} else {
    $country = 'Pays non disponible';
    $city = 'Ville non disponible';
    $region = 'Région non disponible';
}

// Construire le message à enregistrer
$logMessage = sprintf(
    "[%s] IP: %s | Pays: %s | Ville: %s | Région: %s\n",
    date('Y-m-d H:i:s'),
    $userIP,
    $country,
    $city,
    $region
);

// Enregistrer le message dans le fichier de log
file_put_contents($logFile, $logMessage, FILE_APPEND);

// Afficher un message de confirmation (facultatif)
// echo "Les informations des utilisateurs ont été enregistrées dans le fichier error.log.";
?>
