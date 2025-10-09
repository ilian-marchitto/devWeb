<?php
class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {
            // Debug : afficher ce qui est demandé
            error_log("Autoloader : tentative de chargement de '$class'");
            
            // Convertir namespace en chemin
            $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $class);
            
            // Essayer dans BASE_PATH
            $file = BASE_PATH . DIRECTORY_SEPARATOR . $classPath . '.php';
            
            error_log("Autoloader : recherche dans '$file'");
            
            if (file_exists($file)) {
                error_log("Autoloader : fichier trouvé et chargé");
                require $file;
                return true;
            }
            
            error_log("Autoloader : fichier NON trouvé");
            return false;
        });
    }
}
Autoloader::register();
?>