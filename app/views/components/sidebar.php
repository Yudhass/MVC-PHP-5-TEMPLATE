<div class="sidebar bg-dark text-white" style="min-height: 100vh; width: 250px; position: fixed; top: 0; left: 0;">
    <div class="p-3">
        <h4><?php echo isset($brandName) ? esc($brandName) : 'Menu'; ?></h4>
        <hr>
        <ul class="nav flex-column">
            <?php if (isset($menuItems) && is_array($menuItems)): ?>
                <?php foreach ($menuItems as $item): ?>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?php echo esc($item['url']); ?>">
                            <?php if (isset($item['icon'])): ?>
                                <i class="<?php echo esc($item['icon']); ?>"></i>
                            <?php endif; ?>
                            <?php echo esc($item['label']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?php echo esc(BASEURL); ?>">Home</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
