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

    public function sejarah_desa()
    {
        $data['title'] = "Sejarah Desa Blahbatuh";
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('landing/sejarah_desa', $data);
        $this->load->view('template/footer');
    }

    public function visi_misi()
    {
        $data['title'] = "Visi & Misi Desa Blahbatuh";
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('landing/visi_misi', $data);
        $this->load->view('template/footer');
    }

        public function struktur_pemerintahan()
    {
        $data['title'] = "Struktur Organisasi dan Tata Kerja";
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('landing/struktur_pemerintahan', $data);
        $this->load->view('template/footer');
    }
}
