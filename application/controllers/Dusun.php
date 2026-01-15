<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property Dusun_model $Dusun_model
 */
class Dusun extends Kades_Middleware {

    public function __construct() {
        parent::__construct();
        $this->load->model('Dusun_model');
        $this->load->library('form_validation'); 
        $this->load->library('session');    
    } 

    public function index() {
        $data['dusun'] = $this->Dusun_model->get_all();
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/dusun/index', $data);
        $this->load->view('template_admin/footer');
    }

    public function create() {
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/dusun/create');
        $this->load->view('template_admin/footer');
    }

    public function store() {
        // Validasi
        $this->form_validation->set_rules('kode_dusun', 'Kode Dusun', 'required|trim');
        $this->form_validation->set_rules('nama_dusun', 'Nama Dusun', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = [
                'kode_dusun' => $this->input->post('kode_dusun'),
                'nama_dusun' => $this->input->post('nama_dusun')
            ];

            $this->Dusun_model->insert($data);
            $this->session->set_flashdata('success', 'Dusun berhasil ditambahkan!');
            redirect('dusun');
        }
    }

    public function edit($id) {
        $data['dusun'] = $this->Dusun_model->get_by_id($id);
        if (!$data['dusun']) {
            show_404();
        }
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/dusun/edit', $data);
        $this->load->view('template_admin/footer');
    }

    public function update($id) {
        $this->form_validation->set_rules('kode_dusun', 'Kode Dusun', 'required|trim');
        $this->form_validation->set_rules('nama_dusun', 'Nama Dusun', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $data = [
                'kode_dusun' => $this->input->post('kode_dusun'),
                'nama_dusun' => $this->input->post('nama_dusun')
            ];

            $this->Dusun_model->update($id, $data);
            $this->session->set_flashdata('success', 'Dusun berhasil diperbarui!');
            redirect('dusun');
        }
    }

    public function delete($id) {
        $dusun = $this->Dusun_model->get_by_id($id);

        if ($dusun) {
            $this->Dusun_model->delete($id);
            $this->session->set_flashdata('success', 'Dusun berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Data dusun tidak ditemukan!');
        }
        redirect('dusun');
    }
}
