<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
<?php
include '../classes/Menu.php';

$menu = new Menu();

echo $menu -> showMenu()

?>
</body>

</html>