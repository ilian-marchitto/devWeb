<?php
session_start();

if (!isset($_SESSION['firstname'])) {
    header("Location: seConnecter.php");
    exit;
}

$prenom = $_SESSION['firstname'];
$initiale = strtoupper(substr($prenom, 0, 1));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
    <link rel="stylesheet" href="../style/bienvenue.css">
    <meta http-equiv="refresh" content="1;url=accueil.php">
</head>
<body>
    <div class="welcome-message">
        <h1>BIENVENUE LE <?= htmlspecialchars($initiale) ?> </h1>
    </div>

    <div class="login-image-wrapper">
        <img src="../assets/images/Jul2tp.webp" alt="Image de connexion" class="login-image">
    </div>
</body>
</html>
