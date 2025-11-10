<?php
class Sitemap extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('markdown');
        $this->load->helper('file');

        // Password protection
        if (!isset($_COOKIE['access_token']) || $_COOKIE['access_token'] !== 'ok') {
            redirect('login');
        }
    }

    public function index()
    {
        $data['title'] = 'Sitemap';
        // Define your top-level sections manually
        $sections = ['books', 'tutorials', 'lyrics'];

        $results = [];
        
        foreach ($sections as $section) {
            $section_path = APPPATH . 'views/' . $section;
            if (!is_dir($section_path)) continue;

            // Recursively get all .md or .txt files
            $files = $this->get_files_recursive($section_path);

            foreach ($files as $file) {
                // Remove APPPATH/views/ from path
                $relative_path = str_replace(APPPATH . 'views/', '', $file);

                // Split path into parts
                $parts = explode('/', $relative_path);
                $filename = array_pop($parts);
                $name = str_replace(['.md', '.txt'], '', $filename);

                // First part is always section, second is book
                $book = isset($parts[1]) ? $parts[1] : $parts[0];

                // If it's README.md, treat it as a folder (remove .md from the URL)
                if (strtolower($name) === 'readme') {
                    $relative_path = implode('/', $parts); // Just the folder path without README.md
                }

                $results[] = [
                    'section' => $section,
                    'path' => $relative_path,
                    'book' => $book,
                    'name' => $name,
                    'full_parts' => $parts, // for nested structure
                ];
            }
        }

        $data['results'] = $results;
        $data['sections'] = $sections;

        $this->load->view('templates/header', $data);
        $this->load->view('sitemap_results', $data);
        $this->load->view('templates/footer');
    }

    private function get_files_recursive($dir)
    {
        $allFiles = [];
        $items = scandir($dir);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;
            $path = $dir . '/' . $item;
            if (is_dir($path)) {
                $allFiles = array_merge($allFiles, $this->get_files_recursive($path));
            } elseif (preg_match('/\.(md|txt)$/i', $item)) {
                $allFiles[] = $path;
            }
        }
        return $allFiles;
    }
}
