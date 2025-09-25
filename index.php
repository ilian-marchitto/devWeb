<?php
// Exemple très simple de routeur "maison"

if (filter_input(INPUT_GET, 'page')) {

    if ($_GET['page'] === 'home') {
        include 'pages/accueil.php';
    } elseif ($_GET['page'] === 'seConnecter') {
        include 'pages/seConnecter.php';
    } elseif ($_GET['page'] === 'sInscrire') {
        include 'pages/sInscrire.php';
    } elseif ($_GET['page'] === 'planDuSite') {
        include 'pages/planDuSite.php';
    } else {
        echo "404 - Page non trouvée";
    }
}
?>