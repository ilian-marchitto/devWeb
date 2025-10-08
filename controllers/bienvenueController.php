<?php

require_once  BASE_PATH . '/config.php';
require_once CONTROLLERS_PATH . '/HeadController.php';
require_once CONTROLLERS_PATH .'/toggleButtonController.php';

toggleButtonController::handleThemeToggle();
$styleDynamique = toggleButtonController::getActiveStyle();


// ==========================
// Variables spécifiques à la page
// ==========================


$pageTitle = "Bienvenue sur le site Fan2Jul";
$pageDescription = "Site officiel des auteurs ACH Sofia, ARFI Maxime, BURBECK Heather et MARCHITTO Ilian. Nous vous souhaitons bienvenue.";
$pageKeywords = "Fan2Jul, ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian, communauté, bienvenue";
$pageAuthor = "ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian";
$pageCss = ["bienvenue.css", $styleDynamique]; // Fichier CSS spécifique à la page

// ==========================
// Contrôleur Head
// ==========================
$head = new HeadController($pageTitle, $pageDescription, $pageKeywords, $pageAuthor, $pageCss);




if (!isset($_SESSION['firstname'])) {
    header("Location: " . BASE_URL . "/index.php?page=seConnecter");
    exit;
}

$prenom = $_SESSION['firstname'];
$initiale = strtoupper(substr($prenom, 0, 1));

require_once LAYOUT_PATH . '/head.php';
require_once PAGES_PATH . '/bienvenue.php';

?>