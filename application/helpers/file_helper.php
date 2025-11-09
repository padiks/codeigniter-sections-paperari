<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Recursively find all .md files inside a directory and its subdirectories
 *
 * @param string $directory  The root directory to search
 * @return array  List of Markdown file paths (relative to views/)
 */
if (!function_exists('find_markdown_files')) {
    function find_markdown_files($directory = null)
    {
        if ($directory === null) {
            $directory = APPPATH . 'views'; // Use absolute path
        }

        $result = [];

        if (!is_dir($directory)) {
            return $result;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && strtolower(pathinfo($file->getFilename(), PATHINFO_EXTENSION)) === 'md') {
                // Convert absolute path to relative (e.g., "books/mynoghra/volume1/chapter1.md")
                $relativePath = str_replace(APPPATH . 'views' . DIRECTORY_SEPARATOR, '', $file->getPathname());
                $result[] = str_replace('\\', '/', $relativePath); // Normalize slashes for Windows
            }
        }

        return $result;
    }
}

// Existing find_markdown_files() stays here...

// ---- Add this at the bottom ----
if (!function_exists('dump_text_files')) {
    function dump_text_files($directory = null, $ignore_folders = [])
    {
        if ($directory === null) {
            $directory = APPPATH . 'views';
        }

        $result = [];

        if (!is_dir($directory)) return $result;

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($iterator as $file) {
            if ($file->isFile()) {

                // Skip files in ignored folders
                foreach ($ignore_folders as $ignore) {
                    if (strpos($file->getPathname(), DIRECTORY_SEPARATOR . $ignore . DIRECTORY_SEPARATOR) !== false) {
                        continue 2; // skip this file
                    }
                }

                // Only .md or .txt
                $ext = strtolower(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
                if (in_array($ext, ['md', 'txt'])) {
                    $relativePath = str_replace($directory . DIRECTORY_SEPARATOR, '', $file->getPathname());
                    $content = @file_get_contents($file->getPathname());
                    $result[] = [
                        'path' => str_replace('\\', '/', $relativePath),
                        'content' => $content
                    ];
                }
            }
        }

        return $result;
    }
}
