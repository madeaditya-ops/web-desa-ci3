<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kadus extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
    }

    public function index()
    {
        $this->load->view('template_kadus/header');
        $this->load->view('template_kadus/sidebar');
        $this->load->view('kadus/dashboard');
        $this->load->view('template_kadus/footer');
    }
}
