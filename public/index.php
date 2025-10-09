    <?php
    session_start();
    //Lien principal
    define('BASE_PATH', dirname(__DIR__));
    require_once BASE_PATH . '/config.php';
    // Sous-dossiers
    define('CONTROLLERS_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'controllers');
    define('MODELS_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'models');

    require_once BASE_PATH . '/AutoLoader.php';

    define('VIEWS_PATH', BASE_PATH . '/views');
    define('PUBLIC_PATH', BASE_PATH . '/public');
    define ('PHPMAILER_PATH', BASE_PATH . '/vendor/phpmailer/phpmailer/src');

    // Sous-dossiers Views
    define('PAGES_PATH', VIEWS_PATH . '/pages');
    define('LAYOUT_PATH', VIEWS_PATH . '/layout');


    // ─────────────── URLs publiques ───────────────
    
    // Lien principal
    define('BASE_URL', 'http://localhost/devWeb/public');


    // Sous-dossiers Public
    define('CSS_URL', BASE_URL . '/css');
    define('ASSETS_URL', BASE_URL . '/assets');


    // Sous-dossiers Assets
    define('IMAGES_URL', ASSETS_URL . '/images');

    // Récupérer le paramètre 'page', sinon définir 'home' par défaut
    $page = filter_input(INPUT_GET, 'page') ?? 'home';

    use controllers\AccueilController;
    use controllers\SeConnecterController;

    switch ($page) {

        case 'home':
            $controller = new AccueilController($connection);
            $controller->render();
            break;

        case 'se_connecter':
            $controller = new SeConnecterController($connection);
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
        'signup' => CONTROLLERS_PATH . '/SInscrireController.php',
        'login' => CONTROLLERS_PATH . '/SeConnecterController.php',
        'forgot' => PAGES_PATH . '/MdpOublie.php',
        'send_reset' => CONTROLLERS_PATH . '/MdpOublieController.php',
        'password_reset' => PAGES_PATH . '/MdpRenit.php',
        'perform_reset' => CONTROLLERS_PATH . '/mdpRenitController.php',];




