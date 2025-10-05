<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Plan du site' ?></title>
    <link rel="stylesheet" href="<?= CSS_URL ?>/planDuSite.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
</head>

<body>
    <main class="plan-du-site-container">
        <h1><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Plan du site' ?></h1>
        <p>Liste de toutes les pages présentes dans <code>views/pages</code> :</p>

        <ul>
            <?php if (!empty($pages)): ?>
                <?php foreach ($pages as $page): ?>
                    <li>
                        <a href="../../<?= htmlspecialchars($page['path']) ?>">
                            <?= htmlspecialchars(ucfirst($page['name'])) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>Aucune page trouvée dans <code>views/pages</code>.</li>
            <?php endif; ?>
        </ul>
    </main>
</body>
</html>
