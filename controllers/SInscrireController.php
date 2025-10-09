<?php
namespace controllers;
use PDO;
use PDOException;
require PHPMAILER_PATH . '/PHPMailer.php';
require PHPMAILER_PATH . '/Exception.php';
require PHPMAILER_PATH . '/SMTP.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class SInscrireController
{
    private string $styleDynamique;
    private string $mailHost;
    private string $mailUsername;
    private string $mailPwd;
    public $head;
    public $pageTitle;
    public $pageDescription;
    public $pageKeywords;
    public $pageCss;
    public $pageAuthor;

    public function __construct($connection)
    {
        global $mailHost, $mailUsername, $mailPwd;
        $this->connection = $connection;
        $this->mailHost = $mailHost;
        $this->mailUsername = $mailUsername;
        $this->mailPwd = $mailPwd;

        toggleButtonController::handleThemeToggle();
        $this->styleDynamique = toggleButtonController::getActiveStyle();

        // ==========================
        // Variables spécifiques à la page
        // ==========================
        $this->pageTitle = "S'inscrire";
        $this->pageDescription = "Site officiel des auteurs ACH Sofia, ARFI Maxime, BURBECK Heather et MARCHITTO Ilian. Inscrivez-vous sur notre site.";
        $this->pageKeywords = "Fan2Jul, ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian, communauté, inscription";
        $this->pageAuthor = "ACH Sofia, ARFI Maxime, BURBECK Heather, MARCHITTO Ilian";
        $this->pageCss = ["seConnecter.css", $this->styleDynamique];
        $this->head = new HeadController($this->pageTitle, $this->pageDescription, $this->pageKeywords, $this->pageAuthor, $this->pageCss);

        // Gestion du formulaire
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->handleForm();
        }
    }

    public function render(): void
    {
        $vars = get_object_vars($this);
        extract($vars);

        require_once LAYOUT_PATH . '/head.php';
        require_once PAGES_PATH . '/sInscrire.php';

    }

    private function handleForm(): void
    {
        $firstname = trim($_POST["firstname"]);
        $lastname = trim($_POST["lastname"]);
        $email = trim($_POST["email"]);
        $password = $_POST["password"];
        $song_id = $_POST["song_id"];

        // Vérification de l’unicité de l’email
        $stmt = $this->connection->prepare("SELECT email FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $existant = $stmt->fetchAll();

        foreach ($existant as $row) {
            if ($row['email'] === $email) {
                $_SESSION['erreuremail'] = 'Email déjà utilisé';
                header("Location:" . BASE_URL . "/index.php?page=s_inscrire");
                exit;
            }
        }

        // Création du code d’authentification
        $code = (string) random_int(100000, 999999);
        $_SESSION['2fa_code'] = $code;
        $_SESSION['2fa_expires'] = time() + 600;
        $_SESSION['Register'] = true;
        $_SESSION['firstname'] = $firstname;
        $_SESSION['lastname'] = $lastname;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        $_SESSION['song_id'] = $song_id;

        // Envoi du mail
        $this->sendVerificationMail($email, $code);
    }

    private function sendVerificationMail(string $email, int $code): void
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $this->mailHost;
            $mail->SMTPAuth = true;
            $mail->Username = $this->mailUsername;
            $mail->Password = $this->mailPwd;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom($this->mailUsername, 'Fan2Jul');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Ton code de vérification";
            $mail->Body = "Bonjour,<br><br>Ton code de vérification est le suivant :<br>
                           <b>$code</b><br><br>Ce code expire dans 10 minutes.<br>
                           Si tu n'as pas demandé cette opération, ignore ce message.";

            $mail->send();

            header("Location:" . BASE_URL . "/index.php?page=second_authenticator");
            exit;
        } catch (Exception $e) {
            $error = "Erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
            echo "<p style='color:red;'>$error</p>";
        }
    }
}
