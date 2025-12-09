<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Input $input
 * @property Template_surat_model $Template_surat_model
 * @property Dusun_model $Dusun_model
 */

require FCPATH.'vendor/autoload.php';
use PhpOffice\PhpWord\TemplateProcessor;

class Kadus extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Template_surat_model'); 
        $this->load->model('Dusun_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index()
    {
        $level_akses = $this->session->userdata('role'); 
        $data['templates'] = $this->Template_surat_model->get_by_level_akses($level_akses);

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kadus/dashboard', $data);
        $this->load->view('template_admin/footer');
    }
    
       private function tanggal_indonesia($tanggal)
    {
        // Konversi format tanggal ke 'd F Y' jika belum
        $tanggal_format = date('d F Y', strtotime($tanggal));
        
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        
        // Memecah tanggal menjadi bagian-bagian
        $pecahkan = explode(' ', $tanggal_format);
        
        // Format: tanggal [spasi] nama_bulan [spasi] tahun
        return $pecahkan[0] . ' ' . $bulan[ (int)date('m', strtotime($tanggal)) ] . ' ' . $pecahkan[2];
    }
    // --- FUNGSI BARU UNTUK MENAMPILKAN FORM ---
    public function gunakan($id_template)
    {
        $data['template'] = $this->Template_surat_model->get_by_id($id_template);
        if (!$data['template']) {
            $this->session->set_flashdata('error', 'Template tidak ditemukan!');
            redirect('kadus');
        }

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kadus/form_surat', $data); 
        $this->load->view('template_admin/footer');
    }

    // --- FUNGSI BARU UNTUK PROSES PEMBUATAN SURAT ---
    public function proses_surat()
    {
        $id_template = $this->input->post('id_template');
        $template = $this->Template_surat_model->get_by_id($id_template);
        $template_file = FCPATH . 'uploads/template_surat/' . $template->file_template;

        if (!file_exists($template_file)) {
            $this->session->set_flashdata('error', 'File template tidak ditemukan!');
            redirect('kadus');
        }

        try {
            // 1. Ambil ID Dusun dan Nama Kadus dari session
            $dusun_id = $this->session->userdata('dusun_id');
            $nama_kadus = $this->session->userdata('nama');

            // 2. Ambil detail data dusun dari database menggunakan model
            $dusun_data = $this->Dusun_model->get_by_id($dusun_id);
            
            // 3. Siapkan variabel (pastikan dusun_data ada untuk menghindari error)
            $nama_dusun = $dusun_data ? $dusun_data->nama_dusun : 'Data Dusun Tidak Ditemukan';
            $kode_dusun = $dusun_data ? $dusun_data->kode_dusun : 'ERR';

            $tanggal_sekarang = date('Y-m-d'); 
            $tanggal_surat = $this->tanggal_indonesia($tanggal_sekarang);


            $templateProcessor = new TemplateProcessor($template_file);

            // Mengisi placeholder dengan data yang sudah benar
            $templateProcessor->setValue('kop_dusun', strtoupper($nama_dusun));
            $templateProcessor->setValue('dusun', $nama_dusun);
            $templateProcessor->setValue('kode_dusun', $kode_dusun);
            $templateProcessor->setValue('nama_kadus', strtoupper($nama_kadus));
            $templateProcessor->setValue('tgl_buat', $tanggal_surat); 

            // Mengisi placeholder dari form input (ini sudah benar, tidak perlu diubah)
            $templateProcessor->setValue('kode_surat', $this->input->post('kode_surat'));
            // ... sisa setValue dari form ...
            $templateProcessor->setValue('no', $this->input->post('no'));
            $templateProcessor->setValue('nama', $this->input->post('nama'));
            $templateProcessor->setValue('nik', $this->input->post('nik'));
            $templateProcessor->setValue('tempat_lahir', $this->input->post('tempat_lahir').', '.' ');
            $templateProcessor->setValue('tgl_lahir', date('d-m-Y', strtotime($this->input->post('tgl_lahir'))));
            $templateProcessor->setValue('jenis_kelamin', $this->input->post('jenis_kelamin'));
            $templateProcessor->setValue('agama', $this->input->post('agama'));
            $templateProcessor->setValue('pekerjaan', $this->input->post('pekerjaan'));
            $templateProcessor->setValue('tujuan', $this->input->post('tujuan'));
            $templateProcessor->setValue('sts_kawin', $this->input->post('sts_kawin'));

            // ... Sisa kode untuk download file (tidak perlu diubah) ...
            $filename = 'Surat Keterangan - ' . $this->input->post('nama') . '.docx';
            $filename = preg_replace('/[\\/\?%*:|"<>\x00-\x1F\x7F]/', '_', $filename);
            
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header('Cache-Control: max-age=0');
            
            $templateProcessor->saveAs('php://output');

        } catch (\Exception $e) {
            $this->session->set_flashdata('error', 'Terjadi kesalahan saat membuat surat: ' . $e->getMessage());
            redirect('kadus');
        }
    }
    
    // --- FUNGSI BARU UNTUK DOWNLOAD BLANKO ---
    public function download_blanko($id_template)
    {
        $template = $this->Template_surat_model->get_by_id($id_template);
        $template_file = FCPATH . 'uploads/template_surat/' . $template->file_template;

        if (!file_exists($template_file)) {
            $this->session->set_flashdata('error', 'File template tidak ditemukan!');
            redirect('kadus');
        }

        try {
            // --- LAKUKAN PERUBAHAN YANG SAMA DI SINI ---
            $dusun_id = $this->session->userdata('dusun_id');
            $nama_kadus = $this->session->userdata('nama');
            $dusun_data = $this->Dusun_model->get_by_id($dusun_id);
            
            $nama_dusun = $dusun_data ? $dusun_data->nama_dusun : 'Data Dusun Tidak Ditemukan';
            $kode_dusun = $dusun_data ? $dusun_data->kode_dusun : 'ERR';
            
            $tanggal_sekarang = date('Y-m-d'); 
            $tanggal_surat = $this->tanggal_indonesia($tanggal_sekarang);


            $templateProcessor = new TemplateProcessor($template_file);

            // Data yang diisi otomatis
            $templateProcessor->setValue('kop_dusun', strtoupper($nama_dusun));
            $templateProcessor->setValue('dusun', $nama_dusun);
            $templateProcessor->setValue('kode_dusun', $kode_dusun);
            $templateProcessor->setValue('nama_kadus', strtoupper($nama_kadus));
            $templateProcessor->setValue('tgl_buat', $tanggal_surat);
            
            // Placeholder lain diisi titik-titik (tidak perlu diubah)
            $titik = '............................................................................................................';
            $templateProcessor->setValue('kode_surat', '.......');
            $templateProcessor->setValue('no', '.....');
            $templateProcessor->setValue('nama', $titik);
            $templateProcessor->setValue('nik', $titik);
            $templateProcessor->setValue('tempat_lahir', '');
            $templateProcessor->setValue('tgl_lahir', $titik);
            $templateProcessor->setValue('jenis_kelamin', $titik);
            $templateProcessor->setValue('agama', $titik);
            $templateProcessor->setValue('pekerjaan', $titik);
            $templateProcessor->setValue('tujuan', $titik);
            $templateProcessor->setValue('sts_kawin', $titik);


            // ... Sisa kode untuk download file (tidak perlu diubah) ...
            $filename = 'Blanko ' . $template->nama_surat . '.docx';
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header('Cache-Control: max-age=0');
            
            $templateProcessor->saveAs('php://output');

        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Gagal membuat blanko: ' . $e->getMessage());
            redirect('kadus');
        }
    }
}