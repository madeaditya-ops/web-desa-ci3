<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Input $input
 * @property CI_Upload $upload
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 * @property Surat_model $Surat_model
 * @property CI_DB_query_builder $db
 * @property Dusun_model $Dusun_model
 */
use PhpOffice\PhpWord\TemplateProcessor;

class Admin extends CI_Controller {

     public function __construct() {
        parent::__construct();
        // ✅ Load semua model yang dipakai Admin
        $this->load->database();
        $this->load->model('Surat_model');
        $this->load->model('Dusun_model');
        $this->load->library('session');
        $this->load->library('upload');
        $this->load->helper(array('url','form'));
    }

    // ================= Dashboard ===================
    public function index()
    {
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/dashboard');
        $this->load->view('template_admin/footer');
    }
    
    // ================= Pengajuan Surat ===================
    // Daftar pengajuan surat
    public function daftar_surat() {
        $data['pengajuan'] = $this->Surat_model->get_all_pengajuan();
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/daftar_surat', $data);
        $this->load->view('template_admin/footer');
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
        $outputFile   = 'surat_'.$pengajuan->id_pengajuan.'.docx';
        $outputPath   = './uploads/surat/'.$outputFile;

        try {
            $templateProcessor = new TemplateProcessor($templatePath);

            // isi nilai dari database ke template Word
            $templateProcessor->setValue('NAMA_WARGA', $pengajuan->nama_warga);
            $templateProcessor->setValue('ALAMAT', $pengajuan->alamat);
            $templateProcessor->setValue('DUSUN', $this->Dusun_model->get_name($pengajuan->dusun_id));
            $templateProcessor->setValue('JENIS_SURAT', $pengajuan->jenis_surat);
            $templateProcessor->setValue('NOMOR_SURAT', $template->nomor_surat); // nomor surat dari template

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

    // ================= Template Surat ===================
    // Controller: Admin.php
public function template_surat() {
    // Ambil parameter filter / search dari GET
    $search_nama  = $this->input->get('nama_surat');
    $filter_dusun = $this->input->get('dusun_id');

    // Ambil list dusun untuk dropdown filter
    $data['dusun_list'] = $this->db->get('dusun')->result(); // result() → array objek

    // Query template surat + join dusun
    $this->db->select('template_surat.*, dusun.nama_dusun');
    $this->db->from('template_surat');
    $this->db->join('dusun', 'dusun.id_dusun = template_surat.dusun_id', 'left');

    // Jika ada search / filter, tambahkan
    if (!empty($search_nama)) {
        $this->db->like('template_surat.nama_surat', $search_nama);
    }
    if (!empty($filter_dusun)) {
        $this->db->where('template_surat.dusun_id', $filter_dusun);
    }

    $data['templates'] = $this->db->get()->result(); // gunakan result() untuk looping di view

    // Load view
    $this->load->view('template_admin/header');
    $this->load->view('template_admin/sidebar');
    $this->load->view('admin/surat/template_surat', $data);
    $this->load->view('template_admin/footer');
}


    // Upload template surat (lama, masih bisa dipakai)
public function upload_template()
{
    if ($this->input->post()) {
        $config['upload_path']   = './uploads/template_surat/';
        $config['allowed_types'] = 'doc|docx|pdf';
        $config['max_size']      = 2048;

        $this->upload->initialize($config);

        if ($this->upload->do_upload('file_template')) {
            $fileData = $this->upload->data();

            $data = [
                'nama_surat'   => $this->input->post('nama_surat'),
                'nomor_surat'  => $this->input->post('nomor_surat'),
                'file_template'=> $fileData['file_name'],
                'level_akses'  => $this->input->post('level_akses'),
                'dusun_id'     => $this->input->post('dusun_id')
            ];

            if ($this->Surat_model->insert($data)) {
                $this->session->set_flashdata('success', 'Template surat berhasil diupload.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan ke database.');
            }

            redirect('admin/template_surat');
        } else {
            // Upload gagal → tampilkan error upload
            $data['error'] = $this->upload->display_errors();
            $data['dusun'] = $this->db->get('dusun')->result_array();

            $this->load->view('template_admin/header');
            $this->load->view('template_admin/sidebar');
            $this->load->view('admin/surat/upload_template', $data);
            $this->load->view('template_admin/footer');
        }
    } else {
        // Load form upload pertama kali
        $data['dusun'] = $this->db->get('dusun')->result_array();

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/surat/upload_template', $data);
        $this->load->view('template_admin/footer');
    }
}



// Tambah template surat
    public function tambah_surat()
    {
        if ($this->input->post()) {
             $config['upload_path']   = './uploads/template_surat/';
            $config['allowed_types'] = 'docx';
            $this->load->library('upload', $config);
            $config['max_size']      = 20048; // 20 MB

            $nomor_surat = $this->input->post('nomor_surat', TRUE);

            // Cek nomor surat sudah ada atau belum
            $exists = $this->db->get_where('template_surat', ['nomor_surat' => $nomor_surat])->row();
            if ($exists) {
                $this->session->set_flashdata('error', 'Nomor surat sudah digunakan!');
                redirect('admin/tambah_surat');
            }

            // Proses upload file
            if ($this->upload->do_upload('file_template')) {
                $data_upload = $this->upload->data();

                $insert = [
                    'nama_surat'    => $this->input->post('nama_surat', TRUE),
                    'nomor_surat'   => $nomor_surat,
                    'dusun_id'      => $this->input->post('dusun_id', TRUE),
                    'level_akses'   => $this->input->post('level_akses', TRUE),
                    'file_template' => $data_upload['file_name']
                ];

                $this->db->insert('template_surat', $insert);

                $this->session->set_flashdata('success', 'Template surat berhasil ditambahkan');
                redirect('admin/template_surat');
            } else {
                // Error upload
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('admin/tambah_surat');
            }
        } else {
            $data['dusun'] = $this->db->get('dusun')->result_array();
            $this->load->view('template_admin/header');
            $this->load->view('template_admin/sidebar');
            $this->load->view('admin/surat/tambah_surat', $data);
            $this->load->view('template_admin/footer');
        }
    }





    // Edit template surat
    public function edit_surat($id)
        {
            // ambil data template berdasarkan id
        $template = $this->db->get_where('template_surat', ['id_template' => $id])->row();
            if (!$template) {
                show_404();
            }

            if ($this->input->post()) {
                $config['upload_path']   = './uploads/template_surat/';
                $config['allowed_types'] = 'doc|docx|pdf';
                $config['max_size']      = 2048;

                $this->upload->initialize($config);

                $file_name = $template->file_template; // default: pakai file lama

                if (!empty($_FILES['file_template']['name'])) {
                    if ($this->upload->do_upload('file_template')) {
                        // hapus file lama jika ada
                        if ($template->file_template && file_exists('./uploads/template_surat/' . $template->file_template)) {
                            unlink('./uploads/template_surat/' . $template->file_template);
                        }
                        $fileData  = $this->upload->data();
                        $file_name = $fileData['file_name'];
                    } else {
                        $data['error']    = $this->upload->display_errors();
                        $data['template'] = $template;
                        $data['dusun']    = $this->db->get('dusun')->result_array();

                        $this->load->view('template_admin/header');
                        $this->load->view('template_admin/sidebar');
                        $this->load->view('admin/surat/edit_surat', $data);
                        $this->load->view('template_admin/footer');
                        return;
                    }
                }

                // update data ke database
                $data_update = [
                    'nama_surat'   => $this->input->post('nama_surat'),
                    'nomor_surat'  => $this->input->post('nomor_surat'),
                    'dusun_id'     => $this->input->post('dusun_id'),
                    'level_akses'  => $this->input->post('level_akses'),
                    'file_template'=> $file_name
                ];

                $this->db->where('id_template', $id);
                $this->db->update('template_surat', $data_update);


                redirect('admin/template_surat');
            } else {
                $data['template'] = $template;
                $data['dusun']    = $this->db->get('dusun')->result_array();

                $this->load->view('template_admin/header');
                $this->load->view('template_admin/sidebar');
                $this->load->view('admin/surat/edit_surat', $data);
                $this->load->view('template_admin/footer');
            }
        }





  public function delete_surat($id)
    {
        $this->Surat_model->delete($id);
        redirect('admin/template_surat');
    }

}
