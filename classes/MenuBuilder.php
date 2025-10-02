<?php
class MenuBuilder {
    private $items = [];

    public function addItemsLink($name, $link) {
        $this->items[] = ['nom' => $name, 'lien' => $link];
    }

    public function addItemPicture($picture, $link, $description = null) {
        $item = [
            'image' => $picture,
            'lien'  => $link
        ];

        if ($description !== null) {
            $item['description'] = $description;
        }
        $this->items[] = $item;
    }


    public function show() {
        echo '<ul>';

        foreach ($this->items as $item) {

            // Cas lien texte
            if (!empty($item['lien']) && !empty($item['nom'])) {
                echo '<li>';
                echo '<a href="' . $item['lien'] . '">' . $item['nom'] . '</a>';
                echo '</li>';

                // Cas image sans description
            } elseif (!empty($item['image']) && !empty($item['lien']) && empty($item['description'])) {
                echo '<li>';
                echo '<a href="' . $item['lien'] . '">';
                echo '<img src="' . $item['image'] . '" alt="">';
                echo '</a>';
                echo '</li>';
            }

            // Cas image avec description → pas dans <li>
            elseif (!empty($item['image']) && !empty($item['lien']) && !empty($item['description'])) {
                echo '<a href="' . $item['lien'] . '">';
                echo '<figure>';
                echo '<img src="' . $item['image'] . '" alt="">';
                echo '<figcaption>' . $item['description'] . '</figcaption>';
                echo '</figure>';
                echo '</a>';
            }
        }

        echo '</ul>';
    }


}
?>
