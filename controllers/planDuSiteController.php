<?php

$pageTitle = "Plan du site";

$dirDisk = VIEWS_PATH . '/pages';
$pages   = [];

if (is_dir($dirDisk)) {
    foreach (scandir($dirDisk) as $file) {
        if ($file[0] === '.') continue;                  
       

        $slug = pathinfo($file, PATHINFO_FILENAME); // nom sans .blabla

        if (in_array($slug, ['bienvenue','forgot','password_reset','seDeconnecter'], true)) continue;

        $pages[] = [
            'name' => $slug,
            'url'  => BASE_URL . '/?page=' . rawurlencode($slug),
        ];
    }

    usort($pages, fn($a,$b) => strcasecmp($a['name'], $b['name']));
}

require VIEWS_PATH . '/pages/planDuSite.php';
