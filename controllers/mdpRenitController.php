<?php
require_once BASE_PATH . '/config.php';
require_once MODELS_PATH . '/UserModels.php';
require_once PHPMAILER_PATH . '/PHPMailer.php';
require_once PHPMAILER_PATH . '/SMTP.php';
require_once PHPMAILER_PATH . '/Exception.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error = '';
$success = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $pwd = $_POST['password'] ?? '';
    $pwd2 = $_POST['password_confirm'] ?? '';

    if (!$token || !$pwd || $pwd !== $pwd2) {
        $error = "Données invalides ou mots de passe non identiques.";
    } else {
        $userModel = new UserModel($connection);
        $user = $userModel->findByToken($token);

        if (!$user) {
            $error = "Lien invalide.";
        } elseif ($userModel->isTokenExpired($user)) {
            $error = "Lien expiré.";
        } else {
            $userModel->updatePassword($user['email'], $pwd);
            $success = "Mot de passe modifié avec succès.";

            // Envoi du mail de confirmation
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = $mailHost;
                $mail->SMTPAuth = true;
                $mail->Username = $mailUsername;
                $mail->Password = $mailPwd;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom($mailUsername, 'Fan2Jul');
                $mail->addAddress($user['email']);
                $mail->Subject = 'Mot de passe modifié';
                $mail->Body = 'Ton mot de passe a été modifié.';
                $mail->send();
            } catch (Exception $e) {
                error_log("Erreur envoi mail : {$mail->ErrorInfo}");
            }

        }
    }
    include PAGES_PATH . '/mdpRenit.php';
}
