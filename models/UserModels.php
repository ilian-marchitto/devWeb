<?php

class UserModel {
    private PDO $pdo;

    public function __construct(PDO $connection) {
        $this->pdo = $connection;
    }

    public function findByEmail(string $email): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function saveResetToken(string $email, string $token, string $expires): void {
        $stmt = $this->pdo->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?");
        $stmt->execute([$token, $expires, $email]);
    }

    public function findByToken(string $token): ?array {
        $stmt = $this->pdo->prepare("SELECT email, reset_expires FROM users WHERE reset_token = ? LIMIT 1");
        $stmt->execute([$token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function isTokenExpired(array $user): bool {
        return new DateTime() > new DateTime($user['reset_expires']);
    }

    public function updatePassword(string $email, string $password): void {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare(
            "UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE email = ?"
        );
        $stmt->execute([$hash, $email]);
    }
}

