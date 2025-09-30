<?php
class Footer {
    private $items = [];

    public function addItem($picture, $link) {
        $this->items[] = ['image' => $picture, 'lien' => $link];
    }

    public function showImages() {
        foreach ($this->items as $item) {
            if (isset($item['image']) && isset($item['lien'])) {
                echo '<a href="' . $item['lien'] . '">';
                echo '<img src="' . $item['image'] . '" alt="">';
                echo '</a>';
            }
        }
    }

    public function __construct() {
        $this->addItem("Communaute", "#communaute");
        $this->addItem("Description", "#description");
        $this->addItem("Albums", "#albums");
        $this->addItem("Actualite", "#Actualite");
    }

    public function render() {
        echo '<footer>';
        $this->showImages();
        echo '</footer>';
    }
}
?>
