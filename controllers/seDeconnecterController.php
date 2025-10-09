<?php

namespace controllers;

class SeDeconnecterController
{
    public $head;
    public $pageTitle;
    public $pageDescription;
    public $pageKeywords;
    public $pageCss;
    public $pageAuthor;

    public function __construct()
    {
        ToggleButtonController::handleThemeToggle();
        $styleDynamique = ToggleButtonController::getActiveStyle();

        // ─────────────── Protection de la page ───────────────
        if (!isset($_SESSION['firstname'])) {
            header("Location: " . BASE_URL . "/index.php?page=se_connecter");
            exit;
        }

        // ==========================
        // Variables spécifiques à la page
        // ==========================
        $pageTitle = "Se déconnecter";
        $pageDescription = "Site officiel des auteurs ACH Sofia, ARFI Maxime, BURBECK Heather et MARCHITTO Ilian. Deconnectez-vous en toutes sécurités.";
        $pageKeywords = "Fan2Jul, ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian, communauté, deconnexion";
        $pageAuthor = "ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian";
        $pageCss = ["seConnecter.css", $styleDynamique]; // Fichier CSS spécifique à la page

        $this->head = new HeadController($pageTitle, $pageDescription, $pageKeywords, $pageAuthor, $pageCss);

        $initiale = '';

        if (isset($_SESSION['firstname']) && !empty($_SESSION['firstname'])) {
            $prenom = $_SESSION['firstname'];
            $initiale = strtoupper(substr($prenom, 0, 1));
        }

        $_SESSION = [];

        session_destroy();
    }

    public function render(): void
    {
        require_once LAYOUT_PATH . '/head.php';
        include PAGES_PATH . '/seDeconnecter.php';
    }
}
