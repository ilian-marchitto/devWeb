<?php
class Footer extends MenuBuilder {

    public function __construct() {
        $this->addItemPicture("../assets/images/instagram.webp", "#communaute");
        $this->addItemPicture("../assets/images/css.webp", "#description");
        $this->addItemPicture("../assets/images/html.webp", "#albums");
        $this->addItemPicture("../assets/images/planDuSite.webp", "#Actualite");
    }

    public function render() {
        echo '<footer>';
        $this->show();
        echo '</footer>';
    }
}
?>
