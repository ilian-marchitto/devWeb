<?php

require_once CONTROLLERS_PATH . '/Builder.php';
class FooterController extends Builder
{

    public function __construct()
    {
        $this->addItemPicture(IMAGES_URL . '/instagram.webp', "#communaute");
        $this->addItemPicture(IMAGES_URL . '/css.webp', "#description");
        $this->addItemPicture(IMAGES_URL . '/html.webp', "#albums");
        $this->addItemPicture(IMAGES_URL . '/planDuSite.webp', "#Actualite");
    }
}


// Créer l’instance de Footer
$footer = new FooterController();

require_once LAYOUT_PATH . '/footer.php';
