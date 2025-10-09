<?php
class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {

            $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
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