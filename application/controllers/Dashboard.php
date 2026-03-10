<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 * @property CI_Session $session
 * 
 * @property Pengaduan_model $Pengaduan_model
 */


class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();   
        $this->load->model('Pengaduan_model');
    }

    public function index()
    {
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/dashboard');
        $this->load->view('template_admin/footer');
    }


    public function get_notifikasi(){

        $data = $this->Pengaduan_model->get_notifikasi();
        $jumlah = $this->Pengaduan_model->count_notifikasi();
        $last_id = $this->Pengaduan_model->get_last_pengaduan_id();

        echo json_encode([
            'jumlah' => $jumlah,
            'data' => $data,
            'last_id' => $last_id
        ]);

    }

    public function read_notifikasi(){
        $this->Pengaduan_model->read_notifikasi();

    }

    public function read_single_notifikasi($id_pengaduan){
        $this->Pengaduan_model->read_single_notifikasi($id_pengaduan);

        echo json_encode([
            'status' => 'ok'
        ]);
    }

}
