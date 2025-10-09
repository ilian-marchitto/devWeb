<?php

namespace controllers;

use PDO;
use models\UserModels;

class DoubleAuthentificationController
{
    public $head;
    public $pageTitle;
    public $pageDescription;
    public $pageKeywords;
    public $pageCss;
    public $pageAuthor;

    public function __construct($connection)
    {

        $this->connection = $connection;

        ToggleButtonController::handleThemeToggle();
        $this->styleDynamique = ToggleButtonController::getActiveStyle();

        // ==========================
        // Métadonnées de la page
        // ==========================
        $pageTitle = "Double authentification";
        $pageDescription = "Site officiel des auteurs ACH Sofia, ARFI Maxime, BURBECK Heather et MARCHITTO Ilian. Nous utilisons une méthode de double authentification pour une meilleure sécurité.";
        $pageKeywords = "Fan2Jul, ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian, communauté, double authentification";
        $pageAuthor = "ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian";
        $pageCss = ["seConnecter.css", $this->styleDynamique];
        $this->head = new HeadController($pageTitle, $pageDescription, $pageKeywords, $pageAuthor, $pageCss);

        // ==========================
        // Vérifications d’accès
        // ==========================
        if (!isset($_SESSION['2fa_code']) && !isset($_SESSION['Register'])) {
            header("Location:" . BASE_URL . "index.php?page=se_connecter");
            exit;
        }

        if (!isset($_SESSION['2fa_code']) && isset($_SESSION['Register'])) {
            header("Location:" . BASE_URL . "index.php?page=s_inscrire");
            exit;
        }

        $success = "Le code de vérification a bien été envoyé.";
        $userMaker = new UserModels($this->connection);
        $erreur = null;

        // ==========================
        // Traitement du formulaire
        // ==========================
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $code_saisi = trim($_POST["code"]);

            if (time() > $_SESSION['2fa_expires']) {
                unset($_SESSION['2fa_code']);
                $erreur = "Code expiré";
            } elseif (!isset($_SESSION['Register'])) {
                $erreur = $this->handleLoginVerification($code_saisi);
            } else {
                $erreur = $this->handleRegisterVerification($code_saisi, $userMaker);
            }
        }
    }

    private function handleLoginVerification(string $code_saisi): ?string
    {
        if ($code_saisi === $_SESSION['2fa_code']) {
            $user = $_SESSION['2fa_user'];
            session_regenerate_id(true);
            $_SESSION["user_id"]   = $user["idu"];
            $_SESSION["email"]     = $user["email"];
            $_SESSION["firstname"] = $user["firstname"];

            unset($_SESSION['2fa_code'], $_SESSION['2fa_user']);

            header("Location:" . BASE_URL . "index.php?page=bienvenue");
            exit;
        }

        return "Code incorrect.";
    }

    private function handleRegisterVerification(string $code_saisi, UserModels $userMaker): ?string
    {
        if ($code_saisi === $_SESSION['2fa_code']) {
            $firstname = $_SESSION["firstname"];
            $lastname  = $_SESSION["lastname"];
            $email     = $_SESSION["email"];
            $password  = $_SESSION["password"];
            $song_id   = $_SESSION["song_id"];

            session_unset();
            $_SESSION = [];
            session_regenerate_id(true);

            try {
                $userMaker->createUser($firstname, $lastname, $email, $password, $song_id);

                $_SESSION["firstname"] = $firstname;
                $_SESSION["email"] = $email;
                header("Location:" . BASE_URL . "/index.php?page=bienvenue");
                exit;
            } catch (PDOException $e) {
                echo "Erreur d'insertion : " . $e->getMessage();
                header("Location:" . BASE_URL . "/index.php?page=s_inscrire");
                exit;
            }
        }

        return "Code incorrect ou expiré.";
    }

    public function render(): void
    {
        $vars = get_object_vars($this);
        extract($vars);

        require_once LAYOUT_PATH . '/head.php';
        include PAGES_PATH . '/doubleAuthentification.php';
    }
}