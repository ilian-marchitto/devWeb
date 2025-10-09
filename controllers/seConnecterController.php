<?php
session_start();

require_once BASE_PATH . '/config.php';
require_once CONTROLLERS_PATH . '/HeadController.php';
require_once CONTROLLERS_PATH . '/toggleButtonController.php';

class SeConnecterController
{
    private PDO $connection;
    private HeadController $head;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function handleRequest(): void
    {
        toggleButtonController::handleThemeToggle();
        $styleDynamique = toggleButtonController::getActiveStyle();

        // ==========================
        // Variables spécifiques à la page
        // ==========================
        $pageTitle = "Se connecter";
        $pageDescription = "Site officiel des auteurs ACH Sofia, ARFI Maxime, BURBECK Heather et MARCHITTO Ilian. Connectez-vous pour découvrir la communauté, les albums et l'actualité.";
        $pageKeywords = "Fan2Jul, ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian, communauté, connexion";
        $pageAuthor = "ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian";
        $pageCss = ["seConnecter.css", $styleDynamique];

        // ==========================
        // Contrôleur Head
        // ==========================
        $this->head = new HeadController($pageTitle, $pageDescription, $pageKeywords, $pageAuthor, $pageCss);

        // Affiche la page
        require_once LAYOUT_PATH . '/head.php';
        require_once PAGES_PATH . '/seConnecter.php';

        // Si le formulaire est soumis
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->processLogin();
        }
    }

    private function processLogin(): void
    {
        $_SESSION['erreur'] = "";

        $identifiant = trim($_POST["identifiant"] ?? '');
        $mot_de_passe = $_POST["mot_de_passe"] ?? '';

        if ($identifiant === '' || $mot_de_passe === '') {
            $_SESSION['erreur'] = "Veuillez remplir tous les champs.";
            $this->redirectToLogin();
        }

        try {
            $sql = "SELECT idu, email, firstname, password FROM users WHERE email = :email LIMIT 1";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([':email' => $identifiant]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($mot_de_passe, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION["user_id"]   = $user["idu"];
                $_SESSION["email"]     = $user["email"];
                $_SESSION["firstname"] = $user["firstname"];

                header("Location: " . BASE_URL . "/index.php?page=bienvenue");
                exit;
            } else {
                $_SESSION['erreur'] = "Identifiant ou mot de passe incorrect.";
                $this->redirectToLogin();
            }
        } catch (PDOException $e) {
            $_SESSION['erreur'] = "Erreur lors de la connexion : " . $e->getMessage();
            $this->redirectToLogin();
        }
    }

    private function redirectToLogin(): void
    {
        header("Location: " . BASE_URL . "/index.php?page=seConnecter");
        exit;
    }
}