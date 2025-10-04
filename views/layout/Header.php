<?php


require_once LAYOUT_PATH . '/MenuBuilder.php';
$isLoggedIn = isset($_SESSION['user']);
class Header extends MenuBuilder {

    private MenuBuilder $nav;
    private MenuBuilder $buttonHtml;
    private bool $isLoggedIn;
    public function __construct($isLoggedIn) {
        $this->nav = new MenuBuilder(); //ELements present dans la nav bar
        $this->buttonHtml = new MenuBuilder(); // Buttons SeConnecter / Deconnecter

        $this->nav->addItemsLink("Communaute", "#communaute");
        $this->nav->addItemsLink("Description", "#description");
        $this->nav->addItemsLink("Albums", "#albums");
        $this->nav->addItemsLink("Actualite", "#Actualite");

        $this->addItemPicture(IMAGES_URL . '/fontJul.png', "#", "", "imageFont");
        if ($isLoggedIn) {
            $this -> buttonHtml ->addItemsLink("Se déconnecter", BASE_URL . '/index.php?page=logout');
        } else {
            $this -> buttonHtml ->addItemsLink("Se connecter", BASE_URL . '/index.php?page=seConnecter');
        }


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

        // Logo et autres items
        foreach ($this->items as $item) {
            $this->showOnce($item);
        }

        // Dropdown utilisateur
        echo '<div class="user-dropdown">';
        echo '<input type="checkbox" id="toggleUser" class="toggle-checkbox">';
        echo '<label for="toggleUser">';
        echo '<img src="' . IMAGES_URL . '/iconUser.webp" alt="Image de connexion" class="login-image">';
        echo '</label>';
        echo '<div class="dropdown-content" id="dropdownContent">';
        foreach ($this->buttonHtml->items as $item) {
            $this->buttonHtml->showOnce($item);
        }
        echo '</div></div>';

        echo "</header>";
    }
}