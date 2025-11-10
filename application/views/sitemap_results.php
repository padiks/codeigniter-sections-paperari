<h2 class="title">Sitemap</h2>
<div class="content">
<?php if (empty($results)): ?>
    <p>No files found.</p>
<?php else: ?>

    <?php foreach ($sections as $section): ?>
        <h3><?= htmlspecialchars($section); ?></h3>
        <?php 
        $section_items = array_filter($results, fn($r) => $r['section'] === $section);
        if (empty($section_items)) continue;

        // Group by first folder after section (book)
        $books = [];
        foreach ($section_items as $item) {
            $book = $item['book'];
            $books[$book][] = $item;
        }
        ?>

        <ul>
        <?php foreach ($books as $bookName => $chapters): ?>
            <li><strong><?= htmlspecialchars($bookName); ?></strong>
                <ul>
                <?php foreach ($chapters as $chapter): ?>
                    <li>
                        <?php 
                            // If it's README.md, treat it as a folder (no file URL)
                            if (strtolower($chapter['name']) === 'readme') {
                                $folderPath = htmlspecialchars(implode('/', array_slice($chapter['full_parts'], 0, count($chapter['full_parts']) - 1)));
                                echo '<a href="' . site_url($folderPath) . '">' . $folderPath . '</a>';
                            } else {
                                // Normal file URL
                                echo '<a href="' . site_url(str_replace('.md', '', str_replace('.txt', '', $chapter['path']))) . '">' . htmlspecialchars($chapter['name']) . '</a>';
                            }
                        ?>
                    </li>
                <?php endforeach; ?>
                </ul>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>

<?php endif; ?>
</div>
