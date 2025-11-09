<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Errors extends CI_Controller {

    public function page_missing()
    {
        // Debug message
        echo "Custom 404 controller is being called!";
        exit;

        $this->output->set_status_header('404');
        $this->load->view('errors/404');
    }
}
