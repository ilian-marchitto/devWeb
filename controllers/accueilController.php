<?php
session_start();

$pageTitle = "Bienvenue sur le site";


require_once CONTROLLERS_PATH . '/headerController.php';

require_once PAGES_PATH . '/accueil.php';

require_once CONTROLLERS_PATH . '/footerController.php';
