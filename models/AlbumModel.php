<?php
namespace Models;
require_once BASE_PATH . '/config.php';

class AlbumModel {

    private $connection;

    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    // ─────────────── CREATE ───────────────
    public function createAlbum(string $titlea, string $imga, string $linka): bool {
        $sql = "INSERT INTO albums (titlea, imga, linka)
                VALUES (:titlea, :imga, :linka)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':titlea' => $titlea,
            ':imga'   => $imga,
            ':linka'  => $linka
        ]);
    }

    // ─────────────── READ ───────────────
    public function getAlbumById(int $ida): ?array {
        $sql = "SELECT ida, titlea, imga, linka FROM albums WHERE ida = :ida";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':ida' => $ida]);
        $album = $stmt->fetch(PDO::FETCH_ASSOC);
        return $album ?: null;
    }

    public function getAllAlbums(): array {
        $sql = "SELECT ida, titlea, imga, linka FROM albums ORDER BY ida ASC";
        $stmt = $this->connection->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function imageUrl(string $path): string {
        $path = trim($path);
        if ($path === '') return '';
        if (preg_match('~^https?://~i', $path)) return $path;
        return IMAGES_URL . '/' . ltrim($path, '/');
    }

    // ─────────────── UPDATE ───────────────
    public function updateAlbum(int $ida, string $titlea, string $imga, string $linka): bool {
        $sql = "UPDATE albums
                SET titlea = :titlea, imga = :imga, linka = :linka
                WHERE ida = :ida";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':titlea' => $titlea,
            ':imga'   => $imga,
            ':linka'  => $linka,
            ':ida'    => $ida
        ]);
    }

    // ─────────────── DELETE ───────────────
    public function deleteAlbum(int $ida): bool {
        $sql = "DELETE FROM albums WHERE ida = :ida LIMIT 1";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([':ida' => $ida]);
    }
}