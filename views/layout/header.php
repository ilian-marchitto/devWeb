<body>
<header>
    <input type="checkbox" id="toggleMenu" class="hamburger">
    <label for="toggleMenu" class="hamburger-label">
        <span></span>
        <span></span>
        <span></span>
    </label>
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
        </di>
    </div>
</header>
