<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Créer un compte</title>
    <link rel="stylesheet" href="../style/seConnecter.css">
</head>

<?php
require_once __DIR__ . '/../configs/config.php';
try {
    // DSN MySQL
    $dsn = "mysql:host=$host;port=$port;dbname=$db";

    // Création de la connexion PDO
    $connection = new PDO($dsn, $user, $pwd);

    // Mode d'erreur : exceptions
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Codage de caractères.
    $connection->exec('SET CHARACTER SET utf8');
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Vérification de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $song_id = $_POST["song_id"];

    // Vérification de l'unicité de l'email
    $stmt = $connection->prepare("SELECT email FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $existant = $stmt->fetchAll();

    $unique = true;
    foreach ($existant as $row) {
        if ($row['email'] === $email) {
            $unique = false;
            $erreuremail = 'Email déjà utilisé';
        }
    }

    // Création du compte si unique
    if ($unique) {
        $hash = password_hash($password, PASSWORD_DEFAULT); // Sécurisation du mot de passe

        $query = "INSERT INTO users (firstname, lastname, email, password, song_id) VALUES (:firstname, :lastname, :email, :password, :song_id)";
        $requete = $connection->prepare($query);

        try {
            $requete->execute([
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'email' => $email,
                    'password' => $hash,
                    'song_id' => $song_id
            ]);

            session_start();
            $_SESSION["firstname"] = $firstname;
            header("Location: bienvenue.php");
            exit;
        } catch (PDOException $e) {
            echo "Erreur d'insertion : " . $e->getMessage();
        }
    }
}
?>

<body>
<div class="login-image-wrapper">
    <img src="../assets/images/Jul2tp.webp" alt="Image de connexion" class="login-image">
</div>

<div class="login-container">
    <form action="" method="post" class="login-form">
        <h2>Créer un compte</h2>
        <?php if (!empty($erreuremail)) : ?>
            <p class="error"><?= htmlspecialchars($erreuremail) ?></p>
        <?php endif; ?>
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
        <p>Déjà un compte ? <a href="seConnecter.php">Connecte toi</a></p>
    </form>
</div>
</body>
</html>