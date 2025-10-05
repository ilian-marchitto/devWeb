<?php

class MenuBuilder
{
    protected $items = [];

    public function addItemsLink($name, $link, $class = null)
    {

        $this->items[] = ['nom' => $name, 'lien' => $link, 'class' => $class];
    }

    public function addItemPicture($picturePath, $link, $description = null, $class = null)
    {
        $item = [
            'image' => $picturePath,
            'lien' => $link,
            'class' => $class,
            'description' => $description
        ];

        $this->items[] = $item;
    }

    public function showOnce($items)
    {
        if (!empty($items['lien']) && !empty($items['nom'])) {
            echo '<a href="' . $items['lien'] . '" class="' . ($items['class'] ?? '') . '">' . $items['nom'] . '</a>';
        } elseif (!empty($items['image']) && !empty($items['lien'])) {
            echo '<a href="' . $items['lien'] . '" class="' . ($items['class'] ?? '') . '">';
            echo '<img src="' . $items['image'] . '" alt="">';
            echo '</a>';
        }
    }

    public function showAll()
    {

        foreach ($this->items as $item) {

            if (!empty($item['lien']) && !empty($item['nom'])) {
                echo '<a href="' . $item['lien'] . '">' . $item['nom'] . '</a>';

            } elseif (!empty($item['image']) && !empty($item['lien']) && empty($item['description'])) {
                echo '<a href="' . $item['lien'] . '">';
                echo '<img src="' . $item['image'] . '" alt="">';
                echo '</a>';
            }

        }
    }


}

?>
