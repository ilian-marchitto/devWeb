<?php

use Couchbase\User;

class Header extends MenuBuilder {

    public function render() {
        $nav = new MenuBuilder();
        $font = new MenuBuilder();
        $user = new MenuBuilder();

        $nav->addItemsLink("Communaute", "#communaute");
        $nav->addItemsLink("Description", "#description");
        $nav->addItemsLink("Albums", "#albums");
        $nav->addItemsLink("Actualite", "#Actualite");
        $font -> addItemPicture(    IMAGES_URL . '/fontJul.png', 
                                    "#", 
                                    "", 
                                    "imageFont");
        $user ->addItemPicture(     IMAGES_URL . '/iconUser.webp', 
                                    BASE_URL . '/index.php?page=seConnecter', 
                                    '',
                                    'userIcon');
        echo "<header>";
        echo "<nav> <ul>";
        foreach ($nav->items as $item) {
            echo "<li>" ;
            $nav->showOnce($item);
            echo "</li>";
        }

        echo "</ul>";
        echo "</nav>";
        $user -> showOnce($user -> items[0]);
        $font -> showOnce($font -> items[0]);
        echo "</header>";

    }
}

?>