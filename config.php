<?php
// Informations de connexion
$host = "mysql-fan2jul.alwaysdata.net";    // ou l'adresse IP du serveur PostgreSQL
$port = "3306";         // port par défaut PostgreSQL
$db   = "fan2jul_database";      // nom de ta base de données
$user = "fan2jul";     // ton utilisateur PostgreSQL
$pwd  = "B@nd30rg@n1s33";   // mot de passe utilisateur

try {
    // DSN PostgreSQL
    $dsn = "mysql:host=$host;port=$port;dbname=$db";

    // Création de la connexion PDO
    $connection = new PDO($dsn, $user, $pwd);

    // Mode d'erreur : exceptions
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Codage de caractères.
    $connection->exec('SET CHARACTER SET utf8');

    echo "✅ Connexion réussie à la base $db";
} catch (PDOException $e) {
    echo "❌ Erreur de connexion : " . $e->getMessage();
}
