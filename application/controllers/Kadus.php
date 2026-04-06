<?php
defined('BASEPATH') or exit('No direct script access allowed');

require FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpWord\TemplateProcessor;

class Kadus extends CI_Controller
{

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Template_surat_model');
        $this->load->model('Dusun_model');
        $this->load->library('session');
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

    public function form_surat($id_template)
    {

        $data['template'] = $this->Template_surat_model->get_by_id($id_template);
        if (!$data['template']) redirect('kadus');

        $data['surat_list'] = $this->Template_surat_model->get_surat_list();

        // ambil dusun kadus yang login
        $dusun_id = $this->session->userdata('dusun_id');

        // ambil warga sesuai dusun kadus
        $data['warga'] = $this->db
            ->select('
            warga.nama,
            warga.no_nik,
            warga.tempat_lahir,
            warga.tanggal_lahir,
            warga.pekerjaan,
            jenis_kelamin.nama as jenis_kelamin,
            agama.nama as agama,
            status_perkawinan.nama as status_perkawinan
        ')
            ->from('warga')
            ->join('keluarga', 'keluarga.id = warga.keluarga_id')
            ->join('jenis_kelamin', 'jenis_kelamin.id = warga.jenis_kelamin_id', 'left')
            ->join('agama', 'agama.id = warga.agama_id', 'left')
            ->join('status_perkawinan', 'status_perkawinan.id = warga.status_perkawinan_id', 'left')
            ->where('keluarga.id_dusun', $dusun_id) // filter banjar
            ->order_by('warga.nama', 'ASC')
            ->get()
            ->result();

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kadus/form_surat', $data);
        $this->load->view('template_admin/footer');
    }

    public function proses_surat()
    {
        $id_template = $this->input->post('id_template');
        $template = $this->Template_surat_model->get_by_id($id_template);
        $dusun_id = $this->session->userdata('dusun_id');
        $dusun_data = $this->Dusun_model->get_by_id($dusun_id);

        // 1. Siapkan Data untuk Word dan JSON
        $post_data = $this->input->post();

        $id_template_pengantar = $this->input->post('id_template'); // 131 (Surat dusun)
        $id_template_tujuan    = $this->input->post('id_template_tujuan'); // 128/129/...
        // Ambil nama dusun asli
        $nama_dusun_asli = $dusun_data ? $dusun_data->nama_dusun : '';
        $post_data['kop_dusun']  = strtoupper($nama_dusun_asli); // Untuk ${kop_surat} di KOP (KAPITAL)
        $post_data['dusun']      = $nama_dusun_asli;             // Untuk ${dusun} di ISI (Normal)

        $post_data['tgl_buat']   = $this->tanggal_indonesia(date('Y-m-d'));
        $post_data['nama_kadus'] = strtoupper($this->session->userdata('nama'));
        $post_data['kode_dusun'] = $dusun_data ? $dusun_data->kode_dusun : '';
        $post_data['tahun']      = date('Y');
        $alamat_lengkap = 'Br. ' .
            ($post_data['dusun'] ?? '-') .
            ' /Kec. Blahbatuh Kab. Gianyar';

        $id_tujuan = $this->input->post('id_template_tujuan');

        $kode_surat = $this->db
            ->select('nomor_template_surat')
            ->get_where('template_surat', ['id_template' => $id_tujuan])
            ->row('nomor_template_surat');

        $nomor_pengantar = $kode_surat . '/' . $post_data['no'] . '/KBD.' . $post_data['kode_dusun'];

        // 2. LOGIKA GENERATE FILE (DI SIMPAN KE SERVER, BUKAN DOWNLOAD)
        $template_file = FCPATH . 'uploads/template_surat/' . $template->file_template;
        $new_filename = 'Draft_' . preg_replace('/[^A-Za-z0-9]/', '_', $post_data['nama']) . '_' . time() . '.docx';
        $save_path = FCPATH . 'uploads/surat/' . $new_filename;

        if (file_exists($template_file)) {
            $templateProcessor = new TemplateProcessor($template_file);
            $templateProcessor->setValue('kode_surat', $kode_surat);
            foreach ($post_data as $key => $value) {
                if (strpos($key, 'tgl') !== false && !empty($value) && $key != 'tgl_buat') {
                    $value = date('d-m-Y', strtotime($value));
                }
                $templateProcessor->setValue($key, htmlspecialchars((string)$value));
            }
            $templateProcessor->saveAs($save_path); // Simpan file ke folder uploads/surat/
        }

        // 3. Simpan ke Database
        $this->db->trans_start();

        // ===============================
        // 1️⃣ SIMPAN KE ARSIP KADUS
        // ===============================

        $data_arsip = [
            'filename'              => $new_filename, // draft kadus
            'file_admin'            => NULL, // nanti diisi admin
            'id_template'           => $id_template,
            'id_user'               => $this->session->userdata('id_user'),
            'nomor_template_surat'  => $kode_surat,
            'nomor_pengantar'       => $nomor_pengantar,
            'nama'                  => $this->input->post('nama'),
            'alamat_penerima'       => $alamat_lengkap,
            'jenis_surat'           => $template->nama_surat,
            'banjar'                => $nama_dusun_asli,
            'kode_banjar'           => $post_data['kode_dusun'],
            'status'                => 'menunggu',
            'created_at'            => date('Y-m-d H:i:s')
        ];

        $this->db->insert('arsip_surat', $data_arsip);
        $id_arsip = $this->db->insert_id();

        // ===============================
        // 2️⃣ SIMPAN KE DATA_SURAT ADMIN
        // ===============================

        $data_admin = [
            'id_template'     => $id_template_tujuan,
            'arsip_id'        => $id_arsip,
            'alamat_lengkap'  => $alamat_lengkap,
            'nomor_pengantar' => $post_data['no'],
            'tempat_lahir'    => $this->input->post('tempat_lahir'),
            'tanggal_lahir'   => $this->input->post('tgl_lahir'),
            'jenis_kelamin'   => $this->input->post('jenis_kelamin'),
            'nama'            => $this->input->post('nama'),
            'nik'             => $this->input->post('nik'),
            'banjar'          => $nama_dusun_asli,
            'kode_banjar'     => $post_data['kode_dusun'],
            'status'          => 'menunggu',
            'sts_kawin'       => $this->input->post('sts_kawin'),
            'agama'           => $this->input->post('agama'),
            'pekerjaan'       => $this->input->post('pekerjaan'),
            'tujuan'          => $this->input->post('tujuan'),
            'id_user'         => $this->session->userdata('id_user'),
            'created_at'      => date('Y-m-d H:i:s')
        ];

        $this->db->insert('data_surat', $data_admin);


        // ===============================
        // 3️⃣ NOTIFIKASI ADMIN
        // ===============================

        $this->db->insert('notifikasi', [
            'tujuan_role' => 'admin',
            'pesan'       => 'Ada pengajuan surat baru dari Kadus',
            'link'        => site_url('admin/verifikasi_data'),
            'status'      => 'belum dibaca',
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        $this->db->trans_complete();


        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Gagal menyimpan surat.');
        } else {
            $this->session->set_flashdata('success', 'Surat berhasil dikirim ke Admin.');
        }

        redirect('kadus/arsip');
    }

    public function arsip()
    {
        $id_user = $this->session->userdata('id_user');
        $this->db->select('arsip_surat.*, template_surat.nama_surat as judul');
        $this->db->from('arsip_surat');
        $this->db->join('template_surat', 'arsip_surat.id_template = template_surat.id_template', 'left');
        $this->db->where('arsip_surat.id_user', $id_user);
        $this->db->order_by('arsip_surat.created_at', 'DESC');
        $data['arsip'] = $this->db->get()->result();

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kadus/arsip', $data);
        $this->load->view('template_admin/footer');
    }

    public function download_arsip($id)
    {
        // Ambil data dari database berdasarkan ID
        $arsip = $this->db->get_where('arsip_surat', ['id' => $id])->row();

        // Validasi: Pastikan data ada dan kolom filename tidak kosong
        if (!$arsip || empty($arsip->filename)) {
            $this->session->set_flashdata('error', 'Nama file tidak ditemukan di database.');
            redirect('kadus/arsip');
        }

        $file_path = FCPATH . 'uploads/surat/' . $arsip->filename;

        // Validasi: Pastikan file fisik benar-benar ada di folder
        if (file_exists($file_path) && !is_dir($file_path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));

            // Bersihkan buffer agar file tidak korup
            ob_clean();
            flush();
            readfile($file_path);
            exit;
        } else {
            $this->session->set_flashdata('error', 'File fisik tidak ditemukan di folder uploads/surat/');
            redirect('kadus/arsip');
        }
    }

    private function tanggal_indonesia($tanggal)
    {
        $bulan = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $ts = strtotime($tanggal);
        return date('j', $ts) . ' ' . $bulan[(int)date('n', $ts)] . ' ' . date('Y', $ts);
    }


    public function baca_notif($id)
    {
        $notif = $this->db->get_where('notifikasi', ['id' => $id])->row();

        if (!$notif) {
            redirect('kadus');
        }

        $this->db->where('id', $id)
            ->update('notifikasi', ['status' => 'dibaca']);

        redirect($notif->link ?? 'kadus');
    }

    public function ajax_notifikasi()
    {
        $role = $this->session->userdata('role');

        $data = $this->db
            ->where('tujuan_role', $role)
            ->order_by('created_at', 'DESC')
            ->limit(5)
            ->get('notifikasi')
            ->result();

        echo json_encode($data);
    }
}
