<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property Apbdes_model $Apbdes_model
 * @property CI_Upload $upload
 */
class Apbdes extends Kades_Middleware {

    public function __construct() {
        parent::__construct();
        // Load model dan library yang dibutuhkan
        $this->load->model('Apbdes_model');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('upload');
    }

    public function index() {
        $data['apbdes_list'] = $this->Apbdes_model->get_all();
        
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/apbdes/index', $data); // View list
        $this->load->view('template_admin/footer');
    }

    public function create() {
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/apbdes/create'); // View create
        $this->load->view('template_admin/footer');
    }

    public function store() {
        // Aturan validasi
        $this->form_validation->set_rules('judul', 'Judul', 'required|trim');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric|exact_length[4]');

        // Validasi file wajib diunggah
        if (empty($_FILES['file_apbdes']['name'])) {
            $this->session->set_flashdata('error', 'File APBDes wajib diunggah!');
            redirect('apbdes/create');
            return;
        }

        if ($this->form_validation->run() == FALSE) {
            $this->create(); // Kembali ke form jika validasi gagal
        } else {
            // Konfigurasi upload
            $config['upload_path']   = './uploads/apbdes/';
            $config['allowed_types'] = 'pdf|jpg|jpeg|png|webp|svg'; // Izinkan PDF, Word, atau Excel
            $config['max_size']      = 2048; // 2MB

            // Buat direktori jika belum ada
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }
            
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('file_apbdes')) {
                // Jika upload gagal
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('apbdes/create');
                return;
            }

            // Jika upload berhasil
            $file_data = $this->upload->data('file_name');

            $data = [
                'judul'       => $this->input->post('judul'),
                'tahun'       => $this->input->post('tahun'),
                'file_apbdes' => $file_data
            ];

            $this->Apbdes_model->insert($data);
            $this->session->set_flashdata('success', 'Data APBDes berhasil ditambahkan!');
            redirect('apbdes');
        }
    }

    public function edit($id) {
        $data['apbdes'] = $this->Apbdes_model->get_by_id($id);
        if (!$data['apbdes']) {
            show_404(); // Tampilkan 404 jika data tidak ditemukan
        }

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/apbdes/edit', $data); // View edit
        $this->load->view('template_admin/footer');
    }

    public function update($id) {
        // Ambil data lama
        $apbdes = $this->Apbdes_model->get_by_id($id);

        $this->form_validation->set_rules('judul', 'Judul', 'required|trim');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|numeric|exact_length[4]');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id); // Kembali ke form edit jika validasi gagal
        } else {
            // Konfigurasi upload
            $config['upload_path']   = './uploads/apbdes/';
            $config['allowed_types'] = 'pdf|jpg|jpeg|png|webp|svg';
            $config['max_size']      = 2048;

            $this->upload->initialize($config);

            $file_apbdes = $apbdes->file_apbdes; // Ambil nama file lama

            // Cek jika ada file baru diunggah
            if (!empty($_FILES['file_apbdes']['name'])) {
                if ($this->upload->do_upload('file_apbdes')) {
                    
                    $file_apbdes = $this->upload->data('file_name'); // Ambil nama file baru
                    
                    // Hapus file lama
                    $old_file_path = './uploads/apbdes/'.$apbdes->file_apbdes;
                    if ($apbdes->file_apbdes && file_exists($old_file_path)) {
                        unlink($old_file_path);
                    }
                } else {
                    // Jika upload file baru gagal
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('apbdes/edit/'.$id);
                    return;
                }
            }

            // Data untuk update
            $data = [
                'judul'       => $this->input->post('judul'),
                'tahun'       => $this->input->post('tahun'),
                'file_apbdes' => $file_apbdes // Gunakan file baru atau file lama
            ];

            $this->Apbdes_model->update($id, $data);
            $this->session->set_flashdata('success', 'Data APBDes berhasil diperbarui!');
            redirect('apbdes');
        }
    }

    public function delete($id) {
        $apbdes = $this->Apbdes_model->get_by_id($id);

        if ($apbdes) {
            // Hapus file fisik
            $file_path = './uploads/apbdes/'.$apbdes->file_apbdes;
            if ($apbdes->file_apbdes && file_exists($file_path)) {
                unlink($file_path);
            }
            // Hapus data dari database
            $this->Apbdes_model->delete($id);
            $this->session->set_flashdata('success', 'Data APBDes berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Data APBDes tidak ditemukan!');
        }
        redirect('apbdes');
    }
}