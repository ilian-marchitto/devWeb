<?php
// controllers/HeaderController.php

include CONTROLLERS_PATH . '/Builder.php';
session_start();

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
        $this->nav->addItemsLink("Communaute", "#communaute");
        $this->nav->addItemsLink("Description", "#description");
        $this->nav->addItemsLink("Albums", "#albums");
        $this->nav->addItemsLink("Actualite", "#actualite");

        // Logo (par exemple)
        $this-> font-> addItemPicture(IMAGES_URL . '/fontJul.png', '#', 'ImageFont', 'imageFont');
        // Bouton connexion / déconnexion
        if ($isLoggedIn) {
            $this->buttonHtml->addItemsLink("Se déconnecter", BASE_URL . '/index.php?page=logout');
        } else {
            $this->buttonHtml->addItemsLink("Se connecter", BASE_URL . '/index.php?page=seConnecter');
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

// Récupération des items à passer à la vue
$navItems = $header->getNavItems();
$buttonItems = $header->getButtonItems();
$FontItems = $header->getFontItems();

