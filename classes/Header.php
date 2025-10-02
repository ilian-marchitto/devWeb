<?php
class Header extends MenuBuilder {

    public function render() {
        $nav = new MenuBuilder();
        $test = new MenuBuilder();

        $nav->addItemsLink("Communaute", "#communaute");
        $nav->addItemsLink("Description", "#description");
        $nav->addItemsLink("Albums", "#albums");
        $nav->addItemsLink("Actualite", "#Actualite");

        $test ->addItemPicture("../assets/images/iconUser.webp", "SeConnecter.php", "", "userIcon");

        echo "<nav> <ul>";
        foreach ($nav->items as $item) {
            echo "<li>" ;
            $nav->showOnce($item);
            echo "</li>";
        }

        echo "</ul>";
        $test -> showOnce($test -> items[0]);
        echo "</nav>";

    }
}

?>