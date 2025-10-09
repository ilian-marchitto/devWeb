<?php $token = $_GET['token'] ?? $_POST['token'] ?? ''; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <link rel="stylesheet" href="<?= CSS_URL ?>/seConnecter.css">
</head>

<body>

<div class="login-container">
    <div class="login-form">
    <h2>Réinitialiser le mot de passe</h2>

    <?php if(empty($success) && ($token)): ?>
        <form method="post" action='<?= BASE_URL ?>/index.php?page=password_reset' >
            <input type="hidden" name="token" value="<?= $token ?>">
            <label>Nouveau mot de passe</label>
            <input type="password" name="password" required>
            <label>Confirmer</label>
            <input type="password" name="password_confirm" required>
            <button type="submit">Modifier le mot de passe</button>
        </form>
    <?php endif; ?>

    <?php if(!empty($success)): ?>
        <p class="success"><?= htmlspecialchars($success) ?></p>
        <p class="forgot">
        <a href="<?= BASE_URL ?>/index.php?page=se_connecter">Retour à la connexion</a>
        <a href="<?= BASE_URL ?>/index.php?page=home">Retour à l'accueil</a>
        </p>
    <?php endif; ?>

    <?php if(!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    </div>
</div>
</body>