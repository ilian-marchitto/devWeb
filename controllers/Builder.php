<?php

namespace controllers;
class Builder
{
    private $items = [];

    public function getItems(): array {
        return $this->items;
    }

    public function addItemsLink($name, $link, $class = null)
    {
        $this->items[] = [
            'nom' => $name,
            'lien' => $link,
            'class' => $class
        ];
    }

    public function addItemPicture($picturePath, $link, $description = null, $class = null)
    {
        $this->items[] = [
            'image' => $picturePath,
            'lien' => $link,
            'class' => $class,
            'description' => $description
        ];
    }

    // ✅ Getter pour récupérer les items

    // ✅ Affiche un seul élément
    public function showOnce($item)
    {
        if (!empty($item['lien']) && !empty($item['nom'])) {
            echo '<a href="' . $item['lien'] . '" class="' . ($item['class'] ?? '') . '">' . $item['nom'] . '</a>';
        } elseif (!empty($item['image']) && !empty($item['lien'])) {
            echo '<a href="' . $item['lien'] . '" class="' . ($item['class'] ?? '') . '">';
            echo '<img src="' . $item['image'] . '" alt="' . ($item['description'] ?? '') . '">';
            echo '</a>';
        }
    }

    // ✅ Affiche tous les éléments
    public function showAll()
    {
        foreach ($this->items as $item) {
            $this->showOnce($item);
        }
    }
}

?>
