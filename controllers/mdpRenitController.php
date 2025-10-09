<?php

namespace controllers;
require BASE_PATH . '/vendor/PHPMailer/src/PHPMailer.php';
require BASE_PATH . '/vendor/PHPMailer/src/Exception.php';
require BASE_PATH . '/vendor/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use models\UserModels;

class MdpRenitController
{
    private string $mailHost;
    private string $mailUsername;
    private string $mailPwd;
    private $connection;
    private string $pageTitle;
    private string $description;
    private string $keywords;
    private string $author;
    private array $cssFiles = [];
    public $success;
    public $error;
    

    public function __construct($connection)
    {
        $this->connection = $connection;
        global $mailHost, $mailUsername, $mailPwd;
        $this->connection = $connection;
        $this->mailHost = $mailHost;
        $this->mailUsername = $mailUsername;
        $this->mailPwd = $mailPwd;

        ToggleButtonController::handleThemeToggle();
        $styleDynamique = ToggleButtonController::getActiveStyle();

        $pageTitle = "mot de passe réinitialisé";
        $pageDescription = "Changez votre mot de passe.";
        $pageKeywords = "Fan2Jul, mot de passe réinitialisé";
        $pageAuthor = "Fan2Jul Team";
        $pageCss = ["seConnecter.css", $styleDynamique];

        $this->head = new HeadController($pageTitle, $pageDescription, $pageKeywords, $pageAuthor, $pageCss);

        $this->handleRequest();
    }

    public function handleRequest()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['token'] ?? '';
            $pwd   = $_POST['password'] ?? '';
            $pwd2  = $_POST['password_confirm'] ?? '';

            if (!$token || !$pwd || $pwd !== $pwd2) {
                $this->error = "Données invalides ou mots de passe non identiques.";
                return;
            }

            $userModel = new UserModels($this->connection);
            $user = $userModel->findByToken($token);

            if (!$user) {
                $this->error = "Lien invalide.";
            } elseif ($userModel->isTokenExpired($user)) {
                $this->error = "Lien expiré.";
            } else {
                $userModel->updatePassword($user['email'], $pwd);
                $this->success = "Mot de passe modifié avec succès.";

                // Envoi du mail de confirmation
                $this->sendConfirmationMail($user['email']);
            }
        }

        
    }

    private function sendConfirmationMail(string $email): void
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

            $mail->setFrom($this->mailUsername, 'fan2jul');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Mot de passe modifié';
            $mail->Body = '
                Bonjour,<br><br>
                Ton mot de passe a été modifié avec succès.<br><br>
                Si tu n\'es pas à l\'origine de cette action, contacte-nous immédiatement.
            ';
            $mail->send();
        } catch (Exception $e) {
            error_log("Erreur envoi mail : {$mail->ErrorInfo}");
        }
    }

    public function render(): void
    {
        $vars = get_object_vars($this);
        extract($vars);

        require_once LAYOUT_PATH . '/head.php';
        include PAGES_PATH . '/mdpRenit.php';
    }
}
