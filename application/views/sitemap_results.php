<h2>Site Map</h2>
<div class="content">
<?php if (empty($results)): ?>
    <p>No folders found.</p>
<?php else: ?>

    <?php foreach ($sections as $section): ?>
        <h3><?= htmlspecialchars($section); ?></h3>
        <?php 
        $section_items = array_filter($results, fn($r) => $r['section'] === $section);
        if (empty($section_items)) continue;
        ?>

        <ul>
        <?php foreach ($section_items as $item): ?>
            <li>
                <a href="<?= site_url($item['path']); ?>"><?= htmlspecialchars($item['path']); ?></a>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>

<?php endif; ?>
</div>
