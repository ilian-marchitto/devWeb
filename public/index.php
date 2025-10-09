<?php
session_start();
//Lien principal
define('BASE_PATH', dirname(__DIR__));
require_once BASE_PATH . '/config.php';
// Sous-dossiers
define('CONTROLLERS_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'controllers');
define('MODELS_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'models');



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



require_once PUBLIC_PATH . '/AutoLoader.php';

use controllers\AccueilController;
use controllers\BienvenueController;
use controllers\SeConnecterController;
use controllers\DoubleAuthentificationController;
use controllers\SInscrireController;
use controllers\SeDeconnecterController;
use controllers\PlanDuSiteController;
use controllers\FooterController;
use controllers\Builder;
use controllers\MdpOublieController;
use controllers\MdpRenitController;

// Récupérer le paramètre 'page', sinon définir 'home' par défaut
$page = filter_input(INPUT_GET, 'page') ?? 'home';
switch ($page) {

    case 'home':
        $controller = new AccueilController($connection);
        $controller->render();
        break;

    case 'se_connecter':
        $controller = new SeConnecterController($connection);
        $controller->render();
        break;

    case 'bienvenue':
        $controller = new BienvenueController($connection);
        $controller->render();
        break;

    case 'second_authenticator':
        $controller = new DoubleAuthentificationController($connection);
        $controller->render();
        break;
    
    case 's_inscrire':
        $controller = new SInscrireController($connection);
        $controller->render();
        break;
    
    case 'logout':
        $controller = new SeDeconnecterController();
        $controller->render();
        break;

    case 'plan_du_site':
        $controller = new PlanDuSiteController(PAGES_PATH, BASE_URL);
        $controller->render();
        break;

    case 'forgot':
        $controller = new MdpOublieController($connection);
        $controller->render();
        break;

    case 'password_reset':
        $controller = new MdpRenitController($connection);
        $controller->render();
        break;
    
    default:
        echo "<h2>Page non trouvée</h2>";
        break;
}

// ─────────────── URLs publiques ─────────────── : clé, fichier à inclure
$routes = [ 'home' => CONTROLLERS_PATH . '/AccueilController.php',
    'se_connecter' => CONTROLLERS_PATH . '/SeConnecterController.php',
    's_inscrire' => CONTROLLERS_PATH . '/SInscrireController.php',
    'plan_du_site' => CONTROLLERS_PATH . '/PlanDuSiteController.php',
    'bienvenue' => CONTROLLERS_PATH . '/BienvenueController.php',
    'logout' => CONTROLLERS_PATH . '/SeDeconnecterController.php',
    'forgot' => CONTROLLERS_PATH . '/MdpOublieController.php',
    'password_reset' => CONTROLLERS_PATH . '/MdpRenitController.php',
    'second_authenticator' => CONTROLLERS_PATH . '/DoubleAuthentificationController.php',];




