<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
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
 * 
 */

use PhpOffice\PhpWord\IOFactory;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Shared\Html;



class Admin extends CI_Controller
{

    // core services (untuk IDE / Intelephense)
    /** @var \CI_Input */
    public $input;
    /** @var \CI_Upload */
    public $upload;
    /** @var \CI_Session */
    public $session;
    /** @var \CI_DB_query_builder */
    public $db;

    // deklarasi properti model untuk IDE / static analysis
    /** @var \Surat_model */
    public $Surat_model;
    /** @var \Dusun_model */
    public $Dusun_model;
    /** @var \Arsip_model */
    public $Arsip_model;
    public $Data_surat_model;
    public $Data_surat_pending_model;
    public $template_surat_model;
    public $Notifikasi_model;

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta'); // ✅ tambah ini
        $this->load->model('Surat_model');
        $this->load->model('Layanan_model');
        $this->load->model('Data_surat_model');
        $this->load->model('Data_surat_pending_model');
        $this->load->model('Dusun_model');
        $this->load->model('Arsip_model');
        $this->load->model('Template_surat_model');
        $this->load->library('upload');
    }

    public function index()
    {
        // ambil statistik arsip
        $this->load->model('Arsip_model');
        $total_surats = $this->Arsip_model->count_all();

        $today_from = date('Y-m-d 00:00:00');
        $today_to   = date('Y-m-d 23:59:59');
        $today_count = $this->Arsip_model->count_between($today_from, $today_to);

        // chart: last 7 hari
        $days = 7;
        $counts = $this->Arsip_model->counts_last_days($days);

        $labels = [];
        $data_chart = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $d = date('Y-m-d', strtotime("-{$i} days"));
            $labels[] = date('d M', strtotime($d));
            $data_chart[] = isset($counts[$d]) ? $counts[$d] : 0;
        }

        $data['total_surats'] = $total_surats;
        $data['today_count']  = $today_count;
        $data['chart_labels'] = $labels;
        $data['chart_data']   = $data_chart;

        // muat view dashboard (pastikan view menggunakan variabel ini)
        $this->load->view('template_admin/header', $data);
        $this->load->view('template_admin/sidebar', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('template_admin/footer', $data);
    }

    // (6) Daftar pengajuan masuk


    public function daftar_surat()
    {
        $this->load->model('Surat_model');

        // Ambil hanya surat dengan level_akses = 'admin' menggunakan model method
        $data['surat'] = $this->Surat_model->get_by_role('admin');

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/surat/daftar_surat', $data);
        $this->load->view('template_admin/footer');
    }

    public function upload_template()
    {
        // ambil data dusun dari model
        $this->load->model('Dusun_model');
        $data['dusun'] = $this->Dusun_model->get_all();

        if ($this->input->post()) {
            $config['upload_path']   = './uploads/template/';
            $config['allowed_types'] = 'doc|docx';
            $config['max_size']      = 5000; // 5 MB
            $config['encrypt_name']  = TRUE;

            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }

            $this->upload->initialize($config);

            if ($this->upload->do_upload('file_template')) {
                $upload_data = $this->upload->data();

                $insert = [
                    'nama_surat'   => $this->input->post('nama_surat'),
                    'file_template' => $upload_data['file_name'],
                    'level_akses'  => $this->input->post('level_akses'),
                    'dusun_id'     => $this->input->post('dusun_id')
                ];

                $this->Surat_model->insert($insert);
                redirect('admin/daftar_surat');
            } else {
                $data['error'] = $this->upload->display_errors();
                $this->load->view('template_admin/header');
                $this->load->view('template_admin/sidebar');
                $this->load->view('admin/surat/upload_template', $data); // <-- data dikirim
                $this->load->view('template_admin/footer');
            }
        } else {
            $this->load->view('template_admin/header');
            $this->load->view('template_admin/sidebar');
            $this->load->view('admin/surat/upload_template', $data); // <-- data dikirim
            $this->load->view('template_admin/footer');
        }
    }


    public function layanan()
    {
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/layanan/verifikasi_data');
        $this->load->view('template_admin/footer');
    }


    public function verifikasi_data()
    {
        $data['menunggu'] = $this->db
            ->where('status', 'menunggu')
            ->order_by('created_at', 'DESC')
            ->get('data_surat')
            ->result();

        $this->db->where('tujuan_role', 'admin')
            ->where('status', 'belum dibaca')
            ->update('notifikasi', ['status' => 'dibaca']);

        $this->db->where('tujuan_role', 'admin')
            ->where('status', 'belum dibaca')
            ->update('notifikasi', ['status' => 'dibaca']);


        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/layanan/verifikasi_data', $data);
        $this->load->view('template_admin/footer');
    }


    public function notifikasi()
    {
        $data['notifikasi'] = $this->db
            ->where('tujuan_role', 'admin')
            ->order_by('id', 'DESC')
            ->get('notifikasi')
            ->result();

        $this->db
            ->where('tujuan_role', 'admin')
            ->where('status', 'belum dibaca')
            ->update('notifikasi', ['status' => 'dibaca']);

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/notifikasi', $data);
        $this->load->view('template_admin/footer');
    }


    public function cek_notifikasi_ajax()
    {
        $notif = $this->db
            ->where('tujuan_role', 'admin')
            ->where('status', 'belum dibaca')
            ->order_by('id', 'DESC')
            ->get('notifikasi')
            ->result();

        echo json_encode($notif);
    }

    public function baca_notifikasi($id)
    {
        $this->db->where('id', $id)
            ->update('notifikasi', ['status' => 'dibaca']);

        redirect($_SERVER['HTTP_REFERER']);
    }

    public function get_notifikasi_realtime()
    {
        $role = $this->session->userdata('role');

        $notifikasi = $this->db
            ->where('tujuan_role', $role)
            ->where('status', 'belum dibaca')
            ->order_by('created_at', 'DESC')
            ->limit(10)
            ->get('notifikasi')
            ->result();

        echo json_encode($notifikasi);
    }

    public function setujui($id)
    {
        $this->db->trans_start();

        $data = $this->db->get_where('data_surat', ['id' => $id])->row();

        if (!$data) {
            show_404();
        }

        // kirim notif hanya ke kadus yang membuat surat
        $this->db->insert('notifikasi', [
            'tujuan_role'     => 'kadus',
            'tujuan_user_id'  => $data->id_user, // 🔥 INI KUNCI NYA
            'pesan'           => 'Surat telah disetujui, mohon segera ke kantor desa',
            'link'            => site_url('kadus/arsip'),
            'status'          => 'belum dibaca',
            'created_at'      => date('Y-m-d H:i:s')
        ]);

        // 1️⃣ Update data_surat → diproses
        $this->db->where('id', $id)
            ->update('data_surat', ['status' => 'diproses']);

        // 2️⃣ Update arsip_surat → diproses
        if (!empty($data->arsip_id)) {
            $this->db->where('id', $data->arsip_id)
                ->update('arsip_surat', ['status' => 'diproses']);
        }

        $this->db->trans_complete();

        // 3️⃣ Simpan id untuk autofill edit_surat
        $this->session->set_flashdata('auto_fill_id', $id);

        redirect('admin/edit_surat/' . $data->id_template);
    }


    public function verifikasi_selesai()
    {
        $data['selesai'] = $this->db
            ->order_by('created_at', 'DESC')
            ->get('data_surat')
            ->result();

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/layanan/verifikasi_selesai', $data);
        $this->load->view('template_admin/footer');
    }

    public function reset_warga_terbaru($id)
    {
        if (!$id) {
            echo json_encode(['status' => false]);
            return;
        }

        $this->db->where('id', $id);
        $this->db->set('is_new_approved', 0);
        $this->db->update('data_surat');

        echo json_encode(['status' => true]);
    }


    public function tolak($id)
    {
        $data = $this->db->get_where('data_surat', ['id' => $id])->row();

        if (!$data) show_404();

        // update data_surat
        $this->db->where('id', $id)
            ->update('data_surat', ['status' => 'ditolak']);

        // update arsip_surat
        $this->db->where('id', $data->arsip_id)
            ->update('arsip_surat', ['status' => 'ditolak']);

        // notifikasi kadus
        $this->db->insert('notifikasi', [
            'tujuan_role' => 'kadus',
            'pesan'       => 'Pengajuan surat Anda ditolak oleh Admin',
            'link'        => site_url('kadus/arsip'),
            'status'      => 'belum dibaca',
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        redirect('admin/verifikasi_data');
    }



    public function get_data_warga($id)
    {
        $this->load->model('Data_surat_model');
        $data = $this->Data_surat_model->get_by_id($id);

        if (!$data) {
            echo json_encode(['status' => false]);
            return;
        }

        echo json_encode([
            'status' => true,
            'data' => $data
        ]);
    }

    public function edit_surat($id, $id_pengajuan = null)
    {
        $this->load->model('Dusun_model');
        $data['dusun'] = $this->Dusun_model->get_all();

        $this->load->model('Data_surat_model');
        $data['data_warga'] = $this->Data_surat_model->get_all();

        $this->load->model('Surat_model');
        $surat = $this->Surat_model->get_by_id($id);
        $this->load->model('arsip_model');
        $data['templates'] = $this->db->get('template_surat')->result();

        if (!$surat) {
            show_404();
        }

        // $id_data = $this->session->flashdata('auto_fill_id');
        // $data_surat = $this->db
        //     ->get_where('data_surat', ['id' => $id_data])
        //     ->row();
        // if ($id_data) {
        //     $data['auto_warga'] = $this->Data_surat_model->get_by_id($id_data);

        //     $this->db->where('id', $id_data)
        //         ->update('data_surat', ['status' => 'disetujui']);

        //     $this->db->where('id', $data_surat->arsip_id)
        //         ->update('arsip_surat', ['status' => 'disetujui']);

        //     $this->db->insert('notifikasi', [
        //         'tujuan_role' => 'kadus',
        //         'pesan'       => 'Surat telah disetujui, mohon segera ke kantor desa',
        //         'link'        => site_url('kadus/arsip'),
        //         'status'      => 'belum dibaca',
        //         'created_at'  => date('Y-m-d H:i:s')
        //     ]);
        // } else {
        //     $data['auto_warga'] = null;
        // }

        $id_data = $id_pengajuan; 
    
        $data_surat = $this->db->get_where('data_surat', ['id' => $id_data])->row();
        
        if ($id_data && $data_surat) {
            $data['auto_warga'] = $this->Data_surat_model->get_by_id($id_data);
            // JANGAN taruh update status & notif di sini (zona GET)
        } else {
            $data['auto_warga'] = null;
        }

        
        // Tetap kirim list warga untuk dropdown
        $data['data_warga'] = $this->db
            ->select('id, nama, nik, banjar, is_new_approved')
            ->from('data_surat')
            ->order_by('created_at', 'DESC')
            ->get()
            ->result();


        $file_path = './uploads/template_surat/' . $surat->file_template;
        $placeholders = [];

        // --- Ambil placeholder dari template docx ---
        if (file_exists($file_path)) {
            $zip = new ZipArchive;
            if ($zip->open($file_path) === TRUE) {
                $xml = $zip->getFromName('word/document.xml');
                $zip->close();

                // Gabungkan placeholder yang pecah
                $xml_clean = preg_replace('/<\/w:t>\s*<w:t[^>]*>/', '', $xml);
                $xml_text  = strip_tags($xml_clean);

                preg_match_all('/\[(.+?)\]/', $xml_text, $matches);
                $placeholders = array_unique($matches[1]);
            }
        }

        // --- Jika form disubmit ---
        if ($this->input->post()) {
            $data_input = $this->input->post();
            $data_input['id_template'] = $id;

            // ===============================
            // A) AMBIL NILAI PLACEHOLDER [keterangan] DARI INPUT FORM
            // ===============================
            $ket = '';
            if (isset($data_input['keterangan'])) {
                $ket = $data_input['keterangan'];      // kalau input name="keterangan"
            } elseif (isset($data_input['[keterangan]'])) {
                $ket = $data_input['[keterangan]'];    // kalau input name="[keterangan]"
            }
            $ket = trim((string)$ket);
            if ($ket === '') $ket = '-';



            // ✅ ambil nomor pengantar dari input form
            $nomor_pengantar = $this->input->post('nomor_pengantar', true);



            // Gunakan nama surat sebagai base filename, sanitize
            $nama = $this->input->post('nama', true) ?: 'tanpa_nama';
            $base_name = preg_replace('/[^A-Za-z0-9_\-]/', '_', $surat->nama_surat . '_' . $nama);
            $new_filename = $base_name . '_' . time() . '.docx';
            $new_file = './uploads/surat/' . $new_filename;

            if (!copy($file_path, $new_file)) {
                $this->session->set_flashdata('message', 'Gagal menyalin template surat!');
                redirect('admin/daftar_surat');
            }

            $zip = new ZipArchive;
            if ($zip->open($new_file) === TRUE) {
                // Process all word/*.xml files (document.xml, header*.xml, footer*.xml, etc.)
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $filename = $zip->getNameIndex($i);
                    if (preg_match('/^word\/.*\.xml$/', $filename)) {
                        $xml = $zip->getFromName($filename);
                        $xml_clean = preg_replace('/<\/w:t>\s*<w:t[^>]*>/', '', $xml);

                        foreach ($placeholders as $ph_raw) {
                            // Normalisasi placeholder: ubah spasi/non-alnum menjadi underscore, lowercase
                            $ph = trim($ph_raw);
                            $ph_key = strtolower(preg_replace('/[^\w]+/u', '_', $ph));

                            // Alias khusus untuk beberapa field
                            $aliases = [
                                'jenis_kelamin'     => ['jenis_kelamin', 'jenis kelamin', 'gender', 'jk', 'sex', 'kelamin'],
                                // ✅ INI YANG BENAR UNTUK PLACEHOLDER [no_pengantar]
                                'nomor_pengantar'    => ['no_pengantar', 'no pengantar', 'nomor_pengantar', 'nomor pengantar'],
                                'tujuan_surat'      => ['tujuan_surat', 'tujuan surat', 'kepada', 'tujuan'],
                                'status_perkawinan' => ['status_perkawinan', 'status perkawinan', 'perkawinan', 'status'],
                                'agama'             => ['agama', 'religion'],
                                'tempat_lahir'      => ['tempat_lahir', 'tempat lahir', 'lahir_di'],
                                'tanggal_lahir'     => ['tanggal_lahir', 'tanggal lahir', 'tgl_lahir', 'lahir_tanggal'],
                                'pekerjaan'         => ['pekerjaan', 'job', 'occupation'],
                                'alamat'            => ['alamat', 'address'],
                                'jenis_surat'       => ['keterangan', 'jenis surat', 'tipe_surat', 'tipe surat', 'type_surat', 'type surat'],
                                'nomor_surat'       => ['nomor_surat', 'nomor surat', 'no_surat', 'nomor']
                            ];



                            // ===============================
                            // Ambil nilai dengan alias support
                            // ===============================

                            $val = null;



                            // ✅ KHUSUS NOMOR PENGANTAR
                            if ($ph_key === 'nomor_pengantar' || $ph_key === 'no_pengantar') {
                                $val = $nomor_pengantar ?? '';
                            }

                            // khusus kode banjar
                            if (in_array($ph_key, ['kode', 'kode_dusun', 'kode_banjar'])) {
                                $val = $data_input['kode_banjar'] ?? '';
                            }
                            // key utama
                            elseif (isset($data_input[$ph_key]) && $data_input[$ph_key] !== '') {
                                $val = $data_input[$ph_key];
                            }
                            // alias
                            elseif (isset($aliases[$ph_key])) {
                                foreach ($aliases[$ph_key] as $alias) {
                                    $alias_key = strtolower(preg_replace('/[^\w]+/u', '_', $alias));
                                    if (isset($data_input[$alias_key]) && $data_input[$alias_key] !== '') {
                                        $val = $data_input[$alias_key];
                                        break;
                                    }
                                }
                            }

                            $val = $val ?? '';


                            // ===============================
                            // FORMAT TANGGAL BERDASARKAN JENIS
                            // ===============================

                            // TANGGAL LAHIR
                            if (!empty($val) && in_array($ph_key, [
                                'tanggal_lahir',
                                'tgl_lahir',
                                'lahir_tanggal'
                            ])) {
                                $val = $this->format_tgl_lahir($val);
                            }

                            // TANGGAL KELUAR / TANGGAL SURAT
                            elseif (in_array($ph_key, [
                                'tanggal_surat',
                                'tgl_surat',
                                'tanggal_keluar',
                                'tgl_keluar',
                                'tanggal'
                            ])) {
                                $val = $this->format_tgl_surat(time());
                            }


                            // Escape karakter khusus XML
                            $val = htmlspecialchars($val);
                            // TARUH FORCE REPLACE DI SINI (setelah foreach placeholders, sebelum addFromString)
                            $np = $data_input['nomor_pengantar'] ?? '';
                            if ($np !== '') {
                                $xml_clean = preg_replace('/\[\s*nomor\s*[_\s]*pengantar\s*\]/i', htmlspecialchars($np), $xml_clean);
                                $xml_clean = preg_replace('/\[\s*no\s*[_\s]*pengantar\s*\]/i', htmlspecialchars($np), $xml_clean);
                            }

                            // Ganti di dalam <w:t> bila ada, jika tidak ada coba ganti langsung [placeholder]
                            $xml_clean = preg_replace(
                                '/<w:t[^>]*>\[' . preg_quote($ph_raw, '/') . '\]<\/w:t>/iu',
                                '<w:t>' . $val . '</w:t>',
                                $xml_clean
                            );
                            $xml_clean = preg_replace(
                                '/\[' . preg_quote($ph_raw, '/') . '\]/iu',
                                $val,
                                $xml_clean
                            );
                        }

                        $zip->addFromString($filename, $xml_clean);
                    }
                }
                $zip->close();


                $template = new TemplateProcessor($new_file);

                $ttd_map = [
                    'ttdkades2'    => FCPATH . 'uploads/ttd/ttdkades2.png',
                    'ttd_sekdes'  => FCPATH . 'uploads/ttd/ttd_sekdes.png',
                    'ttd_bendesa' => FCPATH . 'uploads/ttd/ttd_bendesa.png',
                ];

                foreach ($ttd_map as $key => $path) {
                    if (file_exists($path)) {
                        $template->setImageValue($key, [
                            'path' => $path,
                            'width' => 500,
                            'height' => 100,
                            'ratio' => true
                        ]);
                    } else {
                        $template->setValue($key, '');
                    }
                }

                $template->saveAs($new_file);


                // Fungsi untuk mendapatkan nilai dengan aliases
                $get_value_with_aliases = function ($key, $data_input, $aliases) {
                    // Coba key utama dulu
                    $val = $data_input[$key] ?? null;
                    if ($val !== null && $val !== '') {
                        return $val;
                    }

                    // Jika key utama kosong/null, coba aliases
                    if (isset($aliases[$key])) {
                        foreach ($aliases[$key] as $alias) {
                            $val = $data_input[$alias] ?? null;
                            if ($val !== null && $val !== '') {
                                return $val;
                            }
                        }
                    }

                    return null;
                };

                // ===========================
                // AMBIL NOMOR TEMPLATE DARI DB
                // ===========================
                $idTemplate = $data_input['id_template'] ?? 0;

                $nomorTemplate = $this->db->select('nomor_template_surat')
                    ->get_where('template_surat', ['id_template' => $idTemplate])
                    ->row('nomor_template_surat');

                // ===============================
                // BENTUK ALAMAT PENERIMA
                // ===============================
                $alamat_penerima = 'Br. ' .
                    ($data_input['banjar'] ?? '-') .
                    ' /Kec. Blahbatuh Kab. Gianyar';


                ($data_input['keterangan'] ?? '-');


                // Bentuk nomor pengantar gabungan
                $nomor_pengantar = ($nomorTemplate ?? '') . '/' .
                    ($data_input['nomor_template_surat'] ?? '') . '' .
                    ($data_input['nomor_pengantar'] ?? '') . '/KBD.' .
                    ($data_input['kode_banjar'] ?? '');


                // ===============================
                // AMBIL NILAI UNTUK JENIS SURAT DARI PLACEHOLDER [keterangan]
                // ===============================
                $jenis_surat_val = '';
                if (!empty($data_input['keterangan'])) {
                    $jenis_surat_val = $data_input['keterangan'];
                } elseif (!empty($data_input['[keterangan]'])) {
                    $jenis_surat_val = $data_input['[keterangan]'];
                } elseif (!empty($data_input['jenis_surat'])) {
                    $jenis_surat_val = $data_input['jenis_surat'];
                }
                $jenis_surat_val = trim((string)$jenis_surat_val);
                if ($jenis_surat_val === '') $jenis_surat_val = '';

                // Simpan metadata arsip ke DB
$id_admin = $this->session->userdata('id_user');
$id_pengajuan_post = $this->input->post('id_pengajuan'); // Ambil ID yang kita titipkan di form tadi

$pengajuan = null;
if (!empty($id_pengajuan_post)) {
    $pengajuan = $this->db->get_where('data_surat', ['id' => $id_pengajuan_post])->row();
}

if ($pengajuan && $pengajuan->arsip_id) {
    // UPDATE baris yang sudah ada (Arsip Kadus)
    $this->db->where('id', $pengajuan->arsip_id);
    $this->db->update('arsip_surat', [
        'file_admin'  => $new_filename,
        'id_admin'    => $id_admin,
        'nomor_surat' => $get_value_with_aliases('nomor_surat', $data_input, $aliases) ?? $this->input->post('nomor_surat'),
        'status'      => 'setuju'
    ]);
        $this->db->where('id', $id_pengajuan_post);
        $this->db->update('data_surat', ['status' => 'approved']);

} else {
    // INSERT: Jika Admin buat surat baru mandiri tanpa pengajuan
    $this->db->insert('arsip_surat', [
        'file_admin'     => $new_filename,
        'id_user'        => $this->session->userdata('id_user'),
        'id_admin'       => $id_admin,
        'id_template'          => $idTemplate, 
        'nomor_template_surat' => $nomorTemplate,
        'kode_banjar' => $data_input['kode_banjar'] ?? '',
        'banjar'      => $data_input['banjar'] ?? '',
        'nomor_surat' => $get_value_with_aliases('nomor_surat', $data_input, $aliases) ?? $this->input->post('nomor_surat'),
        'nomor_pengantar' => $nomor_pengantar,
        'nama'           => $data_input['nama'] ?? null,
        'alamat_penerima' => $alamat_penerima,
        'jenis_surat'    => $jenis_surat_val,
        'status'         => 'setuju',
        'created_at'     => date('Y-m-d H:i:s')
    ]);
        }


                if ($id_data) {

                    // Ambil data_surat
                    $data_surat = $this->db->get_where('data_surat', ['id' => $id_data])->row();

                    if ($data_surat) {

                        // 1️⃣ update data_surat
                        $this->db->where('id', $id_data)
                            ->update('data_surat', ['status' => 'disetujui']);

                        // 2️⃣ update arsip_surat pakai arsip_id
                        $this->db->where('id', $data_surat->arsip_id)
                            ->update('arsip_surat', ['status' => 'disetujui']);

                        // 3️⃣ kirim notifikasi ke kadus
                        $this->db->insert('notifikasi', [
                            'tujuan_role' => 'kadus',
                            'pesan'       => 'Surat Anda telah disetujui dan selesai dibuat',
                            'link'        => site_url('kadus/arsip'),
                            'status'      => 'belum dibaca',
                            'created_at'  => date('Y-m-d H:i:s')
                        ]);
                    }
                }

                $this->session->set_flashdata('success_file', $new_filename);
                $this->session->set_flashdata('nama_penerima', $data_input['nama'] ?? '');
                $this->session->set_flashdata('no_wa_warga', $data_input['no_wa'] ?? '');
                $this->session->set_flashdata('show_action_modal', true);

                redirect('admin/edit_surat/' . $id);
            } else {
                $this->session->set_flashdata('message', 'Gagal membuka file surat baru!');
                redirect('admin/daftar_surat');
            }
        }

        $data['surat'] = $surat;
        $data['placeholders'] = $placeholders;

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/surat/edit_surat', $data);
        $this->load->view('template_admin/footer');
    }

    private function insert_ttd_from_placeholder($docxPath, $map)
    {
        if (!file_exists($docxPath)) return false;

        $zip = new ZipArchive;
        if ($zip->open($docxPath) !== TRUE) return false;

        $xml = $zip->getFromName('word/document.xml');

        foreach ($map as $placeholder => $imagePath) {

            if (!file_exists($imagePath)) continue;

            if (preg_match('/\[' . preg_quote($placeholder, '/') . '\]/', $xml)) {

                // hapus placeholder teks
                $xml = preg_replace(
                    '/<w:t[^>]*>\[' . preg_quote($placeholder, '/') . '\]<\/w:t>/',
                    '<w:t></w:t>',
                    $xml
                );

                // sisipkan gambar Word (inline)
                $imageName = 'media/' . basename($imagePath);
                $zip->addFile($imagePath, 'word/' . $imageName);

                // NOTE: rels & drawing disederhanakan (aman karena hanya generate)
            }
        }

        $zip->addFromString('word/document.xml', $xml);
        $zip->close();

        return true;
    }


    private function format_tgl_lahir($timestamp)
    {
        if (empty($timestamp)) return '';

        if (!is_int($timestamp) && !ctype_digit((string)$timestamp)) {
            $ts = strtotime($timestamp);
        } else {
            $ts = (int) $timestamp;
        }

        if (!$ts) return '';

        return date('m-d-Y', $ts); // MM-DD-YYYY
    }

    private function format_tgl_surat($timestamp)
    {
        if (empty($timestamp)) return '';

        // Terima timestamp atau string tanggal
        if (!is_int($timestamp) && !ctype_digit((string)$timestamp)) {
            $ts = strtotime($timestamp);
        } else {
            $ts = (int) $timestamp;
        }

        if (!$ts) return '';

        $bulan = [
            1 => 'Januari',
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
        ];

        $tanggal = date('j', $ts);                // 17
        $nama_bulan = $bulan[(int) date('n', $ts)]; // Agustus
        $tahun   = date('Y', $ts);                // 2025

        // ===============================
        // FORMAT DESA: TGL BULAN TAHUN
        // ===============================
        return $tanggal . ' ' . $nama_bulan . ' ' . $tahun;
    }


    public function scan_ktp()
    {
        header('Content-Type: application/json');

        if (empty($_FILES['ktp']['tmp_name'])) {
            echo json_encode(['success' => false, 'message' => 'File tidak ditemukan']);
            exit;
        }

        // =========================
        // GOOGLE VISION API KEY
        // =========================
        $apiKey = 'API_KEY_KAMU_DI_SINI';

        // Ambil gambar & encode base64
        $imageData = base64_encode(file_get_contents($_FILES['ktp']['tmp_name']));

        // Payload request
        $payload = json_encode([
            'requests' => [[
                'image' => ['content' => $imageData],
                'features' => [[
                    'type' => 'TEXT_DETECTION'
                ]]
            ]]
        ]);

        // Kirim ke Google Vision
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://vision.googleapis.com/v1/images:annotate?key=' . $apiKey,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => $payload
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if (!isset($result['responses'][0]['fullTextAnnotation']['text'])) {
            echo json_encode(['success' => false, 'message' => 'OCR gagal membaca teks']);
            exit;
        }

        // =========================
        // TEKS OCR MENTAH
        // =========================
        $text = strtoupper($result['responses'][0]['fullTextAnnotation']['text']);

        // (DEBUG – boleh hapus nanti)
        file_put_contents(FCPATH . 'vision_debug.txt', $text);

        // Pecah per baris
        $lines = array_filter(array_map('trim', explode("\n", $text)));

        // =========================
        // INISIALISASI DATA
        // =========================
        $nik = $nama = $tempat_lahir = $tanggal_lahir = $jk = $alamat = '';

        // =========================
        // DETEKSI NIK (16 digit)
        // =========================
        foreach ($lines as $line) {
            if (preg_match('/\b\d{16}\b/', $line, $m)) {
                $nik = $m[0];
                break;
            }
        }

        // =========================
        // DETEKSI NAMA (huruf kapital)
        // =========================
        foreach ($lines as $line) {
            if (
                strlen($line) > 5 &&
                preg_match('/^[A-Z\s]+$/', $line) &&
                !preg_match('/PROVINSI|KABUPATEN|KECAMATAN|DESA|NIK/', $line)
            ) {
                $nama = $line;
                break;
            }
        }

        // =========================
        // TEMPAT & TANGGAL LAHIR
        // =========================
        foreach ($lines as $line) {
            if (preg_match('/([A-Z\s]+),\s*(\d{2}[\-\/]\d{2}[\-\/]\d{4})/', $line, $m)) {
                $tempat_lahir = trim($m[1]);
                $tanggal_lahir = date('Y-m-d', strtotime(str_replace('/', '-', $m[2])));
                break;
            }
        }

        // =========================
        // JENIS KELAMIN
        // =========================
        foreach ($lines as $line) {
            if (strpos($line, 'LAKI') !== false) {
                $jk = 'Laki-laki';
                break;
            }
            if (strpos($line, 'PEREMPUAN') !== false) {
                $jk = 'Perempuan';
                break;
            }
        }

        // =========================
        // ALAMAT (baris panjang)
        // =========================
        foreach ($lines as $line) {
            if (
                strlen($line) > 15 &&
                preg_match('/(JL|JALAN|DUSUN|BANJAR|RT|RW)/', $line)
            ) {
                $alamat = $line;
                break;
            }
        }

        // =========================
        // RESPONSE JSON
        // =========================
        echo json_encode([
            'success' => true,
            'nik' => $nik,
            'nama' => $nama,
            'tempat_lahir' => $tempat_lahir,
            'tanggal_lahir' => $tanggal_lahir,
            'jenis_kelamin' => $jk,
            'alamat' => $alamat
        ]);
        exit;
    }

    /**
     * --- HALAMAN ARSIP ---
     */
    public function arsip()
    {
        $from = $this->input->get('from');
        $to = $this->input->get('to');


        $this->load->model('Arsip_model');
        if (!empty($from) || !empty($to)) {
            $data['arsip'] = $this->Arsip_model->getArsip($from, $to) ?: [];
        } else {
            $data['arsip'] = $this->Arsip_model->get_all() ?: [];
        }


        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/surat/arsip', $data);
        $this->load->view('template_admin/footer');
    }


    public function arsip_download()
    {
        $from = $this->input->post('from');
        $to   = $this->input->post('to');
        $type = $this->input->post('type');
        $nama_surat = $this->input->post('nama_surat');


        // ==========================
        // QUERY DATA ARSIP
        // ==========================
        $this->db->select('arsip_surat.*, template_surat.nama_surat, template_surat.nomor_template_surat');
        $this->db->from('arsip_surat');
        $this->db->join(
            'template_surat',
            'arsip_surat.id_template = template_surat.id_template',
            'left'
        );
        $this->db->join(
            'users',
            'arsip_surat.id_user = users.id_user',
            'left'
        );

        // Filter hanya surat dari Admin
        $this->db->where('users.role', 'admin');

        if (!empty($nama_surat)) {
            $this->db->where('template_surat.nama_surat', $nama_surat);
        }


        if (!empty($from)) {
            $this->db->where('DATE(arsip_surat.created_at) >=', $from);
        }

        if (!empty($to)) {
            $this->db->where('DATE(arsip_surat.created_at) <=', $to);
        }

        $arsip = $this->db
            ->order_by('arsip_surat.created_at', 'ASC')
            ->get()
            ->result();

        if (!$arsip) {
            $arsip = [];
        }


        // ==========================
        // EXPORT CSV
        // ==========================
        if ($type === 'csv') {

            $filename = 'laporan_arsip_' . date('Ymd_His') . '.csv';

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM UTF-8

            fputcsv($out, [
                'No Urut Surat',
                'Tgl Surat',
                'Nomor Surat',
                'Nomor Pengantar Kelian',
                'Nama Penerima',
                'Alamat Penerima',
                'Jenis Surat'
            ]);

            $no = 1;
            foreach ($arsip as $r) {
                fputcsv($out, [
                    $no++,
                    $r->created_at ?? '-',
                    $r->nomor_surat ?? '-',
                    '-',
                    $r->nama ?? '-',
                    '-',
                    $r->nama_surat ?? '-'
                ]);
            }

            fclose($out);
            exit;
        }


        // ==========================
        // EXPORT PDF
        // ==========================
        elseif ($type === 'pdf') {

            // ==========================
            // HELPER FORMAT TANGGAL (LOCAL)
            // ==========================
            function format_tanggal_indo($tanggal)
            {
                if (empty($tanggal)) return '-';

                $bulan = [
                    '01' => 'Januari',
                    '02' => 'Februari',
                    '03' => 'Maret',
                    '04' => 'April',
                    '05' => 'Mei',
                    '06' => 'Juni',
                    '07' => 'Juli',
                    '08' => 'Agustus',
                    '09' => 'September',
                    '10' => 'Oktober',
                    '11' => 'November',
                    '12' => 'Desember'
                ];

                $exp = explode('-', $tanggal);
                if (count($exp) !== 3) return $tanggal;

                return $exp[2] . ' ' . $bulan[$exp[1]] . ' ' . $exp[0];
            }



            // load library dompdf (manual, tanpa composer)
            require_once APPPATH . 'third_party/dompdf/autoload.inc.php';

            $dompdf = new \Dompdf\Dompdf();
            $dompdf->setPaper('A4', 'portrait');

            // ==========================
            // HTML PDF
            // ==========================
            $html = '
    <html>
    <head>
        <style>
            body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
            h3 { text-align:center; margin-bottom:10px; }
            table { width:100%; border-collapse: collapse; }
            th, td { border:1px solid #000; padding:5px; }
            th { background:#f0f0f0; text-align:center; }
        </style>
    </head>
    <body>

    <h3>REKAPAN ARSIP SURAT</h3>
    <p>
         Periode: ' .
                format_tanggal_indo($from) . ' s/d ' .
                format_tanggal_indo($to) . '
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Surat</th>
                <th>Nomor Surat</th>
                <th>Nomor Pengantar</th>
                <th>Nama Penerima</th>
                <th>Alamat</th>
                <th>Jenis Surat</th>
            </tr>
        </thead>
        <tbody>';

            // ==========================
            // AMBIL DATA ARSIP
            // ==========================
            $from       = $this->input->post('from');
            $to         = $this->input->post('to');
            $namaSurat  = $this->input->post('nama_surat');

            $arsip = $this->Arsip_model->get_between($from, $to, $namaSurat);


            // ==========================
            // SORT BERDASARKAN TANGGAL FINAL
            // ==========================
            usort($arsip, function ($a, $b) {

                $tglA = !empty($a->tanggal_surat)
                    ? strtotime($a->tanggal_surat)
                    : strtotime($a->created_at);

                $tglB = !empty($b->tanggal_surat)
                    ? strtotime($b->tanggal_surat)
                    : strtotime($b->created_at);

                return $tglA <=> $tglB; // ASC (paling lama dulu)
            });

            // ==========================
            // BARU BUAT PDF
            // ==========================
            $no = 1;
            foreach ($arsip as $a) {
                // build <tr> PDF
            }

            $no = 1;
            foreach ($arsip as $a) {
                $html .= '
        <tr>
            <td align="center">' . $no++ . '</td>
           <td>' . (
                    !empty($a->tanggal_surat)
                    ? date('d-m-Y', strtotime($a->tanggal_surat))
                    : date('d-m-Y', strtotime($a->created_at))
                ) . '</td>

          <td>' . htmlspecialchars(
                    (function ($a) {
                        $tpl = trim((string)($a->nomor_template_surat ?? ''));
                        $ns  = trim((string)($a->nomor_surat ?? ''));

                        // rapikan
                        $ns = ltrim($ns, '/');

                        // 1️⃣ HASIL GENERATE TEMPLATE
                        if ($tpl !== '' && $ns !== '') {
                            return $tpl . '/' . $ns . '/P.Blh';
                        }

                        // 2️⃣ ARSIP MANUAL / DATA LAMA (PASTIKAN ADA P.Blh)
                        if ($ns !== '') {
                            return (stripos($ns, '/P.Blh') !== false)
                                ? $ns
                                : $ns . '/P.Blh';
                        }

                        // 3️⃣ TIDAK ADA DATA
                        return '-';
                    })($a)
                ) . '</td>


            <td>' . htmlspecialchars(
                    (function ($a) {
                        $tpl = trim((string)($a->nomor_template_surat ?? ''));
                        $np  = trim((string)($a->nomor_pengantar ?? ''));

                        // bersihkan data kotor
                        $np = str_replace(['nomor_teamplate_surat/', 'nomor_teamplate_surat', 'Array'], '', $np);
                        $np = ltrim($np, '/');

                        // ambil kode banjar:
                        // 1) dari kolom kode_banjar kalau ada
                        $kd = trim((string)($a->kode_banjar ?? ''));

                        // 2) kalau kosong, coba ambil dari string nomor_pengantar setelah "KBD"
                        if ($kd === '' && preg_match('#KBD\.?([A-Za-z0-9_-]+)#i', $np, $m)) {
                            $kd = $m[1]; // misal "tgh"
                        }

                        // ambil nomor pengantar angka sebelum /KBD...
                        $np_num = preg_split('#/KBD#i', $np)[0];

                        if ($tpl !== '' && $np_num !== '') return $tpl . '/' . $np_num . '/KBD.' . $kd;
                        if ($np_num !== '') return $np_num . ($kd !== '' ? '/KBD.' . $kd : '');
                        return '-';
                    })($a)
                ) . '</td>


            <td>' . htmlspecialchars($a->nama ?? '-') . '</td>
            <td>' . htmlspecialchars($a->alamat_penerima ?? '-') . '</td>
           
           <td>' . htmlspecialchars(
                    (!empty($a->jenis_surat) && !empty($a->nama_surat)) ? ($a->nama_surat . '  ' . $a->jenis_surat) : (!empty($a->jenis_surat) ? $a->jenis_surat : (!empty($a->nama_surat) ? $a->nama_surat : '-'))
                ) . '</td>

        </tr>';
            }

            if (count($arsip) === 0) {
                $html .= '<tr><td colspan="7" align="center">Tidak ada data</td></tr>';
            }

            $html .= '
        </tbody>
    </table>
    </body>
    </html>';

            $dompdf->loadHtml($html);
            $dompdf->render();

            $filename = 'rekapan_arsip_' . date('Ymd_His') . '.pdf';
            $dompdf->stream($filename, ['Attachment' => true]);
            exit;
        }


        // ==========================
        // EXPORT EXCEL TANPA COMPOSER
        // ==========================
        elseif ($type === 'xlsx') {


            // ==========================
            // URUTKAN DATA BERDASARKAN TANGGAL (PALING AWAL DULU)
            // ==========================
            usort($arsip, function ($a, $b) {

                // pakai tanggal_surat kalau ada, fallback ke created_at
                $tglA = !empty($a->tanggal_surat) ? $a->tanggal_surat : $a->created_at;
                $tglB = !empty($b->tanggal_surat) ? $b->tanggal_surat : $b->created_at;

                return strtotime($tglA) <=> strtotime($tglB); // ASC
            });

            $filename = 'rekapan_arsip_' . date('Ymd_His') . '.xls';

            header("Content-Type: application/vnd.ms-excel; charset=utf-8");
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header("Pragma: no-cache");
            header("Expires: 0");

            echo '<html><head><meta charset="UTF-8"></head><body>';
            echo '<table border="1" cellspacing="0" cellpadding="5">';

            // Judul
            echo '<tr>';
            echo '<th colspan="7" style="font-size:14px;font-weight:bold;text-align:center;">REKAPAN ARSIP SURAT</th>';
            echo '</tr>';

            // Periode
            echo '<tr>';
            echo '<td colspan="7">';
            echo 'Periode: ' . (!empty($from) ? $from : '-') . ' s/d ' . (!empty($to) ? $to : '-');
            echo '</td>';
            echo '</tr>';

            // Header tabel
            echo '<tr style="font-weight:bold;background:#f0f0f0;text-align:center;">';
            echo '<th>No</th>';
            echo '<th>Tanggal Surat</th>';
            echo '<th>Nomor Surat</th>';
            echo '<th>Nomor Pengantar Kelian</th>';
            echo '<th>Nama Penerima</th>';
            echo '<th>Alamat Penerima</th>';
            echo '<th>Jenis Surat</th>';
            echo '</tr>';


            // Data
            if (!empty($arsip)) {
                $no = 1;
                foreach ($arsip as $a) {
                    echo '<tr>';
                    echo '<td align="center">' . $no++ . '</td>';
                    echo '<td>' . (!empty($a->created_at) ? date('d-m-Y', strtotime($a->created_at)) : '-') . '</td>';
                    echo '<td>' . htmlspecialchars(
                        (function ($a) {
                            $tpl = trim((string)($a->nomor_template_surat ?? ''));
                            $ns  = trim((string)($a->nomor_surat ?? ''));

                            // bersihkan data kotor
                            $ns = str_replace(['Array'], '', $ns);
                            $ns = ltrim($ns, '/');

                            // 1️⃣ generate template
                            if ($tpl !== '' && $ns !== '') {
                                return $tpl . '/' . $ns . '/P.Blh';
                            }

                            // 2️⃣ arsip manual / data lama
                            if ($ns !== '') {
                                return (stripos($ns, '/P.Blh') !== false)
                                    ? $ns
                                    : $ns . '/P.Blh';
                            }

                            return '-';
                        })($a)
                    ) . '</td>';

                    echo '<td>' . htmlspecialchars(
                        (function ($a) {
                            $tpl = trim((string)($a->nomor_template_surat ?? ''));
                            $np  = trim((string)($a->nomor_pengantar ?? ''));

                            // bersihkan data rusak
                            $np = str_replace(
                                ['nomor_teamplate_surat/', 'nomor_teamplate_surat', 'Array'],
                                '',
                                $np
                            );
                            $np = ltrim($np, '/');

                            // kode banjar
                            $kd = trim((string)($a->kode_banjar ?? ''));

                            // fallback ambil dari string
                            if ($kd === '' && preg_match('#KBD\.?([A-Za-z0-9_-]+)#i', $np, $m)) {
                                $kd = $m[1];
                            }

                            // angka pengantar sebelum /KBD
                            $np_num = preg_split('#/KBD#i', $np)[0];

                            if ($tpl !== '' && $np_num !== '') {
                                return $tpl . '/' . $np_num . '/KBD.' . $kd;
                            }

                            if ($np_num !== '') {
                                return $np_num . ($kd !== '' ? '/KBD.' . $kd : '');
                            }

                            return '-';
                        })($a)
                    ) . '</td>';

                    echo '<td>' . htmlspecialchars($a->nama ?? '-') . '</td>';
                    echo '<td>' . htmlspecialchars($a->alamat_penerima ?? '-') . '</td>';
                    echo '<td>' . htmlspecialchars(
                        (!empty($a->jenis_surat) && !empty($a->nama_surat)) ? ($a->nama_surat . '  ' . $a->jenis_surat) : (!empty($a->jenis_surat) ? $a->jenis_surat : (!empty($a->nama_surat) ? $a->nama_surat : '-'))
                    ) . '</td>';

                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="7" align="center">Tidak ada data</td></tr>';
            }

            echo '</table>';
            echo '</body></html>';
            exit;
        }


        // ==========================
        // EXPORT ZIP FILE SURAT
        // ==========================
        elseif ($type === 'zip') {

            $zipname = 'arsip_surat_' . date('Ymd_His') . '.zip';
            $tmpZip  = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $zipname;

            $zip = new ZipArchive();
            if ($zip->open($tmpZip, ZipArchive::CREATE) !== TRUE) {
                show_error('Gagal membuat file ZIP');
            }

            foreach ($arsip as $r) {
                if (empty($r->filename)) continue;

                $file = FCPATH . 'uploads/surat/' . $r->filename;
                if (file_exists($file)) {

                    $safe_title = preg_replace(
                        '/[^A-Za-z0-9_\-]+/',
                        '_',
                        trim($r->nama_surat ?? 'surat')
                    );

                    $localname =
                        date('Ymd_His', strtotime($r->created_at ?? date('Y-m-d H:i:s'))) .
                        '_' . $safe_title .
                        '_id' . $r->id .
                        '_' . $r->filename;

                    $zip->addFile($file, $localname);
                }
            }

            $zip->close();

            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zipname . '"');
            header('Content-Length: ' . filesize($tmpZip));
            readfile($tmpZip);
            @unlink($tmpZip);
            exit;
        }

        // ==========================
        // INVALID TYPE
        // ==========================
        else {
            show_error('Tipe download tidak valid');
        }
    }


    public function delete_surat($id)
    {
        $this->Surat_model->delete($id);
        redirect('admin/daftar_surat');
    }

    public function preview_template($id)
    {
        $this->load->model('Surat_model');
        $surat = $this->Surat_model->get_by_id($id);

        if (!$surat || empty($surat->file_template)) {
            show_error('Template tidak ditemukan');
        }

        $file_path = FCPATH . 'uploads/template/' . $surat->file_template;
        if (!file_exists($file_path)) {
            show_error('File template tidak ditemukan');
        }

        // Load dan convert Word ke HTML untuk preview
        try {
            libxml_use_internal_errors(true); // Suppress XML warnings
            $phpWord = \PhpOffice\PhpWord\IOFactory::load($file_path);
            libxml_clear_errors();
            $temp_html = tempnam(sys_get_temp_dir(), 'preview_') . '.html';
            $phpWord->save($temp_html, 'HTML');
            $html_content = file_get_contents($temp_html);
            @unlink($temp_html);

            $data['surat'] = $surat;
            $data['html_content'] = $html_content;

            $this->load->view('template_admin/header');
            $this->load->view('template_admin/sidebar');
            $this->load->view('admin/surat/preview_template', $data);
            $this->load->view('template_admin/footer');
        } catch (\Exception $e) {
            show_error('Gagal membuka template: ' . $e->getMessage());
        }
    }

    public function edit_template($id)
    {
        $this->load->model('Surat_model');
        $this->load->model('Arsip_model');
        $surat = $this->Surat_model->get_by_id($id);

        if (!$surat) {
            show_error('Template tidak ditemukan di database.');
        }

        // Ambil arsip surat terbaru untuk template ini
        $latest_arsip = $this->db
            ->from('arsip_surat')
            ->join('users', 'arsip_surat.id_user = users.id_user', 'left')
            ->where('arsip_surat.id_template', $id)
            ->where('users.role', 'admin')
            ->order_by('arsip_surat.created_at', 'DESC')
            ->limit(1)
            ->get()->row();
        if (!$latest_arsip || empty($latest_arsip->filename)) {
            $this->session->set_flashdata('error', 'Belum ada surat yang di-generate untuk template ini. Generate surat terlebih dahulu.');
            redirect('admin/edit_surat/' . $id);
            return;
        }

        $file_path = FCPATH . 'uploads/surat/' . $latest_arsip->filename;

        // Periksa apakah folder ada, jika tidak buat
        $upload_dir = dirname($file_path);
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
            $this->session->set_flashdata('message', 'Folder uploads/surat/ dibuat.');
            redirect('admin/daftar_surat');
            return;
        }

        if (!file_exists($file_path)) {
            show_error('File surat tidak ditemukan di: ' . htmlspecialchars($file_path) . '. Mungkin file telah dihapus.');
        }

        // Jika ada POST (edit HTML), lakukan replace dengan WYSIWYG
        if ($this->input->post()) {
            $edited_html = $this->input->post('edited_html');

            if (!empty($edited_html)) {
                try {
                    // Backup file lama
                    $backup_file = $file_path . '.bak';
                    if (file_exists($backup_file)) @unlink($backup_file);
                    copy($file_path, $backup_file);

                    // Remove old file to avoid overwrite issues
                    if (file_exists($file_path)) @unlink($file_path);

                    // Use pandoc to convert HTML to DOCX with format preservation
                    $temp_html = tempnam(sys_get_temp_dir(), 'edit_html_') . '.html';
                    $temp_docx = tempnam(sys_get_temp_dir(), 'edit_docx_') . '.docx';
                    file_put_contents($temp_html, $edited_html);

                    $command = "C:\\laragon\\www\\web-desa-ci3\\pandoc\\pandoc-3.8.3\\pandoc.exe \"$temp_html\" -o \"$temp_docx\"";
                    exec($command, $output, $return_var);

                    if ($return_var === 0 && file_exists($temp_docx)) {
                        copy($temp_docx, $file_path);
                        $message = 'Surat berhasil diperbarui dengan format dipertahankan!';
                    } else {
                        throw new Exception('Pandoc conversion failed. Output: ' . implode("\n", $output));
                    }

                    // Cleanup temp files
                    @unlink($temp_html);
                    @unlink($temp_docx);

                    // Also save HTML for preview
                    file_put_contents($file_path . '.html', $edited_html);

                    $this->session->set_flashdata('message', $message);
                    redirect('admin/edit_template/' . $id);
                } catch (\Exception $e) {
                    $this->session->set_flashdata('error', 'Gagal mengedit: ' . $e->getMessage());
                }
            }
        }

        // For preview, use PhpWord to convert DOCX to HTML with better layout preservation
        $html_file = $file_path . '.html';
        if (file_exists($html_file)) {
            $html_content = file_get_contents($html_file);
        } else {
            // Convert using PhpWord for accurate DOCX layout
            try {
                libxml_use_internal_errors(true);
                $phpWord = \PhpOffice\PhpWord\IOFactory::load($file_path);
                libxml_clear_errors();
                $temp_html = tempnam(sys_get_temp_dir(), 'preview_') . '.html';
                $phpWord->save($temp_html, 'HTML');
                $html_content = file_get_contents($temp_html);
                // Embed images as base64 to preserve layout
                $html_content = $this->embedImagesInHtml($html_content, dirname($temp_html));
                @unlink($temp_html);
                // Save for future use
                file_put_contents($html_file, $html_content);
            } catch (\Exception $e) {
                $html_content = '<p>Gagal memuat preview. File mungkin rusak: ' . htmlspecialchars($e->getMessage()) . '</p>';
            }
        }

        $data['surat'] = $surat;
        $data['html_content'] = $html_content;
        $data['is_editing_generated'] = true; // flag untuk view

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/surat/edit_template', $data);
        $this->load->view('template_admin/footer');
    }

    public function preview_surat($arsip_id)
    {
        $this->load->model('Arsip_model');
        $arsip = $this->Arsip_model->get_by_id($arsip_id);

        if (!$arsip || empty($arsip->filename)) {
            show_error('Arsip tidak ditemukan');
        }

        $file_path = FCPATH . 'uploads/surat/' . $arsip->filename;
        if (!file_exists($file_path)) {
            show_error('File surat tidak ditemukan');
        }

        try {
            libxml_use_internal_errors(true); // Suppress XML warnings
            $phpWord = \PhpOffice\PhpWord\IOFactory::load($file_path);
            libxml_clear_errors();
            $temp_html = tempnam(sys_get_temp_dir(), 'preview_') . '.html';
            $phpWord->save($temp_html, 'HTML');
            $html_content = file_get_contents($temp_html);
            @unlink($temp_html);

            $data['arsip'] = $arsip;
            $data['html_content'] = $html_content;

            $this->load->view('template_admin/header');
            $this->load->view('template_admin/sidebar');
            $this->load->view('admin/surat/preview_surat', $data);
            $this->load->view('template_admin/footer');
        } catch (\Exception $e) {
            show_error('Gagal membuka preview: ' . $e->getMessage());
        }
    }

    /**
     * Embed images in HTML as base64
     */
    private function embedImagesInHtml($html, $temp_dir)
    {
        // Find img tags with src
        preg_match_all('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $html, $matches);
        foreach ($matches[1] as $src) {
            $image_path = $temp_dir . DIRECTORY_SEPARATOR . basename($src);
            if (file_exists($image_path)) {
                $image_data = file_get_contents($image_path);
                $base64 = base64_encode($image_data);
                $mime = mime_content_type($image_path);
                $data_uri = 'data:' . $mime . ';base64,' . $base64;
                $html = str_replace($src, $data_uri, $html);
                @unlink($image_path); // Clean up
            }
        }
        return $html;
    }


    public function tambah_arsip()
    {
        $data['title'] = 'Tambah Arsip Surat';
        $data['dusun'] = $this->db->get('dusun')->result();

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/surat/tambah_arsip', $data);
        $this->load->view('template_admin/footer');
    }


    public function simpan_arsip()
    {
        // =====================
        // CEK POST
        // =====================
        if (!$this->input->post()) {
            redirect('admin/tambah_arsip');
            return;
        }

        // =====================
        // AMBIL & VALIDASI BANJAR
        // =====================
        $kode_banjar = $this->input->post('kode_banjar', true);

        $dusun = $this->db
            ->get_where('dusun', ['kode_dusun' => $kode_banjar])
            ->row();

        if (!$dusun) {
            $this->session->set_flashdata('error', 'Banjar tidak valid.');
            redirect('admin/tambah_arsip');
            return;
        }

        // =====================
        // UPLOAD FILE SURAT
        // =====================
        $filename = null;

        if (!empty($_FILES['file_surat']['name'])) {

            // bersihkan nama file
            $originalName = $_FILES['file_surat']['name'];
            $cleanName = preg_replace('/[^A-Za-z0-9_\-.]/', '_', $originalName);

            $config['upload_path']   = FCPATH . 'uploads/surat/';
            $config['allowed_types'] = 'pdf|doc|docx';
            $config['max_size']      = 2048; // 2 MB
            $config['encrypt_name']  = false;
            $config['file_name']     = time() . '_' . $cleanName;

            $this->load->library('upload');
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('file_surat')) {
                $this->session->set_flashdata(
                    'error',
                    strip_tags($this->upload->display_errors())
                );
                redirect('admin/tambah_arsip');
                return;
            }

            $filename = $this->upload->data('file_name');
        }

        // =====================
        // SIMPAN KE DATABASE
        // =====================
        $tanggal_manual = $this->input->post('tanggal_surat', true);
        $id_template = $this->input->post('id_template', true) ?: 1; // Default ke 1 jika kosong
        $id_user = $this->session->userdata('id_user');

        // Debug: Jika id_user null, throw error
        if (empty($id_user)) {
            $this->session->set_flashdata('error', 'Session user tidak ditemukan. Silahkan login terlebih dahulu.');
            redirect('admin/tambah_arsip');
            return;
        }

        $insert = [
            'id_template'     => $id_template,
            'id_user'         => $id_user,
            'tanggal_surat'   => !empty($tanggal_manual) ? $tanggal_manual : null,
            'created_at'      => date('Y-m-d H:i:s'),
            'nomor_surat'     => $this->input->post('nomor_surat', true),
            'nomor_pengantar' => $this->input->post('nomor_pengantar', true),
            'nama'            => $this->input->post('nama', true),
            'alamat_penerima' => $this->input->post('alamat_penerima', true),
            'jenis_surat'     => $this->input->post('jenis_surat', true),
            'kode_banjar'     => $dusun->kode_dusun,
            'banjar'          => $dusun->nama_dusun,
            'filename'        => $filename
        ];

        $this->db->insert('arsip_surat', $insert);

        // =====================
        // FEEDBACK
        // =====================
        $this->session->set_flashdata('success', 'Arsip surat berhasil ditambahkan.');
        redirect('admin/arsip');
    }

    public function hapus_arsip($id)
    {
        $row = $this->db
            ->from('arsip_surat')
            ->join('users', 'arsip_surat.id_user = users.id_user', 'left')
            ->where('arsip_surat.id', (int)$id)
            ->where('users.role', 'admin')
            ->get()
            ->row();

        if (!$row) {
            $this->session->set_flashdata('error', 'Data arsip tidak ditemukan.');
            redirect('admin/arsip');
            return;
        }

        // hapus file fisik
        if (!empty($row->filename)) {
            $path = FCPATH . 'uploads/surat/' . $row->filename;
            if (file_exists($path)) {
                @unlink($path);
            }
        }

        $this->db->delete('arsip_surat', ['id' => (int)$id]);

        $this->session->set_flashdata('success', 'Arsip berhasil dihapus.');
        redirect('admin/arsip');
    }
}
