<?php


$pageTitle = "Plan du site";

$dirDisk = __DIR__ . '/../views/pages';       
$dirWeb  = dirname($_SERVER['SCRIPT_NAME']);   
$pagesUrlPrefix = $dirWeb . '/../views/pages';

$pages = [];

if (is_dir($dirDisk)) {
    $files = scandir($dirDisk);

    foreach ($files as $file) {
        
                
        if (in_array($file, ['passwordreset.php','forgot.php'], true)) continue;

        $pages[] = [
            'name' => pathinfo($file, PATHINFO_FILENAME),       // nom sans .blablabla
            'url'  => $pagesUrlPrefix . '/' . $file             // URL relative depuis l’URL du contrôleur
        ];
    }

    // tri par nom
    usort($pages, fn($a,$b) => strcasecmp($a['name'], $b['name']));
}

require __DIR__ . '/../views/pages/planDuSite.php';
