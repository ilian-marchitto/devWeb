<?php
// Démarrer la session
session_start();


$initiale = '';


if (isset($_SESSION['firstname']) && !empty($_SESSION['firstname'])) {
    $prenom = $_SESSION['firstname'];
    $initiale = strtoupper(substr($prenom, 0, 1));
}

// Inclure le template de déconnexion
include PAGES_PATH . '/seDeconnecter.php';


$_SESSION = [];

session_destroy();
?>
