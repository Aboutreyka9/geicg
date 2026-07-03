<?php
// Désactiver l'affichage des erreurs (ne pas montrer d'erreurs aux utilisateurs)
ini_set('display_errors', '0');

// Activer la journalisation des erreurs
ini_set('log_errors', '1');

// Spécifier le fichier où les erreurs seront enregistrées
ini_set('error_log', __DIR__ . '/logs/php_errors.log'); // Assurez-vous que le dossier "logs" existe et est accessible en écriture

// Désactiver l'exposition de PHP (éviter de divulguer la version de PHP)
ini_set('expose_php', '0');

// Configurer la limite de mémoire (éviter que les scripts consomment trop de ressources)
ini_set('memory_limit', '128M');

// Limiter le temps d'exécution des scripts
ini_set('max_execution_time', '30');

// Configurer la taille maximale des fichiers téléchargés
ini_set('upload_max_filesize', '2M');
ini_set('post_max_size', '8M');

// Activer le cache OPCache pour améliorer les performances
if (function_exists('opcache_get_status')) {
    ini_set('opcache.enable', '1');
    ini_set('opcache.validate_timestamps', '0');
}

// Vérifier si le mode production est activé
// echo "Mode production activé avec succès.";
?>
