          </div>
        </div>
      </div>
      <div class="sm-12 md-4 col sidebar">
        <div class="paper">
          <h3 class="sidebar-title" style="text-align:center;font-weight:bold;">ナビゲーション</h3>
          <div class="row">
            <div class="collapsible full-width">
              <input id="collapsible-content" type="radio" name="collapsible" 
							  <?= !isset($_COOKIE['access_token']) || $_COOKIE['access_token'] !== 'ok' ? 'checked' : '' ?>>
              <label for="collapsible-content">Resources</label>
              <div class="collapsible-body">
                <ul>
                  <li><a href="https://www.freebsd.org/">The FreeBSD Project</a></li>
                  <li><a href="https://www.debian.org/">Debian GNU/Linux</a></li>
                  <li><a href="https://www.codeigniter.com/">CodeIgniter PHP Framework</a></li>
                  <li><a href="https://flask.palletsprojects.com/en/stable/">Flask Web Framework</a></li>
                  <li><a href="https://www.djangoproject.com/">Django Software Foundation</a></li>
                </ul>
              </div>
            </div>					
					  <?php if (isset($_COOKIE['access_token']) && $_COOKIE['access_token'] === 'ok'): ?>	
            <div class="collapsible full-width">
              <input id="collapsible-components" type="radio" name="collapsible">
              <label for="collapsible-components">Sections</label>
              <div class="collapsible-body">
                <ul>
                  <li><a href="/books/">Books</a></li>
                  <li><a href="/lyrics/">Lyrics</a></li>
                  <li><a href="/tutorials/">Tutorials</a></li>
                </ul>
              </div>
            </div>			
            <div class="collapsible full-width">
              <input id="collapsible-tags" type="radio" name="collapsible">
              <label for="collapsible-tags">Tags</label>
              <div class="collapsible-body">
                <div class="tag-container">
                  <a href="<?= site_url('search?q=debian') ?>" class="tag">Debian</a>
                  <a href="<?= site_url('search?q=flask') ?>" class="tag">Flask</a>
                  <a href="<?= site_url('search?q=freebsd') ?>" class="tag">FreeBSD</a>
                  <a href="<?= site_url('search?q=light+novel') ?>" class="tag">Light Novel</a>
                  <a href="<?= site_url('search?q=lyrics') ?>" class="tag">Lyrics</a>
                  <a href="<?= site_url('search?q=markdown') ?>" class="tag">Markdown</a>									
                  <a href="<?= site_url('search?q=python') ?>" class="tag">Python</a>
                  <a href="<?= site_url('search?q=web+novel') ?>" class="tag">Web Novel</a>
                </div>
              </div>
            </div>						
						<div class="full-width">
							<label for="collapsible-search" class="sidebar-title"><br></label>
							<div class="collapsible-body">
								<form action="<?= site_url('search'); ?>" method="get">
									<input type="text" name="q" placeholder="Search..." class="paper-input" style="width: calc(100% - 20px); padding: 0.5em; margin-left: 20px;">
									<button type="submit" class="paper-btn" style="margin-top: 0.5em; margin-left: 20px;">Search</button>
								</form>
							</div>
						</div>
						<?php endif; ?>						
          </div>
        </div>
      </div>
    </div>
    <footer class="attribution">
      <p>
        &copy; らいぶらり Paperari.
        Made with 💛 by <a href="https://vlaservich.com" target="_blank">Rhyne</a> and some <a href="https://github.com/rhyneav/papercss/graphs/contributors" target="_blank">fantastic contributors</a>!
        Designed by <a href="https://www.getpapercss.com/" target="_blank">PaperCSS</a>.
        Favicon by <a href="https://www.freepik.com/" target="_blank">Freepik</a>
        Powered by <a href="https://www.codeigniter.com/" target="_blank">CodeIgniter v3.1.13</a>
      </p>
    </footer>
    <script src="<?= base_url('assets/js/theme.js'); ?>"></script>
  </body>
</html>
