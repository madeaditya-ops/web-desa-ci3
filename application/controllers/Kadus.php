<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Input $input
 * @property CI_Upload $upload
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 * @property Surat_model $Surat_model
 * @property Dusun_model $Dusun_model
 */
class Kadus extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(['Surat_model','Dusun_model']);
    }

     public function buat_surat() {
    if ($this->input->post()) {
        $data = [
            'nik_warga'   => $this->input->post('nik', TRUE),
            'nama_warga'  => $this->input->post('nama', TRUE),
            'alamat'      => $this->input->post('alamat', TRUE),
            'dusun_id'    => $this->input->post('dusun_id', TRUE),
            'jenis_surat' => $this->input->post('jenis_surat', TRUE),
            'status'      => 'menunggu'
        ];

        $this->Surat_model->insert_pengajuan($data);
        redirect('kadus/daftar_surat');
    }

    $data['dusun'] = $this->Dusun_model->get_all();
    $this->load->view('kadus/form_surat', $data);
}


    
    public function index()
    {
        $this->load->view('template_kadus/header');
        $this->load->view('template_kadus/sidebar');
        $this->load->view('kadus/dashboard');
        $this->load->view('template_kadus/footer');
    }

public function daftar_surat()
{
    $data['pengajuan'] = $this->Surat_model->get_all_pengajuan();

    $this->load->view('template_kadus/header');
    $this->load->view('template_kadus/sidebar');
    $this->load->view('kadus/daftar_surat', $data);
    $this->load->view('template_kadus/footer');
}



public function form_surat() {
    $data['dusun'] = $this->Dusun_model->get_all();
    $this->load->view('template_kadus/header');
    $this->load->view('template_kadus/sidebar');
    $this->load->view('kadus/form_surat', $data);
    $this->load->view('template_kadus/footer');
}

}