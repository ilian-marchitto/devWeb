<?php
// Informations de connexion
$host = "postgresql-fan2jul.alwaysdata.net";    // ou l'adresse IP du serveur PostgreSQL
$port = "5432";         // port par défaut PostgreSQL
$db   = "fan2jul_database";      // nom de ta base de données
$user = "fan2jul";     // ton utilisateur PostgreSQL
$pwd  = "B@nd30rg@n1s33";   // mot de passe utilisateur

try {
    // DSN PostgreSQL
    $dsn = "pgsql:host=$host;port=$port;dbname=$db";

    // Création de la connexion PDO
    $connection = new PDO($dsn, $user, $pwd);

    // Mode d'erreur : exceptions
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "✅ Connexion réussie à la base $db";
} catch (PDOException $e) {
    echo "❌ Erreur de connexion : " . $e->getMessage();
}
?>

