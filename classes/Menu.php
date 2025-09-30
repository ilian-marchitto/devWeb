<?php
class Menu {
    private $items = [];

    public function addItem($name, $link) {
        $this->items[] = ['nom' => $name, 'lien' => $link];
    }

    public function showMenu() {
        echo '<ul>';
        foreach ($this->items as $item) {
            echo '<li><a href="' . $item['lien'] . '">' . $item['nom'] . '</a></li>';
        }
        echo '</ul>';
    }

    public function __construct () {
        $this->addItem("Communaute", "#communaute");
        $this->addItem("Description", "#description");
        $this->addItem("Albums", "#albums");
        $this->addItem("Actualite", "#Actualite");
    }
}
?>
