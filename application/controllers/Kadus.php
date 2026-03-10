<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
        $bulan = [
            1 => 'Januari','Februari','Maret','April','Mei','Juni',
                 'Juli','Agustus','September','Oktober','November','Desember'
        ];

        $exp = explode('-', $tanggal);
        return $exp[2].' '.$bulan[(int)$exp[1]].' '.$exp[0];
    }

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

    public function proses_surat()
    {
        $id_template = $this->input->post('id_template');
        $template = $this->Template_surat_model->get_by_id($id_template);
        $template_file = FCPATH.'uploads/template_surat/'.$template->file_template;

        if (!file_exists($template_file)) {
            $this->session->set_flashdata('error', 'File template tidak ditemukan!');
            redirect('kadus');
        }

        try {

            $dusun_id   = $this->session->userdata('dusun_id');
            $nama_kadus = $this->session->userdata('nama') ;

            $dusun      = $this->Dusun_model->get_by_id($dusun_id);

            $nama_dusun = $dusun ? $dusun->nama_dusun : '';
            $kode_dusun = $dusun ? $dusun->kode_dusun : '';

            $tanggal_surat = $this->tanggal_indonesia(date('Y-m-d'));

            // ===== VALIDASI TANGGAL LAHIR =====
            $tgl_input = $this->input->post('tgl_lahir');
            $tgl_lahir = $tgl_input ? date('d-m-Y', strtotime($tgl_input)) : '';

            // ===== GABUNG TTL (PALING AMAN UNTUK WORD) =====
            $ttl = trim($this->input->post('tempat_lahir'));
            if ($tgl_lahir) {
                $ttl .= ', '.$tgl_lahir;
            }

            $templateProcessor = new TemplateProcessor($template_file);

            // ===== DATA OTOMATIS =====
            $templateProcessor->setValue('kop_dusun', strtoupper($nama_dusun));
            $templateProcessor->setValue('dusun', $nama_dusun);
            $templateProcessor->setValue('kode_dusun', $kode_dusun);
            $templateProcessor->setValue('nama_kadus', strtoupper($nama_kadus));
            $templateProcessor->setValue('tgl_buat', $tanggal_surat);

            // ===== DATA FORM =====
            $templateProcessor->setValue('kode_surat', $this->input->post('kode_surat'));
            $templateProcessor->setValue('no', $this->input->post('no'));
            $templateProcessor->setValue('nama', $this->input->post('nama'));
            $templateProcessor->setValue('nik', $this->input->post('nik'));
            $templateProcessor->setValue('ttl', $ttl);
            $templateProcessor->setValue('jenis_kelamin', $this->input->post('jenis_kelamin'));
            $templateProcessor->setValue('agama', $this->input->post('agama'));
            $templateProcessor->setValue('pekerjaan', $this->input->post('pekerjaan'));
            $templateProcessor->setValue('tujuan', $this->input->post('tujuan'));
            $templateProcessor->setValue('sts_kawin', $this->input->post('sts_kawin'));

            // ===== BERSIHKAN OUTPUT BUFFER (KRITIS) =====
            if (ob_get_length()) {
                ob_end_clean();
            }

            $filename = 'Surat Keterangan - '.$this->input->post('nama').'.docx';

            // REGEX AMAN (FIX)
            $filename = preg_replace('/[\/\\\\\?\%\*\:\|"<>\x00-\x1F\x7F]/', '_', $filename);

            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header('Cache-Control: max-age=0');

            $templateProcessor->saveAs('php://output');
            exit;


        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Terjadi kesalahan: '.$e->getMessage());
            redirect('kadus');
        }
    }

    public function download_blanko($id_template)
    {
        $template = $this->Template_surat_model->get_by_id($id_template);
        $template_file = FCPATH.'uploads/template_surat/'.$template->file_template;

        if (!file_exists($template_file)) {
            $this->session->set_flashdata('error', 'File template tidak ditemukan!');
            redirect('kadus');
        }

        try {

            $dusun_id   = $this->session->userdata('dusun_id');
            $nama_kadus = $this->session->userdata('nama');
            $dusun      = $this->Dusun_model->get_by_id($dusun_id);

            $nama_dusun = $dusun ? $dusun->nama_dusun : '';
            $kode_dusun = $dusun ? $dusun->kode_dusun : '';

            $tanggal_surat = $this->tanggal_indonesia(date('Y-m-d'));

            $templateProcessor = new TemplateProcessor($template_file);

            $templateProcessor->setValue('kop_dusun', strtoupper($nama_dusun));
            $templateProcessor->setValue('dusun', $nama_dusun);
            $templateProcessor->setValue('kode_dusun', $kode_dusun);
            $templateProcessor->setValue('nama_kadus', strtoupper($nama_kadus));
            $templateProcessor->setValue('tgl_buat', $tanggal_surat);

            $titik = '.........................................................';

            $templateProcessor->setValue('kode_surat', '.....');
            $templateProcessor->setValue('no', '.....');
            $templateProcessor->setValue('nama', $titik);
            $templateProcessor->setValue('nik', $titik);
            $templateProcessor->setValue('ttl', $titik);
            $templateProcessor->setValue('jenis_kelamin', $titik);
            $templateProcessor->setValue('agama', $titik);
            $templateProcessor->setValue('pekerjaan', $titik);
            $templateProcessor->setValue('tujuan', $titik);
            $templateProcessor->setValue('sts_kawin', $titik);

            if (ob_get_length()) {
                ob_end_clean();
            }

            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header("Content-Disposition: attachment; filename=\"Blanko {$template->nama_surat}.docx\"");
            header('Cache-Control: max-age=0');

            $templateProcessor->saveAs('php://output');

        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Gagal membuat blanko: '.$e->getMessage());
            redirect('kadus');
        }
    }
}
