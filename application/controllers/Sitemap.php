<?php
class Sitemap extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
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

            // Get only the directories (folders), no files
            $folders = $this->get_folders_recursive($section_path);

            foreach ($folders as $folder) {
                // Remove APPPATH/views/ from path
                $relative_path = str_replace(APPPATH . 'views/', '', $folder);
                
                // Add the folder to results
                $results[] = [
                    'section' => $section,
                    'path' => $relative_path,
                ];
            }
        }

        $data['results'] = $results;
        $data['sections'] = $sections;

        $this->load->view('templates/header', $data);
        $this->load->view('sitemap_results', $data);
        $this->load->view('templates/footer');
    }

    private function get_folders_recursive($dir)
    {
        $allFolders = [];
        $items = scandir($dir);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;
            $path = $dir . '/' . $item;
            if (is_dir($path)) {
                $allFolders[] = $path;
                // Recursively scan subdirectories
                $allFolders = array_merge($allFolders, $this->get_folders_recursive($path));
            }
        }
        return $allFolders;
    }
}
