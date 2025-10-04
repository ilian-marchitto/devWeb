<?php

// Définir les variables d'environnement en local
$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pwd  = getenv('DB_PASS');

$mailHost = getenv('DB_MAIL_PWD')
$mailUsername = getenv('DB_MAIL_USERNAME');
$mailPwd = getenv('DB_MAIL_HOST');

try {
    $dsn = "mysql:host=$host; port=$port; dbname=$db";
    $connection = new PDO($dsn, $user, $pwd);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->exec('SET CHARACTER SET utf8');

    // ✅ Connexion réussie → console JS
    echo "<script>console.log('✅ Connexion réussie à la base {$db}');</script>";
} catch (PDOException $e) {
    // ❌ Erreur de connexion → console JS
    $msg = addslashes($e->getMessage()); // Échapper les quotes
    echo "<script>console.error('❌ Erreur de connexion : {$msg}');</script>";
}
?>
