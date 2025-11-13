<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

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
        $query = trim($this->input->get('q'));
        $results = [];

				$data['title'] = 'Search Results';
        // Define your top-level sections manually
        $sections = ['books', 'tutorials', 'lyrics'];

        if ($query !== '') {
            foreach ($sections as $section) {
                $section_path = APPPATH . 'views/' . $section;
                if (!is_dir($section_path)) continue;

                $files = $this->get_files_recursive($section_path);

                foreach ($files as $file) {
                    $content = @file_get_contents($file);
                    if ($content !== false && mb_stripos($content, $query, 0, 'UTF-8') !== false) {
                        $pos = mb_stripos($content, $query, 0, 'UTF-8');
                        $snippet = mb_substr($content, max(0, $pos - 30), 150, 'UTF-8');
                        $snippet = preg_replace('/[#>*_`~\-]+/', '', $snippet);
                        $snippet = strip_tags($snippet);

                        // Relative path
                        $relative_path = str_replace(APPPATH . 'views/', '', $file);
                        $parts = explode('/', $relative_path);
                        $filename = array_pop($parts);
                        $name = str_replace(['.md', '.txt'], '', $filename);

                        // First part is section, second is book
                        $book = isset($parts[1]) ? $parts[1] : $parts[0];

                        $results[] = [
                            'section' => ucfirst($section),
                            'path' => $relative_path,
                            'url' => str_replace(['.md', '.txt'], '', $relative_path),
                            'book' => $book,
                            'name' => $name,
                            'match_snippet' => htmlspecialchars($snippet) . '...',
                        ];
                    }
                }
            }
        }

        $data['query'] = $query;
        $data['results'] = $results;
        $data['sections'] = $sections;

        $this->load->view('templates/header', $data);
        $this->load->view('search_results', $data);
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
