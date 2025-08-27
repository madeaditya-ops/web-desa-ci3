<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 * @property Dusun_model $Dusun_model
 */
class Dusun extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dusun_model');
    }

    public function index()
    {
        $data['dusun'] = $this->Dusun_model->get_all();
        
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/dusun/index', $data);
        $this->load->view('template_admin/footer');
    }

   public function tambah()
{
    if ($this->input->post()) {  // Cukup cek ada POST data
        $data = [
            'nama_dusun' => $this->input->post('nama_dusun', TRUE)
        ];
        $this->Dusun_model->insert($data);
        redirect('dusun');
    } else {
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/dusun/tambah');
        $this->load->view('template_admin/footer');
    }
}


   public function edit($id)
{
    if ($this->input->post()) {
        $data = [
            'nama_dusun' => $this->input->post('nama_dusun', TRUE)
        ];
        $this->Dusun_model->update($id, $data);
        redirect('dusun');
    } else {
        $data['dusun'] = $this->Dusun_model->get_by_id($id);
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/dusun/edit', $data);
        $this->load->view('template_admin/footer');
    }
}


    public function hapus($id)
    {
        $this->Dusun_model->delete($id);
        redirect('dusun');
    }
}
