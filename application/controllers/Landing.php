<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 * @property CI_Session $session
 * @property Berita_model $Berita_model
 */

class Landing extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Berita_model');
        
    }

    public function index()
    {
        $data['title'] = "Website Desa Blahbatuh";
        $data['berita'] = $this->Berita_model->get_latest_berita();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/navbar');
        $this->load->view('landing/beranda', $data);
        $this->load->view('layouts/footer');
    }
}
