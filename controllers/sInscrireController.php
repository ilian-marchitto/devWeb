<?php
require_once BASE_PATH . '/local.php';

session_start();

// Vérification de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $song_id = $_POST["song_id"];

    // Vérification de l'unicité de l'email
    $stmt = $connection->prepare("SELECT email FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $existant = $stmt->fetchAll();

    $unique = true;
    foreach ($existant as $row) {
        if ($row['email'] === $email) {
            $unique = false;
            $_SESSION['erreuremail'] = 'Email déjà utilisé';
            header("Location:". BASE_URL . "/index.php?page=sInscrire");
            exit;
        }
    }

    // Création du compte si unique
    if ($unique) {
        $hash = password_hash($password, PASSWORD_DEFAULT); // Sécurisation du mot de passe

        $query = "INSERT INTO users (firstname, lastname, email, password, song_id) VALUES (:firstname, :lastname, :email, :password, :song_id)";
        $requete = $connection->prepare($query);

        try {
            $requete->execute([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'password' => $hash,
                'song_id' => $song_id
            ]);

            $_SESSION["firstname"] = $firstname;
            $_SESSION["email"] = $email;
            header("Location:" . BASE_URL . "/index.php?page=bienvenue");
            exit;
        } catch (PDOException $e) {
            echo "Erreur d'insertion : " . $e->getMessage();
            header("Location:". BASE_URL . "/index.php?page=sInscrire");
            exit;
        }
    }
}
?>
