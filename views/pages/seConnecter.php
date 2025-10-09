<body>
    <div class=" login-image-wrapper">
        <img src="<?= IMAGES_URL ?>/Jul2tp.webp" alt="Image de connexion" class="login-image">
    </div>

    <div class="login-container">
        <div class="login-form">
            <form action="?page=se_connecter" method="post" class="login-form">
                <h2>Connexion</h2>
                <?php
                
                if (!empty($_SESSION['erreur'])) : ?>
                    <p class="error" role="alert" aria-live="assertive"><?= htmlspecialchars($_SESSION['erreur']) ?></p>
                <?php
                    unset($_SESSION['erreur']);
                endif;
                ?>
                <label for="identifiant">Email</label>
                <input type="email" name="identifiant" id="identifiant" placeholder="juldetp@d&p.com" required>

                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" name="mot_de_passe" id="mot_de_passe" placeholder="LeJC'estle100!!" required>

                <button type="submit">Se connecter</button>
                <p class="forgot">
                    <a href="<?= BASE_URL ?>/index.php?page=home">Retour à l'accueil</a>
                    <a href="<?= BASE_URL ?>/index.php?page=forgot">Mot de passe oublié ?</a>
                </p>
                <p>Pas encore de compte ? <a href="<?= BASE_URL ?>/index.php?page=s_inscrire">Crée le maintenant</a></p>
            </form>
        </div>
    </div>
</body>

