<body>
<header>
    <nav>
        <ul>
            <?php foreach ($navItems->getItems() as $item): ?>
                <li><?php $navItems->showOnce($item); ?></li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <?php foreach ($FontItems->getItems() as $item): ?>
        <?php $FontItems->showOnce($item); ?>
    <?php endforeach; ?>


    <div class="user-dropdown">
        <input type="checkbox" id="toggleUser" class="toggle-checkbox">
        <label for="toggleUser">
            <img src="<?= IMAGES_URL ?>/iconUser.webp" alt="Image de connexion" class="login-image">
        </label>

        <div class="dropdown-content" id="dropdownContent">
            <?php foreach ($buttonItems->getItems() as $item): ?>
                <?php $buttonItems->showOnce($item); ?>
            <?php endforeach; ?>
    </div>
</header>
