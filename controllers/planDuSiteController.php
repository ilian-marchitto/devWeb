<?php


require_once CONTROLLERS_PATH . '/HeadController.php';
require_once CONTROLLERS_PATH .'/toggleButtonController.php';

toggleButtonController::handleThemeToggle();
$styleDynamique = toggleButtonController::getActiveStyle();


$pageTitle = "Plan du site";
$pageDescription = "Site officiel des auteurs ACH Sofia, ARFI Maxime, BURBECK Heather et MARCHITTO Ilian. Découvrez les différentes pages de notre site.";
$pageKeywords = "Fan2Jul, ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian, communauté, plan du site";
$pageAuthor = "ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian";
$pageCss = ["planDuSite.css",$styleDynamique]; // Fichier CSS spécifique à la page

// ==========================
// Contrôleur Head
// ==========================
$head = new HeadController($pageTitle, $pageDescription, $pageKeywords, $pageAuthor, $pageCss);

require_once LAYOUT_PATH . '/head.php';


$dirDisk = VIEWS_PATH . '/pages';
$pages   = [];

if (is_dir($dirDisk)) {
    foreach (scandir($dirDisk) as $file) {
        if ($file[0] === '.') continue;

        $slug = pathinfo($file, PATHINFO_FILENAME); // nom sans .blabla

        if (in_array($slug, ['bienvenue','forgot','password_reset','seDeconnecter','mdpRenit','mdpOublie'], true)) continue;

        if ($slug === 'accueil') {
            $displayName = 'Accueil';   
            $linkSlug    = 'home';      
        } else {
            $displayName = $slug;      
            $linkSlug    = $slug;       
        }

        $pages[] = [
            'name' => $displayName,
            'url'  => BASE_URL . '/?page=' . rawurlencode($linkSlug),
        ];
    }

    usort($pages, fn($a, $b) => strcasecmp($a['name'], $b['name']));
}

require VIEWS_PATH . '/pages/planDuSite.php';
