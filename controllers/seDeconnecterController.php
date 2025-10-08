<?php
// Démarrer la session
session_start();
require_once CONTROLLERS_PATH . '/HeadController.php';
require_once CONTROLLERS_PATH .'/toggleButtonController.php';

toggleButtonController::handleThemeToggle();
$styleDynamique = toggleButtonController::getActiveStyle();


// ==========================
// Variables spécifiques à la page
// ==========================


$pageTitle = "Se connecter";
$pageDescription = "Site officiel des auteurs ACH Sofia, ARFI Maxime, BURBECK Heather et MARCHITTO Ilian. Connectez-vous pour découvrir la communauté, les albums et l'actualité.";
$pageKeywords = "Fan2Jul, ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian, communauté, connexion";
$pageAuthor = "ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian";
$pageCss = ["seConnecter.css", $styleDynamique]; // Fichier CSS spécifique à la page

// ==========================
// Contrôleur Head
// ==========================
$head = new HeadController($pageTitle, $pageDescription, $pageKeywords, $pageAuthor, $pageCss);

require_once LAYOUT_PATH . '/head.php';
require_once PAGES_PATH . '/seConnecter.php';

$initiale = '';


if (isset($_SESSION['firstname']) && !empty($_SESSION['firstname'])) {
    $prenom = $_SESSION['firstname'];
    $initiale = strtoupper(substr($prenom, 0, 1));
}

// Inclure le template de déconnexion
include PAGES_PATH . '/seDeconnecter.php';


$_SESSION = [];

session_destroy();
?>
