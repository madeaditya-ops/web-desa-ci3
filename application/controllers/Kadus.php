<?php
defined('BASEPATH') or exit('No direct script access allowed');

require FCPATH . 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\TemplateProcessor;

/**
 * @property CI_DB_query_builder $db
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_Input $input
 * @property CI_Upload $upload
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 * @property Surat_model $Surat_model
 * @property Dusun_model $Dusun_model
 * @property Layanan_model $Layanan_model
 * @property Arsip_model $Arsip_model
 * @property Data_surat_model $Data_surat_model
 * @property Data_surat_pending_model $Data_surat_pending_model
 * @property Master_data_model $Master_data_model
 */
class Kadus extends CI_Controller
{

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Template_surat_model');
        $this->load->model('Dusun_model');
        $this->load->model('Warga_model');
        $this->load->model('Keluarga_model');
        $this->load->model('Dashboard_kadus_model');
        $this->load->model('Data_surat_model');
        $this->load->library('session');
    }

    public function get_notif_kadus_realtime()
    {
        // KUNCI KEAMANAN: Jika bukan kadus, hentikan proses!
        if ($this->session->userdata('role') !== 'kadus') {
            echo json_encode(['jumlah' => 0, 'list' => []]);
            exit;
        }

        $id_user = $this->session->userdata('id_user');

        $this->db->select('id, nama, status, alasan_tolak, created_at');
        $this->db->where('id_user', $id_user);
        $this->db->where('new_approved', 1);
        $this->db->group_start();
        $this->db->where('status', 'disetujui');
        $this->db->or_where('status', 'ditolak');
        $this->db->group_end();
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('data_surat');

        echo json_encode([
            'jumlah' => $query->num_rows(),
            'list'   => $query->result()
        ]);
    }

    public function get_surat_keluar_realtime()
    {
        if ($this->session->userdata('role') !== 'kadus') {
            echo json_encode(['jumlah' => 0, 'total' => 0]);
            exit;
        }

        $id_user = $this->session->userdata('id_user');

        $jumlah = $this->Dashboard_kadus_model->count_surat_keluar($id_user);
        $total  = $this->Dashboard_kadus_model->count_total_surat($id_user);

        echo json_encode([
            'jumlah' => $jumlah,
            'total'  => $total
        ]);
    }

    public function get_grafik_data_realtime()
    {
        if ($this->session->userdata('role') !== 'kadus') {
            echo json_encode(['status' => [], 'hari' => []]);
            exit;
        }

        $id_user = $this->session->userdata('id_user');

        $status = $this->Dashboard_kadus_model->get_surat_status_distribution($id_user);
        $hari   = $this->Dashboard_kadus_model->get_surat_keluar_per_hari($id_user);

        echo json_encode([
            'status' => $status,
            'hari'   => $hari
        ]);
    }

    public function index()
    {
        $level_akses = $this->session->userdata('role');
        $id_user = $this->session->userdata('id_user');

        $data['templates'] = $this->Template_surat_model->get_by_level_akses($level_akses);

        $data['jumlah_total_surat'] = $this->Dashboard_kadus_model->count_total_surat($id_user);
        $data['jumlah_menunggu']    = $this->Dashboard_kadus_model->count_by_status($id_user, 'menunggu');
        $data['jumlah_disetujui']   = $this->Dashboard_kadus_model->count_by_status($id_user, 'disetujui');
        $data['jumlah_ditolak']     = $this->Dashboard_kadus_model->count_by_status($id_user, 'ditolak');

        $data['status_distribution'] = $this->Dashboard_kadus_model->get_surat_status_distribution($id_user);
        $data['surat_per_bulan']     = $this->Dashboard_kadus_model->get_surat_per_bulan($id_user);
        $data['surat_terbaru']       = $this->Dashboard_kadus_model->get_surat_terbaru($id_user);

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kadus/dashboard', $data);
        $this->load->view('template_admin/footer');
    }


    function buat_surat()
    {
        $level_akses = $this->session->userdata('role');
        $data['templates'] = $this->Template_surat_model->get_by_level_akses($level_akses);

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kadus/buat_surat', $data);
        $this->load->view('template_admin/footer');
    }

    public function form_surat($id_template)
    {
        $data['template'] = $this->Template_surat_model->get_by_id($id_template);

        if (!$data['template']) {
            redirect('kadus');
        }

        $data['surat_list'] = $this->Template_surat_model->get_surat_list();

        $this->load->model('Master_data_model');

        // master data dropdown
        $data['list_jk'] = $this->Master_data_model->get_jenis_kelamin();
        $data['status_kawin_list'] = $this->Master_data_model->get_status_perkawinan();
        $data['list_agama'] = $this->Master_data_model->get_agama();

        // 🔥 CEK APAKAH SURAT KETERANGAN
        $nama_surat = strtoupper($data['template']->nama_surat);

        $data['is_surat_keterangan'] =
            (strpos($nama_surat, 'SURAT KETERANGAN') !== false);

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
            ->where('keluarga.id_dusun', $dusun_id)
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

        $nomor_pengantar = '' . $post_data['no'];

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

        $template_pengantar = $this->Template_surat_model->get_by_id($id_template);
        $template_tujuan    = $this->Template_surat_model->get_by_id($id_template_tujuan);
        // 3. Simpan ke Database
        $this->db->trans_start();

        // ===============================
        // 1️⃣ SIMPAN KE DATA_SURAT ADMIN
        // ===============================

        $data_admin = [
            'id_template'     => $id_template_tujuan,
            'alamat_lengkap'  => $alamat_lengkap,
            'nomor_pengantar' => $post_data['no'],
            'keterangan' => $this->input->post('keterangan', true),
            'no_nasional' => $this->input->post('no_nasional', true),
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

        // 🔥 ambil id data_surat terbaru
        $id_data_surat = $this->db->insert_id();


        // ===============================
        // 2️⃣ SIMPAN KE ARSIP KADUS
        // ===============================

        $data_arsip = [
            'filename'              => $new_filename,
            'file_admin'            => NULL,
            // surat pengantar
            'id_template'           => $id_template,
            // template tujuan
            'id_template_tujuan'    => $id_template_tujuan,
            // 🔥 RELASI BARU
            'data_surat_id'         => $id_data_surat,
            'id_user'               => $this->session->userdata('id_user'),
            'nomor_template_surat'  => $kode_surat,
            'nomor_pengantar'       => $nomor_pengantar,
            'nama'                  => $this->input->post('nama'),
            'alamat_penerima'       => $alamat_lengkap,
            'jenis_surat'           => $template_pengantar->nama_surat,
            'jenis_surat_tujuan'    => $template_tujuan->nama_surat,
            'banjar'                => $nama_dusun_asli,
            'kode_banjar'           => $post_data['kode_dusun'],
            'status'                => 'menunggu',
            'created_at'            => date('Y-m-d H:i:s')
        ];

        $this->db->insert('arsip_surat', $data_arsip);




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

  $this->db->select('
    arsip_surat.*,
    template_surat.nama_surat as judul,
    template_surat.nomor_template_surat as nomor_template_asli,
    template_surat.jenis_template,
    data_surat.no_nasional AS no_nasional_data,
    data_surat.keterangan
');
    $this->db->from('arsip_surat');
    $this->db->join('template_surat', 'arsip_surat.id_template = template_surat.id_template', 'left');
    $this->db->join('data_surat', 'arsip_surat.data_surat_id = data_surat.id', 'left');
    $this->db->where('arsip_surat.id_user', $id_user);
    $this->db->order_by('arsip_surat.created_at', 'DESC');

    $data['arsip'] = $this->db->get()->result();

    $this->db->where('id_user', $this->session->userdata('id_user'))
        ->update('data_surat', ['new_approved' => 0]);

    $this->load->view('template_admin/header');
    $this->load->view('template_admin/sidebar');
    $this->load->view('kadus/arsip', $data);
    $this->load->view('template_admin/footer');
}

    public function verifikasi_ambil($id)
    {
        $nama_pengambil = $this->session->userdata('nama');

        $this->db->where('id', $id);
        $this->db->update('arsip_surat', [
            'status_ambil' => 'sudah',
            'tanggal_ambil' => date('Y-m-d H:i:s'),
            'diambil_oleh' => $nama_pengambil
        ]);

        $this->session->set_flashdata('swal', [
            'icon'  => 'success',
            'title' => 'Berhasil',
            'text'  => 'Surat sudah diambil oleh ' . $nama_pengambil
        ]);

        redirect('kadus/arsip');
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




    // data warga masing masing dusun
    public function data_warga()
    {

        $dusun_id = $this->session->userdata('dusun_id');
        $data['warga'] = $this->db
            ->select('w.*, d.nama_dusun, h.nama as hubungan, jk.nama as jenis_kelamin, a.nama as agama, sp.nama as status_perkawinan, kw.nama as kewarganegaraan, p.nama as pendidikan, ket.nama_keterangan')
            ->from('warga w')
            ->join('keluarga k', 'k.id = w.keluarga_id')
            ->join('dusun d', 'k.id_dusun = d.id_dusun', 'left')
            ->join('hubungan h', 'w.hubungan_id = h.id', 'left')
            ->join('jenis_kelamin jk', 'w.jenis_kelamin_id = jk.id', 'left')
            ->join('agama a', 'w.agama_id = a.id', 'left')
            ->join('status_perkawinan sp', 'w.status_perkawinan_id = sp.id', 'left')
            ->join('kewarganegaraan kw', 'w.kewarganegaraan_id = kw.id', 'left')
            ->join('pendidikan p', 'w.pendidikan_id = p.id', 'left')
            ->join('keterangan ket', 'w.id_keterangan = ket.id_keterangan', 'left')
            ->where('k.id_dusun', $dusun_id)
            ->order_by('w.nama', 'ASC')
            ->get()
            ->result();


        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kadus/warga/data_warga', $data);
        $this->load->view('template_admin/footer');
    }

    public function tambah()
    {
        $dusun_id = $this->session->userdata('dusun_id');
        $data['title'] = 'Tambah Warga';
        $data['keluarga'] = $this->db
            ->where('id_dusun', $dusun_id)
            ->get('keluarga')
            ->result();
        $data['hubungan'] = $this->db->get('hubungan')->result();
        $data['jenis_kelamin'] = $this->db->get('jenis_kelamin')->result();
        $data['agama'] = $this->db->get('agama')->result();
        $data['status_perkawinan'] = $this->db->get('status_perkawinan')->result();
        $data['kewarganegaraan'] = $this->db->get('kewarganegaraan')->result();
        $data['pendidikan'] = $this->db->get('pendidikan')->result();

        $this->load->view('template_admin/header', $data);
        $this->load->view('template_admin/sidebar');
        $this->load->view('kadus/warga/tambah', $data);
        $this->load->view('template_admin/footer');
    }

    public function simpan()
    {
        $data = [
            'keluarga_id' => $this->input->post('keluarga_id'),
            'no_nik' => $this->input->post('no_nik'),
            'nama' => $this->input->post('nama'),
            'hubungan_id' => $this->input->post('hubungan_id'),
            'jenis_kelamin_id' => $this->input->post('jenis_kelamin_id'),
            'agama_id' => $this->input->post('agama_id'),
            'status_perkawinan_id' => $this->input->post('status_perkawinan_id'),
            'kewarganegaraan_id' => $this->input->post('kewarganegaraan_id'),
            'pendidikan_id' => $this->input->post('pendidikan_id'),
            'tempat_lahir' => $this->input->post('tempat_lahir'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir'),
            'pekerjaan' => $this->input->post('pekerjaan'),
            'keterangan' => $this->input->post('keterangan')
        ];

        // Validasi wajib
        if (empty($data['no_nik']) || empty($data['nama']) || empty($data['hubungan_id']) || empty($data['jenis_kelamin_id']) || empty($data['agama_id'])) {
            $this->session->set_flashdata('error', 'Field wajib harus diisi!');
            redirect('warga/tambah');
        }

        // Cek duplikat NIK
        if ($this->db->get_where('warga', ['no_nik' => $data['no_nik']])->row()) {
            $this->session->set_flashdata('error', 'NIK sudah terdaftar!');
            redirect('warga/tambah');
        }

        $this->Warga_model->insert($data);
        $this->session->set_flashdata('success', 'Data warga berhasil ditambahkan!');
        redirect('kadus/warga/data_warga');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Warga';
        $data['warga'] = $this->Warga_model->get_by_id($id);
        $dusun_id = $this->session->userdata('dusun_id');

        $data['keluarga'] = $this->db
            ->where('id_dusun', $dusun_id)
            ->get('keluarga')
            ->result();
        $data['hubungan'] = $this->db->get('hubungan')->result();
        $data['jenis_kelamin'] = $this->db->get('jenis_kelamin')->result();
        $data['agama'] = $this->db->get('agama')->result();
        $data['status_perkawinan'] = $this->db->get('status_perkawinan')->result();
        $data['kewarganegaraan'] = $this->db->get('kewarganegaraan')->result();
        $data['pendidikan'] = $this->db->get('pendidikan')->result();
        $data['keterangan_list'] = $this->db->get('keterangan')->result();

        $this->load->view('template_admin/header', $data);
        $this->load->view('template_admin/sidebar');
        $this->load->view('kadus/warga/edit', $data);
        $this->load->view('template_admin/footer');
    }

    public function update($id)
    {
        $data = [
            'keluarga_id' => $this->input->post('keluarga_id'),
            'no_nik' => $this->input->post('no_nik'),
            'nama' => $this->input->post('nama'),
            'hubungan_id' => $this->input->post('hubungan_id'),
            'jenis_kelamin_id' => $this->input->post('jenis_kelamin_id'),
            'agama_id' => $this->input->post('agama_id'),
            'status_perkawinan_id' => $this->input->post('status_perkawinan_id'),
            'kewarganegaraan_id' => $this->input->post('kewarganegaraan_id'),
            'pendidikan_id' => $this->input->post('pendidikan_id'),
            'tempat_lahir' => $this->input->post('tempat_lahir'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir'),
            'pekerjaan' => $this->input->post('pekerjaan'),
            'keterangan' => $this->input->post('keterangan'),
            'id_keterangan' => $this->input->post('id_keterangan'),
        ];

        // Validasi wajib
        if (
            empty($data['no_nik']) ||
            empty($data['nama']) ||
            empty($data['hubungan_id']) ||
            empty($data['jenis_kelamin_id']) ||
            empty($data['agama_id'])
        ) {
            $this->session->set_flashdata('error', 'Field wajib harus diisi!');
            redirect('kadus/edit/' . $id);
        }

        // Cek duplikat NIK kecuali untuk data sendiri
        $existing = $this->db->get_where('warga', ['no_nik' => $data['no_nik']])->row();
        if ($existing && $existing->id != $id) {
            $this->session->set_flashdata('error', 'NIK sudah terdaftar!');
            redirect('warga/edit/' . $id);
        }

        $this->Warga_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data warga berhasil diupdate!');
        redirect('kadus/data_warga');
    }

    public function delete($id)
    {
        $this->Warga_model->delete($id);
        redirect('kadus/data_warga');
    }

    // import dan export warga menggunakan excel

    public function detail($id)
    {
        // data warga
        $data['warga'] = $this->db
            ->select('
            warga.*,
            keluarga.no_kk,
            dusun.nama_dusun,
            jenis_kelamin.nama as jenis_kelamin,
            agama.nama as agama,
            ket.nama_keterangan,
            status_perkawinan.nama as status_kawin
        ')
            ->from('warga')
            ->join('keluarga', 'keluarga.id = warga.keluarga_id', 'left')
            ->join('dusun', 'dusun.id_dusun = keluarga.id_dusun', 'left')
            ->join('jenis_kelamin', 'jenis_kelamin.id = warga.jenis_kelamin_id', 'left')
            ->join('agama', 'agama.id = warga.agama_id', 'left')
            ->join('status_perkawinan', 'status_perkawinan.id = warga.status_perkawinan_id', 'left')
            ->join('keterangan ket', 'warga.id_keterangan = ket.id_keterangan', 'left')
            ->where('warga.id', $id)
            ->get()
            ->row();

        // riwayat surat warga
        $data['riwayat_surat'] = $this->db
            ->select('
            data_surat.*,
            template_surat.nama_surat,
            data_surat.data_surat_id
            ')
            ->from('data_surat')
            ->join('template_surat', 'template_surat.id_template = data_surat.id_template', 'left')
            ->where('data_surat.nik', $data['warga']->no_nik)
            ->order_by('data_surat.created_at', 'DESC')
            ->get()
            ->result();

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kadus/warga/detail', $data);
        $this->load->view('template_admin/footer');
    }

    public function download_surat($id_data_surat)
    {

        $surat = $this->db
            ->select('arsip_surat.filename')
            ->from('data_surat')
            ->join('arsip_surat', 'arsip_surat.data_surat_id = data_surat.id')
            ->where('data_surat.id', $id_data_surat)
            ->get()
            ->row();

        if (!$surat) {
            show_404();
        }

        $file = FCPATH . 'uploads/surat/' . $surat->filename;

        if (file_exists($file)) {

            header('Content-Description: File Transfer');
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            header('Content-Length: ' . filesize($file));

            ob_clean();
            flush();
            readfile($file);
            exit;
        } else {

            $this->session->set_flashdata('error', 'File surat tidak ditemukan');
            redirect('kadus');
        }
    }

    public function lengkapi($id)
    {
        $this->db->select('
    data_surat.*,
    arsip_surat.id AS arsip_id,
    arsip_surat.status,
    arsip_surat.created_at,
    arsip_surat.filename,
    arsip_surat.data_surat_id
');

        $this->db->from('data_surat');

        $this->db->join(
            'arsip_surat',
            'arsip_surat.data_surat_id = data_surat.id',
            'left'
        );

        $this->db->where('arsip_surat.id', $id);

        $this->db->where(
            'arsip_surat.id_user',
            $this->session->userdata('id_user')
        );

        $surat = $this->db->get()->row();

        if (!$surat) {
            show_404();
        }

        // reset notif
        $this->db->where('id', $surat->id);

        $this->db->update('data_surat', [
            'new_approved' => 0
        ]);

        $data['surat'] = $surat;

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kadus/lengkapi_surat', $data);
        $this->load->view('template_admin/footer');
    }
    public function update_lengkapi($id)
    {
        $post = $this->input->post();

        // ambil data surat
        $surat = $this->db
            ->get_where('data_surat', [
                'id' => $id
            ])
            ->row();

        if (!$surat) {
            show_404();
        }

        /*
    |--------------------------------------------------------------------------
    | UPDATE DATA SURAT
    |--------------------------------------------------------------------------
    */

        $this->db->where('id', $id);

        $this->db->update('data_surat', [

            'nama'             => $post['nama'] ?? null,
            'nik'              => $post['nik'] ?? null,
            'tempat_lahir'     => $post['tempat_lahir'] ?? null,
            'tanggal_lahir'    => $post['tanggal_lahir'] ?? null,
            'jenis_kelamin'    => $post['jenis_kelamin'] ?? null,
            'agama'            => $post['agama'] ?? null,
            'pekerjaan'        => $post['pekerjaan'] ?? null,
            'sts_kawin'        => $post['sts_kawin'] ?? null,
            'tujuan'           => $post['tujuan'] ?? null,

            // reset penolakan
            'alasan_tolak'     => null,

            // kirim ulang ke admin
            'status'           => 'menunggu',

            // notif admin
            'new_approved'     => 1,

            'updated_at'       => date('Y-m-d H:i:s')

        ]);

        /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS ARSIP
    |--------------------------------------------------------------------------
    */

        $this->db
            ->where('data_surat_id', $id)
            ->update('arsip_surat', [

                'status' => 'menunggu'

            ]);

        $this->session->set_flashdata(
            'success',
            'Data berhasil dikirim ulang.'
        );

        redirect('kadus/arsip');
    }

    public function hapus_pengajuan($id)
    {
        // ambil data arsip
        $arsip = $this->db
            ->get_where('arsip_surat', [
                'id' => $id,
                'id_user' => $this->session->userdata('id_user')
            ])
            ->row();

        if (!$arsip) {
            show_404();
        }

        /*
    |--------------------------------------------------------------------------
    | HAPUS FILE SURAT
    |--------------------------------------------------------------------------
    */

        if (!empty($arsip->filename)) {

            $path = FCPATH . 'uploads/surat/' . $arsip->filename;

            if (file_exists($path)) {
                unlink($path);
            }
        }

        /*
    |--------------------------------------------------------------------------
    | HAPUS ARSIP
    |--------------------------------------------------------------------------
    */

        $this->db->where('id', $id);
        $this->db->delete('arsip_surat');

        /*
    |--------------------------------------------------------------------------
    | HAPUS DATA SURAT
    |--------------------------------------------------------------------------
    */

        $this->db->where('id', $arsip->data_surat_id);
        $this->db->delete('data_surat');

        $this->session->set_flashdata(
            'success',
            'Pengajuan berhasil dihapus.'
        );

        redirect('kadus/arsip');
    }
    public function jumlah_kk()
    {
        $dusun_id = $this->session->userdata('dusun_id');
        $data['keluarga'] = $this->Keluarga_model->get_by_dusun($dusun_id);

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kadus/keluarga/jumlah_kk', $data);
        $this->load->view('template_admin/footer');
    }


    public function tambah_kk()
    {
        $data['title'] = 'Tambah Keluarga';
        $dusun_id = $this->session->userdata('dusun_id');

        $data['dusun'] = $this->db
            ->get_where('dusun', ['id_dusun' => $dusun_id])
            ->row();
        // 🔥 TAMBAHAN MASTER
        $data['hubungan'] = $this->db->get('hubungan')->result();
        $data['agama'] = $this->db->get('agama')->result();
        $data['jenis_kelamin'] = $this->db->get('jenis_kelamin')->result();
        $data['status_perkawinan'] = $this->db->get('status_perkawinan')->result();
        $data['pendidikan'] = $this->db->get('pendidikan')->result();
        $data['kewarganegaraan'] = $this->db->get('kewarganegaraan')->result();

        $this->load->view('template_admin/header', $data);
        $this->load->view('template_admin/sidebar');
        $this->load->view('kadus/keluarga/tambah_kk', $data);
        $this->load->view('template_admin/footer');
    }

    public function simpan_kk()
    {
        // ===============================
        // 1. SIMPAN KELUARGA
        // ===============================

        $data_keluarga = [
            'id_dusun' => $this->session->userdata('dusun_id'),
            'no_kk' => $this->input->post('no_kk'),
            'nama_kepala_keluarga' => $this->input->post('nama_kepala'),
            'alamat' => $this->input->post('alamat')
        ];

        $this->db->insert('keluarga', $data_keluarga);
        $keluarga_id = $this->db->insert_id();

        // ===============================
        // SIMPAN KEPALA KELUARGA KE WARGA
        // ===============================
        $this->db->insert('warga', [
            'keluarga_id' => $keluarga_id,
            'no_nik' => $this->input->post('nik_kepala'),
            'nama' => $this->input->post('nama_kepala'),

            'hubungan_id' => 1, // 🔥 WAJIB: kepala keluarga

            'jenis_kelamin_id' => $this->input->post('jk_kepala'),
            'agama_id' => $this->input->post('agama_kepala'),
            'status_perkawinan_id' => $this->input->post('status_kepala'),
            'kewarganegaraan_id' => $this->input->post('kewarganegaraan_kepala'),
            'pendidikan_id' => $this->input->post('pendidikan_kepala'),

            // 🔥 TAMBAHAN (biar lengkap)
            'tempat_lahir' => $this->input->post('tempat_lahir_kepala'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir_kepala'),
            'pekerjaan' => $this->input->post('pekerjaan_kepala'),

            'keterangan' => null
        ]);

        // ===============================
        // 3. SIMPAN ANGGOTA
        // ===============================
        $niks = $this->input->post('anggota_nik');
        $namas = $this->input->post('anggota_nama');
        $hubungans = $this->input->post('anggota_hubungan');
        $jks = $this->input->post('anggota_jk');
        $agamas = $this->input->post('anggota_agama');
        $status = $this->input->post('anggota_status');
        $pendidikan = $this->input->post('anggota_pendidikan');
        $kewarganegaraan = $this->input->post('anggota_kewarganegaraan');
        $tempat_lahir = $this->input->post('anggota_tempat_lahir');
        $tanggal_lahir = $this->input->post('anggota_tanggal_lahir');
        $pekerjaan = $this->input->post('anggota_pekerjaan');

        if (!empty($niks)) {
            foreach ($niks as $i => $nik) {

                if (empty($nik)) continue;

                $this->db->insert('warga', [
                    'keluarga_id' => $keluarga_id,
                    'no_nik' => $nik,
                    'nama' => $namas[$i],
                    'hubungan_id' => $hubungans[$i],
                    'jenis_kelamin_id' => $jks[$i],
                    'agama_id' => $agamas[$i],
                    'status_perkawinan_id' => $status[$i],
                    'kewarganegaraan_id' => $kewarganegaraan[$i],
                    'pendidikan_id' => $pendidikan[$i],
                    // 🔥 TAMBAHAN BARU
                    'tempat_lahir' => $tempat_lahir[$i],
                    'tanggal_lahir' => $tanggal_lahir[$i],
                    'pekerjaan' => $pekerjaan[$i],
                    'keterangan' => null
                ]);
            }
        }

        redirect('kadus/jumlah_kk');
    }


    public function edit_kk($id)
    {
        $data['title'] = 'Edit Keluarga';
        $data['keluarga'] = $this->Keluarga_model->get_by_id($id);
        $data['dusun'] = $this->db->get('dusun')->result();

        $data['kepala'] = $this->db
            ->where('keluarga_id', $id)
            ->where('hubungan_id', 1)
            ->get('warga')
            ->row();

        $data['agama'] = $this->db->get('agama')->result();
        $data['status_perkawinan'] = $this->db->get('status_perkawinan')->result();
        $data['kewarganegaraan'] = $this->db->get('kewarganegaraan')->result();
        $data['pendidikan'] = $this->db->get('pendidikan')->result();

        $this->load->view('template_admin/header', $data);
        $this->load->view('template_admin/sidebar');
        $this->load->view('kadus/keluarga/edit', $data);
        $this->load->view('template_admin/footer');
    }

    public function update_kk($id)
    {
        // ===============================
        // 1. UPDATE TABEL KELUARGA
        // ===============================
        $data_keluarga = [
            'id_dusun' => $this->input->post('id_dusun'),
            'no_kk' => $this->input->post('no_kk'),
            'nama_kepala_keluarga' => $this->input->post('nama_kepala'),
            'alamat' => $this->input->post('alamat')
        ];

        $this->db->where('id', $id);
        $this->db->update('keluarga', $data_keluarga);

        // ===============================
        // 2. UPDATE KEPALA KELUARGA DI TABEL WARGA
        // ===============================
        $data_kepala = [
            'no_nik' => $this->input->post('nik_kepala'),
            'nama' => $this->input->post('nama_kepala'),
            'jenis_kelamin_id' => $this->input->post('jk_kepala'),
            'agama_id' => $this->input->post('agama_kepala'),
            'status_perkawinan_id' => $this->input->post('status_kepala'),
            'kewarganegaraan_id' => $this->input->post('kewarganegaraan_kepala'),
            'pendidikan_id' => $this->input->post('pendidikan_kepala'),
            'tempat_lahir' => $this->input->post('tempat_lahir_kepala'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir_kepala'),
            'pekerjaan' => $this->input->post('pekerjaan_kepala'),
            'hubungan_id' => 1,
            'keterangan' => null
        ];

        $this->db->where('keluarga_id', $id);
        $this->db->where('hubungan_id', 1);
        $this->db->update('warga', $data_kepala);

        redirect('kadus/jumlah_kk');
    }




    public function delete_kk($id)
    {
        $this->Keluarga_model->delete($id);
        redirect('kadus/jumlah_kk');
    }

    public function get_members($keluarga_id = null)
    {
        header('Content-Type: application/json');

        if (!$keluarga_id) {
            echo json_encode([]);
            return;
        }

        $data = $this->db
            ->select('
            warga.no_nik as nik,
            warga.nama,
            warga.jenis_kelamin_id,
            warga.tanggal_lahir,
            hubungan.nama as nama_hubungan
        ')
            ->from('warga')
            ->join('hubungan', 'hubungan.id = warga.hubungan_id', 'left')
            ->where('warga.keluarga_id', $keluarga_id)
            ->order_by('warga.hubungan_id', 'ASC')
            ->get()
            ->result();

        echo json_encode($data);
    }


    public function detail_kk($id)
    {

        $data['keluarga'] = $this->db
            ->select('keluarga.*, dusun.nama_dusun')
            ->from('keluarga')
            ->join('dusun', 'dusun.id_dusun = keluarga.id_dusun', 'left')
            ->where('keluarga.id', $id)
            ->get()
            ->row();

        $data['anggota'] = $this->db
            ->select('
                warga.id,
                warga.no_nik,
                warga.nama,
                warga.foto,
                warga.jenis_kelamin_id,
                warga.tanggal_lahir,
                hubungan.nama as hubungan
                ')
            ->from('warga')
            ->join('hubungan', 'hubungan.id=warga.hubungan_id', 'left')
            ->where('warga.keluarga_id', $id)
            ->order_by('warga.hubungan_id', 'ASC')
            ->get()
            ->result();

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kadus/keluarga/detail', $data);
        $this->load->view('template_admin/footer');
    }

    public function edit_foto($id)
    {

        $data['warga'] = $this->db
            ->get_where('warga', ['id' => $id])
            ->row();

        $data['title'] = 'Edit Foto Warga';

        $this->load->view('template_admin/header', $data);
        $this->load->view('template_admin/sidebar');
        $this->load->view('kadus/keluarga/edit_foto', $data);
        $this->load->view('template_admin/footer');
    }

    public function update_foto($id)
    {

        $warga = $this->db->get_where('warga', ['id' => $id])->row();

        $nik = $warga->no_nik;

        $config['upload_path'] = './uploads/foto_warga/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 2048;
        $config['file_name'] = $nik;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('foto')) {

            $upload = $this->upload->data();

            $filename = $upload['file_name'];

            $this->db->where('id', $id);
            $this->db->update('warga', [
                'foto' => $filename
            ]);
        }

        redirect('kadus/keluarga/detail/' . $warga->keluarga_id);
    }

 private function format_jenis_surat($a)
{
    $pengantar = trim((string)($a->jenis_surat ?? ''));

    $keterangan = strtoupper(
        trim((string)($a->keterangan_data ?? ''))
    );

    $tujuan = strtoupper(
        trim((string)($a->jenis_surat_tujuan ?? ''))
    );

    // KONDISI 1
    if ($pengantar !== '' && $keterangan !== '') {

        return $pengantar . " untuk\n"
            . 'SURAT KETERANGAN ' . $keterangan;
    }

    // KONDISI 2
    if ($pengantar !== '' && $tujuan !== '') {

        return $pengantar . " untuk\n"
            . $tujuan;
    }

    return $pengantar
        ?: $tujuan
        ?: $a->judul
        ?: '-';
}
   private function get_arsip_by_tanggal($from = null, $to = null)
{
    $id_user = $this->session->userdata('id_user');

    $this->db->select('
        arsip_surat.*,
        template_surat.nama_surat AS judul,
        template_surat.nama_surat AS nama_surat,
        template_surat.nomor_template_surat AS nomor_template_db,
        template_surat.jenis_template,
        data_surat.no_nasional,
        data_surat.keterangan AS keterangan_data
    ');

    $this->db->from('arsip_surat');

    $this->db->join(
        'template_surat',
        'template_surat.id_template = arsip_surat.id_template',
        'left'
    );

   $this->db->join(
    'data_surat',
    'data_surat.id = arsip_surat.data_surat_id',
    'left'
);

    $this->db->where('arsip_surat.id_user', $id_user);

    // FILTER TANGGAL
    if (!empty($from)) {
        $this->db->where('arsip_surat.created_at >=', $from . ' 00:00:00');
    }

    if (!empty($to)) {
        $this->db->where('arsip_surat.created_at <=', $to . ' 23:59:59');
    }

    $this->db->order_by('arsip_surat.created_at', 'DESC');

    return $this->db->get()->result();
}

private function format_nomor_pengantar($a)
{
    $jenis = strtoupper(trim($a->jenis_surat_tujuan ?? $a->jenis_surat ?? $a->judul ?? ''));

    if ($jenis === 'SURAT KETERANGAN') {
        $noTpl = trim((string)($a->no_nasional ?? ''));
    } else {
        $noTpl = trim((string)($a->nomor_template_surat ?? $a->nomor_template_db ?? ''));
    }

    $noPg = trim((string)($a->nomor_pengantar ?? ''));
    $kd   = trim((string)($a->kode_banjar ?? ''));

    if ($noTpl !== '' && $noPg !== '') {
        $cleanNoPg = preg_replace('/^\d+\//', '', ltrim($noPg, '/'));
        $nomor = $noTpl . '/' . $cleanNoPg;
    } elseif ($noPg !== '') {
        $nomor = $noPg;
    } elseif ($noTpl !== '') {
        $nomor = $noTpl;
    } else {
        $nomor = '-';
    }

    if ($kd !== '' && strpos($nomor, '/KBD.') === false) {
        $nomor .= '/KBD.' . $kd;
    }

    return $nomor;
}

public function arsip_excel()
{
    $from = $this->input->get('from', true);
    $to   = $this->input->get('to', true);

    $arsip = $this->get_arsip_by_tanggal($from, $to);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setTitle('Laporan Arsip Surat');

    $sheet->setCellValue('A1', 'LAPORAN ARSIP SURAT KADUS');
    $sheet->mergeCells('A1:E1');

    $periode = (!empty($from) || !empty($to))
        ? 'Periode: ' . (!empty($from) ? date('d-m-Y', strtotime($from)) : '-') . ' s/d ' . (!empty($to) ? date('d-m-Y', strtotime($to)) : '-')
        : 'Periode: Semua Surat';

    $sheet->setCellValue('A2', $periode);
    $sheet->mergeCells('A2:E2');

    // HEADER
    $sheet->setCellValue('A4', 'No');
    $sheet->setCellValue('B4', 'Tanggal');
    $sheet->setCellValue('C4', 'Nama');
    $sheet->setCellValue('D4', 'Nomor Pengantar');
    $sheet->setCellValue('E4', 'Jenis Surat');

    $row = 5;
    $no = 1;

    foreach ($arsip as $a) {

        $jenis_surat = $this->format_jenis_surat($a);
        $nomor = $this->format_nomor_pengantar($a);

        $sheet->setCellValue('A' . $row, $no++);
        $sheet->setCellValue(
            'B' . $row,
            !empty($a->created_at)
                ? date('d-m-Y H:i', strtotime($a->created_at))
                : '-'
        );

        $sheet->setCellValue('C' . $row, $a->nama ?? '-');
        $sheet->setCellValue('D' . $row, $nomor);
        $sheet->setCellValue('E' . $row, $jenis_surat);

        // WRAP TEXT jenis surat
        $sheet->getStyle('E' . $row)
            ->getAlignment()
            ->setWrapText(true);

        $row++;
    }

    // AUTO SIZE
    foreach (range('A', 'E') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // STYLE
    $sheet->getStyle('A1:E4')->getFont()->setBold(true);

    $sheet->getStyle('A1:E2')
        ->getAlignment()
        ->setHorizontal('center');

    $sheet->getStyle('A4:E4')
        ->getAlignment()
        ->setHorizontal('center');

    $filename = 'arsip_surat_' . date('Ymd_His') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}
public function arsip_pdf()
{
    $from = $this->input->get('from', true);
    $to   = $this->input->get('to', true);

    $data['arsip'] = $this->get_arsip_by_tanggal($from, $to);
    $data['from']  = $from;
    $data['to']    = $to;

    $html = $this->load->view('kadus/arsip_pdf', $data, true);

    $options = new \Dompdf\Options();
    $options->set('isRemoteEnabled', true);

    $dompdf = new \Dompdf\Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    $dompdf->stream('arsip_surat_' . date('Ymd_His') . '.pdf', [
        'Attachment' => false
    ]);
}
}