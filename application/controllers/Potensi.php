<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Upload $upload
 * @property CI_Form_validation $form_validation
 * @property Potensi_model $Potensi_model
 */
class Potensi extends Kades_Middleware {

    public function __construct() {
        parent::__construct();
        $this->load->model('Potensi_model'); 
        $this->load->library('upload');
        $this->load->library('form_validation'); 
        $this->load->library('session');     
    } 

    public function index() {
        $data['potensi'] = $this->Potensi_model->get_all_potensi(); 
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/potensi/index', $data); 
        $this->load->view('template_admin/footer');
    }

    public function create() {
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/potensi/create'); 
        $this->load->view('template_admin/footer');
    }

    public function store() {
        $this->form_validation->set_rules('nama', 'Nama Potensi', 'required|trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|trim');
        $this->form_validation->set_rules('lokasi', 'Lokasi', 'required|trim');

        $kategori = $this->input->post('kategori');

        if (empty($kategori)) {
            $this->session->set_flashdata('error', 'Kategori harus dipilih.');
            $this->create();
            return;
        }

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            if (empty($_FILES['gambar']['name'])) {
                $this->session->set_flashdata('error', 'Gambar wajib diunggah!');
                $this->create();
                return; 
            }

            $config['upload_path']   = './uploads/potensi/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']      = 2048; 
            $config['encrypt_name']  = TRUE; 

            $this->upload->initialize($config);

            if ($this->upload->do_upload('gambar')) {
                $upload_data = $this->upload->data();
                $gambar = $upload_data['file_name'];

                $data = [
                    'nama'      => $this->input->post('nama'),
                    'deskripsi' => $this->input->post('deskripsi'),
                    'kategori'  => $kategori,
                    'lokasi'    => $this->input->post('lokasi'),
                    'gambar'    => $gambar
                ];

                $this->Potensi_model->insert($data);
                $this->session->set_flashdata('success', 'Data potensi berhasil ditambahkan!');
                redirect('potensi');
            } else {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error);
                $this->create();
            }
        }
    }

    public function edit($id) {
        $data['potensi'] = $this->Potensi_model->get_by_id($id);
        if (!$data['potensi']) {
            show_404();
        }
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/potensi/edit', $data);
        $this->load->view('template_admin/footer');
    }

    public function update($id) {
        $old_data = $this->Potensi_model->get_by_id($id);

        $this->form_validation->set_rules('nama', 'Nama Potensi', 'required|trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|trim');
        $this->form_validation->set_rules('lokasi', 'Lokasi', 'required|trim');

        $kategori = $this->input->post('kategori');
    
        if (empty($kategori)) {
            $this->session->set_flashdata('error', 'Kategori harus dipilih.');
            $this->edit($id);
            return;
        }

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $gambar = $old_data->gambar;

            if (!empty($_FILES['gambar']['name'])) {
                $config['upload_path']   = './uploads/potensi/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size']      = 2048;
                $config['encrypt_name']  = TRUE;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('gambar')) {
                    if ($old_data->gambar && file_exists('./uploads/potensi/' . $old_data->gambar)) {
                        unlink('./uploads/potensi/' . $old_data->gambar);
                    }
                    $upload_data = $this->upload->data();
                    $gambar = $upload_data['file_name'];
                } else {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect('potensi/edit/' . $id);
                    return;
                }
            }

            $data = [
                'nama'      => $this->input->post('nama'),
                'deskripsi' => $this->input->post('deskripsi'),
                'kategori'  => $kategori,
                'lokasi'    => $this->input->post('lokasi'),
                'gambar'    => $gambar
            ];

            $this->Potensi_model->update($id, $data);
            $this->session->set_flashdata('success', 'Data potensi berhasil diperbarui!');
            redirect('potensi');
        }
    }

    public function delete($id) {
        $potensi = $this->Potensi_model->get_by_id($id);

        if ($potensi) {
            if ($potensi->gambar && file_exists('./uploads/potensi/' . $potensi->gambar)) {
                unlink('./uploads/potensi/' . $potensi->gambar);
            }
            $this->Potensi_model->delete($id);
            $this->session->set_flashdata('success', 'Data potensi berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Data potensi tidak ditemukan!');
        }
        redirect('potensi');
    }
}
