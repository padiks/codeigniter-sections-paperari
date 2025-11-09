<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('md')) {
    function md($filename) {
        // Determine file path
        if (file_exists($filename)) {
            $path = $filename;
        } else {
            $path = FCPATH . ltrim($filename, '/');
        }

        if (!file_exists($path)) {
            return "<p>File not found: {$filename}</p>";
        }

        require_once(APPPATH . 'third_party/Parsedown/Parsedown.php');
        $Parsedown = new Parsedown();

        // Optionally allow markup breaks (Parsedown Extra has it)
        if (method_exists($Parsedown, 'setBreaksEnabled')) {
            $Parsedown->setBreaksEnabled(true); // <- enables line breaks
        }

        $content = file_get_contents($path);

        // Fallback: if parser doesn’t support line breaks, replace manually
        if (!method_exists($Parsedown, 'setBreaksEnabled')) {
            $content = str_replace("\n", "  \n", $content);
        }

        return $Parsedown->text($content);
    }
}
