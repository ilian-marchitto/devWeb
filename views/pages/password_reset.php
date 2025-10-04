<?php
require 'config.php';
$token = $_GET['token'] ?? '';
if (!$token) { echo "Lien invalide."; exit; }

// Vérifier token
$stmt = $pdo->prepare("SELECT id, reset_expires FROM users WHERE reset_token = ? LIMIT 1");
$stmt->execute([$token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) { echo "Lien invalide."; exit; }

// Vérifier expiration
if (new DateTime() > new DateTime($user['reset_expires'])) {
    echo "Lien expiré."; exit;
}

// Afficher formulaire (POST vers perform_reset.php)
?>
<form method="post" action="perform_reset.php">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
    <label>Nouveau mot de passe</label>
    <input type="password" name="password" required>
    <label>Confirmer</label>
    <input type="password" name="password_confirm" required>
    <button type="submit">Modifier le mot de passe</button>
</form>

