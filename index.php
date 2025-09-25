<?php
// Tableau des routes autorisées : clé, fichier à inclure
$routes = [
    'home' => 'pages/accueil.php',
    'seConnecter' => 'pages/seConnecter.php',
    'sInscrire' => 'pages/sInscrire.php',
    'planDuSite' => 'pages/planDuSite.php'
];

// Récupérer le paramètre 'page', sinon définir 'home' par défaut
$page = filter_input(INPUT_GET, 'page') ?? 'home';

// Vérifier si la page demandée est dans les routes autorisées
if (isset($routes[$page])) {
    include $routes[$page];
} else {
    // Page non trouvée → afficher une page 404
    echo "<h2>404 - Page non trouvée</h2>";
}
