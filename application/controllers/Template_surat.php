<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property Template_surat_model $Template_surat_model
 * @property Dusun_model $Dusun_model
 * @property CI_Upload $upload
 */
class Template_surat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Template_surat_model');
        $this->load->model('Dusun_model');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('upload');
    }

    public function index() {
        $data['templates'] = $this->Template_surat_model->get_with_dusun();
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/template_surat/index', $data);
        $this->load->view('template_admin/footer');
    }

    public function create() {
        $data['dusun'] = $this->Dusun_model->get_all();
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/template_surat/create', $data);
        $this->load->view('template_admin/footer');
    }

    public function store() {
        // Validasi input
        $this->form_validation->set_rules('nama_surat', 'Nama Surat', 'required|trim');
        $this->form_validation->set_rules('level_akses', 'Level Akses', 'required');
        $this->form_validation->set_rules(
    'nomor_template_surat',
    'Nomor Template Surat',
    'required|trim'
            );


        if (empty($_FILES['file_template']['name'])) {
            $this->session->set_flashdata('error', 'File template wajib diunggah!');
            redirect('template_surat/create');
            return;
        }

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            // Konfigurasi upload
            $config['upload_path']   = './uploads/template_surat/';
            $config['allowed_types'] = 'docx|pdf';
            $config['max_size']      = 2048; // 2MB

            $this->upload->initialize($config);

            if (!$this->upload->do_upload('file_template')) {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('template_surat/create');
                return;
            }

            $file_template = $this->upload->data('file_name');

            $data = [
                'nomor_template_surat'  => $this->input->post('nomor_template_surat'),
                'nama_surat'    => $this->input->post('nama_surat'),
                'file_template' => $file_template,
                'level_akses'   => $this->input->post('level_akses'),
                'dusun_id'      => $this->input->post('dusun_id') ?: null
            ];

            $this->Template_surat_model->insert($data);
            $this->session->set_flashdata('success', 'Template Surat berhasil ditambahkan!');
            redirect('template_surat');
        }
    }

    public function edit($id) {
        $data['template'] = $this->Template_surat_model->get_by_id($id);
        $data['dusun']    = $this->Dusun_model->get_all();
        if (!$data['template']) {
            show_404();
        }

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/template_surat/edit', $data);
        $this->load->view('template_admin/footer');
    }

    public function update($id) {
        $template = $this->Template_surat_model->get_by_id($id);

        $this->form_validation->set_rules('nama_surat', 'Nama Surat', 'required|trim');
        $this->form_validation->set_rules('level_akses', 'Level Akses', 'required');
        $this->form_validation->set_rules(
                'nomor_template_surat',
                'Nomor Template Surat',
                'required|trim'
            );


        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $config['upload_path']   = './uploads/template_surat/';
            $config['allowed_types'] = 'docx|pdf';
            $config['max_size']      = 2048;

            $this->upload->initialize($config);

            $file_template = $template->file_template;
            if (!empty($_FILES['file_template']['name'])) {
                if ($this->upload->do_upload('file_template')) {
                    $file_template = $this->upload->data('file_name');
                    // Hapus file lama
                    if ($template->file_template && file_exists('./uploads/template_surat/'.$template->file_template)) {
                        unlink('./uploads/template_surat/'.$template->file_template);
                    }
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('template_surat/edit/'.$id);
                    return;
                }
            }

            $data = [
                'nomor_template_surat'  => $this->input->post('nomor_template_surat'),
                'nama_surat'    => $this->input->post('nama_surat'),
                'file_template' => $file_template,
                'level_akses'   => $this->input->post('level_akses'),
                'dusun_id'      => $this->input->post('dusun_id') ?: null
            ];

            $this->Template_surat_model->update($id, $data);
            $this->session->set_flashdata('success', 'Template Surat berhasil diperbarui!');
            redirect('template_surat');
        }
    }

    public function delete($id) {
        $template = $this->Template_surat_model->get_by_id($id);

        if ($template) {
            // hapus file fisik
            if ($template->file_template && file_exists('./uploads/template_surat/'.$template->file_template)) {
                unlink('./uploads/template_surat/'.$template->file_template);
            }
            $this->Template_surat_model->delete($id);
            $this->session->set_flashdata('success', 'Template Surat berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Data Template tidak ditemukan!');
        }
        redirect('template_surat');
    }
}
