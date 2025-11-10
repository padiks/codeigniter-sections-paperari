<div class="content" style="max-width:400px; margin:2em auto;">
  <h3>らいぶらりー ろぐいん</h3>

  <?php if (!empty($error)): ?>
    <p style="color:red;"><?= $error ?></p>
  <?php endif; ?>

  <form method="post">
    <label>ぱすわーど</label><br>
    <input type="password" placeholder="q" name="password" style="width:100%; padding:0.5em;" autofocus required><br><br>
    <button type="submit" style="padding:0.5em 1em;">ろぐいん</button>
  </form>
</div>
