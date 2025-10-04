<?php
require_once LAYOUT_PATH . '/Header.php';
session_start();

$isLoggedIn = isset($_SESSION['email']);


// Créer l’instance de Header
$header = new Header($isLoggedIn);
$header->render();




