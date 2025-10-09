<?php
namespace controllers;
use PDO;
use PDOException;
require BASE_PATH . '/vendor/PHPMailer/src/PHPMailer.php';
require BASE_PATH . '/vendor/PHPMailer/src/Exception.php';
require BASE_PATH . '/vendor/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


class SeConnecterController
{
    private PDO $connection;
    private string $mailHost;
    private string $mailUsername;
    private string $mailPwd;
    public $head;
    public $pageTitle;
    public $pageDescription;
    public $pageKeywords;
    public $pageCss;
    public $pageAuthor;



    public function __construct(PDO $connection)
    {
        global $mailHost, $mailUsername, $mailPwd;
        $this->connection = $connection;
        $this->mailHost = $mailHost;
        $this->mailUsername = $mailUsername;
        $this->mailPwd = $mailPwd;

        ToggleButtonController::handleThemeToggle();
        $styleDynamique = ToggleButtonController::getActiveStyle();

        // ==========================
        // Variables spécifiques à la page
        // ==========================
        $this->pageTitle = "Se connecter";
        $this->pageDescription = "Site officiel des auteurs ACH Sofia, ARFI Maxime, BURBECK Heather et MARCHITTO Ilian. Connectez-vous pour découvrir la communauté, les albums et l'actualité.";
        $this->pageKeywords = "Fan2Jul, ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian, communauté, connexion";
        $this->pageAuthor = "ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian";
        $this->pageCss = ["seConnecter.css", $styleDynamique];
        $this->head = new HeadController($this->pageTitle, $this->pageDescription, $this->pageKeywords, $this->pageAuthor, $this->pageCss);

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
                $code = (string) random_int(100000, 999999);
                $_SESSION['2fa_code'] = $code;
                $_SESSION['2fa_user'] = $user;
                $_SESSION['2fa_expires'] = time() + 600;

                //PHPMailer
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = $this->mailHost;
                    $mail->SMTPAuth = true;
                    $mail->Username = $this->mailUsername;
                    $mail->Password = $this->mailPwd;
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    $mail->setFrom($this->mailUsername, 'fan2jul');
                    $mail->addAddress($identifiant);

                    $mail->isHTML(true);
                    $mail->Subject = "Ton code de vérification";
                    $mail->Body = "Bonjour,<br><br>Ton code de vérification est le suivant :<br>
                           <b>$code</b><br><br>Ce code expire dans 10 minutes.<br>
                           Si tu n'as pas demandé cette opération, ignore ce message.";;
                    $mail->send();

                    header("Location:" . BASE_URL . "/index.php?page=second_authenticator");
                    exit;
                } catch (Exception $e) {
                    $error = "Erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
                }
            }
            else {
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
        header("Location: " . BASE_URL . "/index.php?page=se_connecter");
        exit;
    }

    public function render(): void{
        $vars = get_object_vars($this);
        extract($vars);

        require_once LAYOUT_PATH . '/head.php';
        require_once PAGES_PATH . '/seConnecter.php';
    }
}
