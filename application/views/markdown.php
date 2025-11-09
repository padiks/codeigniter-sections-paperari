<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="markdown-content">
    <?php
    // $html_content is generated in the controller using Parsedown
    echo isset($html_content) ? $html_content : '<p><em>Markdown file not found.</em></p>';
    ?>
</div>

<?php if (!empty($prev_url) || !empty($next_url)): ?>
<div class="chapter-nav" style="margin-top: 2em; width: 100%; overflow: hidden;">
    <?php if (!empty($prev_url)): ?>
        <a href="<?= $prev_url ?>" style="float:left;">← Previous</a>
    <?php endif; ?>

    <?php if (!empty($next_url)): ?>
        <a href="<?= $next_url ?>" style="float:right;">Next →</a>
    <?php endif; ?>
</div>
<?php endif; ?>
