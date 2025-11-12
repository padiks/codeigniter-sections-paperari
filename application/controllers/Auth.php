<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    private $password_enabled = true;
    private $password = 'q';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'cookie']); // add cookie helper
    }

    public function login()
    {
        $data['title'] = 'ろぐいん';
        $data['show_hero'] = true;

        if (!$this->password_enabled) {
            set_cookie('access_token', 'ok', 3600); // valid for 1 hour
            redirect('/');
            return;
        }

        if ($this->input->post('password')) {
            $pw = strtolower($this->input->post('password'));

            if ($pw === $this->password) {
                // Use CI cookie helper
                set_cookie('access_token', 'ok', 3600);
                redirect('/');
            } else {
                $data['error'] = 'Wrong password!';
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('login', $data);
        $this->load->view('templates/footer');
    }

    public function logout()
    {
        delete_cookie('access_token');
        redirect('login');
    }
}

