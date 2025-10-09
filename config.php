<?php

// Définir les variables d'environnement en local
$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pwd  = getenv('DB_PASS');

$mailHost = getenv('DB_MAIL_HOST');
$mailUsername = getenv('DB_MAIL_USERNAME');
$mailPwd = getenv('DB_MAIL_PWD');

try {
    $dsn = "mysql:host=$host; port=$port; dbname=$db";
    $connection = new PDO($dsn, $user, $pwd);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->exec('SET CHARACTER SET utf8');

} catch (PDOException $e) {
}
?>