<?php

namespace controllers;

class PlanDuSiteController
{
    private string $viewsPath;
    private string $baseUrl;
    public $head;
    public $pageTitle;
    public $pageDescription;
    public $pageKeywords;
    public $pageCss;
    public $pageAuthor;
    public array $pages = [];

    public function __construct(string $viewsPath, string $baseUrl)
    {
        $this->viewsPath = $viewsPath;
        $this->baseUrl = $baseUrl;
        
        // ─────────────── Gestion du thème ───────────────
        ToggleButtonController::handleThemeToggle();
        $styleDynamique = ToggleButtonController::getActiveStyle();

        // ───────────── Head ─────────────
        $pageTitle = "Plan du site";
        $pageDescription = "Site officiel des auteurs ACH Sofia, ARFI Maxime, BURBECK Heather et MARCHITTO Ilian. Découvrez les différentes pages de notre site.";
        $pageKeywords = "Fan2Jul, ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian, communauté, plan du site";
        $pageAuthor = "ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian";
        $pageCss = ["planDuSite.css", $styleDynamique];
        $this->head = new HeadController($pageTitle, $pageDescription, $pageKeywords, $pageAuthor, $pageCss);

        $this->buildPages();
    }

    public function buildPages(): void
{
    $dirDisk = $this->viewsPath;
    $this->pages = [];

    if (!is_dir($dirDisk)) return;

    // ─────────────── Configuration centralisée ───────────────
    
    // Pages à ignorer complètement
    $ignoredPages = [
        'bienvenue', 
        'forgot', 
        'password_reset', 
        'mdpRenit', 
        'mdpOublie', 
        'doubleAuthentification',  // minuscule
        'DoubleAuthentification',  // majuscule
        'seDeconnecter',           // minuscule
        'SeDeconnecter',           // majuscule
    ];

    // Mapping : slug fichier => [nom d'affichage, slug URL]
    $pageMapping = [
        'accueil' => ['Accueil', 'home'],
        'seConnecter' => ['Se connecter', 'se_connecter'],
        'sInscrire' => ["S'inscrire", 's_inscrire'],
        'planDuSite' => ['Plan du site', 'plan_du_site'],
    ];

    // ─────────────── Traitement ───────────────
    
    foreach (scandir($dirDisk) as $file) {
        if ($file[0] === '.') continue;

        $slug = pathinfo($file, PATHINFO_FILENAME);

        // Ignorer les pages de la liste noire (insensible à la casse)
        if (in_array(strtolower($slug), array_map('strtolower', $ignoredPages), true)) {
            continue;
        }

        // Utiliser le mapping si disponible, sinon valeurs par défaut
        if (isset($pageMapping[$slug])) {
            [$displayName, $linkSlug] = $pageMapping[$slug];
        } else {
            // Fallback : transformer le slug en nom lisible
            $displayName = ucfirst(str_replace('_', ' ', $slug));
            $linkSlug = $slug;
        }

        $this->pages[] = [
            'name' => $displayName,
            'url'  => $this->baseUrl . '?page=' . rawurlencode($linkSlug)
        ];
    }

    // Tri alphabétique
    usort($this->pages, fn($a, $b) => strcasecmp($a['name'], $b['name']));
    }

    public function render(): void
    {
        $vars = get_object_vars($this);
        extract($vars);

        require_once LAYOUT_PATH . '/head.php';
        include PAGES_PATH . '/planDuSite.php';
    }
}
