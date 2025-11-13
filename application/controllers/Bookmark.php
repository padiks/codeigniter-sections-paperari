<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bookmark extends CI_Controller {

    // Path to bookmark file
    private $bookmark_file = FCPATH . 'application/views/static/bookmark.md';

    public function __construct() {
        parent::__construct();
        // Ensure the bookmark file exists to avoid errors
        if (!file_exists($this->bookmark_file)) {
            file_put_contents($this->bookmark_file, "", LOCK_EX); // start empty
        }
    }

    // Display bookmark (no change to Go to Bookmark functionality)
    public function index() {
        $q = $this->input->get('q', true);
        $bookmark = trim(file_get_contents($this->bookmark_file));

        // Only show if matches search query or no query
        $data['bookmarks'] = (!$q || stripos($bookmark, $q) !== false) ? [$bookmark] : [];

        // Load the existing view (Go to Bookmark works)
        $this->load->view('bookmark_list', $data);
    }

		// Save a single bookmark (overwrite previous)
		public function save() {
				// Hardcode the target file
				$bookmark_file = FCPATH . 'application/views/static/bookmark.md';

				// Get the URL from POST input (the input field in your form)
				$url = $this->input->post('url', true);

				// Check if the file is writable before attempting to save
				if ($url && is_writable($bookmark_file)) {
						file_put_contents($bookmark_file, $url . PHP_EOL, LOCK_EX);
				}

				// Redirect back to the page where the form is
				redirect($_SERVER['HTTP_REFERER'] ?? site_url());
		}
}
