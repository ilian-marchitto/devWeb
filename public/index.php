<?php


// ─────────────── Liens PHP ───────────────


//Lien principal
define('BASE_PATH', dirname(__DIR__));


// Sous-dossiers
define('CONTROLLERS_PATH', BASE_PATH . '/controllers');
define('MODELS_PATH', BASE_PATH . '/models');
define('VIEWS_PATH', BASE_PATH . '/views');
define('PUBLIC_PATH', BASE_PATH . '/public');
define ('PHPMAILER_PATH', BASE_PATH . '/vendor/phpmailer/phpmailer/src');

// Sous-dossiers Views
define('PAGES_PATH', VIEWS_PATH . '/pages');
define('LAYOUT_PATH', VIEWS_PATH . '/layout');


// ─────────────── URLs publiques ───────────────


// Lien principal
define('BASE_URL', 'https://fan2jul.alwaysdata.net/');


// Sous-dossiers Public
define('CSS_URL', BASE_URL . '/css');
define('ASSETS_URL', BASE_URL . '/assets');


// Sous-dossiers Assets
define('IMAGES_URL', ASSETS_URL . '/images');

// ─────────────── Autoloader  ───────────────
spl_autoload_register(function ($className) {
    // Remplacer le namespace App par le chemin réel
    $className = str_replace('App\\', '', $className);

    // Chemins à tester
    $paths = [
        __DIR__ . '/controllers/' . $className . '.php',
        __DIR__ . '/models/' . $className . '.php',
    ];

    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }

    // Si aucune classe trouvée
    throw new Exception("Classe $className introuvable !");
});

// ─────────────── URLs publiques ─────────────── : clé, fichier à inclure
$routes = [ 'home' => CONTROLLERS_PATH . '/accueilController.php',
    'seConnecter' => CONTROLLERS_PATH . '/seConnecterController.php',
    'sInscrire' => CONTROLLERS_PATH . '/sInscrireController.php',
    'planDuSite' => CONTROLLERS_PATH . '/planDuSiteController.php',
    'bienvenue' => CONTROLLERS_PATH . '/bienvenueController.php',
    'logout' => CONTROLLERS_PATH . '/seDeconnecterController.php',
    'signup' => CONTROLLERS_PATH . '/sInscrireController.php',
    'login' => CONTROLLERS_PATH . '/seConnecterController.php',
    'forgot' => PAGES_PATH . '/mdpOublie.php',
    'send_reset' => CONTROLLERS_PATH . '/mdpOublieController.php',
    'password_reset' => PAGES_PATH . '/mdpRenit.php',
    'perform_reset' => CONTROLLERS_PATH . '/mdpRenitController.php'];

// Récupérer le paramètre 'page', sinon définir 'home' par défaut
$page = filter_input(INPUT_GET, 'page') ?? 'home';


switch ($page) {
    case 'home':
        // Instanciation du controller pour la page d'accueil
        $controller = new AccueilController($connection);
        $controller->render(); // Appelle toutes les vues head, header, page, footer
        break;

    case 'seConnecter':
        $controller = new SeConnecterController($connection);
        $controller->render();
        break;

    case 'sInscrire':
        $controller = new SInscrireController($connection);
        $controller->render();
        break;

    case 'bienvenue':
    $controller = new BienvenueController($connection);
    $controller->render();
    break;
    }