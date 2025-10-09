<?php

namespace controllers;

class BienvenueController
{
    public static function afficherPage()
    {
        // Inclusion des dépendances
        require_once BASE_PATH . '/config.php';
        require_once CONTROLLERS_PATH . '/HeadController.php';
        require_once CONTROLLERS_PATH . '/toggleButtonController.php';

        // Gestion du thème (toggle)
        toggleButtonController::handleThemeToggle();
        $styleDynamique = toggleButtonController::getActiveStyle();

        // ==========================
        // Variables spécifiques à la page
        // ==========================
        $pageTitle = "Bienvenue sur le site Fan2Jul";
        $pageDescription = "Site officiel des auteurs ACH Sofia, ARFI Maxime, BURBECK Heather et MARCHITTO Ilian. Nous vous souhaitons bienvenue.";
        $pageKeywords = "Fan2Jul, ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian, communauté, bienvenue";
        $pageAuthor = "ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian";
        $pageCss = ["bienvenue.css", $styleDynamique];

        // ==========================
        // Contrôleur Head
        // ==========================
        $head = new \HeadController($pageTitle, $pageDescription, $pageKeywords, $pageAuthor, $pageCss);

        // ==========================
        // Sécurité : redirection si non connecté
        // ==========================
        if (!isset($_SESSION['firstname'])) {
            header("Location: " . BASE_URL . "/index.php?page=seConnecter");
            exit;
        }

        // Données pour la vue
        $prenom = $_SESSION['firstname'];
        $initiale = strtoupper(substr($prenom, 0, 1));

    }

    public static function render(){
        require_once LAYOUT_PATH . '/head.php';
        require_once PAGES_PATH . '/bienvenue.php';
    }
}
