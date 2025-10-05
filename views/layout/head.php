<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>

    <?php if(!empty($description)): ?>
        <meta name="description" content="<?= htmlspecialchars($description) ?>">
    <?php endif; ?>

    <?php if(!empty($keywords)): ?>
        <meta name="keywords" content="<?= htmlspecialchars($keywords) ?>">
    <?php endif; ?>

    <meta name="author" content="<?= htmlspecialchars($author) ?>">
    <meta name="robots" content="index, follow">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <!-- Favicons -->
    <link rel="icon" type="webp" href="<?= IMAGES_URL ?>/Jul2tp.webp">
    <link rel="icon" type="webp" sizes="32x32" href="<?= IMAGES_URL ?>/Jul2tp.webp">
    <link rel="icon" type="webp" sizes="16x16" href="<?= IMAGES_URL ?>/Jul2tp.webp">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= IMAGES_URL ?>/Jul2tp.webp">
    <link rel="apple-touch-icon" sizes="180x180" href="Jul2tp.webp">
    <link rel="apple-touch-icon" sizes="152x152" href="Jul2tp.webp">
    <link rel="apple-touch-icon" sizes="120x120" href="Jul2tp.webp">

    <!-- CSS -->
    <?php if(!empty($pageCss)): ?>
        <?php foreach($pageCss as $file): ?>
            <link rel="stylesheet" href="<?= CSS_URL . '/' . htmlspecialchars($file) ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- JS -->
    <?php if(!empty($jsFiles)): ?>
        <?php foreach($jsFiles as $file): ?>
            <script src="<?= BASE_URL . '/js/' . htmlspecialchars($file) ?>" defer></script>
        <?php endforeach; ?>
    <?php endif; ?>
</head>

