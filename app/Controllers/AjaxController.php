<?php
session_name("APP15464655_SESSION");


session_start();
include __DIR__ . '/../../src/Core/security.php';

require __DIR__ . '/../../vendor/autoload.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée']);
    exit;
}

// section user 
if (isset($_POST['action_user'])) {

    include __DIR__ . '/../../src/Controllers/AjaxUserController.php';
    exit;
    // section personne
} elseif (isset($_POST['action_personne'])) {
    include __DIR__ . '/../../src/Controllers/AjaxPersonneController.php';
    exit;
    // section produit
} elseif (isset($_POST['action_produit'])) {
    include __DIR__ . '/../../src/Controllers/AjaxProduitController.php';
    exit;
} else {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Action manquante']);
    exit;
}
