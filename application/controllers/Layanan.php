<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Layanan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Layanan_model');
           $this->load->model('Surat_model');
        $this->load->model('Layanan_model');
         $this->load->model('Data_surat_model');
            $this->load->model('Data_surat_pending_model');
        $this->load->model('Dusun_model');
        $this->load->model('Arsip_model');
        $this->load->library('upload');

    }
    

    public function index() {
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/layanan/layanan_index');
        $this->load->view('template_admin/footer');
    }



}
