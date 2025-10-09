<?php
class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {
            // Convertir les namespaces en chemins de dossiers
            $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

            // Le projet racine (défini dans index.php)
            $basePath = defined('BASE_PATH') ? BASE_PATH : dirname(__DIR__);

            // Chemin complet du fichier à charger
            $file = $basePath . DIRECTORY_SEPARATOR . $classPath;

            if (file_exists($file)) {
                require_once $file;
                return true;
            }

            return false;
        });
    }
}
Autoloader::register();
?>