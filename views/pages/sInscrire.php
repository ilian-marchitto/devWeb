<body>
<div class="login-image-wrapper">
    <img src="<?= IMAGES_URL ?>/Jul2tp.webp" alt="Image de connexion" class="login-image">
</div>

<div class="login-container">
    <form action="?page=s_inscrire" method="post" class="login-form">
        <h2>Créer un compte</h2>
        <?php
        
        if (!empty($_SESSION['erreuremail'])) : ?>
            <p class="error"><?= htmlspecialchars($_SESSION['erreuremail']) ?></p>
        <?php
            unset($_SESSION['erreuremail']);
        endif;
        ?>
        <label for="firstname">Prénom</label>
        <input type="text" name="firstname" id="firstname" placeholder="Julien" required>

        <label for="lastname">Nom de famille</label>
        <input type="text" name="lastname" id="lastname" placeholder="Mari" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="juldetp@d&p.com" required>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" placeholder="LeJC'estle100!!" required>

        <label for="song_id">Chanson préférée</label>
        <select id="song_id" name="song_id" required>
            <option value="" disabled selected>-- Choisir --</option>
            <option value="1">Tu la love</option>
            <option value="2">Tchikita</option>
            <option value="3">La faille</option>
            <option value="4">Ma jolie</option>
            <option value="5">My World</option>
            <option value="6">Anti BDH</option>
            <option value="7">Dans ma paranoïa</option>
            <option value="8">C'est réel</option>
        </select>

        <button type="submit">Créer le compte</button>
        <p class="forgot"><a href="<?= BASE_URL ?>/index.php?page=home">Retour à l'accueil</a></p>
        <p>Déjà un compte ? <a href="<?= BASE_URL ?>/index.php?page=seConnecter">Connecte toi</a></p>
    </form>
</div>
</body>
