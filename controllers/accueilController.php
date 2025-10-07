<?php
// controllers/accueilController.php

require_once BASE_PATH . '/config.php';
require_once CONTROLLERS_PATH . '/HeadController.php';
require_once CONTROLLERS_PATH . '/HeaderController.php';
require_once CONTROLLERS_PATH . '/FooterController.php';

require_once MODELS_PATH . '/AlbumModel.php';
require_once MODELS_PATH . '/ItemModel.php';

// ==========================
// Variables spécifiques à la page
// ==========================
$pageTitle = "Bienvenue sur le site Fan2Jul";
$pageDescription = "Site officiel des auteurs ACH Sofia, ARFI Maxime, BURBECK Heather et MARCHITTO Ilian. Découvrez la communauté, les albums et l'actualité.";
$pageKeywords = "Fan2Jul, ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian, albums, communauté, actualité";
$pageAuthor = "ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian";
$pageCss = ["accueil.css"]; // Fichier CSS spécifique à la page

// ==========================
// Contrôleur Head
// ==========================
$head = new HeadController($pageTitle, $pageDescription, $pageKeywords, $pageAuthor, $pageCss);

// ==========================
// Contrôleurs Header & Footer
// ==========================
$isLoggedIn = isset($_SESSION['email']);
$header = new HeaderController($isLoggedIn);
$footer = new FooterController();

// Récupération des items pour la vue
$navItems    = $header->getNavItems();
$buttonItems = $header->getButtonItems();
$fontItems   = $header->getFontItems();

//Recuperation du nombres de compte dans la base
$itemsData = new ItemModel($connection);
$numberUser = $itemsData -> countUserAccount();


$albumModel = new AlbumModel($connection);
$rows = $albumModel->getAllAlbums();

$albums = array_map(function ($r) {
    return [
        'title' => (string)$r['titlea'],
        'img'   => AlbumModel::imageUrl((string)$r['imga']),
        'link'  => (string)$r['linka'],
    ];
}, $rows);


// Pagination
$perPage = 5;
$totalAlbums = count($albums);
$totalPages = ceil($totalAlbums / $perPage);

$page = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
if ($page > $totalPages) $page = $totalPages;

$start = ($page - 1) * $perPage;
$pageAlbums = array_slice($albums, $start, $perPage);

// ==========================
// Inclusion des vues
// ==========================
require_once LAYOUT_PATH . '/head.php';
require_once LAYOUT_PATH . '/header.php';
require_once PAGES_PATH . '/accueil.php';
require_once LAYOUT_PATH . '/footer.php';

?>


