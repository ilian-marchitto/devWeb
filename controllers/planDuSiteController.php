<?php

namespace controllers;

class PlanDuSiteController
{
    private string $viewsPath;
    private string $baseUrl;

    public array $pages = [];

    public function __construct(string $viewsPath, string $baseUrl)
    {
        $this->viewsPath = $viewsPath;
        $this->baseUrl = $baseUrl;
    }

    public function buildPages(): void
    {
        $dirDisk = $this->viewsPath . '/pages';
        $this->pages = [];

        if (!is_dir($dirDisk)) return;

        foreach (scandir($dirDisk) as $file) {
            if ($file[0] === '.') continue;

            $slug = pathinfo($file, PATHINFO_FILENAME);

            // Ignorer certaines pages
            if (in_array($slug, ['bienvenue', 'forgot', 'password_reset', 'seDeconnecter', 'mdpRenit', 'mdpOublie'], true)) {
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
        $this->buildPages();
        require $this->viewsPath . '/pages/planDuSite.php';
    }
}
