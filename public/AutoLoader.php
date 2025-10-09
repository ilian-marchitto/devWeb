<?php
class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {
            // Convertir les backslashes du namespace en séparateurs de répertoire
            $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $class);
            
            // Construire le chemin complet du fichier
            $file = BASE_PATH . DIRECTORY_SEPARATOR . $classPath . '.php';
            
            // Charger le fichier s'il existe
            if (file_exists($file)) {
                require_once $file;
                return true;
            }
            
            return false;
        });
    }
}

// Enregistrer l'autoloader immédiatement
Autoloader::register();