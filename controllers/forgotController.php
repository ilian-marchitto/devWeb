<?php
require_once '../config.php';
require_once MODELS_PATH . '/UserModels.php';
require_once PHPMAILER_PATH.'/PHPMailer.php';
require_once PHPMAILER_PATH.'/SMTP.php';
require_once PHPMAILER_PATH.'/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Initialisation des messages
$error = '';
$success = '';
$message = '';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $error = "Aucune donnée reçue.";
    include PAGES_PATH.'/forgot.php';
    exit;
}

// Récupérer et nettoyer l'email
$email = trim($_POST['email'] ?? '');
if (!$email) {
    $error = "Email requis.";
    include PAGES_PATH.'/forgot.php';
    exit;
}

// Message générique (toujours affiché)
$message = "Si un compte existe pour cet email, tu recevras un message contenant un lien.";

// Recherche de l'utilisateur
$userModel = new UserModel($connection);
$userData = $userModel->findByEmail($email);

if ($userData) {
    // Générer token et sauvegarder
    $token = bin2hex(random_bytes(16));
    $expires = (new DateTime('+1 hour'))->format('Y-m-d H:i:s');
    $userModel->saveResetToken($email, $token, $expires);

    // Construire le lien
    $link = BASE_URL."/index.php?page=password_reset&token=" . urlencode($token);

    // Envoi du mail
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = $mailHost;
        $mail->SMTPAuth = true;
        $mail->Username = $mailUsername;
        $mail->Password = $mailPwd;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($mailUsername, 'fan2jul');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = "Réinitialisation de mot de passe";
        $mail->Body = "Bonjour,<br><br>Pour réinitialiser ton mot de passe, clique sur le lien suivant :<br>
                       <a href=\"$link\">$link</a><br><br>Ce lien expire dans 1 heure.<br>
                       Si tu n'as pas demandé cette opération, ignore ce message.";
        $mail->send();
        $success = "L'e-mail de réinitialisation a bien été envoyé à $email.";
    } catch (Exception $e) {
        $error = "Erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
    }
}

// Charger la vue
include PAGES_PATH.'/forgot.php';
