<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Upload $upload
 * @property CI_Form_validation $form_validation
 * @property Lembaga_model $Lembaga_model
 */

class Bidang_lembaga extends SuperAdmin_Middleware {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Lembaga_model');
    }

    public function index($lembaga_id)
    {   
        $data['lembaga'] = $this->Lembaga_model->get_lembaga_by_id($lembaga_id);
        $data['bidang'] = $this->Lembaga_model->get_bidang_by_lembaga($lembaga_id);
        
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/lembaga/bidang_lembaga/index', $data);
        $this->load->view('template_admin/footer');
    }

    public function create($lembaga_id = null){
        if (!$lembaga_id) {
            show_404();
        }
        
        $data['lembaga'] = $this->Lembaga_model->get_lembaga_by_id($lembaga_id);
        
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/lembaga/bidang_lembaga/create', $data);
        $this->load->view('template_admin/footer');
    }

    public function store(){
        $this->form_validation->set_rules('nama_bidang', 'Nama Bidang', 'required|trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('bidang_lembaga/create');
            return;
        } 

        $lembaga_id = $this->input->post('lembaga_id');
        $urutan = $this->Lembaga_model->get_next_urutan('lembaga_bidang', $lembaga_id);
        $icon = 'bi-building';

        $data = [
            'lembaga_id' => $lembaga_id,
            'nama_bidang' => $this->input->post('nama_bidang'),
            'deskripsi' => $this->input->post('deskripsi'),
            'icon' => $icon,
            'urutan' => $urutan
        ];

        if($this->Lembaga_model->insert_bidang_lembaga($data)){
            $this->session->set_flashdata('success', 'Bidang lembaga berhasil ditambahkan!');
        } else {
            $this->session->set_flashdata('error', 'Bidang lembaga gagal ditambahkan!');
        }
        redirect('bidang_lembaga/index/' . $lembaga_id);
    }

    public function edit($id){
        $data['bidang'] = $this->Lembaga_model->get_bidang_by_id($id);
        
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/lembaga/bidang_lembaga/edit', $data);
        $this->load->view('template_admin/footer');
    }

    public function update($id){
        $this->form_validation->set_rules('nama_bidang', 'Nama Bidang', 'required|trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|trim');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('bidang_lembaga/edit/'.$id);
            return;
        } 

        $lembaga_id = $this->input->post('lembaga_id');

        $data = [
            'lembaga_id' => $lembaga_id,
            'nama_bidang' => $this->input->post('nama_bidang'),
            'deskripsi' => $this->input->post('deskripsi'),
        ];

        if($this->Lembaga_model->update_bidang_lembaga($id,$data)){
            $this->session->set_flashdata('success', 'Bidang lembaga berhasil diedit!');
        } else {
            $this->session->set_flashdata('error', 'Bidang lembaga gagal diedit!');
        }
        redirect('bidang_lembaga/index/' . $lembaga_id);
    }

    public function delete($id){
        $bidang = $this->Lembaga_model->get_bidang_by_id($id);
        $lembaga_id = $bidang['lembaga_id'];
        if($this->Lembaga_model->delete_bidang_lembaga($id)){
            $this->Lembaga_model->reset_urutan('lembaga_bidang', $lembaga_id);
            $this->session->set_flashdata('success', 'Bidang lembaga berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Bidang lembaga gagal dihapus!');
        }
        redirect('bidang_lembaga/index/' . $lembaga_id);
    }
}
