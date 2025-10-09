<body>
<div class="login-container">
    <div class="login-form">
        <h2>Saisir le code de double authentification</h2>
        <form action='?page=second_authenticator' method="post">
            <label>Code</label>
            <input type="text" name="code" maxlength="6" required>
            <button type="submit">Valider ce code</button>
        </form>

        <p class="forgot">
            <a href="<?= BASE_URL ?>/index.php?page=se_connecter">Retour à la connexion</a>
            <a href="<?= BASE_URL ?>/index.php?page=home">Retour à l'accueil</a>
        </p>
    </div>
    <?php if(!empty($this->erreur)): ?>
        <p class="error"><?= htmlspecialchars($this->erreur) ?></p>
    <?php endif; ?>

    <?php if(!empty($this->success)): ?>
        <p class="success"><?= htmlspecialchars($this->success) ?></p>
    <?php endif; ?>
</div>
</body>