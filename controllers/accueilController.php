<?php

namespace App\Controllers;

require_once BASE_PATH . '/config.php';
require_once CONTROLLERS_PATH . '/HeadController.php';
require_once CONTROLLERS_PATH . '/HeaderController.php';
require_once CONTROLLERS_PATH . '/FooterController.php';
require_once CONTROLLERS_PATH . '/toggleButtonController.php';

use App\Models\UserModels;
use App\Models\SongModel;
use App\Models\AlbumModel;

class AccueilController {
    private $connection;
    public $head;
    public $header;
    public $footer;
    public $navItems;
    public $buttonItems;
    public $fontItems;
    public $albums;
    public $pageAlbums;
    public $totalPages;
    public $randomVideoId;
    public $numberUser;
    public $page;

    public function __construct($connection) {
        $this->connection = $connection;

        // ───────────── Toggle theme ─────────────
        toggleButtonController::handleThemeToggle();
        $styleDynamique = toggleButtonController::getActiveStyle();

        // ───────────── Head ─────────────
        $pageTitle = "Bienvenue sur le site Fan2Jul";
        $pageDescription = "Site officiel des auteurs ACH Sofia, ARFI Maxime, BURBECK Heather et MARCHITTO Ilian. Découvrez la communauté, les albums et l'actualité.";
        $pageKeywords = "Fan2Jul, ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian, albums, communauté, actualité";
        $pageAuthor = "ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian";
        $pageCss = ["accueil.css", $styleDynamique];
        $this->head = new HeadController($pageTitle, $pageDescription, $pageKeywords, $pageAuthor, $pageCss);

        // ───────────── Header & Footer ─────────────
        $isLoggedIn = isset($_SESSION['email']);
        $this->header = new HeaderController($isLoggedIn);
        $this->footer = new FooterController();
        $this->navItems = $this->header->getNavItems();
        $this->buttonItems = $this->header->getButtonItems();
        $this->fontItems = $this->header->getFontItems();

        // ───────────── Users ─────────────
        $userModel = new UserModels($this->connection);
        $this->numberUser = $userModel->countUserAccount();

        // ───────────── Albums ─────────────
        $albumModel = new AlbumModel($this->connection);
        $rows = $albumModel->getAllAlbums();
        $this->albums = array_map(function($r) {
            return [
                'title' => (string)$r['titlea'],
                'img' => AlbumModel::imageUrl((string)$r['imga']),
                'link' => (string)$r['linka']
            ];
        }, $rows);

        // Pagination
        $perPage = 5;
        $totalAlbums = count($this->albums);
        $this->totalPages = ceil($totalAlbums / $perPage);
        $this->page = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
        if ($this->page > $this->totalPages) $this->page = $this->totalPages;
        $start = ($this->page - 1) * $perPage;
        $this->pageAlbums = array_slice($this->albums, $start, $perPage);

        // ───────────── Random Song ─────────────
        $songModel = new SongModel($this->connection);
        $randomSong = $songModel->getRandomSong();
        if ($randomSong) {
            parse_str(parse_url($randomSong['url'], PHP_URL_QUERY), $yt_params);
            $this->randomVideoId = $yt_params['v'] ?? null;
        }
    }

    // Méthode pour inclure toutes les vues
    public function render() {
        require_once LAYOUT_PATH . '/head.php';
        require_once LAYOUT_PATH . '/header.php';
        require_once PAGES_PATH . '/accueil.php';
        require_once LAYOUT_PATH . '/footer.php';
    }
}
