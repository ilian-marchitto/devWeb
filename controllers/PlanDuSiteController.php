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
        
        // ───────────── Head ─────────────
        $pageTitle = "Plan du site";
        $pageDescription = "Site officiel des auteurs ACH Sofia, ARFI Maxime, BURBECK Heather et MARCHITTO Ilian. Découvrez les différentes pages de notre site.";
        $pageKeywords = "Fan2Jul, ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian, communauté, plan du site";
        $pageAuthor = "ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian";
        $pageCss = ["planDuSite.css", $styleDynamique];
        $this->head = new HeadController($pageTitle, $pageDescription, $pageKeywords, $pageAuthor, $pageCss);
    }

    public function buildPages(): void
    {
        $dirDisk = $this->viewsPath;
        $this->pages = [];

        if (!is_dir($dirDisk)) return;

        foreach (scandir($dirDisk) as $file) {
            if ($file[0] === '.') continue;

            $slug = pathinfo($file, PATHINFO_FILENAME);

            // Ignorer certaines pages
            if (in_array($slug, ['bienvenue', 'forgot', 'password_reset', 'logout', 'mdpRenit', 'mdpOublie', 'second_authenticator', ], true)) {
                continue;
            }

            $displayName = $slug === 'accueil' ? 'Accueil' : $slug;
            $linkSlug    = $slug === 'accueil' ? 'home' : $slug;

            $this->pages[] = [
                'name' => $displayName,
                'url'  => $this->baseUrl . '/?page=' . rawurlencode($linkSlug),
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
