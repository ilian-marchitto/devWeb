<?php
require_once BASE_PATH . '/config.php';
require_once CONTROLLERS_PATH . '/HeadController.php';
require_once CONTROLLERS_PATH .'/toggleButtonController.php';

toggleButtonController::handleThemeToggle();
$styleDynamique = toggleButtonController::getActiveStyle();

// ==========================
// Variables spécifiques à la page
// ==========================


$pageTitle = "S'inscrire";
$pageDescription = "Site officiel des auteurs ACH Sofia, ARFI Maxime, BURBECK Heather et MARCHITTO Ilian. Inscrivez vous sur notre site.";
$pageKeywords = "Fan2Jul, ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian, communauté,inscription";
$pageAuthor = "ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian";
$pageCss = ["seConnecter.css",$styleDynamique]; // Fichier CSS spécifique à la page

// ==========================
// Contrôleur Head
// ==========================
$head = new HeadController($pageTitle, $pageDescription, $pageKeywords, $pageAuthor, $pageCss);

require_once LAYOUT_PATH . '/head.php';
require_once PAGES_PATH . '/sInscrire.php';



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
