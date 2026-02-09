<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Input $input
 * @property CI_Upload $upload
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 * @property Surat_model $Surat_model
 * @property Dusun_model $Dusun_model
 * @property Arsip_model $Arsip_model
 * 
 */
use PhpOffice\PhpWord\IOFactory;
use Dompdf\Dompdf;
use Dompdf\Options;

use PhpOffice\PhpWord\TemplateProcessor;



class Admin extends Admin_Middleware {

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

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Surat_model');
        $this->load->model('Dusun_model');
        $this->load->model('Arsip_model');
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
        $config['upload_path']   = './uploads/template_surat/';
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
                'file_template'=> $upload_data['file_name'],
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


public function edit_surat($id)
{
    $this->load->model('Dusun_model');
    $data['dusun'] = $this->Dusun_model->get_all();

    $this->load->model('Surat_model');
    $surat = $this->Surat_model->get_by_id($id);

    if (!$surat) {
        show_404();
    }

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

        $new_filename = 'surat_' . time() . '.docx';
        $new_file = './uploads/surat/' . $new_filename;

        if (!copy($file_path, $new_file)) {
            $this->session->set_flashdata('message', 'Gagal menyalin template surat!');
            redirect('admin/daftar_surat');
        }

        $zip = new ZipArchive;
        if ($zip->open($new_file) === TRUE) {
            $xml = $zip->getFromName('word/document.xml');
            $xml_clean = preg_replace('/<\/w:t>\s*<w:t[^>]*>/', '', $xml);

            foreach ($placeholders as $ph_raw) {
                // Normalisasi placeholder: ubah spasi/non-alnum menjadi underscore, lowercase
                $ph = trim($ph_raw);
                $ph_key = strtolower(preg_replace('/[^\w]+/u', '_', $ph));

                // Alias khusus untuk beberapa field
                $aliases = [
                    'jenis_kelamin'     => ['jenis_kelamin','jenis kelamin','gender','jk','sex'],
                    'status_perkawinan' => ['status_perkawinan','status perkawinan','perkawinan','status']
                ];

                // Ambil nilai dari input dengan beberapa fallback
                if (in_array($ph_key, ['kode','kode_dusun','kode_banjar'])) {
                    $val = $data_input['kode_banjar'] ?? '';
                } else {
                    $val = $data_input[$ph_key] ?? null;
                    if ($val === null) {
                        foreach ($aliases as $key => $alts) {
                            if (in_array($ph_key, $alts, true)) {
                                $val = $data_input[$key] ?? null;
                                if ($val === null && isset($data_input[$alts[0]])) {
                                    $val = $data_input[$alts[0]];
                                }
                                break;
                            }
                        }
                    }
                    $val = $val ?? '';
                }

                // Gunakan $ph_key untuk deteksi tanggal (bukan $ph_clean)
                if (!empty($val) && (stripos($ph_key, 'tgl') !== false || stripos($ph_key, 'tanggal') !== false)) {
                    $timestamp = strtotime($val);
                    if ($timestamp) {
                        $val = $this->tanggal_indonesia($timestamp);
                    }
                }

                // Escape karakter khusus XML
                $val = htmlspecialchars($val);

                // Ganti di dalam <w:t> bila ada, jika tidak ada coba ganti langsung [placeholder]
                $xml_clean = preg_replace(
                    '/<w:t>\[' . preg_quote($ph_raw, '/') . '\]<\/w:t>/iu',
                    '<w:t>' . $val . '</w:t>',
                    $xml_clean
                );
                $xml_clean = preg_replace(
                    '/\[' . preg_quote($ph_raw, '/') . '\]/iu',
                    $val,
                    $xml_clean
                );
            }

            $zip->addFromString('word/document.xml', $xml_clean);
            $zip->close();

            // Simpan metadata arsip ke DB
            $arsip_data = [
                'filename'    => $new_filename,
                'id_template' => $id,
                'nomor_surat' => $data_input['nomor_surat'] ?? null,
                'nama'        => $data_input['nama'] ?? null,
                'created_at'  => date('Y-m-d H:i:s')
            ];
            $this->Arsip_model->add($arsip_data);

            $this->session->set_flashdata('success_file', $new_filename);
            $this->session->set_flashdata('message', 'Surat berhasil dibuat!');
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

/**
 * Format tanggal ke Indonesia
 */
private function tanggal_indonesia($timestamp)
{
    if (empty($timestamp)) {
        return '';
    }

    // terima integer timestamp atau string tanggal
    if (!is_int($timestamp) && !ctype_digit((string)$timestamp)) {
        $ts = strtotime($timestamp);
    } else {
        $ts = (int) $timestamp;
    }

    if ($ts === false || $ts <= 0) {
        return '';
    }

    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    return date('j', $ts) . ' ' . $bulan[(int) date('n', $ts)] . ' ' . date('Y', $ts);
}

/**
 * Cetak ke PDF (perbaikan sanitasi filename & error handling)
 */
public function cetak_pdf($filename = null)
{
    if (empty($filename)) {
        show_error('Nama file tidak diberikan.');
    }

    // decode dan sanitasi (hindari directory traversal / input non-string)
    $filename = (string) $filename;
    $filename = rawurldecode($filename);
    $filename = str_replace("\0", '', $filename); // buang null byte jika ada
    $filename = trim($filename);
    if ($filename === '') {
        show_error('Nama file tidak valid.');
    }

    $safe_name = basename($filename); // hanya nama file, tanpa path
    $file_path = FCPATH . 'uploads/surat/' . $safe_name;

    if (!file_exists($file_path)) {
        show_error("File tidak ditemukan: " . htmlspecialchars($safe_name));
    }

    // konversi Word -> HTML -> PDF dengan penanganan error
    $temp_html = tempnam(sys_get_temp_dir(), 'word_') . '.html';
    try {
        // Load dokumen Word
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($file_path);

        // Simpan sementara ke HTML
        $phpWord->save($temp_html, 'HTML');

        // Baca HTML
        $html = file_get_contents($temp_html);
        if ($html === false) {
            throw new Exception('Gagal membaca file HTML sementara.');
        }

        // Render PDF
        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Stream ke browser (inline)
        $out_name = preg_replace('/\.[^.]+$/', '.pdf', $safe_name);
        if (empty($out_name)) { $out_name = 'surat.pdf'; }
        $dompdf->stream($out_name, ["Attachment" => false]);

    } catch (\Exception $e) {
        log_message('error', 'cetak_pdf error: ' . $e->getMessage());
        show_error('Terjadi kesalahan saat membuat PDF: ' . htmlspecialchars($e->getMessage()));
    } finally {
        // bersihkan file temporary jika ada
        if (is_file($temp_html)) {
            @unlink($temp_html);
        }
    }
}

/**
 * --- HALAMAN ARSIP ---
 */
public function arsip()
{
    $this->load->model('Arsip_model');
    $this->load->model('Surat_model');

    // Ambil filter dari GET (format YYYY-MM-DD)
    $from_raw = $this->input->get('from');
    $to_raw   = $this->input->get('to');

    if ($from_raw && $to_raw) {
        $from = date('Y-m-d 00:00:00', strtotime($from_raw));
        $to   = date('Y-m-d 23:59:59', strtotime($to_raw));
        $arsip = $this->Arsip_model->get_between($from, $to);
    } else {
        $arsip = $this->Arsip_model->get_all();
    }

    // Tambahkan nama template (nama_surat) ke setiap record arsip
    foreach ($arsip as $idx => $a) {
        $nama_surat = null;
        if (!empty($a->id_template)) {
            $surat = $this->Surat_model->get_by_id($a->id_template);
            $nama_surat = $surat ? $surat->nama_surat : null;
        }
        $arsip[$idx]->nama_surat = $nama_surat ?: '-';
        $arsip[$idx]->nomor_surat = !empty($a->nomor_surat) ? $a->nomor_surat : '-';
        $arsip[$idx]->nama = !empty($a->nama) ? $a->nama : '-';
        $arsip[$idx]->created_at = !empty($a->created_at) ? $a->created_at : '-';
    }

    $data['arsip'] = $arsip;
    $data['filter_from'] = $from_raw;
    $data['filter_to']   = $to_raw;

    $this->load->view('template_admin/header');
    $this->load->view('template_admin/sidebar');
    $this->load->view('admin/surat/arsip', $data);
    $this->load->view('template_admin/footer');
}


public function arsip_download()
{
    // input
    $type = $this->input->post('type') ?? 'csv';
    $ids  = $this->input->post('ids');
    $from = $this->input->post('from');
    $to   = $this->input->post('to');

    // pilih rows berdasarkan ids atau rentang tanggal atau semua
    if (is_array($ids) && count($ids) > 0) {
        $rows = $this->Arsip_model->get_by_ids($ids);
    } elseif (!empty($from) && !empty($to)) {
        $from_dt = date('Y-m-d 00:00:00', strtotime($from));
        $to_dt   = date('Y-m-d 23:59:59', strtotime($to));
        $rows = $this->Arsip_model->get_between($from_dt, $to_dt);
    } else {
        $rows = $this->Arsip_model->get_all();
    }

    // augment nama_surat
    foreach ($rows as $k => $r) {
        $r->nama_surat = '-';
        if (!empty($r->id_template)) {
            $t = $this->Surat_model->get_by_id($r->id_template);
            $r->nama_surat = $t ? $t->nama_surat : '-';
        }
        $rows[$k] = $r;
    }

    if ($type === 'csv') {
        $filename = 'laporan_arsip_' . date('Ymd_His') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename='.$filename);

        $out = fopen('php://output', 'w');
        fputcsv($out, ['ID','Filename','Nama Surat','Nomor Surat','Nama Penerima','Tanggal']);
        foreach ($rows as $r) {
            fputcsv($out, [
                $r->id,
                $r->filename,
                $r->nama_surat,
                $r->nomor_surat ?? '',
                $r->nama ?? '',
                $r->created_at ?? ''
            ]);
        }
        fclose($out);
        exit;
    } else {
        $zipname = 'arsip_surat_' . date('Ymd_His') . '.zip';
        $zip = new ZipArchive();
        $tmpZip = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $zipname;
        if ($zip->open($tmpZip, ZipArchive::CREATE) !== TRUE) {
            show_error('Gagal membuat zip');
        }
        foreach ($rows as $r) {
            $file = FCPATH . 'uploads/surat/' . $r->filename;
            if (file_exists($file)) {
                // safe nama surat untuk file dalam zip
                $safe_title = preg_replace('/[^A-Za-z0-9_\-]+/', '_', trim($r->nama_surat ?? 'surat'));
                $localname = date('Ymd_His', strtotime($r->created_at ?? date('Y-m-d H:i:s'))) . '_' . $safe_title . '_id' . $r->id . '_' . $r->filename;
                $zip->addFile($file, $localname);
            }
        }
        $zip->close();

        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="'.$zipname.'"');
        header('Content-Length: ' . filesize($tmpZip));
        readfile($tmpZip);
        @unlink($tmpZip);
        exit;
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
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($file_path);
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
    $surat = $this->Surat_model->get_by_id($id);
    
    if (!$surat) {
        show_error('Template tidak ditemukan');
    }

    $file_path = FCPATH . 'uploads/template/' . $surat->file_template;
    if (!file_exists($file_path)) {
        show_error('File template tidak ditemukan');
    }

    // Jika ada POST (edit text), lakukan replace
    if ($this->input->post()) {
        $old_text = $this->input->post('old_text');
        $new_text = $this->input->post('new_text');

        if (!empty($old_text) && !empty($new_text)) {
            try {
                // Baca XML dari docx
                $zip = new ZipArchive();
                $temp_file = $file_path . '.tmp';
                copy($file_path, $temp_file);
                
                if ($zip->open($temp_file) === TRUE) {
                    $xml = $zip->getFromName('word/document.xml');
                    // Replace text (simple approach)
                    $xml = str_replace($old_text, $new_text, $xml);
                    $zip->addFromString('word/document.xml', $xml);
                    $zip->close();

                    // Backup file lama
                    $backup_file = $file_path . '.bak';
                    if (file_exists($backup_file)) @unlink($backup_file);
                    copy($file_path, $backup_file);

                    // Ganti dengan file baru
                    copy($temp_file, $file_path);
                    @unlink($temp_file);

                    $this->session->set_flashdata('message', 'Template berhasil diperbarui!');
                    redirect('admin/edit_template/' . $id);
                }
            } catch (\Exception $e) {
                $this->session->set_flashdata('error', 'Gagal mengedit: ' . $e->getMessage());
            }
        }
    }

    try {
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($file_path);
        $temp_html = tempnam(sys_get_temp_dir(), 'edit_') . '.html';
        $phpWord->save($temp_html, 'HTML');
        $html_content = file_get_contents($temp_html);
        @unlink($temp_html);

        $data['surat'] = $surat;
        $data['html_content'] = $html_content;

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/surat/edit_template', $data);
        $this->load->view('template_admin/footer');
    } catch (\Exception $e) {
        show_error('Gagal membuka template: ' . $e->getMessage());
    }
}
}
