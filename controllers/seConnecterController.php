<?php
session_start();

require_once  BASE_PATH . '/config.php';

$_SESSION['erreur'] = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $identifiant = trim($_POST["identifiant"]);
    $mot_de_passe = $_POST["mot_de_passe"] ?? '';

    if ($identifiant !== '' && $mot_de_passe !== '') {
        try {
            $sql = "SELECT idu , email, firstname, password 
                FROM users 
                WHERE email = :email 
                LIMIT 1";

            $stmt = $connection->prepare($sql);
            $stmt->execute([':email' => $identifiant]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($mot_de_passe, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION["user_id"]   = $user["idu"];
                $_SESSION["email"]     = $user["email"];
                $_SESSION["firstname"] = $user["firstname"];

                header("Location:". BASE_URL . "/index.php?page=bienvenue");
                exit;
            } else {
                $_SESSION['erreur'] = "Identifiant ou mot de passe incorrect.";
                header("Location:". BASE_URL . "index.php?page=seConnecter");
                exit;
            }
        } catch (PDOException $e) {
            $_SESSION['erreur'] = "Erreur lors de la connexion : " . $e->getMessage();
            header("Location:". BASE_URL . "index.php?page=seConnecter");
            exit;
        }
    } else {
        $_SESSION['erreur'] = "Veuillez remplir tous les champs.";
        header("Location:". BASE_URL . "index.php?page=seConnecter");
        exit;
    }
}
?>