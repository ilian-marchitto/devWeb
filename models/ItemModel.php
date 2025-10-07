<?php

class ItemModel {

    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    public function countUserAccount() {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users");
        $stmt->execute();
        $countUserAccount = $stmt->fetchColumn();
        return (int)$countUserAccount;
    }
}
