<?php

require_once LAYOUT_PATH . '/MenuBuilder.php';
$isLoggedIn = isset($_SESSION['user']);
class Header extends MenuBuilder {
    private MenuBuilder $nav;
    public function __construct() {

        $this->nav = new MenuBuilder();

        // Menu de navigation
        $this->nav->addItemsLink("Communaute", "#communaute");
        $this->nav->addItemsLink("Description", "#description");
        $this->nav->addItemsLink("Albums", "#albums");
        $this->nav->addItemsLink("Actualite", "#Actualite");

        // Logo et icône utilisateur
        $this->addItemPicture(IMAGES_URL . '/fontJul.png', "#", "", "imageFont");
        $this->addItemPicture(IMAGES_URL . '/iconUser.webp', BASE_URL . '/index.php?page=seConnecter', "", "userIcon");
    }

    public function render() {
        echo "<header>";

        // Menu principal
        echo "<nav><ul>";
        foreach ($this->nav->items as $item) {
            echo "<li>";
            $this->nav->showOnce($item);
            echo "</li>";
        }
        echo "</ul></nav>";

        // Logo et icône utilisateur
        foreach ($this->items as $item) {
            $this->showOnce($item);
        }

        echo "</header>";
    }
}
?>
