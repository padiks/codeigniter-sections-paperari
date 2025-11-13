<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="PaperCSS - the less formal CSS framework.">
    <title><?= isset($title) ? $title : 'Template by PaperCSS'; ?> - Paperari</title>
    <link href="<?= base_url('assets/img/paper_737804.png'); ?>" rel="icon" type="image/x-icon">
    <link href="<?= base_url('assets/css/paper.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css'); ?>?v=1.0.1" rel="stylesheet">
  </head>
  <body>
    <div id="top" class="row site">
      <div class="sm-12 md-8 col">
        <div class="paper">
          <div class="demo-title">
            <div class="row flex-center">
              <div class="text-center">
                <h1 class="fw-bold" title="図書館Toshokan - Paperari">らいぶらり</h1>
                <h2 class="fw-bold" style="font-size: 1.5em" title="PaperCSS - the less formal CSS framework">ぺーぱしーえすえす ふれーむわーく</h2>
              </div>
            </div>
            <div class="row flex-center child-borders">
              <a class="paper-btn margin" href="<?= site_url() ?>">Home</a>
              <a class="paper-btn margin" href="<?= site_url() ?>books/">Books</a>
              <a class="paper-btn margin" href="<?= site_url() ?>sitemap/">Sitemap</a>							
              <a class="paper-btn margin" href="#" onclick="toggleTheme()">Theme</a>
              <a href="https://github.com/padiks/codeigniter-sections-paperari" target="_blank" class="paper-btn margin">Github</a>             
              <a class="paper-btn margin" href="<?= isset($_COOKIE['access_token']) && $_COOKIE['access_token'] === 'ok' ? site_url('logout') : site_url('login') ?>" 
                title="<?= isset($_COOKIE['access_token']) && $_COOKIE['access_token'] === 'ok' ? 'Logout' : 'Login' ?>">
                <?= isset($_COOKIE['access_token']) && $_COOKIE['access_token'] === 'ok' ? 'Logout' : 'Login' ?>
              </a>
            </div>
          </div>
          <div class="to-top">
            <a href="#top" class="paper-btn margin">^</a>
          </div>
          <div class="section">		
            <h2 class="breadcrumb">
              <?php if (!empty($breadcrumb)): ?>
                <?php foreach($breadcrumb as $idx => $crumb): ?>
                  <a class="ff-heading" href="<?= $crumb['url'] ?>" style="text-decoration: none;">
                    <?= $crumb['name'] ?>
                  </a>
                  <?php if($idx < count($breadcrumb) - 1) echo ' &nbsp;»&nbsp; '; ?>
               <?php endforeach; ?>
             <?php endif; ?>
           </h2>