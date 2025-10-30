<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property Peraturan_model $Peraturan_model
 * @property CI_Upload $upload
 */
class Peraturan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load model, library
        $this->load->model('Peraturan_model');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('upload');
    }

    // Menampilkan daftar semua peraturan
    public function index() {
        $data['peraturan_list'] = $this->Peraturan_model->get_all();
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/peraturan/index', $data); // View list
        $this->load->view('template_admin/footer');
    }

    // Menampilkan form tambah
    public function create() {
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/peraturan/create'); // View create
        $this->load->view('template_admin/footer');
    }

    // Menyimpan data baru
    public function store() {
        // Validasi input
        $this->form_validation->set_rules('judul', 'Judul', 'required|trim');

        // Validasi file wajib diunggah
        if (empty($_FILES['file_peraturan']['name'])) {
            $this->session->set_flashdata('error', 'File peraturan wajib diunggah!');
            redirect('peraturan/create');
            return;
        }

        if ($this->form_validation->run() == FALSE) {
            $this->create(); // Kembali ke form create jika validasi gagal
        } else {
            // Konfigurasi upload
            $config['upload_path']   = './uploads/peraturan/'; // Buat folder ini
            $config['allowed_types'] = 'docx|pdf';
            $config['max_size']      = 2048; // 2MB

            // Buat direktori jika belum ada
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }
            
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('file_peraturan')) {
                // Jika upload gagal
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('peraturan/create');
                return;
            }

            // Jika upload berhasil
            $file_peraturan = $this->upload->data('file_name');

            $data = [
                'judul'           => $this->input->post('judul'),
                'file_peraturan'  => $file_peraturan,
                'dibuat_tanggal'  => date('Y-m-d H:i:s') // Set tanggal hari ini
            ];

            $this->Peraturan_model->insert($data);
            $this->session->set_flashdata('success', 'Peraturan berhasil ditambahkan!');
            redirect('peraturan');
        }
    }

    // Menampilkan form edit
    public function edit($id) {
        $data['peraturan'] = $this->Peraturan_model->get_by_id($id);
        if (!$data['peraturan']) {
            show_404();
        }

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/peraturan/edit', $data); // View edit
        $this->load->view('template_admin/footer');
    }

    // Memperbarui data
    public function update($id) {
        $peraturan = $this->Peraturan_model->get_by_id($id);

        $this->form_validation->set_rules('judul', 'Judul', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id); // Kembali ke form edit jika validasi gagal
        } else {
            $config['upload_path']   = './uploads/peraturan/';
            $config['allowed_types'] = 'docx|pdf';
            $config['max_size']      = 2048;

            $this->upload->initialize($config);

            $file_peraturan = $peraturan->file_peraturan; // Ambil nama file lama

            // Cek jika ada file baru diunggah
            if (!empty($_FILES['file_peraturan']['name'])) {
                if ($this->upload->do_upload('file_peraturan')) {
                    
                    $file_peraturan = $this->upload->data('file_name'); // Ambil nama file baru
                    
                    // Hapus file lama
                    $old_file_path = './uploads/peraturan/'.$peraturan->file_peraturan;
                    if ($peraturan->file_peraturan && file_exists($old_file_path)) {
                        unlink($old_file_path);
                    }
                } else {
                    // Jika upload file baru gagal
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('peraturan/edit/'.$id);
                    return;
                }
            }

            // Data untuk update
            $data = [
                'judul'           => $this->input->post('judul'),
                'file_peraturan'  => $file_peraturan,
                // 'dibuat_tanggal' tidak diupdate, karena itu tanggal pembuatan
            ];

            $this->Peraturan_model->update($id, $data);
            $this->session->set_flashdata('success', 'Peraturan berhasil diperbarui!');
            redirect('peraturan');
        }
    }

    // Menghapus data
    public function delete($id) {
        $peraturan = $this->Peraturan_model->get_by_id($id);

        if ($peraturan) {
            // Hapus file fisik
            $file_path = './uploads/peraturan/'.$peraturan->file_peraturan;
            if ($peraturan->file_peraturan && file_exists($file_path)) {
                unlink($file_path);
            }
            // Hapus data dari database
            $this->Peraturan_model->delete($id);
            $this->session->set_flashdata('success', 'Peraturan berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Data Peraturan tidak ditemukan!');
        }
        redirect('peraturan');
    }
}