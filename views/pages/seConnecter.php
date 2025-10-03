<?php
session_start();

require_once  BASE_PATH . '/config.php';

$erreur = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $identifiant = trim($_POST["identifiant"]);
    $mot_de_passe = trim($_POST["mot_de_passe"]);

    if (!empty($identifiant) && !empty($mot_de_passe)) {
        try {
            $sql = "SELECT * FROM users 
                    WHERE email = :identifiant 
                    AND password = :mot_de_passe 
                    LIMIT 1";

            $stmt = $connection->prepare($sql);
            $stmt->bindParam(":identifiant", $identifiant, PDO::PARAM_STR);
            $stmt->bindParam(":mot_de_passe", $mot_de_passe, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $_SESSION["email"] = $user["email"];
                $_SESSION["firstname"] = $user["firstname"];

                header("Location:". BASE_URL . "/index.php?page=bienvenue");
                exit;
            } else {
                $erreur = "Identifiant ou mot de passe incorrect.";
            }
        } catch (PDOException $e) {
            $erreur = "Erreur lors de la connexion : " . $e->getMessage();
        }
    } else {
        $erreur = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="<?= CSS_URL ?>/seConnecter.css">
</head>

<body>
    <div class=" login-image-wrapper">
        <img src="<?= IMAGES_URL ?>/Jul2tp.webp" alt="Image de connexion" class="login-image">
    </div>

    <div class="login-container">
        <form action="" method="post" class="login-form">
            <h2>Connexion</h2>
            <?php if (!empty($erreur)) : ?>
                <p class="error"><?= htmlspecialchars($erreur) ?></p>
            <?php endif; ?>
            <label for="identifiant">Email</label>
            <input type="email" name="identifiant" id="identifiant" placeholder="juldetp@d&p.com" required>

            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" name="mot_de_passe" id="mot_de_passe" placeholder="LeJC'estle100!!" required>

            <button type="submit">Se connecter</button>
            <p class="forgot"><a href="#">Mot de passe oublié ?</a></p>
            <p>Pas encore de compte ? <a href="#">Crée le maintenant</a></p>
        </form>
    </div>
</body>

</html>