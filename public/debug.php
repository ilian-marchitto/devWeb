<?php
// debug.php
define('BASE_PATH', dirname(__DIR__));

echo "<h2>Diagnostic</h2>";
echo "<strong>BASE_PATH:</strong> " . BASE_PATH . "<br>";
echo "<strong>Séparateur:</strong> " . DIRECTORY_SEPARATOR . "<br><br>";

// Vérifier la structure
$controllers_dir = BASE_PATH . DIRECTORY_SEPARATOR . 'controllers';
echo "<strong>Dossier controllers:</strong> " . $controllers_dir . "<br>";
echo "Existe ? " . (is_dir($controllers_dir) ? "OUI" : "NON") . "<br><br>";

// Lister les fichiers dans controllers
if (is_dir($controllers_dir)) {
    echo "<strong>Fichiers dans controllers:</strong><br>";
    $files = scandir($controllers_dir);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            echo "- $file<br>";
        }
    }
}

// Tester le chemin exact d'AccueilController
$accueil_file = BASE_PATH . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'AccueilController.php';
echo "<br><strong>Chemin AccueilController:</strong> " . $accueil_file . "<br>";
echo "Existe ? " . (file_exists($accueil_file) ? "OUI" : "NON") . "<br><br>";

// Afficher les 3 premières lignes du fichier s'il existe
if (file_exists($accueil_file)) {
    echo "<strong>Début du fichier AccueilController.php:</strong><br>";
    $lines = file($accueil_file);
    echo "<pre>";
    echo htmlspecialchars(implode('', array_slice($lines, 0, 5)));
    echo "</pre>";
}
?>