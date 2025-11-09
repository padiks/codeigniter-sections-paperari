<h2 class="title">Search Results for &ldquo;<?= htmlspecialchars($query); ?>&rdquo;</h2>

<div class="content">
  <?php if (empty($results)): ?>
    <p>No matching documents found.</p>
  <?php else: ?>
    <?php foreach ($results as $item): ?>
      <div class="result">
        <h4>
          <a href="<?= site_url($item['url']); ?>">
            [<?= $item['section']; ?>] <?= htmlspecialchars($item['path']); ?>
          </a>
        </h4>
        <p><?= $item['match_snippet']; ?></p>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>
