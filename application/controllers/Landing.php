<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Berita_model $Berita_model
 * @property Galeri_model $Galeri_model
 * @property Aparatur_model $Aparatur_model
 * @property Peraturan_model $Peraturan_model
 * @property Potensi_model $Potensi_model
 * @property Apbdes_model $Apbdes_model
 * @property CI_Input $input
 */

class Landing extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Berita_model');
        $this->load->model('Galeri_model');
        $this->load->model('Aparatur_model');
        $this->load->model('Peraturan_model');
        $this->load->model('Potensi_model');
        $this->load->model('Apbdes_model');
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
        $data['aparatur'] = $this->Aparatur_model->get_aparatur_for_view();
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('landing/struktur_pemerintahan', $data);
        $this->load->view('template/footer');
    }
        public function peta_wilayah()
    {
        $this->load->helper('map');
        $data['lokasi_banjar'] = get_lokasi_banjar();
        $data['title'] = "Peta Wilayah";
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('landing/peta_wilayah', $data);
        $this->load->view('template/footer');
    }

    public function potensi_desa()
    {
        $data['title'] = "Potensi Desa Blahbatuh";
        $data['potensi'] = $this->Potensi_model->get_all();
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('landing/potensi_desa', $data);
        $this->load->view('template/footer');
    }

    public function peraturan_desa()
    {
        $data['title'] = "Peraturan Desa Blahbatuh";
        $data['peraturan'] = $this->Peraturan_model->get_all_peraturan();
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('landing/peraturan_desa', $data);
        $this->load->view('template/footer');
    }
    public function apbdes()
    {

        $tahun = $this->input->post('tahun');
        $judul = $this->input->post('judul');
        
        $data['title'] = "APBDes Blahbatuh";
        $data['dropdown_tahun'] = $this->Apbdes_model->get_tahun_dropdown('tahun');
        $data['dropdown_judul'] = $this->Apbdes_model->get_judul_dropdown('judul');
        $data['hasil'] = $this->Apbdes_model->get_apbdes_by_tahun_judul($tahun, $judul);

        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('landing/apbdes', $data);
        $this->load->view('template/footer');
    }

}
