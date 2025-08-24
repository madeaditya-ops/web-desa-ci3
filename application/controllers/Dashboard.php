<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('auth');
        cek_login(); // helper cek role
    }

    public function admin() {
        cek_role('admin');
        $this->load->view('admin/admin');
    }

    public function kades() {
        cek_role('kades');
        $this->load->view('kades/kades');
    }

    public function kadus() {
        cek_role('kadus');
        $this->load->view('kadus/kadus');
    }
}
