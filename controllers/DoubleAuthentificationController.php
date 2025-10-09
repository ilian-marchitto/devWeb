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

    public function __construct(PDO $connection)
    {

        $this->connection = $connection;

        ToggleButtonController::handleThemeToggle();
        $this->styleDynamique = ToggleButtonController::getActiveStyle();

        // ==========================
        // Métadonnées de la page
        // ==========================
        $this->pageTitle = "Double authentification";
        $this->pageDescription = "Site officiel des auteurs ACH Sofia, ARFI Maxime, BURBECK Heather et MARCHITTO Ilian. Nous utilisons une méthode de double authentification pour une meilleure sécurité.";
        $this->pageKeywords = "Fan2Jul, ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian, communauté, double authentification";
        $this->pageAuthor = "ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian";
        $this->pageCss = ["seConnecter.css", $this->styleDynamique];
        $this->head = new HeadController($this->pageTitle, $this->pageDescription, $this->pageKeywords, $this->pageAuthor, $this->pageCss);

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

        $this->success = "Le code de vérification a bien été envoyé.";
        $userMaker = new UserModels($this->connection);
        $this->erreur = null;

        // ==========================
        // Traitement du formulaire
        // ==========================
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $code_saisi = $_POST["code"];

            if (time() > $_SESSION['2fa_expires']) {
                unset($_SESSION['2fa_code']);
                $this->erreur = "Code expiré";
            } elseif ($code_saisi === $_SESSION['2fa_code'] && !isset($_SESSION['Register'])) {
                $this->handleLoginVerification();
            } elseif ($code_saisi === $_SESSION['2fa_code'] && isset($_SESSION['Register'])) {
                $this->handleRegisterVerification($userMaker);
            } else {
                $this->erreur = "Code incorrect";
            }
        }
    }

    private function handleLoginVerification(): void
    {
        $user = $_SESSION['2fa_user'];
        session_regenerate_id(true);
        $_SESSION["user_id"]   = $user["idu"];
        $_SESSION["email"]     = $user["email"];
        $_SESSION["firstname"] = $user["firstname"];

        unset($_SESSION['2fa_code'], $_SESSION['2fa_user']);

        header("Location:" . BASE_URL . "/index.php?page=bienvenue");
        exit;
    }

    private function handleRegisterVerification(UserModels $userMaker): void
    {
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

    public function render(): void
    {
        $vars = get_object_vars($this);
        extract($vars);

        require_once LAYOUT_PATH . '/head.php';
        include PAGES_PATH . '/doubleAuthentification.php';
    }
}