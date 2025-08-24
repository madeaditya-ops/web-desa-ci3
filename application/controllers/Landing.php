<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Berita_model');
        $this->load->model('Galeri_model');
    }

    public function index()
    {
        $data['title'] = "Website Desa Blahbatuh";
        $data['berita'] = $this->Berita_model->get_latest_berita();
        $data['galeri'] = $this->Galeri_model->get_latest_galeri();
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('landing/beranda', $data);
        $this->load->view('template/footer');
    }
}
