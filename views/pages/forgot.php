<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
    <link rel="stylesheet" href="<?= CSS_URL ?>/seConnecter.css">
</head>
<body>

<form action='<?= BASE_URL ?>/index.php?page=send_reset' method="post" >
    <label>Adresse e-mail</label>
    <input type="email" name="email" required>
    <button type="submit">Envoyer le lien de réinitialisation</button>
</form>

</body>

