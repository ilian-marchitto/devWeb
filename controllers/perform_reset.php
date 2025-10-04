<?php
require_once __DIR__ . '/../../config.php';

require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/SMTP.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$token = $_POST['token'] ?? '';
$pwd = $_POST['password'] ?? '';
$pwd2 = $_POST['password_confirm'] ?? '';

if (!$token || !$pwd || $pwd !== $pwd2) {
    echo "Données invalides."; exit;
}

// Trouver utilisateur par token et vérifier expiry
$stmt = $connection ->prepare("SELECT email, reset_expires  FROM users WHERE reset_token = ? LIMIT 1");
$stmt->execute([$token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) { echo "Lien invalide."; exit; }

if (new DateTime() > new DateTime($user['reset_expires'])) {
    echo "Lien expiré."; exit;
}

// Mettre à jour mot de passe
$hash = password_hash($pwd, PASSWORD_DEFAULT);
$upd = $connection->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE email = ?");
$upd->execute([$hash, $user['email']]);

// Notification simple
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

echo "Mot de passe changé avec succès.";
