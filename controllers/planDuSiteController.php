<?php


$pageTitle = "Plan du site";

$directory = __DIR__ . '/../views/pages';
$pages = [];


$ignoreFiles = ['passwordreset.php', 'forgot.php'];

if (is_dir($directory)) {
    $files = scandir($directory);

    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;

        if (in_array($file, $ignoreFiles, true)) continue; //fichiers  ignorés

        // Ajoute la page dans le tableau
        $pages[] = [
            'name' => pathinfo($file, PATHINFO_FILENAME), // nom sans les .blabla
            'path' => 'views/pages/' . $file             
        ];
    }
} else {
    $pages = [];
}

require __DIR__ . '/../views/pages/planDuSite.php';
