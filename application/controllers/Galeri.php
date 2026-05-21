<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Upload $upload
 * @property CI_Form_validation $form_validation
 * @property Galeri_model $Galeri_model
 */
class Galeri extends SuperAdmin_Middleware {

    public function __construct() {
        parent::__construct();
        $this->load->model('Galeri_model');
        $this->load->library('upload');
        $this->load->library('form_validation'); 
        $this->load->library('session');    
    } 

    public function index() {
        $data['galeri'] = $this->Galeri_model->get_all();
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/galeri/index', $data);
        $this->load->view('template_admin/footer');
    }

    public function create() {
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/galeri/create');
        $this->load->view('template_admin/footer');
    }

    public function store() {
        // Validasi form
        $this->form_validation->set_rules('caption', 'Caption', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            if (empty($_FILES['gambar']['name'])) {
                $this->session->set_flashdata('error', 'Gambar wajib diunggah!');
                $this->create();
                return; 
            }

            $config['upload_path']   = './uploads/galeri/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']      = 2048; 
            $config['encrypt_name']  = TRUE; 

            $this->upload->initialize($config);

            if ($this->upload->do_upload('gambar')) {
                $upload_data = $this->upload->data();
                $gambar = $upload_data['file_name'];

                $data = [
                    'caption' => $this->input->post('caption'),
                    'gambar'  => $gambar
                ];

                $this->Galeri_model->insert($data);
                $this->session->set_flashdata('success', 'Galeri berhasil ditambahkan!');
                redirect('galeri');
            } else {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error);
                $this->create();
            }
        }
    }

    public function edit($id) {
        $data['galeri'] = $this->Galeri_model->get_by_id($id);
        if (!$data['galeri']) {
            show_404();
        }
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/galeri/edit', $data);
        $this->load->view('template_admin/footer');
    }

    public function update($id) {
        $old_data = $this->Galeri_model->get_by_id($id);

        $this->form_validation->set_rules('caption', 'Caption', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $gambar = $old_data->gambar;

            if (!empty($_FILES['gambar']['name'])) {
                $config['upload_path']   = './uploads/galeri/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size']      = 2048;
                $config['encrypt_name']  = TRUE;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('gambar')) {
                    $upload_data = $this->upload->data();
                    $gambar = $upload_data['file_name']; 
                    // hapus file lama
                    if ($old_data->gambar && file_exists('./uploads/galeri/' . $old_data->gambar)) {
                        unlink('./uploads/galeri/' . $old_data->gambar);
                    }
                } else {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect('galeri/edit/' . $id);
                    return;
                }
            }

            $data = [
                'caption' => $this->input->post('caption'),
                'gambar'  => $gambar
            ];

            $this->Galeri_model->update($id, $data);
            $this->session->set_flashdata('success', 'Galeri berhasil diperbarui!');
            redirect('galeri');
        }
    }

    public function delete($id) {
        $galeri = $this->Galeri_model->get_by_id($id);

        if ($galeri) {
            if ($galeri->gambar && file_exists('./uploads/galeri/' . $galeri->gambar)) {
                unlink('./uploads/galeri/' . $galeri->gambar);
            }
            $this->Galeri_model->delete($id);
            $this->session->set_flashdata('success', 'Galeri berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Data galeri tidak ditemukan!');
        }
        redirect('galeri');
    }
}
