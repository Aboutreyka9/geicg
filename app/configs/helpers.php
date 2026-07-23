<?php

use App\Core\Auth;
use App\Core\Gqr;
use App\Middlewares\CsrfMiddleware;
use App\Services\PersonneService;
use App\Services\Service;

function sideLink($title, $icon, $data)
{
    if (empty($data)) {
        return false;
    }

    $output = '<div class="nav-item dropdown">
    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa ' . $icon . ' me-2"></i>' . $title . '</a>
    <div class="dropdown-menu bg-transparent border-0">';
    foreach ($data as $key) {
        $link = explode('@', $key);
        $output .= '<a href="' . LINK . $link[0] . '" class="dropdown-item">' . $link[1] . '</a>';
    }
    $output .= '
            </div>
        </div>';
    return $output;
}


function genCar()
{
    $letter = implode("", range('a', 'z')) . implode("", range('A', 'Z'));
    $number = implode("", range(0, 9));
    return str_shuffle($letter . $number);
}

function generetor($longueur = 8)
{
    $caracteres = genCar();
    $chaineAleatoire = '';
    $longueurMax = strlen($caracteres) - 1;

    // Générer la chaîne aléatoire avec random_int()
    for ($i = 0; $i < $longueur; $i++) {
        $chaineAleatoire .= $caracteres[random_int(0, $longueurMax)];
    }

    return $chaineAleatoire;
}

function loadDataBilanCaisseComptable($detailsReservation, $service, $reservationNonRegler, $serviceNonRegler, $reservationEnnuler, $serviceEnnuler)
{


    $montant_reservation = 0;
    $montant_service = 0;
    $montantNotOk = 0;
    $countReservation = 0;
    $countReservationEnnuler = 0;
    $montantReservationEnnuler = 0;
    $countServiceEnnuler = 0;
    $montantServiceEnnuler = 0;


    // reservation valide
    if (!empty($detailsReservation)) {
        foreach ($detailsReservation as $r) {
            $day = daysBetweenDates($r['date_entree'], $r['date_sortie']);
            $montant_reservation += $day * $r['prix_reservation'];
        }
    }

    // reservation non regler
    if (!empty($reservationNonRegler)) {
        foreach ($reservationNonRegler as $r) {
            $day = daysBetweenDates($r['date_entree'], $r['date_sortie']);
            $montantNotOk += $day * $r['prix_reservation'];
            $countReservation++;
        }
    }

    // service non regler
    if (!empty($serviceNonRegler)) {
        foreach ($serviceNonRegler as $s) {
            $montantNotOk += $s['prix_consommation'] * $s['quantite_consommation'];
            $countReservation++;
        }
    }

    // reservation ennnuler
    if (!empty($reservationEnnuler)) {
        foreach ($reservationEnnuler as $r) {
            $day = daysBetweenDates($r['date_entree'], $r['date_sortie']);
            $montantReservationEnnuler += $day * $r['prix_reservation'];
            $countReservationEnnuler++;
        }
    }

    // service ennnuler
    if (!empty($serviceEnnuler)) {
        foreach ($serviceEnnuler as $s) {
            $montantServiceEnnuler += $s['prix_consommation'] * $s['quantite_consommation'];
            $countServiceEnnuler++;
        }
    }

    // service valide
    $montant_service = $service ?? 0;

    return [
        'montant_service' => money($montant_service),
        'montantNotOk' => money($montantNotOk),
        'montant_reservation' => money($montant_reservation),
        'montantReservationEnnuler' => money($montantReservationEnnuler),
        'montantServiceEnnuler' => money($montantServiceEnnuler),
        'countReservation' => $countReservation,
        'countReservationEnnuler' => $countReservationEnnuler,
        'countServiceEnnuler' => $countServiceEnnuler
    ];
}

function loadDataBilanCaisseComptableTest($detailsReservation, $service, $reservationNonRegler, $serviceNonRegler, $reservationEnnuler, $serviceEnnuler)
{


    $montant_reservation = 0;
    $montant_service = 0;
    $montantNotOk = 0;
    $countReservation = 0;
    $countReservationEnnuler = 0;
    $montantReservationEnnuler = 0;
    $countServiceEnnuler = 0;
    $montantServiceEnnuler = 0;


    // reservation valide
    if (!empty($detailsReservation)) {
        foreach ($detailsReservation as $r) {
            $day = daysBetweenDates($r['date_entree'], $r['date_sortie']);
            $montant_reservation += $day * $r['prix_reservation'];
        }
    }

    // reservation non regler
    if (!empty($reservationNonRegler)) {
        foreach ($reservationNonRegler as $r) {
            $day = daysBetweenDates($r['date_entree'], $r['date_sortie']);
            $montantNotOk += $day * $r['prix_reservation'];
            $countReservation++;
        }
    }

    // service non regler
    if (!empty($serviceNonRegler)) {
        foreach ($serviceNonRegler as $s) {
            $montantNotOk += $s['prix_consommation'] * $s['quantite_consommation'];
            $countReservation++;
        }
    }

    // reservation ennnuler
    if (!empty($reservationEnnuler)) {
        foreach ($reservationEnnuler as $r) {
            $day = daysBetweenDates($r['date_entree'], $r['date_sortie']);
            $montantReservationEnnuler += $day * $r['prix_reservation'];
            $countReservationEnnuler++;
        }
    }

    //   return $serviceEnnuler;
    // service ennnuler
    if (!empty($serviceEnnuler)) {
        foreach ($serviceEnnuler as $s) {
            $montantServiceEnnuler += $s['prix_consommation'] * $s['quantite_consommation'];
            $countServiceEnnuler++;
        }
    }

    // service valide
    $montant_service = $service ?? 0;

    return [
        'montant_service' => money($montant_service),
        'montantNotOk' => money($montantNotOk),
        'montant_reservation' => money($montant_reservation),
        'montantReservationEnnuler' => money($montantReservationEnnuler),
        'montantServiceEnnuler' => money($montantServiceEnnuler),
        'countReservation' => $countReservation,
        'countReservationEnnuler' => $countReservationEnnuler,
        'countServiceEnnuler' => $countServiceEnnuler
    ];
}

function urlVerify($data)
{
    $result = false;

    if (sizeof($data) > 0 && sizeof($data) > 0) {

        foreach ($data as $key) {
            if (key_exists($key, $_GET)) {

                if ($_GET[$key] == false) {
                    $result = true;
                    break;
                }
            } else {
                $result = true;
                break;
            }
        }
    }
    return $result;
}

function url($page, $param = [])
{
    $return =  HOME;

    if (trim($page) != "") {
        $return =  LINK . $page;
        $size = sizeof($param);

        if ($size != 0) {
            $count = 0;
            $return .= "/";
            foreach ($param as  $value) {
                $count++;

                $return .=  $value;

                if ($size != $count) {
                    $return .= "/";
                }
            }
        }
    }
    return $return;
}

// two letter
function shortName($name)
{
    $name = explode("  ", $name);
    if (count($name) < 2) {
        $name = $name[0][0] . "." . $name[0][1];
    } else {
        $name = $name[0][0] . "." . $name[1][0];
    }
    return $name;
}

function urlOld($page, $param = [])
{
    $return =  HOME;

    if (trim($page) != "") {
        $return =  LINK . $page;
        $size = sizeof($param);

        if ($size != 0) {
            $count = 0;
            $return .= "/";
            foreach ($param as  $value) {
                $count++;

                $return .=  urlEncript($value);

                if ($size != $count) {
                    $return .= "/";
                }
            }
        }
    }
    return $return;
}

function urlEncript($url)
{

    if (!empty($url)) {
        return crypter($url);
    }
}

function urlDecript()
{

    if (sizeof($_GET) > 0) {

        foreach ($_GET as $key => $value) {
            $_GET[$key] = decrypter($value);
        }
    }
}



function crypter($url)
{
    $cleCryptage = 'treykaSanaogoHotel'; // Vous pouvez changer la clé de cryptage
    return urlencode(base64_encode(openssl_encrypt($url, 'aes-256-cbc', $cleCryptage, 0, substr(md5($cleCryptage), 0, 16))));
}

function decrypter($url)
{
    $cleCryptage = 'treykaSanaogoHotel'; // Utilisez la même clé que pour le cryptage
    return openssl_decrypt(base64_decode(urldecode($url)), 'aes-256-cbc', $cleCryptage, 0, substr(md5($cleCryptage), 0, 16));
}
// verifier les input
function clsInput($param)
{
    foreach ($param as $key => $value) {

        $value = trim($value, ' ');
        $value = htmlspecialchars(htmlentities($value));
        $value = utf8_decode(ucwords($value));
        $param[$key] = $value;
    }
    return $param;
}

// formater date
function date_formater($date, bool $format = false, bool $time = false)
{
    if ($format)
        return $time ? (new DateTime($date))->format('d/m/Y H:i:s') : (new DateTime($date))->format('d/m/Y');
    else
        return $time ? (new DateTime($date))->format('d-m-Y H:i:s') : (new DateTime($date))->format('d-m-Y');
}

function removeSpace($number)
{
    return str_replace(' ', '', $number);
}

function formatHeure($date)
{

    return substr($date, 0, 5);
    // return (new DateTime($date))->format('H:i');
}


function isValidPhoneNumber($telephone)
{
    $result = false;
    if (preg_match('/^\+225\s0[0-9]{1}\s[0-9]{2}\s[0-9]{2}\s[0-9]{2}\s[0-9]{2}$/', $telephone)) {
        $result = true;
        // Ici tu peux enregistrer dans la base de données par exemple
    }
    return $result;
}

function isValidPhoneNumberOther($telephone)
{
    $result = false;
    if (preg_match('/^\+225\s0[0-9]{2}\s[0-9]{3}\s[0-9]{4}$/', $telephone)) {
        $result = true;
        // Ici tu peux enregistrer dans la base de données par exemple
    }
    return $result;
}

function cleanVar($name)
{
    if (isset($_POST[$name]) && !empty($_POST[$name])) {
        return htmlspecialchars(strip_tags(trim($_POST[$name])));
    } else {
        return null;
    }
}

function sanitizePostData(array $post): array
{
    $clean = [];

    if (sizeof($post) > 0) {
        foreach ($post as $key => $value) {

            if (is_array($value)) {
                // Nettoyage récursif si champ est un tableau (ex: checkboxes)
                $clean[$key] = sanitizePostData($value);
            } else {
                $clean[$key] = htmlspecialchars(strip_tags(trim($value)));
            }
        }
    }

    return $clean;
}

function getFormatMois($mois)
{

    $timestamp = strtotime($mois);

    $fmt = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
    $fmt->setPattern('MMMM'); // nom complet du mois
    $month = ucfirst($fmt->format($timestamp));

    return $month;
}

function money($montant)
{
    return number_format($montant, 0, ',', ' ') . " FCFA";
}

function checkModePaiement(string $mode)
{
    $modes = PAYMENT_MODE_SHOW;

    if (!isset($modes[$mode])) {
        return '';
    }

    return '<span class="text-light badge bg-' . $modes[$mode]['class'] . '">
                ' . $modes[$mode]['label'] . '
            </span>';
}


function checkStatusCommande(string $etat, array $data = STATUT_COMMANDE)
{
    $result = "";
    switch ($etat) {
        case $data[0]:
            $result = '<span class="badge badge-statut statut-warning"><span class="dot"></span> ' . $data[0] . '</span>';
            break;
        case $data[1]:
            $result = '<span class="badge badge-statut statut-info"><span class="dot"></span> ' . $data[1] . '</span>';
            break;
        case $data[2]:
            $result = '<span class="badge badge-statut statut-success"><span class="dot"></span> ' . $data[2] . '</span>';
            break;
        case $data[3]:
            $result = '<span class="badge badge-statut statut-default"><span class="dot"></span> ' . $data[3] . '</span>';
            break;
        case $data[4]:
            $result = '<span class="badge badge-statut statut-danger"><span class="dot"></span> ' . $data[4] . '</span>';
            break;
        default:
            $result = '';
            break;
    }
    return $result;
}
function checkEtat(string $status, array $data = ETATS)
{
    $result = "";
    switch ($status) {
        case $data[0]:
            $result = '<span class="badge badge-statut statut-warning"><span class="dot"></span> ' . 'En attente' . '</span>';
            break;
        case $data[1]:
            $result = '<span class="badge badge-statut statut-success"><span class="dot"></span> ' . 'confirmé' . '</span>';
            break;
        default:
            $result = 1;
            break;
    }


    return $result;
}


function checkEtatData(string $status, array $data = STATUT_DATA)
{
    $result = "";
    switch ($status) {
        case $data[0]:
            $result = '<span class="badge badge-statut statut-success"><span class="dot"></span> actif </span>';
            break;
        default:
            $result = '<span class="badge badge-statut statut-warning"><span class="dot"></span> inactif </span>';
            break;
    }


    return $result;
}

function checkEtatDispo(string $status, array $data = ETATS)
{
    $result = "";
    switch ($status) {
        case $data[0]:
            $result = '<span class="badge badge-statut statut-warning"> NON </span>';
            break;
        case $data[1]:
            $result = '<span class="badge badge-statut statut-success"> OUI </span>';
            break;
        default:
            $result = 1;
            break;
    }


    return $result;
}

function checkEtatStock(string $stock, $stockAlerte)
{
    $result = "";

    if ($stock >= ($stockAlerte + 20)) {
        $result = ' <i class="fas fa-arrow-up text-icon-success"></i> ' . $stock;
    } elseif ($stock < ($stockAlerte + 20) && $stock > $stockAlerte) {
        $result = ' <i class="fas fa-arrow-down text-icon-warning"></i> ' . $stock;
    } else {
        $result = ' <i class="fas fa-arrow-down text-icon-danger"></i> ' . $stock;
    }



    return $result;
}
function checkEtatEcart($ecart)
{
    $result = "";

    if ($ecart > 0) {
        $result = ' <i class="fas fa-arrow-circle-up text-icon-primary"></i> ' . $ecart;
    } elseif ($ecart < 0) {
        $result = ' <i class="fas fa-arrow-circle-down text-icon-danger"></i> ' . $ecart;
    } else {
        $result = ' <i class="fas fa-check-circle text-icon-success"></i> ' . $ecart;
    }



    return $result;
}

function checkEtatPaiement(string $status)
{
    $result = "";
    switch ($status) {
        case 'Non payé':
            $result = '<span class="badge badge-statut statut-danger"> ' . $status . ' </span>';
            break;
        case 'Payé':
            $result = '<span class="badge badge-statut statut-success"> ' . $status . ' </span>';
            break;
        default:
            $result = '<span class="badge badge-statut statut-warning"> En cour... </span>';
            break;
    }


    return $result;
}


function checkStatusDepense(string $etat, array $data = STATUT_DEPENSE)
{
    $result = "";
    switch ($etat) {
        case $data[0]:
            $result = '<span class="badge badge-statut statut-warning"><span class="dot"></span> ' . $data[0] . '</span>';
            break;
        case $data[1]:
            $result = '<span class="badge badge-statut statut-success"><span class="dot"></span> ' . $data[1] . '</span>';
            break;
        case $data[2]:
            $result = '<span class="badge badge-statut statut-danger"><span class="dot"></span> ' . $data[2] . '</span>';
            break;
        default:
            $result = '';
            break;
    }


    return $result;
}

function showHtmlElement($item = 1, $equal = 2, $return = 'active show')
{
    return $item == $equal ? $return : '';
}

/**
 * Summary of compareSchoolYears
 * @param string $schoolYear
 * @return int
 * Undocumented function
 *  echo compareSchoolYears('2025-2026');      // -1
 * echo compareSchoolYears('2026 - 2025');    // 1
 * echo compareSchoolYears('2025 - 2025');    // 0
 * DESCRIPTION 
 * -1 → la première année est inférieure à la deuxième.
 * 0 → les deux années sont identiques.
 * 1 → la première année est supérieure à la deuxième.
 */
function compareSchoolYears(string $schoolYear): int
{
    // Supprime les espaces inutiles
    $schoolYear = preg_replace('/\s+/', '', $schoolYear);

    // verifier si le symbole existe avant de separer 


    // Sépare les deux années
    [$startYear, $endYear] = explode('-', $schoolYear);

    return (int)$startYear <=> (int)$endYear;
}

/**
 * Summary of compareAcademicYears
 * @param string $year1
 * @param string $year2
 * @return int| bool
 * compareAcademicYears('2025 - 2026', '2024 - 2025'); // 1
 * compareAcademicYears('2025 - 2026', '2025 - 2026'); // 0
 * compareAcademicYears('2023 - 2024', '2025 - 2026'); // -1
 * DESCRIPTION 
 * -1 → la première année est inférieure à la deuxième.
 * 0 → les deux années sont identiques.
 * 1 → la première année est supérieure à la deuxième.
 */
function compareAcademicYears(string $year1, string $year2): int| bool
{

    $extract = function ($year) {

        $year = preg_replace('/\s+/', '', $year);


        if (!preg_match('/^(\d{4})-(\d{4})$/', $year, $matches)) {
            return false;
        }

        [$start, $end] = explode('-', $year);
        return [(int)$start, (int)$end];
    };

    // if (!is_array($extract($year1))) return false;


    [$start1, $end1] = $extract($year1);
    [$start2, $end2] = $extract($year2);

    // Comparaison d'abord sur l'année de début puis sur l'année de fin
    return [$start1, $end1] <=> [$start2, $end2];
}

/**
 * Summary of isValidSchoolYear
 * @param string $schoolYear
 * @return bool
 */
function isValidSchoolYear(string $schoolYear): bool
{
    $schoolYear = preg_replace('/\s+/', '', $schoolYear);

    if (!preg_match('/^(\d{4})-(\d{4})$/', $schoolYear, $matches)) {
        return false;
    }

    $startYear = (int) $matches[1];
    $endYear   = (int) $matches[2];

    return $endYear === ($startYear + 1);
}

/**
 * Summary of function shiftSpaceBlank(string $text): string
 * @param string $text
 * @return array|string|null
 */
function shiftSpaceBlank(string $text): string
{
    return preg_replace('/\s+/', '', trim($text));
}

function textLimit(string | null $text, int $limit = 30, string $suffix = '...'): string
{
    if (empty($text)) {
        return '...';
    }
    if (mb_strlen($text) <= $limit) {
        return $text;
    }

    $truncated = mb_substr($text, 0, $limit);
    $result = preg_replace('/\s+\S*$/u', '', $truncated);

    // Si aucun espace n'a été trouvé (mot très long)
    if ($result === '') {
        return $truncated . $suffix;
    }

    return rtrim($result) . $suffix;
}

function isAllPermissionsChecked(array $permissions, array $fields, $symbole = 0): bool
{
    // if (array_key_exists()) return false;

    foreach ($fields as $field) {

        if (empty($permissions[$field]) || $permissions[$field] == $symbole) {
            return false;
        }
    }

    return true;
}

function rolePermissionChecked(array $role): bool
{
    return
        !empty($role['create_permission']) &&
        !empty($role['show_permission']) &&
        !empty($role['edit_permission']) &&
        !empty($role['delete_permission']);
}

/**
 * Returns the string "disabled" if the two provided values are equal.
 *
 * @param mixed $equel The first value to compare.
 * @param mixed $val The second value to compare.
 * @return string|null The string "disabled" if the values are equal, otherwise null.
 */

function disabled($val, $equal): string
{
    $result = "";
    if ($equal == $val) {
        $result = "disabled";
    }
    return $result;
}



function selected($val, $equal)
{
    $result = "";
    if ($equal == $val) {
        $result = "selected";
    }
    return $result;
}

function checked($val, $equal)
{
    $result = "";
    if ($equal == $val) {
        $result = "checked";
    }
    return $result;
}

function dateFrench($date, $avecHeure = false)
{
    setlocale(LC_TIME, 'fr_FR.UTF-8', 'fra', 'french');

    if (!$date instanceof DateTime) {
        $date = new DateTime($date);
    }

    $format = $avecHeure ? '%A, %d %B %Y à %Hh%M' : '%A, %d/%m/%Y';
    $formattedDate = strftime($format, $date->getTimestamp());

    return ucwords($formattedDate);
}

function filterCheckBox($name)
{
    if (isset($_POST[$name]) && !empty($_POST[$name])) {
        return htmlspecialchars(strip_tags($_POST[$name]));
    } else {
        return 0;
    }
}

function getDataEnv(string $key): ?string
{
    return $_ENV[$key] ?? null;
}


function loadEnv()
{
    $envPath = __DIR__ . THREE_PIP . '.env';
    if (!file_exists($envPath)) {
        throw new \Exception(".env introuvable");
    }

    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value, "\"'");
    }
}

if (!function_exists('auth')) {
    function auth(): Auth
    {
        return new Auth();
    }
}

if (!function_exists('service')) {
    function service(): Service
    {
        return new Service();
    }
}

if (!function_exists('personneService')) {
    function personneService(): PersonneService
    {
        return new PersonneService();
    }
}

if (!function_exists('csrfToken')) {
    function csrfToken(): CsrfMiddleware
    {
        return new CsrfMiddleware();
    }
}

if (!function_exists('gqr')) {
    function gqr(): Gqr
    {
        return new Gqr();
    }
}

if (!function_exists('route')) {
    /**
     * Générer l'URL d'une route nommée
     * et retourne le pattern avec l'url de base comme https://localhost/hotel
     * pourqoui j'ai ça http://localhost/hotel/hotel/page2
     * @param string $name Nom de la route
     * @param array $params Paramètres dynamiques
     * @return string|null
     */
    function route(string $name, array $params = [])
    {
        global $router;
        $pattern = $router->router($name, $params);
        if ($pattern === null) {
            return null; // Route non trouvée
        }
        return getUrl()  . "/" . ltrim($pattern, '/'); // Ajoute   // Détecte automatiquement la racine du projet
        // $scriptName = $_SERVER['SCRIPT_NAME']; // ex: /hotel/index.php
        // $basePath = rtrim(str_replace('\\', '/', dirname($scriptName)), '/'); // ex: /hotel

        // // Construit l'URL absolue depuis la racine
        // return $basePath . '/' . ltrim($pattern, '/');


    }
}




/**
 * Vérifie si un dossier existe, sinon le crée avec les permissions spécifiées
 * @param string $dir Chemin du dossier
 * @param int $permissions Permissions en octal (par défaut 0755)
 * @return bool True si dossier existe ou créé avec succès, false sinon
 */
function creerDossierSiNonExistant(string $dir, int $permissions = 0755): bool
{
    if (!is_dir($dir)) {
        // Tente de créer le dossier récursivement
        if (!mkdir($dir, $permissions, true)) {
            return false; // Échec création
        }
    }
    return true; // Dossier existe ou créé
}

function verifyExt($file): bool
{
    if (empty($file) || trim($file) === '') return false;

    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    return in_array($ext, EXTENSION);
}

function getExt($file)
{
    if (empty($file) || trim($file) === '') return null;

    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    return $ext;
}

/**
 * detection de l'url du site
 * avoir url automatique comme https://localhost/hotel
 * avec le protocole, le nom de domaine et le chemin du script
 * return string
 */

function getUrlSite(): string
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $scriptName = dirname($_SERVER['SCRIPT_NAME']);
    $url = $protocol . $host . $scriptName;
    return rtrim($url, '/'); // Supprimer le slash final si présent



}

/**
 * avoir la page active
 * @return string
 */
function getActivePage(): string
{
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $path = trim($path, '/');
    $segments = explode('/', $path);
    return end($segments); // Retourne le dernier segment de l'URL
}

/**
 * detection de l'url pour activer la page active
 * le lien actif de sidebar
 * @return string
 * is_active
 */
function isActive(string $page): string
{
    $activePage = getActivePage();
    return $activePage === $page ? 'active' : '';
}

/**construire une url directement sans donne parametre
 * comment avoir ce lien http://localhost/
 */
function getUrl(): string
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $scriptName = dirname($_SERVER['SCRIPT_NAME']);

    // Retourne l'URL de base du site
    return $protocol . $host;
    // return $protocol . $host . $scriptName . '/';
}

function dashlink($role)
{
    // $url = match ($role) {
    //     Roles::SUPER => url('teggdd'),
    //     Roles::PARAMETRE  => url('setting/home'),
    //     Roles::ADMIN_H  => url('admin/liste-employes'),
    //     Roles::DASHBOARD_H  => url('admin/role'),
    //     Roles::COMPTATBLE_H  => url('comptabilite/caisse'),
    //     Roles::SALAIRE_H  => url('salaires'),
    //     Roles::MANAGER_H  => url('chambres'),
    //     Roles::DEPENSE_H  => url('depenses'),
    //     Roles::RECEPTION_H  => url('reservation'),
    //     default   => url(''),
    // };
    // return $url;
}

function dashlinkLabel($role)
{
    // $url = match ($role) {
    //     Roles::PARAMETRE  => 'Parametre du conpte',
    //     Roles::ADMIN_H  => 'Liste des employes',
    //     Roles::DASHBOARD_H  => 'Gestion des roles',
    //     Roles::COMPTATBLE_H  => 'Gestion des caisses',
    //     Roles::SALAIRE_H  => 'Gestion des salaires',
    //     Roles::MANAGER_H  => 'Gestion des chambres',
    //     Roles::DEPENSE_H  => 'Gestion des depenses',
    //     Roles::RECEPTION_H  => 'Gestion des reservations',
    //     default   => '',
    // };
    // return $url;
}

function dashlabel($groupe)
{
    // $url = match ($groupe) {
    //     Groupes::SUPER => '😃 Super Admin',
    //     Groupes::PARAMETRE  => '🔄 Paramétrage',
    //     Groupes::ADMIN  => '👨 Admin',
    //     Groupes::COMPTABLE  => '💰 Comptabilité',
    //     Groupes::RECEPTION  => '💻 Reception',
    //     Groupes::HOTEL  => '🏨 Gestion Hotel',

    //     default   => '',
    // };
    // return $url;
}


class Permissions
{
    public const CREATE = 'create_permission';
    public const EDIT = 'edit_permission';
    public const VIEW = 'show_permission';
    public const DELETE = 'delete_permission';
}

class Roles
{
    public const SUPER = 'sup1';
    public const PARAMETRE = 'para1';
    public const ADMIN_H = 'ga1';
    public const DASHBOARD_H = 'ga3';
    public const COMPTATBLE_H = 'gcom1';
    public const SALAIRE_H = 'gcom2';
    public const MANAGER_H = 'gh1';
    public const DEPENSE_H = 'gh2';
    public const RECEPTION_H = 'grecp1';
}

class Groupes
{
    public const ADMIN = 'GADMIN';
    public const PEDAGOGIE = 'GPEDAGOGIE';
    public const COMPTABLE = 'GCOMPT';
    public const RECEPTION = 'GRECP';
    public const HOTEL = 'GHOT';
    public const PARAMETRE = 'PARA';
    public const SUPER = 'SUPER';
}
