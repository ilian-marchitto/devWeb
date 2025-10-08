
<body>

<main class="plan-du-site-container">
    <h1><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Plan du site' ?></h1>
    <p>Plan Fan2jul:</p>

    <ul>
        <?php if (!empty($pages)): ?>
            <?php foreach ($pages as $p): ?>
                <li>
                    <a href="<?= htmlspecialchars($p['url']) ?>">
                        <?= htmlspecialchars($p['name']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Aucune page trouvée dans <code>views/pages</code>.</li>
        <?php endif; ?>
    </ul>
</main>

</body>

