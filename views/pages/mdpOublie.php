<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <link rel="stylesheet" href="<?= CSS_URL ?>/seConnecter.css">
</head>
<body>

<div class="login-container">
    <div class="login-form">
        <h2>Réinitialiser le mot de passe</h2>

        <!-- Affichage d'erreurs éventuelles -->
        <?php if(!empty($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form action='<?= BASE_URL ?>/index.php?page=send_reset' method="post">
            <label>Adresse e-mail</label>
            <input type="email" name="email" placeholder="Entrez votre e-mail" required>

            <button type="submit">Envoyer le lien de réinitialisation</button>
        </form>

        <p class="forgot">
            <a href="<?= BASE_URL ?>/index.php?page=seConnecter">Retour à la connexion</a>
            <a href="<?= BASE_URL ?>/index.php?page=home">Retour à l'accueil</a>
        </p>
    </div>
    <?php if(!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if(!empty($success)): ?>
        <p class="success"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <?php if(!empty($message)): ?>
        <p class="info"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
</div>



</body>
