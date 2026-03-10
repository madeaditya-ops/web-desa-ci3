<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <?php foreach ($breadcrumb as $item): ?>
            <?php if (!empty($item['url'])): ?>
                <li class="breadcrumb-item">
                    <a href="<?= $item['url']; ?>">
                        <?= $item['title']; ?>
                    </a>
                </li>
            <?php else: ?>
                <li class="breadcrumb-item active" aria-current="page">
                    <?= $item['title']; ?>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ol>
</nav>
