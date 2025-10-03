<?php

// ─────────────── Liens PHP ───────────────

//Lien principal 
define('BASE_PATH', dirname(__DIR__)); 

// Sous-dossiers 
define('CONTROLLERS_PATH', BASE_PATH . '/controllers'); 
define('MODELS_PATH', BASE_PATH . '/models'); 
define('VIEWS_PATH', BASE_PATH . '/views'); 
define('PUBLIC_PATH', BASE_PATH . '/public'); 

// Sous-dossiers Views 
define('PAGES_PATH', VIEWS_PATH . '/pages'); 
define('LAYOUT_PATH', VIEWS_PATH . '/layout');

// ─────────────── URLs publiques ───────────────

// Lien principal 
define('BASE_URL', '/public');

// Sous-dossiers Public 
define('CSS_URL', BASE_URL . '/css');
define('ASSETS_URL', BASE_URL . '/assets');

// Sous-dossiers Assets 
define('IMAGES_URL', ASSETS_URL . '/images');

// ─────────────── URLs publiques ─────────────── : clé, fichier à inclure 
$routes = [ 'home' => CONTROLLERS_PATH . '/accueilController.php', 
            'seConnecter' => PAGES_PATH . '/seConnecter.php', 
            'sInscrire' => PAGES_PATH . '/sInscrire.php', 
            'planDuSite' => PAGES_PATH . '/planDuSite.php',
            'bienvenue' => PAGES_PATH . '/bienvenue.php' ]; 
            
// Récupérer le paramètre 'page', sinon définir 'home' par défaut 
$page = filter_input(INPUT_GET, 'page') ?? 'home'; 

// Vérifier si la page demandée est dans les routes autorisées 
if (isset($routes[$page])) { include $routes[$page]; } 

else { // Page non trouvée → afficher une page 404 
echo "<h2>404 - Page non trouvée</h2>"; } 
