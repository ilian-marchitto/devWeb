<?php

class AlbumModel {
    private PDO $pdo;

    public function __construct(PDO $connection) {
        $this->pdo = $connection;
    }

    public function getAllAlbums(): array {
        $stmt = $this->pdo->prepare("SELECT * FROM albums ORDER BY idalbum ASC");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows ?: [];
    }

      public static function imageUrl(string $path): string {
        $path = trim($path);
        if ($path === '') return '';
        if (preg_match('~^https?://~i', $path)) return $path;
        return IMAGES_URL . '/' . ltrim($path, '/');
    }

}
