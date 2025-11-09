<div class="content">
  <?php if (empty($links)): ?>
    <p><em>No readable files found in this folder.</em></p>
  <?php else: ?>
    <ul>
      <?php foreach ($links as $link): ?>
        <li>
          <?php if ($link['type'] === 'folder'): ?>
            📂 <a href="<?= $link['url'] ?>"><?= ucfirst($link['name']) ?></a>
          <?php else: ?>
            📄 <a href="<?= $link['url'] ?>"><?= ucfirst($link['name']) ?></a>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <!-- ✅ Display README.md content (if available) -->
  <?php if (!empty($html_content)): ?>
    <div class="markdown-body">
      <?= $html_content ?>
    </div>
  <?php endif; ?>
</div>
