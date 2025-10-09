<?php

namespace controllers;
use models\UserModels;

class BienvenueController
{

    private string $prenom;
    private string $initiale;
    private HeadController $head;
    private PDO $connection;
    private string $styleDynamique;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;

        // ─────────────── Gestion du thème ───────────────
        ToggleButtonController::handleThemeToggle();
        $this->styleDynamique = ToggleButtonController::getActiveStyle();

        // ─────────────── Protection de la page ───────────────
        if (!isset($_SESSION['firstname'])) {
            header("Location: " . BASE_URL . "/index.php?page=se_connecter");
            exit;
        }

        // ─────────────── Données utilisateur ───────────────
        $this->prenom = $_SESSION['firstname'];
        $this->initiale = strtoupper(substr($this->prenom, 0, 1));

        // ─────────────── Configuration de la page ───────────────
        $pageTitle = "Bienvenue sur le site Fan2Jul";
        $pageDescription = "Site officiel des auteurs ACH Sofia, ARFI Maxime, BURBECK Heather et MARCHITTO Ilian. Nous vous souhaitons bienvenue.";
        $pageKeywords = "Fan2Jul, ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian, communauté, bienvenue";
        $pageAuthor = "ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian";
        $pageCss = ["bienvenue.css", $this->styleDynamique];

        // ─────────────── Initialisation du head ───────────────
        $this->head = new HeadController($pageTitle, $pageDescription, $pageKeywords, $pageAuthor, $pageCss);
    }

    // ─────────────── Méthode d’affichage ───────────────
    public function render(): void
    {
        $vars = get_object_vars($this);
        extract($vars);

        require_once LAYOUT_PATH . '/head.php';
        include PAGES_PATH . '/bienvenue.php';
    }

    // ─────────────── Getters utiles pour la vue ───────────────
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getInitiale(): string
    {
        return $this->initiale;
    }

    public function getHead(): HeadController
    {
        return $this->head;
    }
}
