<?php
// debug.php
define('BASE_PATH', dirname(__DIR__));
define('PUBLIC_PATH', BASE_PATH . '/public');

echo "<h2>Test Autoloader</h2>";

// Charger l'autoloader
echo "1. Chargement de l'autoloader...<br>";
if (file_exists(PUBLIC_PATH . '/AutoLoader.php')) {
    require_once PUBLIC_PATH . '/AutoLoader.php';
    echo "✓ AutoLoader.php chargé<br><br>";
} else {
    die("✗ AutoLoader.php introuvable dans " . PUBLIC_PATH);
}

// Tester le chargement d'une classe
echo "2. Test de chargement de la classe controllers\AccueilController<br>";

try {
    // Vérifier si la classe peut être chargée
    if (class_exists('controllers\AccueilController', true)) {
        echo "✓ La classe controllers\AccueilController a été chargée !<br>";
    } else {
        echo "✗ La classe controllers\AccueilController n'existe pas<br>";
    }
} catch (Exception $e) {
    echo "✗ Erreur: " . $e->getMessage() . "<br>";
}

echo "<br>3. Test de chargement manuel<br>";
$manual_file = BASE_PATH . '/controllers/AccueilController.php';
echo "Fichier: $manual_file<br>";
if (file_exists($manual_file)) {
    require_once $manual_file;
    echo "✓ Fichier chargé manuellement<br>";
    
    if (class_exists('controllers\AccueilController', false)) {
        echo "✓ La classe existe maintenant !<br>";
    } else {
        echo "✗ La classe n'existe toujours pas après require_once<br>";
    }
} else {
    echo "✗ Fichier introuvable<br>";
}

echo "<br>4. Liste des classes déclarées contenant 'Accueil':<br>";
$classes = get_declared_classes();
foreach ($classes as $class) {
    if (stripos($class, 'accueil') !== false) {
        echo "- $class<br>";
    }
}
?>