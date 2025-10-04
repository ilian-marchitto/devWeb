<?php
require_once __DIR__ . '/../../config.php';

require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/SMTP.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit("Aucune donnée reçue.");
}

// Récupérer et nettoyer l'email
$email = trim($_POST['email'] ?? '');
if (!$email) {
    exit("Email requis.");
}

// Recherche de l'utilisateur dans la base
$stmt = $connection->prepare("SELECT email FROM users WHERE email = ? LIMIT 1");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Message générique pour éviter de révéler l'existence de l'email
echo "Si un compte existe pour cet email, tu recevras un message contenant un lien.";

if (!$user) {
    exit; // On arrête si l'utilisateur n'existe pas
}

// Générer un token sécurisé et définir sa durée de validité
$token = bin2hex(random_bytes(16));
$expires = (new DateTime('+1 hour'))->format('Y-m-d H:i:s');

// Stocker le token et sa date d'expiration dans la base
$upd = $connection->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?");
$upd->execute([$token, $expires, $user['email']]);

// Construire le lien de réinitialisation
$link = BASE_URL."/index.php?page=password_reset&token=" . urlencode($token);

// Envoi de l'e-mail via PHPMailer
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = $mailHost;
    $mail->SMTPAuth = true;
    $mail->Username = $mailUsername; // Ton email Alwaysdata
    $mail->Password = $mailPwd;         // Ton mot de passe
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom($mailUsername, 'fan2jul');
    $mail->addAddress($email); // Destinataire : l'utilisateur

    $mail->isHTML(true);
    $mail->Subject = "Réinitialisation de mot de passe";
    $mail->Body = "Bonjour,<br><br>Pour réinitialiser ton mot de passe, clique sur le lien suivant :<br><a href=\"$link\">$link</a><br><br>Ce lien expire dans 1 heure.<br>Si tu n'as pas demandé cette opération, ignore ce message.";
    $mail->send();
    echo "<br>L'e-mail de réinitialisation a bien été envoyé à $email.";
} catch (Exception $e) {
    echo "<br>Erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
}
