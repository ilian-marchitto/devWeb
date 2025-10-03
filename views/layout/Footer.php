<?php
class Footer extends MenuBuilder {

    public function __construct() {
        $this->addItemPicture(IMAGES_URL . '/instagram.webp', "#communaute");
        $this->addItemPicture(IMAGES_URL . '/css.webp', "#description");
        $this->addItemPicture(IMAGES_URL . '/html.webp', "#albums");
        $this->addItemPicture(IMAGES_URL . '/planDuSite.webp', "#Actualite");
    }

    public function render() {
        echo '<footer>';
        $this->showAll();
        echo '</footer>';
    }
}
?>
