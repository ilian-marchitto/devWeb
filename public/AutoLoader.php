<?php
class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {
            // Remplacer les backslashes des namespaces par des séparateurs de dossier
            $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

            // Dossiers racine à explorer
            $paths = [BASE_PATH];

            foreach ($paths as $path) {
                $file = $path . DIRECTORY_SEPARATOR . $classPath;
                if (file_exists($file)) {
                    require_once $file;
                    return true;
                }
            }

            return false;
        });
    }
}
Autoloader::register();
?>