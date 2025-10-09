<?php

namespace controllers;

class SeDeconnecterController
{
    public static function disconnect()
    {
        // Démarrer la session si elle n’est pas déjà active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Supprimer toutes les variables de session
        $_SESSION = [];

        // Détruire la session
        session_destroy();

        // Rediriger vers la page de connexion
        header("Location: index.php?page=seConnecter");
        exit;
    }
}
