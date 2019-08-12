<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Error_404 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->output->set_status_header('404');

        $info['title'] = "Error 404 Page Not Found !";
        // Make sure you actually have some view file named 404.php
        $this->load->view('templates/error404_view', $info);
    }
}
