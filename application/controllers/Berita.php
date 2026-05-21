<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Upload $upload
 * @property CI_Form_validation $form_validation
 * @property Berita_model $Berita_model
 */
class Berita extends SuperAdmin_Middleware {

    public function __construct() {
        parent::__construct();
        $this->load->model('Berita_model');
        $this->load->library('upload');
        $this->load->library('form_validation'); 
        $this->load->library('session');    
    } 

    public function index() {
        $data['berita'] = $this->Berita_model->get_all();
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/berita/index', $data);
        $this->load->view('template_admin/footer');
    }

    public function create() {
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/berita/create');
        $this->load->view('template_admin/footer');
    }

    public function store() {
        $this->form_validation->set_rules('judul', 'Judul', 'required|trim');
        $this->form_validation->set_rules('isi', 'Isi Berita', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            if (empty($_FILES['gambar']['name'])) {
                $this->session->set_flashdata('error', 'Gambar wajib diunggah!');
                $this->create();
                return; 
            }
            $config['upload_path']   = './uploads/berita/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']      = 2048; 
            $config['encrypt_name']  = TRUE; 

            $this->upload->initialize($config);

            if ($this->upload->do_upload('gambar')) {
                // Jika upload berhasil
                $upload_data = $this->upload->data();
                $gambar = $upload_data['file_name'];

                $judul = $this->input->post('judul');

                $data = [
                    'judul'  => $judul,
                    'slug'   => create_slug($judul),
                    'isi'    => $this->input->post('isi'),
                    'gambar' => $gambar
                ];

                $this->Berita_model->insert($data);
                $this->session->set_flashdata('success', 'Berita berhasil ditambahkan!');
                redirect('berita');
            } else {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error);
                $this->create();
            }
        }
    }

    public function edit($id) {
        $data['berita'] = $this->Berita_model->get_by_id($id);
        if (!$data['berita']) {
            show_404();
        }
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/berita/edit', $data);
        $this->load->view('template_admin/footer');
    }

    public function update($id) {
        $old_data = $this->Berita_model->get_by_id($id);

        $this->form_validation->set_rules('judul', 'Judul', 'required|trim');
        $this->form_validation->set_rules('isi', 'Isi Berita', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $gambar = $old_data->gambar;

            if (!empty($_FILES['gambar']['name'])) {
                $config['upload_path']   = './uploads/berita/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size']      = 2048;
                $config['encrypt_name']  = TRUE;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('gambar')) {
                    $upload_data = $this->upload->data();
                    $gambar = $upload_data['file_name']; 
                } else {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect('berita/edit/' . $id);
                    return;
                }
            }

            $data = [
                'judul' => $this->input->post('judul'),
                'slug'  => create_slug($this->input->post('judul')), 
                'isi'   => $this->input->post('isi'),
                'gambar'=> $gambar
            ];

            $this->Berita_model->update($id, $data);
            $this->session->set_flashdata('success', 'Berita berhasil diperbarui!');
            redirect('berita');
        }
    }

    public function delete($id) {
        $berita = $this->Berita_model->get_by_id($id);

        if ($berita) {
            if ($berita->gambar && file_exists('./uploads/berita/' . $berita->gambar)) {
                unlink('./uploads/berita/' . $berita->gambar);
            }
            $this->Berita_model->delete($id);
            $this->session->set_flashdata('success', 'Berita berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Data berita tidak ditemukan!');
        }
        redirect('berita');
    }


    // Halaman detail berita (untuk share)
    public function detail($slug) {
        $data['berita'] = $this->Berita_model->get_by_slug($slug);

        if (!$data['berita']) {
            show_404();
        }

        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('landing/berita_detail', $data);
        $this->load->view('template/footer');
    }
}
