<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {
	
		public function __construct()
		{
				parent::__construct();
				$this->load->helper('url');
				$this->load->helper('markdown');

				// Password protection: check cookie
				if (!isset($_COOKIE['access_token']) || $_COOKIE['access_token'] !== 'ok') {
						redirect('login');
				}
		}	

    /**
     * Display standalone PHP files directly
     * (without header/footer or markdown layout)
     *
     * Example URLs:
     *   /lorem-ipsum           → views/lorem-ipsum/index.php
     *   /lorem-ipsum/test      → views/lorem-ipsum/test.php
     */
    public function view($folder = '', $page = 'index')
    {
        // Build the path to the PHP file inside /views/
        $path = APPPATH . "views/$folder/$page.php";

        // Security: prevent traversal outside /views/
        if (strpos(realpath($path), realpath(APPPATH . 'views')) !== 0) {
            show_404();
            return;
        }

        // If file exists, run it directly without header/footer
        if (file_exists($path)) {
            include($path);
        } else {
            show_404();
        }
    }
}
