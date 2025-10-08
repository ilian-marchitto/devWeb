<?php
namespace Models;
require_once BASE_PATH . '/config.php';

class SongModel {
    private $connection;
    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    // ─────────────── CREATE ───────────────
    public function createSong(string $title, string $url): bool {
        $sql = "INSERT INTO songs (title, url)
                VALUES (:title, :url)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':title' => $title,
            ':url'   => $url
        ]);
    }

    // ─────────────── READ ───────────────
    public function getSongById(int $ids): ?array {
        $sql = "SELECT ids, title, url 
                FROM songs 
                WHERE ids = :ids LIMIT 1";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':ids' => $ids]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getAllSongs(): array {
        $sql = "SELECT ids, title, url 
                FROM songs 
                ORDER BY ids ASC";
        $stmt = $this->connection->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ─────────────── UPDATE ───────────────
    public function updateSong(int $ids, string $title, string $url): bool {
        $sql = "UPDATE songs 
                SET title = :title, url = :url 
                WHERE ids = :ids LIMIT 1";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':title' => $title,
            ':url'   => $url,
            ':ids'   => $ids
        ]);
    }

    // ─────────────── DELETE ───────────────
    public function deleteSong(int $ids): bool {
        $sql = "DELETE FROM songs WHERE ids = :ids LIMIT 1";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([':ids' => $ids]);
    }

    public function getRandomSong(): ?array {
        $sql = "SELECT ids, title, url 
            FROM song
            ORDER BY RAND() 
            LIMIT 1";
        $stmt = $this->connection->query($sql);
        $song = $stmt->fetch(PDO::FETCH_ASSOC);
        return $song ?: null;
    }


}
