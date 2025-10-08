<?php
// controllers/HeaderController.php

include CONTROLLERS_PATH . '/Builder.php';
require_once  CONTROLLERS_PATH .'/toggleButtonController.php';

$isLoggedIn = isset($_SESSION['email']);

class HeaderController
{
    private Builder $font;
    private Builder $nav;
    private Builder $buttonHtml;

    public function __construct(bool $isLoggedIn)
    {
        $this -> font = new Builder();
        $this->nav = new Builder();
        $this->buttonHtml = new Builder();

        // Liens de nav
        $this->nav->addItemsLink("Communaute", "#Communaute");
        $this->nav->addItemsLink("Description", "#Description");
        $this->nav->addItemsLink("Albums", "#Albums");
        $this->nav->addItemsLink("Actualite", "#Actualite");

        // Logo (par exemple)
        $this-> font-> addItemPicture(IMAGES_URL . '/fontDeJul.webp', '#', 'ImageFont', 'imageFontDesktop');
        $this-> font-> addItemPicture(IMAGES_URL . '/fontJulMobile.png', '#', 'ImageFont', 'imageFontMobile');
        $this -> font -> addItemPicture(IMAGES_URL.'/iconFleche.png', '#Communaute', 'Icon Fleche', 'iconFleche');
        // Bouton connexion / déconnexion
        if ($isLoggedIn) {
            $this->buttonHtml->addItemsLink("Se déconnecter", BASE_URL . '/index.php?page=logout');
        } else {
            $this->buttonHtml->addItemsLink("Se connecter", BASE_URL . '/index.php?page=seConnecter');
            $this->buttonHtml->addItemsLink("S'inscrire", BASE_URL . '/index.php?page=sInscrire');
        }
    }

    // getters -> on expose les objets Builder (et headerItems si besoin)
    public function getNavItems(): Builder {
        return $this->nav;
    }

    public function getButtonItems(): Builder {
        return $this->buttonHtml;
    }

    public function getFontItems(): Builder {
        return $this -> font;
    }
}

$header = new HeaderController($isLoggedIn);
$toggleButton = new toggleButtonController();

// Récupération des items à passer à la vue
$navItems = $header->getNavItems();
$buttonItems = $header->getButtonItems();
$FontItems = $header->getFontItems();

