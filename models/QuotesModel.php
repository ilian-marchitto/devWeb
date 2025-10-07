<?php

require_once BASE_PATH . '/config.php';

class QuoteModel {
    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    // ─────────────── CREATE ───────────────
    public function createQuote(int $ids, string $quote): bool {
        $sql = "INSERT INTO quotes (ids, quote)
                VALUES (:ids, :quote)";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':ids'   => $ids,
            ':quote' => $quote
        ]);
    }

    // ─────────────── READ ───────────────
    public function getQuoteById(int $idq): ?array {
        $sql = "SELECT idq, ids, quote 
                FROM quotes 
                WHERE idq = :idq";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':idq' => $idq]);
        $quote = $stmt->fetch(PDO::FETCH_ASSOC);
        return $quote ?: null;
    }

    public function getQuotesBySongId(int $ids): array {
        $sql = "SELECT idq, ids, quote 
                FROM quotes 
                WHERE ids = :ids 
                ORDER BY idq ASC";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':ids' => $ids]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRandomQuotesBySongId(int $ids): array {
        $sql = "SELECT idq, ids, quote 
                FROM quotes 
                WHERE ids = :ids 
                ORDER BY RANDOM() 
                LIMIT 1";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':ids' => $ids]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllQuotes(): array {
        $sql = "SELECT idq, ids, quote 
                FROM quotes 
                ORDER BY idq ASC";
        $stmt = $this->connection->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ─────────────── UPDATE ───────────────
    public function updateQuote(int $idq, int $ids, string $quote): bool {
        $sql = "UPDATE quotes
                SET ids = :ids, quote = :quote
                WHERE idq = :idq";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([
            ':ids'   => $ids,
            ':quote' => $quote,
            ':idq'   => $idq
        ]);
    }

    // ─────────────── DELETE ───────────────
    public function deleteQuote(int $idq): bool {
        $sql = "DELETE FROM quotes 
                WHERE idq = :idq";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([':idq' => $idq]);
    }
}
