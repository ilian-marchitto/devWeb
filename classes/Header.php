<?php
class Header extends MenuBuilder {

    public function __construct()
    {
        $this->addItemsLink("Communaute", "#communaute");
        $this->addItemsLink("Description", "#description");
        $this->addItemsLink("Albums", "#albums");
        $this->addItemsLink("Actualite", "#Actualite");
    }

}

?>