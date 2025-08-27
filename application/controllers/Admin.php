<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Input $input
 * @property CI_Upload $upload
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 * @property Surat_model $Surat_model
 * @property Dusun_model $Dusun_model
 */
use PhpOffice\PhpWord\TemplateProcessor;

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Surat_model','Dusun_model']);
        $this->load->library('session');
    }

    // Daftar pengajuan surat
    public function daftar_surat() {
        $data['pengajuan'] = $this->Surat_model->get_all_pengajuan();
        $this->load->view('admin/daftar_surat', $data);
    }

    // Konfirmasi surat & generate Word
    public function konfirmasi($id) {
        $pengajuan = $this->Surat_model->get_pengajuan($id);

        if (!$pengajuan) {
            $this->session->set_flashdata('error','Pengajuan tidak ditemukan');
            redirect('admin/daftar_surat');
        }

        $template = $this->Surat_model->get_template($pengajuan->jenis_surat, $pengajuan->dusun_id);

        if (!$template) {
            $this->session->set_flashdata('error','Template surat tidak ditemukan');
            redirect('admin/daftar_surat');
        }

        // Pastikan folder output ada
        if (!is_dir('./uploads/surat/')) {
            mkdir('./uploads/surat/', 0777, true);
        }

        $templatePath = './uploads/template_surat/'.$template->file_template;
        $outputFile = 'surat_'.$pengajuan->id_pengajuan.'.docx';
        $outputPath = './uploads/surat/'.$outputFile;

        try {
            $templateProcessor = new TemplateProcessor($templatePath);
            $templateProcessor->setValue('NAMA_WARGA', $pengajuan->nama_warga);
            $templateProcessor->setValue('ALAMAT', $pengajuan->alamat);
            $templateProcessor->setValue('DUSUN', $this->Dusun_model->get_name($pengajuan->dusun_id));
            $templateProcessor->setValue('JENIS_SURAT', $pengajuan->jenis_surat);

            $templateProcessor->saveAs($outputPath);

            // Update status & file_surat di DB
            $this->Surat_model->update_pengajuan($id, [
                'status' => 'disetujui',
                'file_surat' => $outputFile
            ]);

            $this->session->set_flashdata('success','Surat berhasil dikonfirmasi & Word dibuat');
        } catch (\Exception $e) {
            $this->session->set_flashdata('error','Gagal generate Word: '.$e->getMessage());
        }

        redirect('admin/daftar_surat');
    }

    // Upload template surat
    public function upload_template() {
        if ($this->input->post()) {
            $config['upload_path']   = './uploads/template_surat/';
            $config['allowed_types'] = 'docx';
            $config['max_size']      = 2048;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('file_template')) {
                $data = $this->upload->data();
                $insert = [
                    'dusun_id'      => $this->input->post('dusun_id', TRUE),
                    'jenis_surat'   => $this->input->post('jenis_surat', TRUE),
                    'file_template' => $data['file_name']
                ];
                $this->db->insert('template_surat', $insert);
                $this->session->set_flashdata('success','Template berhasil diupload');
                redirect('admin/template_surat');
            } else {
                $this->session->set_flashdata('error',$this->upload->display_errors());
                redirect('admin/upload_template');
            }
        } else {
            $data['dusun'] = $this->db->get('dusun')->result_array();
            $this->load->view('admin/upload_template', $data);
        }
    }
}
