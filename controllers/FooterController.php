<?php

namespace controllers;

class FooterController extends Builder
{
    private ?string $quoteA = null;
    private ?string $quoteB = null;

    public function __construct($connection)
    {
        // Logos existants
        $this->addItemPicture(IMAGES_URL . '/instagram.webp', "#");
        $this->addItemPicture(IMAGES_URL . '/css.webp', "#");
        $this->addItemPicture(IMAGES_URL . '/html.webp', "#");
        $this->addItemPicture(IMAGES_URL . '/planDuSite.webp', BASE_URL . '/index.php?page=plan_du_site');

        // Si un PDO est fourni et qu'un user est connecté, on récupère ses citations
        if ($connection && !empty($_SESSION['email'])) {
            // 1) récupérer l'id de la chanson préférée
            $stmt = $connection->prepare("SELECT song_id FROM users WHERE email = :email LIMIT 1");
            $stmt->execute([':email' => $_SESSION['email']]);
            $songId = $stmt->fetchColumn();

            if ($songId) {
                // 2) récupérer 2 citations (ordre par idq)
                $q = $connection->prepare("SELECT quote FROM quotes WHERE ids = :ids ORDER BY idq ASC LIMIT 2");
                $q->execute([':ids' => $songId]);
                $quotes = $q->fetchAll(PDO::FETCH_COLUMN);

                $this->quoteA = $quotes[0] ?? null;
                $this->quoteB = $quotes[1] ?? null;
            }
        }
    }

    public function getQuotes(): array
    {
        return [$this->quoteA, $this->quoteB];
    }
}


