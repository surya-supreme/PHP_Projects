<nav class="main-nav">
    <ul class="nav-list">
        <?php foreach ($nav_items as $item): ?>
            <li class="nav-item">
                <a href="<?php echo $item['url']; ?>" 
                   class="nav-link <?php echo isActive($item['url']); ?>">
                    <span class="nav-icon"><?php echo $item['icon']; ?></span>
                    <span class="nav-text"><?php echo $item['name']; ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>