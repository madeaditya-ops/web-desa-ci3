<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Berita_model $Berita_model
 * @property Galeri_model $Galeri_model
 * @property Aparatur_model $Aparatur_model
 * @property Peraturan_model $Peraturan_model
 * @property Potensi_model $Potensi_model
 * @property Apbdes_model $Apbdes_model
 * @property Lembaga_model $Lembaga_model  
 * @property CI_Input $input
 * @property CI_Pagination $pagination
 * @property CI_Config $config
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
        $this->load->model('Lembaga_model');
        
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


    public function berita_desa()
    {
        $this->load->library('pagination');

        if ($this->input->get('page') === NULL) {
            $_GET['page'] = '1';
        }

        $page = (ctype_digit($_GET['page'])) ? (int)$_GET['page'] : 1;

        $limit  = 3;
        $offset = ($page - 1) * $limit;

        $config['base_url'] = site_url('landing/berita_desa');
        $config['total_rows'] = $this->Berita_model->count_berita();
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = TRUE;
        $config['cur_page'] = $page;

        // Bootstrap 5
        $config['full_tag_open']  = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open']   = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']  = '</span></li>';
        $config['num_tag_open']   = '<li class="page-item">';
        $config['num_tag_close']  = '</li>';
        $config['attributes']     = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        $data['breadcrumb'] = [
            ['title' => 'Beranda', 'url' => base_url()],
            ['title' => 'Informasi Publik', 'url' => site_url('landing/berita_desa')],
            ['title' => 'Berita Desa', 'url' => '']
        ];

        $data['title'] = "Berita Desa Blahbatuh";
        $data['berita'] = $this->Berita_model->get_berita_pagination($limit, $offset);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('landing/berita_desa', $data);
        $this->load->view('template/footer');
    }


    public function galeri_foto()
    {
        $data['title'] = "Galeri Foto Desa Blahbatuh";
        $data['galeri'] = $this->Galeri_model->get_all_latest_galeri();

        // Breadcrumb
        $data['breadcrumb'] = [
            [
                'title' => 'Beranda',
                'url'   => base_url()
            ],
            [
                'title' => 'Galeri Foto',
                'url'   => '' // halaman aktif
            ]
        ];

        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('landing/galeri_foto', $data);
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
        $data['meta_description'] = "Peta wilayah Desa Blahbatuh yang menampilkan batas desa, lokasi dusun, dan informasi geografis wilayah administrasi desa.";
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


    public function detail_berita($id)
    {
        $berita = $this->Berita_model->get_by_id($id);

        if (!$berita) show_404();

        $data['berita'] = $berita;
        $data['url'] = site_url('berita/detail/'.$id);

        // Breadcrumb
        $data['breadcrumb'] = [
            [
                'title' => 'Beranda',
                'url'   => base_url()
            ],
            [
                'title' => 'Informasi Publik',
                'url'   => site_url('landing/berita_desa')
            ],
            [
                'title' => 'Berita',
                'url'   => '' 
            ]
        ];

        
        $this->load->view('template/header',);
        $this->load->view('template/navbar');
        $this->load->view('landing/detail_berita', $data);
        $this->load->view('template/footer');
    }



    public function lembaga($slug = null)
    {
        if ($slug === null) {

            $data['title']   = "Jenis Kelembagaan Desa Blahbatuh";
            $data['lembaga'] = $this->Lembaga_model->get_all_lembaga();

            $grouped= [
                'lembaga_desa'=>[],
                'lembaga_kemasyarakatan'=>[],
                'badan_usaha'=>[],
                'lembaga_lainnya'=>[],
            ];

            foreach ($data['lembaga'] as $item) {
                $grouped[$item['jenis_lembaga']][] = $item;
            };

            $data['lembaga_group'] = $grouped;

            $nama_jenis = [
                'lembaga_desa' => 'Lembaga Desa',
                'lembaga_kemasyarakatan' => 'Lembaga Kemasyarakatan Desa',
                'badan_usaha' => 'Badan Usaha Milik Desa (BUMDesa)',
                'lembaga_lainnya' => 'Lembaga Lainnya'
            ];

            $data['nama_jenis'] = $nama_jenis;

            $this->load->view('template/header', $data);
            $this->load->view('template/navbar');
            $this->load->view('landing/lembaga', $data);
            $this->load->view('template/footer');
        } 
        else {

            $lembaga = $this->Lembaga_model->get_lembaga_by_slug($slug);

            if (!$lembaga) {
                show_404();
            }

            $data['title']   = $lembaga['nama']; //menyimpan nama lembaga saja
            $data['meta']    = $lembaga; //menyimpan seluruh data lembaga
            $data['anggota'] = $this->Lembaga_model->get_anggota_by_slug($slug);
            $data['bidang']  = $this->Lembaga_model->get_bidang_by_slug($slug);


            // Breadcrumb
            $data['breadcrumb'] = [
                [
                    'title' => 'Beranda',
                    'url'   => base_url()
                ],
                [
                    'title' => 'Lembaga',
                    'url'   => site_url('landing/lembaga')
                ],
                [
                    'title' => 'Detail Lembaga',
                    'url'   => '' // halaman aktif
                ]
            ];

            $this->load->view('template/header', $data);
            $this->load->view('template/navbar');
            $this->load->view('landing/detail_lembaga', $data);
            $this->load->view('template/footer');
        }
    }

    

}
