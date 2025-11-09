<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Books extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');

        // Password protection: check cookie
        if (!isset($_COOKIE['access_token']) || $_COOKIE['access_token'] !== 'ok') {
            redirect('login');
        }
    }

    /**
     * Default homepage / table of contents
     */
    public function index()
    {
        $data['title'] = 'らいぶらり';
        $this->load->view('templates/header', $data);
        $this->load->view('index', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Flexible view loader for books, volumes, and chapters.
     */
    public function view(...$segments)
    {
        if (empty($segments)) {
            redirect('/');
            return;
        }

        $book = array_shift($segments);
        $base_path = APPPATH . "views/$book/";

        if (!is_dir($base_path)) {
            $this->_show404();
            return;
        }

        $current_path = $base_path;
        $file_to_load = null;
        $current_segments = []; // only subfolders after $book

        // Traverse deeper into segments
        foreach ($segments as $segment) {
            $next_md     = $current_path . "$segment.md";
            $next_php    = $current_path . "$segment.php";
            $next_folder = $current_path . "$segment/";

            if (file_exists($next_md)) {
                $file_to_load = $next_md;
                $current_segments[] = $segment;
                break;
            } elseif (file_exists($next_php)) {
                $file_to_load = $next_php;
                $current_segments[] = $segment;
                break;
            } elseif (is_dir($next_folder)) {
                $current_path = $next_folder;
                $current_segments[] = $segment;
                $file_to_load = null;
            } else {
                $this->_show404();
                return;
            }
        }

        // --- FOLDER & MD FILE LINKS ---
        if (!$file_to_load) {
            $subfolders = [];
            $md_files = [];

            foreach (scandir($current_path) as $entry) {
                if ($entry === '.' || $entry === '..') continue;
                $full = $current_path . $entry;

                if (is_dir($full)) {
                    $subfolders[] = $entry;
                } elseif (preg_match('/\.md$/i', $entry) && strtolower($entry) !== 'readme.md') {
                    $md_files[] = basename($entry, '.md');
                }
            }

            sort($subfolders);
            sort($md_files);

            $links = [];
            foreach ($subfolders as $d) {
                $links[] = [
                    'type' => 'folder',
                    'name' => $d,
                    'url'  => site_url("$book/" . implode('/', $current_segments) . "/$d")
                ];
            }
            foreach ($md_files as $f) {
                $links[] = [
                    'type' => 'file',
                    'name' => $f,
                    'url'  => site_url("$book/" . implode('/', $current_segments) . "/$f")
                ];
            }

            $data['links'] = $links;
            $readme_path = $current_path . 'README.md';
            if (file_exists($readme_path)) {
                $file_to_load = $readme_path;
            } elseif (empty($links)) {
                $this->_show404();
                return;
            }

            $data['title'] = ucfirst($book) . (count($current_segments) ? ' - ' . implode(' - ', $current_segments) : '');
        }

				// --- BREADCRUMB LOGIC ---
				$breadcrumb = [];
				$path_segments = array_merge([$book], $current_segments);

				if ($file_to_load && pathinfo($file_to_load, PATHINFO_EXTENSION) === 'md') {
						$basename = basename($file_to_load, '.md');
						if (strtolower($basename) !== 'readme') {
								// Only append if it's not already the last segment
								if (empty($current_segments) || end($current_segments) !== $basename) {
										$path_segments[] = $basename;
								}
						}
				}

				foreach ($path_segments as $idx => $segment) {
						$breadcrumb[] = [
								'name' => ucfirst($segment),
								'url'  => site_url(implode('/', array_slice($path_segments, 0, $idx + 1)))
						];
				}

				$data['breadcrumb'] = $breadcrumb;
				// --- BREADCRUMB LOGIC END ---

        // --- TITLE & MD PATH ---
        $title = ucfirst($book);
        if (!empty($current_segments)) {
            $title .= ' - ' . implode(' - ', array_map('ucfirst', $current_segments));
        }
        $data['title']   = $title;
        $data['md_path'] = $file_to_load ?? null;

        // --- CHAPTER NAVIGATION ---
        $basename = basename($file_to_load, '.md');
        if (preg_match('/(\d+)$/', $basename, $m)) {
            $chapter_num = (int)$m[1];
            $dir = dirname($file_to_load) . '/';
            $prev_chapter = $dir . preg_replace('/\d+$/', $chapter_num - 1, $basename) . '.md';
            $next_chapter = $dir . preg_replace('/\d+$/', $chapter_num + 1, $basename) . '.md';

            $data['chapter_num'] = $chapter_num;
            $data['prev_url'] = file_exists($prev_chapter) ? preg_replace('/\d+$/', $chapter_num - 1, current_url()) : null;
            $data['next_url'] = file_exists($next_chapter) ? preg_replace('/\d+$/', $chapter_num + 1, current_url()) : null;
        } else {
            $data['chapter_num'] = null;
            $data['prev_url'] = null;
            $data['next_url'] = null;
        }

        $this->load->view('templates/header', $data);

        if (!$file_to_load) {
            $this->load->view('folder_index', $data);
            $this->load->view('templates/footer');
            return;
        }

        $ext = pathinfo($file_to_load, PATHINFO_EXTENSION);
        if ($ext === 'md') {
            require_once APPPATH . 'third_party/Parsedown/Parsedown.php';
            $Parsedown = new Parsedown();
            $Parsedown->setBreaksEnabled(true);

            $md_content = file_exists($file_to_load) ? file_get_contents($file_to_load) : '';
            $base_segments = !empty($current_segments) ? implode('/', $current_segments) . '/' : '';

            // Rewrite relative links
            $md_content = preg_replace_callback(
                '/\[(.*?)\]\((\.\/[^\)]+)\)/',
                function($matches) use ($book, $base_segments) {
                    $relative = ltrim($matches[2], './');
                    $url = site_url("$book/$base_segments$relative");
                    return '[' . $matches[1] . '](' . $url . ')';
                },
                $md_content
            );

            $data['html_content'] = $Parsedown->text($md_content);

            // Show both folder links + README if exists
            if (!empty($data['links'])) {
                $this->load->view('folder_index', $data);
            } else {
                $this->load->view('markdown', $data);
            }
        }

        $this->load->view('templates/footer');
    }

    private function _show404()
    {
        $this->output->set_status_header('404');
        $data['title'] = 'Page Not Found';
        $this->load->view('templates/header', $data);
        $this->load->view('errors/404', $data);
        $this->load->view('templates/footer');
    }
}
