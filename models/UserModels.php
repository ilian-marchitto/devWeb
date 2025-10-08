<?php
namespace Models;
require_once BASE_PATH . '/config.php';

class UserModels {

    private $connection;
    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    // ─────────────── CREATE ───────────────
    public function createUser(string $firstname, string $lastname, string $email, string $password, int $song_id): bool {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (firstname, lastname, email, password, song_id)
                VALUES (:firstname, :lastname, :email, :password, :song_id)";
        $stmt = $this->connection->prepare($sql);

        return $stmt->execute([
            ':firstname' => $firstname,
            ':lastname'  => $lastname,
            ':email'     => $email,
            ':password'  => $hashedPassword,
            ':song_id'   => $song_id
        ]);
    }

    // ─────────────── READ ───────────────
    public function getUserByEmail(string $email): ?array {
        $sql = "SELECT idu, firstname, lastname, email, password, song_id
                FROM users WHERE email = :email";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function getUserById(int $idu): ?array {
        $sql = "SELECT idu, firstname, lastname, email, song_id
                FROM users WHERE idu = :idu";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':idu' => $idu]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function getAllUsers(): array {
        $sql = "SELECT idu, firstname, lastname, email, song_id FROM users ORDER BY idu ASC";
        $stmt = $this->connection->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ─────────────── UPDATE ───────────────
    public function updateUser(int $idu, string $firstname, string $lastname, ?string $password = null, ?int $song_id = null): bool {
        if ($password) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET firstname = :firstname, lastname = :lastname, password = :password, song_id = :song_id WHERE idu = :idu";
            $params = [
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':password' => $hashed,
                ':idu' => $idu,
                ':song_id' => $song_id
            ];
        } else {
            $sql = "UPDATE users SET firstname = :firstname, lastname = :lastname, song_id = :song_id WHERE idu = :idu";
            $params = [
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':idu' => $idu,
                ':song_id' => $song_id
            ];
        }

        $stmt = $this->connection->prepare($sql);
        return $stmt->execute($params);
    }

    // ─────────────── DELETE ───────────────
    public function deleteUser(int $idu): bool {
        $sql = "DELETE FROM users WHERE idu = :idu LIMIT 1";
        $stmt = $this->connection->prepare($sql);
        return $stmt->execute([':idu' => $idu]);
    }

    // ─────────────── Password Reset ───────────────
    public function findByEmail(string $email): ?array {
        $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function saveResetToken(string $email, string $token, string $expires): void {
        $stmt = $this->connection->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?");
        $stmt->execute([$token, $expires, $email]);
    }

    public function findByToken(string $token): ?array {
        $stmt = $this->connection->prepare("SELECT email, reset_expires FROM users WHERE reset_token = ? LIMIT 1");
        $stmt->execute([$token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function isTokenExpired(array $user): bool {
        return new DateTime() > new DateTime($user['reset_expires']);
    }

    public function updatePassword(string $email, string $password): void {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->connection->prepare(
            "UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE email = ?"
        );
        $stmt->execute([$hash, $email]);
    }

    public function countUserAccount() {
        $stmt = $this->connection->prepare("SELECT COUNT(*) FROM users");
        $stmt->execute();
        $countUserAccount = $stmt->fetchColumn();
        return (int)$countUserAccount;
    }


}