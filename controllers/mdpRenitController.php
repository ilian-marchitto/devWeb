<?php

namespace controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use models\UserModels;

class MdpRenitController
{
    private $connection;
    private $mailConfig;

    public function __construct($connection, $mailConfig)
    {
        $this->connection = $connection;
        $this->mailConfig = $mailConfig;
    }

    public function handleRequest()
    {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['token'] ?? '';
            $pwd   = $_POST['password'] ?? '';
            $pwd2  = $_POST['password_confirm'] ?? '';

            if (!$token || !$pwd || $pwd !== $pwd2) {
                $error = "Données invalides ou mots de passe non identiques.";
                include PAGES_PATH . '/mdpRenit.php';
                return;
            }

            $userModel = new UserModels($this->connection);
            $user = $userModel->findByToken($token);

            if (!$user) {
                $error = "Lien invalide.";
            } elseif ($userModel->isTokenExpired($user)) {
                $error = "Lien expiré.";
            } else {
                $userModel->updatePassword($user['email'], $pwd);
                $success = "Mot de passe modifié avec succès.";

                // Envoi du mail de confirmation
                $this->sendConfirmationMail($user['email']);
            }
        }

        include PAGES_PATH . '/mdpRenit.php';
    }

    private function sendConfirmationMail(string $email): void
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = $this->mailConfig['host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->mailConfig['username'];
            $mail->Password   = $this->mailConfig['password'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom($this->mailConfig['username'], 'Fan2Jul');
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
}
