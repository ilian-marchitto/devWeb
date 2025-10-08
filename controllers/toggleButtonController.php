<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

class ToggleButtonController
{
    /**
     * Gère le basculement du thème quand on clique sur le bouton (?toggle_style=1)
     * et mémorise le choix dans la session + un cookie (valide 1 an)
     */
    public static function handleThemeToggle(): void
    {
        // --- 1. Si le bouton est cliqué, on bascule le style ---
        if (isset($_GET['toggle_style'])) {
            $current = $_SESSION['styleDynamique'] ?? $_COOKIE['styleDynamique'] ?? 'style.css';

            $new = ($current === 'style.css') ? 'theme-alt.css' : 'style.css';

            // On sauvegarde dans la session
            $_SESSION['styleDynamique'] = $new;

            // Et dans un cookie (valable 1 an, sur tout le site)
            setcookie('styleDynamique', $new, [
                'expires'  => time() + 365 * 24 * 60 * 60,
                'path'     => '/',
                'secure'   => isset($_SERVER['HTTPS']), // cookie sécurisé si HTTPS
                'httponly' => false,
                'samesite' => 'Lax'
            ]);

            // Recharge la page sans le paramètre toggle_style (optionnel mais propre)
            $homeUrl = 'https://fan2jul.alwaysdata.net/index.php?page=home';
            header("Location: $homeUrl");
            exit;
        }
        }

        // --- 2. Initialisation du style au premier chargement ---
        if (!isset($_SESSION['styleDynamique'])) {
            // On regarde d'abord s'il existe un cookie enregistré
            if (isset($_COOKIE['styleDynamique'])) {
                $_SESSION['styleDynamique'] = $_COOKIE['styleDynamique'];
            } else {
                $_SESSION['styleDynamique'] = 'style.css';
            }
        }
    }

    /**
     * Renvoie le style actif
     */
    public static function getActiveStyle(): string
    {
        return $_SESSION['styleDynamique'] ?? $_COOKIE['styleDynamique'] ?? 'style.css';
    }
}
