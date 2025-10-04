
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déconnexion</title>
    <link rel="stylesheet" href="<?= CSS_URL ?>/bienvenue.css">
</head>
<body>

<div class="welcome-message">
    <h1>CIAO LE <?= isset($initiale) ? htmlspecialchars($initiale) : '' ?></h1>
    <h2> Vous avez été déconnecté avec succès.</h2>
</div>

<div class="login-image-wrapper">
    <img src='<?= IMAGES_URL ?>/Jul2tp.webp' alt="Image de connexion" class="login-image">
</div>

<p><a href="<?= BASE_URL ?>/index.php?page=home">Retour à l’accueil</a></p>
</body>
</html>
