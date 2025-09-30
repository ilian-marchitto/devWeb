<?php

// Définir les variables d'environnement en local
$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pwd  = getenv('DB_PASS');  

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
