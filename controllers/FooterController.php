<?php

require_once CONTROLLERS_PATH . '/Builder.php';
class FooterController extends Builder
{
    public function __construct()
    {
        $this->addItemPicture(IMAGES_URL . '/instagram.webp', "#");
        $this->addItemPicture(IMAGES_URL . '/css.webp', "#");
        $this->addItemPicture(IMAGES_URL . '/html.webp', "#");
        $this->addItemPicture(IMAGES_URL . '/planDuSite.webp', "#");
    }
}

$footer = new FooterController();


