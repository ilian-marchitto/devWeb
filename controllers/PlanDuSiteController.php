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
        // ─────────────── Configuration centralisée ───────────────
        
        // Pages à ignorer dans le plan du site
        $ignoredPages = [
            'bienvenue',
            'logout',
            'forgot',
            'password_reset',
            'second_authenticator'
        ];

        // Mapping : slug route => nom d'affichage personnalisé
        $pageMapping = [
            'home' => 'Accueil',
            'se_connecter' => 'Se connecter',
            's_inscrire' => "S'inscrire",
            'plan_du_site' => 'Plan du site',
        ];

        // ─────────────── Utiliser les routes définies dans index.php ───────────────
        
        // Récupérer les routes depuis le contexte global (définies dans index.php)
        global $routes;
        
        if (empty($routes)) {
            error_log("PlanDuSiteController: Aucune route trouvée");
            return;
        }

        foreach ($routes as $routeSlug => $controllerPath) {
            // Ignorer les pages de la liste noire
            if (in_array($routeSlug, $ignoredPages, true)) {
                continue;
            }

            // Utiliser le nom personnalisé ou générer un nom par défaut
            $displayName = $pageMapping[$routeSlug] ?? ucfirst(str_replace('_', ' ', $routeSlug));

            $this->pages[] = [
                'name' => $displayName,
                'url'  => $this->baseUrl . '?page=' . rawurlencode($routeSlug)
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
