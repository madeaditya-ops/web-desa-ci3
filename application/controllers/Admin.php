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
use PhpOffice\PhpWord\Shared\Html;



class Admin extends CI_Controller {

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

        // Gunakan nama surat sebagai base filename, sanitize
        $base_name = preg_replace('/[^A-Za-z0-9_\-]/', '_', $surat->nama_surat);
        $new_filename = $base_name . '_' . time() . '.docx';
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
                    'jenis_kelamin'     => ['jenis_kelamin','jenis kelamin','gender','jk','sex','kelamin'],
                    'status_perkawinan' => ['status_perkawinan','status perkawinan','perkawinan','status'],
                    'agama'             => ['agama','religion'],
                    'tempat_lahir'      => ['tempat_lahir','tempat lahir','lahir_di'],
                    'tanggal_lahir'     => ['tanggal_lahir','tanggal lahir','tgl_lahir','lahir_tanggal'],
                    'pekerjaan'         => ['pekerjaan','job','occupation'],
                    'alamat'            => ['alamat','address'],
                    'nomor_surat'       => ['nomor_surat','nomor surat','no_surat','nomor']
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

            // Convert DOCX to HTML for preview and save
            try {
                libxml_use_internal_errors(true);
                $phpWord = \PhpOffice\PhpWord\IOFactory::load($new_file);
                libxml_clear_errors();
                $temp_html = tempnam(sys_get_temp_dir(), 'gen_') . '.html';
                $phpWord->save($temp_html, 'HTML');
                $html_content = file_get_contents($temp_html);
                file_put_contents($new_file . '.html', $html_content);
                @unlink($temp_html);
            } catch (\Exception $e) {
                // Ignore, HTML will be generated on demand if needed
            }

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
        libxml_use_internal_errors(true); // Suppress XML warnings
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($file_path);
        libxml_clear_errors();

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
    $from = $this->input->get('from');
    $to = $this->input->get('to');

    $this->load->model('Arsip_model');
    $data['arsip'] = $this->Arsip_model->get_between($from, $to) ?: []; // Pastikan array

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

    // ==========================
    // QUERY DATA ARSIP
    // ==========================
    $this->db->select('arsip_surat.*, template_surat.nama_surat');
    $this->db->from('arsip_surat');
    $this->db->join(
        'template_surat',
        'arsip_surat.id_template = template_surat.id_template',
        'left'
    );

    if (!empty($from)) {
        $this->db->where('DATE(arsip_surat.created_at) >=', $from);
    }

    if (!empty($to)) {
        $this->db->where('DATE(arsip_surat.created_at) <=', $to);
    }

    $arsip = $this->db
        ->order_by('arsip_surat.created_at', 'DESC')
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
        header('Content-Disposition: attachment; filename="'.$filename.'"');

        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8

        fputcsv($out, [
            'No',
            'Nama Surat',
            'Nomor Surat',
            'Nama Penerima',
            'Nama File',
            'Tanggal Dibuat'
        ]);

        $no = 1;
        foreach ($arsip as $r) {
            fputcsv($out, [
                $no++,
                $r->nama_surat ?? '-',
                $r->nomor_surat ?? '-',
                $r->nama ?? '-',
                $r->filename ?? '-',
                $r->created_at ?? '-'
            ]);
        }

        fclose($out);
        exit;
    }

    // ==========================
    // EXPORT EXCEL TANPA COMPOSER
    // ==========================
    elseif ($type === 'xlsx') {

        $filename = 'rekapan_arsip_' . date('Ymd_His') . '.xls';

        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo '<html><head><meta charset="UTF-8"></head><body>';
        echo '<table border="1" cellspacing="0" cellpadding="5">';

        // Judul
        echo '<tr>';
        echo '<th colspan="6" style="font-size:14px;font-weight:bold;text-align:center;">REKAPAN ARSIP SURAT</th>';
        echo '</tr>';

        // Periode
        echo '<tr>';
        echo '<td colspan="6">';
        echo 'Periode: ' . (!empty($from) ? $from : '-') . ' s/d ' . (!empty($to) ? $to : '-');
        echo '</td>';
        echo '</tr>';

        // Header tabel
        echo '<tr style="font-weight:bold;background:#f0f0f0;text-align:center;">';
        echo '<th>No</th>';
        echo '<th>Nama Surat</th>';
        echo '<th>Nomor Surat</th>';
        echo '<th>Nama Penerima</th>';
        echo '<th>Nama File</th>';
        echo '<th>Tanggal Dibuat</th>';
        echo '</tr>';

        // Data
        $no = 1;
        foreach ($arsip as $a) {
            echo '<tr>';
            echo '<td align="center">'.$no++.'</td>';
            echo '<td>'.htmlspecialchars($a->nama_surat ?? '-').'</td>';
            echo '<td>'.htmlspecialchars($a->nomor_surat ?? '-').'</td>';
            echo '<td>'.htmlspecialchars($a->nama ?? '-').'</td>';
            echo '<td>'.htmlspecialchars($a->filename ?? '-').'</td>';
            echo '<td>'.htmlspecialchars($a->created_at ?? '-').'</td>';
            echo '</tr>';
        }

        if (count($arsip) === 0) {
            echo '<tr><td colspan="6" align="center">Tidak ada data</td></tr>';
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
        header('Content-Disposition: attachment; filename="'.$zipname.'"');
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
    $latest_arsip = $this->db->where('id_template', $id)->order_by('created_at', 'DESC')->limit(1)->get('arsip_surat')->row();
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
}
