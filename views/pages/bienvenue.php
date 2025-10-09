

<head>
    <meta http-equiv="refresh" content="1;url=<?= BASE_URL ?>/index.php?page=home">
</head>

<body>
    <div class="welcome-message">
        <h1>Bienvenue <?= htmlspecialchars($controller->getPrenom()) ?> !</h1>
        <p>Initiale : <?= htmlspecialchars($controller->getInitiale()) ?></p>
    </div>

    <div class="login-image-wrapper">
        <img src='<?= IMAGES_URL ?>/Jul2tp.webp' alt="Image de connexion" class="login-image">
    </div>
</body>

</html>