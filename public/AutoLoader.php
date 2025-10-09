<?php
class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {
            // Convertir les backslashes du namespace en séparateurs de dossier
            $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
            
            // Dossiers où chercher
            $paths = [BASE_PATH];

            foreach ($paths as $path) {
                $file = $path . DIRECTORY_SEPARATOR . $class . '.php';
                if (file_exists($file)) {
                    require $file;
                    return true;
                }
            }

            return false;
        });
    }
}
Autoloader::register();
?>