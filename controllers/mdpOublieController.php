<?php

namespace controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use models\UserModels;

class MdpOublieController
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
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $error = "Aucune donnée reçue.";
            include PAGES_PATH . '/mdpOublie.php';
            return;
        }

        $email = trim($_POST['email'] ?? '');
        if (empty($email)) {
            $error = "Email requis.";
            include PAGES_PATH . '/mdpOublie.php';
            return;
        }

        // Message générique (toujours affiché)
        $message = "Si un compte existe pour cet email, tu recevras un message contenant un lien.";

        $userModel = new UserModels($this->connection);
        $userData = $userModel->findByEmail($email);

        if ($userData) {
            // Générer token et enregistrer
            $token = bin2hex(random_bytes(16));
            $expires = (new \DateTime('+1 hour'))->format('Y-m-d H:i:s');
            $userModel->saveResetToken($email, $token, $expires);

            // Lien de réinitialisation
            $link = BASE_URL . "/index.php?page=password_reset&token=" . urlencode($token);

            // Envoi du mail
            $this->sendResetMail($email, $link, $success, $error);
        }

        // Vue finale
        include PAGES_PATH . '/mdpOublie.php';
    }

    private function sendResetMail(string $email, string $link, &$success, &$error): void
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

            $mail->setFrom($this->mailConfig['username'], 'fan2jul');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Réinitialisation de mot de passe";
            $mail->Body = "
                Bonjour,<br><br>
                Pour réinitialiser ton mot de passe, clique sur le lien suivant :<br>
                <a href=\"$link\">$link</a><br><br>
                Ce lien expire dans 1 heure.<br>
                Si tu n'as pas demandé cette opération, ignore ce message.
            ";

            $mail->send();
            $success = "L'e-mail de réinitialisation a bien été envoyé à $email.";
        } catch (Exception $e) {
            $error = "Erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
        }
    }
}
