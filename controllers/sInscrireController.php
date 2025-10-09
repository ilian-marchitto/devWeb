<?php
namespace App\Controllers;

class SInscrireController
{
    public static function register($connection)
    {
        session_start();

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            return;
        }

        $firstname = trim($_POST["firstname"] ?? '');
        $lastname  = trim($_POST["lastname"] ?? '');
        $email     = trim($_POST["email"] ?? '');
        $password  = $_POST["password"] ?? '';
        $song_id   = $_POST["song_id"] ?? null;

        // Vérification des champs obligatoires
        if (empty($firstname) || empty($lastname) || empty($email) || empty($password)) {
            $_SESSION['erreur'] = "Tous les champs sont obligatoires.";
            header("Location: " . BASE_URL . "/index.php?page=sInscrire");
            exit;
        }

        // Vérifier si l'email existe déjà
        $stmt = $connection->prepare("SELECT 1 FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);

        if ($stmt->fetch()) {
            $_SESSION['erreuremail'] = "Email déjà utilisé.";
            header("Location: " . BASE_URL . "/index.php?page=sInscrire");
            exit;
        }

        // Création du compte
        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (firstname, lastname, email, password, song_id)
                      VALUES (:firstname, :lastname, :email, :password, :song_id)";
            $requete = $connection->prepare($query);
            $requete->execute([
                'firstname' => $firstname,
                'lastname'  => $lastname,
                'email'     => $email,
                'password'  => $hash,
                'song_id'   => $song_id
            ]);

            $_SESSION["firstname"] = $firstname;
            $_SESSION["email"] = $email;

            header("Location: " . BASE_URL . "/index.php?page=bienvenue");
            exit;
        } catch (\PDOException $e) {
            $_SESSION['erreur'] = "Erreur d'inscription : " . $e->getMessage();
            header("Location: " . BASE_URL . "/index.php?page=sInscrire");
            exit;
        }
    }
}
