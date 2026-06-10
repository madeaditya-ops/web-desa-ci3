<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Upload $insert_id
 * @property CI_Session $set_flashdata
 * @property CI_Upload $upload
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 * @property Warga_model $Warga_model
 */

class Warga extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Warga_model');
        $this->load->database('warga');
    }

    public function index()
    {
        $data['title'] = 'Data Warga';
        $data['warga'] = $this->Warga_model->get_all();

        $this->load->view('template_admin/header', $data);
        $this->load->view('template_admin/sidebar');
        $this->load->view('warga/index', $data);
        $this->load->view('template_admin/footer');
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Warga';
        $data['keluarga'] = $this->db->get('keluarga')->result();
        $data['hubungan'] = $this->db->get('hubungan')->result();
        $data['jenis_kelamin'] = $this->db->get('jenis_kelamin')->result();
        $data['agama'] = $this->db->get('agama')->result();
        $data['status_perkawinan'] = $this->db->get('status_perkawinan')->result();
        $data['kewarganegaraan'] = $this->db->get('kewarganegaraan')->result();
        $data['pendidikan'] = $this->db->get('pendidikan')->result();

        $this->load->view('template_admin/header', $data);
        $this->load->view('template_admin/sidebar');
        $this->load->view('warga/tambah', $data);
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
        redirect('warga');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Warga';
        $data['warga'] = $this->Warga_model->get_by_id($id);
        $data['keluarga'] = $this->db->get('keluarga')->result();
        $data['hubungan'] = $this->db->get('hubungan')->result();
        $data['jenis_kelamin'] = $this->db->get('jenis_kelamin')->result();
        $data['agama'] = $this->db->get('agama')->result();
        $data['status_perkawinan'] = $this->db->get('status_perkawinan')->result();
        $data['kewarganegaraan'] = $this->db->get('kewarganegaraan')->result();
        $data['pendidikan'] = $this->db->get('pendidikan')->result();
        $data['keterangan_list'] = $this->db->get('keterangan')->result();

        $this->load->view('template_admin/header', $data);
        $this->load->view('template_admin/sidebar');
        $this->load->view('warga/edit', $data);
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
            redirect('warga/edit/' . $id);
        }

        // Cek duplikat NIK kecuali untuk data sendiri
        $existing = $this->db->get_where('warga', ['no_nik' => $data['no_nik']])->row();
        if ($existing && $existing->id != $id) {
            $this->session->set_flashdata('error', 'NIK sudah terdaftar!');
            redirect('warga/edit/' . $id);
        }

        $this->Warga_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data warga berhasil diupdate!');
        redirect('warga');
    }

    public function delete($id)
    {
        $this->Warga_model->delete($id);
        redirect('warga');
    }





    public function download_template()
    {
        require FCPATH . 'vendor/autoload.php';

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('IMPORT_WARGA');

        // ===============================
        // HEADER 15 KOLOM (HANYA ID)
        // ===============================
        $headers = [
            'Desa',
            'Dusun',
            'No KK',
            'No NIK',
            'Nama',
            'Hubungan',
            'Status Perkawinan',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Agama',
            'Kewarganegaraan',
            'Keterangan',
            'Pendidikan',
            'Pekerjaan'
        ];

        foreach ($headers as $key => $value) {
            $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key + 1);
            $sheet->setCellValue($col . '1', $value);
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $sheet->getStyle($col . '1')->getFont()->setBold(true);
        }

        // ===============================
        // FORMAT TANGGAL KOLOM I
        // ===============================
        $sheet->getStyle('I2:I1000')
            ->getNumberFormat()
            ->setFormatCode('DD-MM-YYYY');

        // ===============================
        // LOCK HEADER
        // ===============================
        $sheet->freezePane('A2');

        // ===============================
        // OUTPUT FILE
        // ===============================
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="template_import_warga.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }


    private function clean_numeric_excel($value)
    {
        $value = trim((string)$value);
        $value = ltrim($value, "'"); // hapus petik satu di depan
        $value = preg_replace('/[^0-9]/', '', $value); // sisakan angka saja
        return $value;
        if (empty($value)) return '';
    
    // Jika terbaca scientific (E+), konversi ke string angka utuh
    if (stripos((string)$value, 'E+') !== false) {
        $value = number_format((float)$value, 0, '', '');
    }
        
    }

    private function validate_upload_file($file_tmp)
    {
        // Cek file exists
        if (!file_exists($file_tmp)) {
            return ['status' => false, 'message' => 'File tidak ditemukan'];
        }

        // Cek file size (max 10MB)
        if (filesize($file_tmp) > 10 * 1024 * 1024) {
            return ['status' => false, 'message' => 'Ukuran file terlalu besar (max 10MB)'];
        }

        // Cek MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file_tmp);
        finfo_close($finfo);

        $allowed_mime = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'];
        if (!in_array($mime, $allowed_mime)) {
            return ['status' => false, 'message' => 'File harus berformat Excel (.xlsx atau .xls)'];
        }

        return ['status' => true];
    }

    private function batch_update_kepala_keluarga($kepala_keluarga)
    {
        if (empty($kepala_keluarga)) return;

        // ℹ️ Gunakan CASE WHEN untuk batch update (1 query vs n query)
        $case_when = '';
        $nos = [];

        foreach ($kepala_keluarga as $no_kk => $nama) {
            $nos[] = "'" . $this->db->escape_str($no_kk) . "'";
            $case_when .= " WHEN no_kk = '" . $this->db->escape_str($no_kk) . "' THEN '" . $this->db->escape_str($nama) . "'";
        }

        if (empty($case_when)) return;

        $nos_str = implode(',', $nos);
        $query = "UPDATE keluarga SET nama_kepala_keluarga = CASE $case_when ELSE nama_kepala_keluarga END WHERE no_kk IN ($nos_str)";

        $this->db->query($query);
    }

  private function validate_date($date) {
    if (empty($date)) return null;

    // Bersihkan spasi dan ganti / menjadi -
    $date = str_replace('/', '-', trim($date));

    // Coba format d-m-Y (31-12-1990)
    $d = DateTime::createFromFormat('d-m-Y', $date);
    if ($d && $d->format('d-m-Y') === $date) return $d->format('Y-m-d');

    // Coba format d-m-y (31-12-90) -> Ini yang ada di file kamu!
    $d2 = DateTime::createFromFormat('d-m-y', $date);
    if ($d2 && $d2->format('d-m-y') === $date) return $d2->format('Y-m-d');

    return false;
}

    private function get_default_kecamatan()
    {
        // Baca dari config atau database
        $config_kecamatan = $this->config->item('desa_kecamatan') ?? 'Blahbatuh';
        $config_kabupaten = $this->config->item('desa_kabupaten') ?? 'Gianyar';
        return 'Kec. ' . $config_kecamatan . ' Kab. ' . $config_kabupaten;
    }

    private function preload_reference_data()
    {
        // Cache semua data referensi untuk avoid repeated queries
        return [
            'hubungan' => $this->db->get('hubungan')->result_array(),
            'jenis_kelamin' => $this->db->get('jenis_kelamin')->result_array(),
            'agama' => $this->db->get('agama')->result_array(),
            'status_perkawinan' => $this->db->get('status_perkawinan')->result_array(),
            'kewarganegaraan' => $this->db->get('kewarganegaraan')->result_array(),
            'pendidikan' => $this->db->get('pendidikan')->result_array(),
        ];
    }

    public function import_excel()
    {
        ini_set('memory_limit', '512M');
        require FCPATH . 'vendor/autoload.php';

        // ===============================
        // VALIDASI FILE
        // ===============================
        if (!isset($_FILES['file_excel'])) {
            $this->session->set_flashdata('error', 'File tidak ditemukan');
            redirect('warga/form_import');
            return;
        }

        $file = $_FILES['file_excel']['tmp_name'];
        $validation = $this->validate_upload_file($file);
        if (!$validation['status']) {
            $this->session->set_flashdata('error', $validation['message']);
            redirect('warga/form_import');
            return;
        }

        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
            $rows = $spreadsheet->getActiveSheet()->toArray();
        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Gagal membaca file: ' . $e->getMessage());
            redirect('warga/form_import');
            return;
        }

        // ===============================
        // PRELOAD CACHE DATA (AVOID REPEATED QUERIES)
        // ===============================
        $dusun_list = $this->db->get('dusun')->result();
        $dusun_map = [];
        foreach ($dusun_list as $d) {
            $dusun_map[$d->id_dusun] = $d;
        }

        $existing_nik = $this->db->select('no_nik')->get('warga')->result_array();
        $nik_map = array_flip(array_column($existing_nik, 'no_nik'));

        $keluarga_list = $this->db->get('keluarga')->result();
        $keluarga_map = [];
        foreach ($keluarga_list as $k) {
            $keluarga_map[$k->no_kk] = $k;
        }

        // Preload reference data
        $ref_data = $this->preload_reference_data();
        $ref_data_map = [];
        foreach ($ref_data as $table => $rows) {
            $ref_data_map[$table] = [];
            foreach ($rows as $row) {
                $ref_data_map[$table][$row['nama']] = $row['id'];
            }
        }

        $insert = [];
        $berhasil = 0;
        $gagal = 0;
        $kepala_keluarga = [];
        $chunk = 500;
        $kec_kabupaten = $this->get_default_kecamatan();
        $batch_insert_count = 0;

        foreach ($rows as $key => $row) {
            if ($key == 0) continue;

            $no_kk = $this->clean_numeric_excel($row[2] ?? '');
            $nik   = $this->clean_numeric_excel($row[3] ?? '');

            // Validasi basic
            if (empty($no_kk) || empty($nik) || strlen($no_kk) != 16 || strlen($nik) != 16) {
                $gagal++;
                continue;
            }

            $nama  = trim((string)($row[4] ?? ''));
            $hubungan = trim((string)($row[5] ?? ''));
            $status_perkawinan = trim((string)($row[6] ?? ''));
            $tempat_lahir = trim((string)($row[7] ?? ''));
            $tanggal_lahir = trim((string)($row[8] ?? ''));
            $jk = trim((string)($row[9] ?? ''));
            $agama = trim((string)($row[10] ?? ''));
            $kewarganegaraan = trim((string)($row[11] ?? ''));
            $keterangan = trim((string)($row[12] ?? ''));
            $pendidikan = trim((string)($row[13] ?? ''));
            $pekerjaan = trim((string)($row[14] ?? ''));

            if (!$nama || !$pekerjaan) {
                $gagal++;
                continue;
            }

            // Cek duplikat NIK
            if (isset($nik_map[$nik])) {
                $gagal++;
                continue;
            }
            $nik_map[$nik] = true;

            // Cari atau ambil ID dari cache (TIDAK query per-row)
            $id_dusun = 1; // default
            if (!empty($row[1])) {
                foreach ($dusun_map as $d) {
                    if (stripos($d->nama_dusun, trim((string)$row[1])) !== false) {
                        $id_dusun = $d->id_dusun;
                        break;
                    }
                }
            }

            // CEK KELUARGA (CACHE)
            if (!isset($keluarga_map[$no_kk])) {
                $dusun = isset($dusun_map[$id_dusun]) ? $dusun_map[$id_dusun] : null;
                $nama_dusun_final = $dusun ? $dusun->nama_dusun : '-';
                $alamat = 'Br. ' . $nama_dusun_final . ' /' . $kec_kabupaten;

                $nama_kk = (strtolower($hubungan) == 'kepala keluarga') ? $nama : '-';

                $this->db->insert('keluarga', [
                    'no_kk' => $no_kk,
                    'nama_kepala_keluarga' => $nama_kk,
                    'id_dusun' => $id_dusun,
                    'alamat' => $alamat
                ]);
                $keluarga_id = $this->db->insert_id();

                $keluarga_map[$no_kk] = (object)['id' => $keluarga_id];
            } else {
                $keluarga_id = $keluarga_map[$no_kk]->id;
            }

            // SIMPAN KEPALA KELUARGA UNTUK BATCH UPDATE
            if (strtolower($hubungan) == 'kepala keluarga') {
                $kepala_keluarga[$no_kk] = $nama;
            }

            // GET ID FROM CACHE (TIDAK query per-row)
            $hubungan_id = $ref_data_map['hubungan'][$hubungan] ?? null;
            if (!$hubungan_id) {
                $this->db->insert('hubungan', ['nama' => $hubungan]);
                $hubungan_id = $this->db->insert_id();
                $ref_data_map['hubungan'][$hubungan] = $hubungan_id;
            }

            $jenis_kelamin_id = $ref_data_map['jenis_kelamin'][$jk] ?? null;
            if (!$jenis_kelamin_id) {
                $this->db->insert('jenis_kelamin', ['nama' => $jk]);
                $jenis_kelamin_id = $this->db->insert_id();
                $ref_data_map['jenis_kelamin'][$jk] = $jenis_kelamin_id;
            }

            $agama_id = $ref_data_map['agama'][$agama] ?? null;
            if (!$agama_id) {
                $this->db->insert('agama', ['nama' => $agama]);
                $agama_id = $this->db->insert_id();
                $ref_data_map['agama'][$agama] = $agama_id;
            }

            $status_id = $ref_data_map['status_perkawinan'][$status_perkawinan] ?? null;
            if (!$status_id) {
                $this->db->insert('status_perkawinan', ['nama' => $status_perkawinan]);
                $status_id = $this->db->insert_id();
                $ref_data_map['status_perkawinan'][$status_perkawinan] = $status_id;
            }

            $kewarganegaraan_id = $ref_data_map['kewarganegaraan'][$kewarganegaraan] ?? null;
            if (!$kewarganegaraan_id) {
                $this->db->insert('kewarganegaraan', ['nama' => $kewarganegaraan]);
                $kewarganegaraan_id = $this->db->insert_id();
                $ref_data_map['kewarganegaraan'][$kewarganegaraan] = $kewarganegaraan_id;
            }

            $pendidikan_id = $ref_data_map['pendidikan'][$pendidikan] ?? null;
            if (!$pendidikan_id) {
                $this->db->insert('pendidikan', ['nama' => $pendidikan]);
                $pendidikan_id = $this->db->insert_id();
                $ref_data_map['pendidikan'][$pendidikan] = $pendidikan_id;
            }

            // VALIDASI DATE
            $tgl = $this->validate_date($tanggal_lahir);
            if ($tanggal_lahir && !$tgl) {
                $gagal++;
                continue;
            }

            $insert[] = [
                'keluarga_id' => $keluarga_id,
                'no_nik' => $nik,
                'nama' => $nama,
                'hubungan_id' => $hubungan_id,
                'jenis_kelamin_id' => $jenis_kelamin_id,
                'agama_id' => $agama_id,
                'status_perkawinan_id' => $status_id,
                'kewarganegaraan_id' => $kewarganegaraan_id,
                'pendidikan_id' => $pendidikan_id,
                'tempat_lahir' => $tempat_lahir,
                'tanggal_lahir' => $tgl,
                'pekerjaan' => $pekerjaan,
                'keterangan' => $keterangan
            ];

            $berhasil++;

            // BATCH INSERT PER CHUNK (WITH TRANSACTION)
            if (count($insert) >= $chunk) {
                $this->db->trans_start();
                $this->db->insert_batch('warga', $insert);
                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    error_log('Error inserting batch ' . $batch_insert_count . ' at row ' . $key);
                }

                $insert = [];
                $batch_insert_count++;
            }
        }

        // FINAL TRANSACTION (SISA INSERT + BATCH UPDATE)
        $this->db->trans_start();

        if (!empty($insert)) {
            $this->db->insert_batch('warga', $insert);
        }

        // BATCH UPDATE KEPALA KELUARGA
        if (!empty($kepala_keluarga)) {
            $this->batch_update_kepala_keluarga($kepala_keluarga);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            error_log('Error in final transaction for import_excel');
            $this->session->set_flashdata('error', 'Gagal menyimpan data akhir. Transaksi dibatalkan.');
        } else {
            $this->session->set_flashdata(
                'success',
                "Import selesai. Berhasil: $berhasil | Gagal: $gagal"
            );
        }

        redirect('warga');
    }


    public function preview_import_ajax()
    {
        require FCPATH . 'vendor/autoload.php';

        // ===============================
        // VALIDASI FILE
        // ===============================
        if (!isset($_FILES['file_excel'])) {
            echo "<div class='alert alert-danger'>File tidak ditemukan</div>";
            return;
        }

        $file = $_FILES['file_excel']['tmp_name'];
        $validation = $this->validate_upload_file($file);
        if (!$validation['status']) {
            echo "<div class='alert alert-danger'>" . $validation['message'] . "</div>";
            return;
        }

        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
            $rows = $spreadsheet->getActiveSheet()->toArray();
        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>Gagal membaca file: " . $e->getMessage() . "</div>";
            return;
        }

        echo "<table class='table table-bordered table-sm'>";
        echo "<tr>
            <th>Desa</th>
            <th>Dusun</th>
            <th>No KK</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Hubungan</th>
            <th>Status</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Agama</th>
            <th>Kewarganegaraan</th>
            <th>Keterangan</th>
            <th>Pendidikan</th>
            <th>Pekerjaan</th>
          </tr>";

        $no = 1;
        foreach ($rows as $key => $row) {
            if ($key == 0) continue;
            if ($no > 50) break; // batasi 50 baris preview

            echo "<tr>
                <td>" . ($row[0] ?? '') . "</td>
                <td>" . ($row[1] ?? '') . "</td>
                <td>" . $this->clean_numeric_excel($row[2] ?? '') . "</td>
                <td>" . $this->clean_numeric_excel($row[3] ?? '') . "</td>
                <td>" . ($row[4] ?? '') . "</td>
                <td>" . ($row[5] ?? '') . "</td>
                <td>" . ($row[6] ?? '') . "</td>
                <td>" . ($row[7] ?? '') . "</td>
                <td>" . ($row[8] ?? '') . "</td>
                <td>" . ($row[9] ?? '') . "</td>
                <td>" . ($row[10] ?? '') . "</td>
                <td>" . ($row[11] ?? '') . "</td>
                <td>" . ($row[12] ?? '') . "</td>
                <td>" . ($row[13] ?? '') . "</td>
                <td>" . ($row[14] ?? '') . "</td>
              </tr>";
            $no++;
        }

        echo "</table>";
    }



    public function import_excel_ajax()
    {
        ini_set('memory_limit', '512M');
        require FCPATH . 'vendor/autoload.php';

        // ===============================
        // VALIDASI FILE UPLOAD
        // ===============================
        if (!isset($_FILES['file_excel'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'File tidak ditemukan.'
            ]);
            return;
        }

        $file = $_FILES['file_excel']['tmp_name'];
        $validation = $this->validate_upload_file($file);
        if (!$validation['status']) {
            echo json_encode([
                'status' => 'error',
                'message' => $validation['message']
            ]);
            return;
        }

        // ===============================
        // LOAD SPREADSHEET
        // ===============================
        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
            $rows = $spreadsheet->getActiveSheet()->toArray();
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal membaca file Excel: ' . $e->getMessage()
            ]);
            return;
        }

        // 🔥 CACHE DATA UNTUK QUERY EFFICIENCY
        $dusun_list = $this->db->get('dusun')->result();
        $dusun_map = [];
        foreach ($dusun_list as $d) {
            $dusun_map[$d->id_dusun] = $d;
        }

        $existing_nik = $this->db->select('no_nik')->get('warga')->result_array();
        $nik_map = array_flip(array_column($existing_nik, 'no_nik'));

        $keluarga_list = $this->db->get('keluarga')->result();
        $keluarga_map = [];
        foreach ($keluarga_list as $k) {
            $keluarga_map[$k->no_kk] = $k;
        }

        $insert = [];
        $errors = [];
        $berhasil = 0;
        $kepala_keluarga = []; // ✅ Hanya 1 array (associative)
        $processed = 0;

        foreach ($rows as $key => $row) {

            if ($key < 1) continue; // skip hanya header (baris 0)

            $baris = $key + 1;

            // ===============================
            // CEK JUMLAH KOLOM
            // ===============================
            if (count($row) < 15) {
                $errors[] = "Baris $baris: Kolom tidak lengkap (harus 15 kolom, dapat " . count($row) . " kolom)";
                continue;
            }

            // ===============================
            // AMBIL 15 KOLOM SESUAI TEMPLATE
            // ===============================
            $desa = trim((string)($row[0] ?? ''));
            $id_dusun = (int)filter_var(trim((string)($row[1] ?? '')), FILTER_SANITIZE_NUMBER_INT);
            $no_kk = $this->clean_numeric_excel($row[2] ?? '');
            $nik   = $this->clean_numeric_excel($row[3] ?? '');
            $nama = trim((string)($row[4] ?? ''));
            $hubungan_id = (int)filter_var(trim((string)($row[5] ?? '')), FILTER_SANITIZE_NUMBER_INT);
            $status_perkawinan_id = (int)filter_var(trim((string)($row[6] ?? '')), FILTER_SANITIZE_NUMBER_INT);
            $tempat_lahir = trim((string)($row[7] ?? ''));
            $tanggal_lahir = trim((string)($row[8] ?? ''));
            $jenis_kelamin_id = (int)filter_var(trim((string)($row[9] ?? '')), FILTER_SANITIZE_NUMBER_INT);
            $agama_id = (int)filter_var(trim((string)($row[10] ?? '')), FILTER_SANITIZE_NUMBER_INT);
            $kewarganegaraan_id = (int)filter_var(trim((string)($row[11] ?? '')), FILTER_SANITIZE_NUMBER_INT);
            $keterangan = trim((string)($row[12] ?? ''));
            $pendidikan_id = (int)filter_var(trim((string)($row[13] ?? '')), FILTER_SANITIZE_NUMBER_INT);
            $pekerjaan = trim((string)($row[14] ?? ''));

            // DEBUG: Log raw row data untuk diagnostik
            // Uncomment baris di bawah jika perlu debugging
            // error_log("DEBUG Baris $baris: " . json_encode($row));
            // error_log("DEBUG parsed: NK=$no_kk, NIK=$nik, Nama=$nama, JK=$jenis_kelamin_id, Agama=$agama_id");

            // ===============================
            // SKIP ROW KOSONG (HEURISTIC)
            // ===============================
            // Jika No KK, NIK, dan Nama semuanya kosong = skip baris ini
            if (empty($no_kk) && empty($nik) && empty($nama)) {
                continue;
            }

            // ===============================
            // VALIDASI WAJIB
            // ===============================
            $errors_detail = [];

            if ($no_kk == '') $errors_detail[] = "No KK kosong";
            if ($nik == '') $errors_detail[] = "NIK kosong";
            if ($nama == '') $errors_detail[] = "Nama kosong";
            if ($jenis_kelamin_id <= 0) $errors_detail[] = "Jenis Kelamin tidak valid (harus > 0)";
            if ($agama_id <= 0) $errors_detail[] = "Agama tidak valid (harus > 0)";
            if ($pekerjaan == '') $errors_detail[] = "Pekerjaan kosong";
            if (strlen($no_kk) != 16) $errors_detail[] = "No KK harus 16 digit";
            if (strlen($nik) != 16) $errors_detail[] = "NIK harus 16 digit";

            if (!empty($errors_detail)) {
                $errors[] = "Baris $baris: " . implode(", ", $errors_detail);
                continue;
            }

            // ===============================
            // VALIDASI ID REFERENSI
            // ===============================
            $id_errors = [];

            if ($hubungan_id <= 0) $id_errors[] = "Hubungan tidak valid";
            if ($status_perkawinan_id <= 0) $id_errors[] = "Status Perkawinan tidak valid";
            if ($kewarganegaraan_id <= 0) $id_errors[] = "Kewarganegaraan tidak valid";
            if ($pendidikan_id <= 0) $id_errors[] = "Pendidikan tidak valid";
            if ($id_dusun <= 0) $id_errors[] = "Dusun tidak valid";

            if (!empty($id_errors)) {
                $errors[] = "Baris $baris: " . implode(", ", $id_errors);
                continue;
            }

            // ===============================
            // CEK DUPLIKAT NIK (PAKAI CACHE)
            // ===============================
            if (isset($nik_map[$nik])) {
                $errors[] = "Baris $baris: NIK ($nik) sudah terdaftar";
                continue;
            }

            // ===============================
            // VALIDASI DUSUN & SEMUA ID REFERENCE (PAKAI CACHE)
            // ===============================
            if (!isset($dusun_map[$id_dusun])) {
                $errors[] = "Baris $baris: ID Dusun ($id_dusun) tidak ditemukan - DATA TIDAK DIPROSES";
                continue;
            }
            $dusun = $dusun_map[$id_dusun];

            // ℹ️ CATATAN PENTING: Jika semua validasi di atas PASS, baru kita proses ke database
            // Jika ada kegagalan, data TIDAK akan masuk ke database

            // ===============================
            // CEK / BUAT KELUARGA (PAKAI CACHE)
            // ===============================
            if (!isset($keluarga_map[$no_kk])) {
                $nama_dusun_final = $dusun->nama_dusun;
                $kec_kab = $this->get_default_kecamatan();
                $alamat_otomatis = 'Br. ' . $nama_dusun_final . ' /' . $kec_kab;

                // Jika data saat ini adalah kepala keluarga, gunakan nama-nya
                $nama_kk = ($hubungan_id == 1) ? $nama : '-';

                $this->db->insert('keluarga', [
                    'no_kk' => $no_kk,
                    'nama_kepala_keluarga' => $nama_kk,
                    'id_dusun' => $id_dusun,
                    'alamat' => $alamat_otomatis
                ]);
                $keluarga_id = $this->db->insert_id();

                // 🔥 simpan ke cache
                $keluarga_map[$no_kk] = (object)[
                    'id' => $keluarga_id
                ];
            } else {
                $keluarga_id = $keluarga_map[$no_kk]->id;
            }

            // ===============================
            // SIMPAN KEPALA KELUARGA UNTUK BATCH UPDATE
            // ===============================
            if ($hubungan_id == 1) {
                $kepala_keluarga[$no_kk] = $nama;
            }

            // Update NIK map SEBELUM insert (cegah duplikat dalam file)
            $nik_map[$nik] = true;

            // ===============================
            // VALIDASI & FORMAT TANGGAL
            // ===============================
            $tgl = $this->validate_date($tanggal_lahir);
            if ($tanggal_lahir && !$tgl) {
                $errors[] = "Baris $baris: Tanggal lahir tidak valid (format: DD-MM-YYYY)";
                continue;
            }

            $insert[] = [
                'keluarga_id' => $keluarga_id,
                'no_nik' => $nik,
                'nama' => $nama,
                'hubungan_id' => $hubungan_id,
                'jenis_kelamin_id' => $jenis_kelamin_id,
                'agama_id' => $agama_id,
                'status_perkawinan_id' => $status_perkawinan_id,
                'kewarganegaraan_id' => $kewarganegaraan_id,
                'pendidikan_id' => $pendidikan_id,
                'tempat_lahir' => $tempat_lahir,
                'tanggal_lahir' => $tgl,
                'pekerjaan' => $pekerjaan,
                'keterangan' => $keterangan
            ];

            $berhasil++;
            $processed++;
        }

        $this->db->trans_start();

        // INSERT BATCH WARGA
        if (!empty($insert)) {
            $this->db->insert_batch('warga', $insert);
        }

        // BATCH UPDATE KEPALA KELUARGA (CASE WHEN)
        if (!empty($kepala_keluarga)) {
            $this->batch_update_kepala_keluarga($kepala_keluarga);
        }

        $this->db->trans_complete();

        // ===============================
        // CEK TRANSACTION STATUS
        // ===============================
        if ($this->db->trans_status() === FALSE) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal menyimpan data ke database. Transaksi dibatalkan.'
            ]);
        } else {
            if (!empty($errors)) {
                echo json_encode([
                    'status' => 'warning',
                    'message' => "Import selesai dengan peringatan:<br>" . implode("<br>", array_slice($errors, 0, 20)) . (count($errors) > 20 ? "<br>... dan " . (count($errors) - 20) . " error lainnya" : "") . "<br><br>Berhasil: $berhasil data."
                ]);
            } else {
                echo json_encode([
                    'status' => 'success',
                    'message' => "Import berhasil: $berhasil data."
                ]);
            }
        }
    }

    public function start_import()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');
        ob_implicit_flush(true);

        require FCPATH . 'vendor/autoload.php';

        $fileName = $this->input->post('file');
        $filePath = FCPATH . 'uploads/import/' . $fileName;

        // ===============================
        // VALIDASI FILE
        // ===============================
        $validation = $this->validate_upload_file($filePath);
        if (!$validation['status']) {
            $this->session->set_flashdata('error', $validation['message']);
            redirect('warga/form_import');
            return;
        }

        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $highestRow = $sheet->getHighestRow();
        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Gagal membaca file: ' . $e->getMessage());
            redirect('warga/form_import');
            return;
        }

        // ===============================
        // INIT SESSION
        // ===============================
        $this->session->set_userdata('total_rows', $highestRow);
        $this->session->set_userdata('processed', 0);
        $this->session->set_userdata('errors', []);

        // ===============================
        // CACHE DATA (ANTI QUERY BERULANG)
        // ===============================

        // 🔥 Cache dusun
        $dusun_list = $this->db->get('dusun')->result();
        $dusun_map = [];
        foreach ($dusun_list as $d) {
            $dusun_map[$d->id_dusun] = $d;
        }

        // 🔥 Cache NIK existing
        $existing_nik = $this->db->select('no_nik')->get('warga')->result_array();
        $nik_map = array_flip(array_column($existing_nik, 'no_nik'));

        // 🔥 Cache keluarga
        $keluarga_list = $this->db->get('keluarga')->result();
        $keluarga_map = [];
        foreach ($keluarga_list as $k) {
            $keluarga_map[$k->no_kk] = $k;
        }

        // ===============================
        // CONFIG DYNAMIC ALAMAT
        // ===============================
        $kec_kabupaten = $this->get_default_kecamatan();

        // ===============================
        // CONFIG
        // ===============================
        $chunk = 1000;
        $insert = [];
        $processed = 0;
        $kepala_keluarga = []; 
        $batch_insert_count = 0;

        // ===============================
        // LOOP BARIS (STREAMING)
        // ===============================
        for ($row = 2; $row <= $highestRow; $row++) {

            $id_dusun = (int)$sheet->getCell('B' . $row)->getValue();
           // 2. Ambil data lainnya
    $no_kk = $this->clean_numeric_excel($sheet->getCell('C' . $row)->getValue());
    $nik   = $this->clean_numeric_excel($sheet->getCell('D' . $row)->getValue());
    $nama  = trim((string)$sheet->getCell('E' . $row)->getValue());
            $hubungan_id = (int)$sheet->getCell('F' . $row)->getValue();
            $status_perkawinan_id = (int)$sheet->getCell('G' . $row)->getValue();
            $tempat_lahir = trim((string)$sheet->getCell('H' . $row)->getValue());
           // 1. Gunakan getFormattedValue untuk tanggal agar formatnya sesuai tampilan Excel
    $tanggal_lahir = trim((string)$sheet->getCell('I' . $row)->getFormattedValue());
            $jenis_kelamin_id = (int)$sheet->getCell('J' . $row)->getValue();
            $agama_id = (int)$sheet->getCell('K' . $row)->getValue();
            $kewarganegaraan_id = (int)$sheet->getCell('L' . $row)->getValue();
            $keterangan = trim((string)$sheet->getCell('M' . $row)->getValue());
            $pendidikan_id = (int)$sheet->getCell('N' . $row)->getValue();
            $pekerjaan = trim((string)$sheet->getCell('O' . $row)->getValue());

           // Skip jika benar-benar kosong satu baris
    if (empty($no_kk) && empty($nik) && empty($nama)) continue;

            // ===============================
            // VALIDASI CEPAT
            // ===============================
            if (strlen($nik) != 18 || strlen($no_kk) != 18) continue;
            if ($jenis_kelamin_id <= 0 || $agama_id <= 0) continue;
           // Validasi NIK Duplikat
    if (isset($nik_map[$nik])) {
        $errors[] = "Baris $row: NIK $nik sudah ada di database atau duplikat di file";
        continue;
    }

    // Validasi Tanggal
    $tgl = $this->validate_date($tanggal_lahir);
    if ($tanggal_lahir && !$tgl) {
        $errors[] = "Baris $row: Tanggal lahir tidak valid (format: DD-MM-YYYY)";
        continue;
    }

    // Simpan error ke session untuk ditampilkan di view
if (!empty($errors)) {
    $this->session->set_userdata('errors', $errors);
}
            // ===============================
            // VALIDASI DUSUN (PAKAI CACHE)
            // ===============================
            if (!isset($dusun_map[$id_dusun])) continue;
            $dusun = $dusun_map[$id_dusun];

            // ===============================
            // CEK / BUAT KELUARGA (CACHE)
            // ===============================
            if (!isset($keluarga_map[$no_kk])) {

                $nama_kk = ($hubungan_id == 1) ? $nama : '-';

                $this->db->insert('keluarga', [
                    'no_kk' => $no_kk,
                    'nama_kepala_keluarga' => $nama_kk,
                    'id_dusun' => $id_dusun,
                    'alamat' => 'Br. ' . $dusun->nama_dusun . ' /' . $kec_kabupaten
                ]);

                $keluarga_id = $this->db->insert_id();

                // 🔥 simpan ke cache
                $keluarga_map[$no_kk] = (object)[
                    'id' => $keluarga_id
                ];
            } else {
                $keluarga_id = $keluarga_map[$no_kk]->id;
            }

            // ===============================
            // SIMPAN KEPALA KELUARGA UNTUK BATCH UPDATE (ASSOCIATIVE ONLY)
            // ===============================
            if ($hubungan_id == 1) {
                $kepala_keluarga[$no_kk] = $nama;
            }

            // Update NIK map SEBELUM insert (cegah duplikat dalam file)
            $nik_map[$nik] = true;

            // ===============================
            // VALIDASI & FORMAT TANGGAL
            // ===============================
            $tgl = $this->validate_date($tanggal_lahir);
            if ($tanggal_lahir && !$tgl) {
                // Skip row dengan tanggal invalid
                continue;
            }

            // ===============================
            // INSERT DATA
            // ===============================
            $insert[] = [
                'keluarga_id' => $keluarga_id,
                'no_nik' => $nik,
                'nama' => $nama,
                'hubungan_id' => $hubungan_id,
                'jenis_kelamin_id' => $jenis_kelamin_id,
                'agama_id' => $agama_id,
                'status_perkawinan_id' => $status_perkawinan_id,
                'kewarganegaraan_id' => $kewarganegaraan_id,
                'pendidikan_id' => $pendidikan_id,
                'tempat_lahir' => $tempat_lahir,
                'tanggal_lahir' => $tgl,
                'pekerjaan' => $pekerjaan,
                'keterangan' => $keterangan
            ];

            $processed++;

            // ===============================
            // BATCH INSERT
            // ===============================
            if (count($insert) >= $chunk) {
                // Transaction per chunk (lebih aman)
                $this->db->trans_start();
                $this->db->insert_batch('warga', $insert);
                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    error_log('Error inserting batch ' . $batch_insert_count . ' at row ' . $row);
                }

                $insert = [];
                $batch_insert_count++;

                // update progress per chunk
                $this->session->set_userdata('processed', $processed);
            }
        }

        // ===============================
        // DATABASE TRANSACTION (FINAL BATCH)
        // ===============================
        $this->db->trans_start();

        // SISA INSERT
        if (!empty($insert)) {
            $this->db->insert_batch('warga', $insert);
        }

        // BATCH UPDATE KEPALA KELUARGA (CASE WHEN)
        if (!empty($kepala_keluarga)) {
            $this->batch_update_kepala_keluarga($kepala_keluarga);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            error_log('Error in final transaction for start_import');
        }

        $this->session->set_userdata('processed', $processed);

        // ===============================
        // CLEANUP FILE (WITH ERROR HANDLING)
        // ===============================
        try {
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        } catch (Exception $e) {
            error_log('Error deleting import file: ' . $e->getMessage());
        }
    }

    
    private function get_or_create_id($table, $nama)
    {
        if (!$nama) return null;

        $row = $this->db->get_where($table, ['nama' => $nama])->row();

        if ($row) {
            return $row->id;
        }

        $this->db->insert($table, ['nama' => $nama]);
        return $this->db->insert_id();
    }

    public function check_progress()
    {
        $total = $this->session->userdata('total_rows') ?? 1;
        $done  = $this->session->userdata('processed') ?? 0;

        $percent = round(($done / $total) * 100);
        $percent = min($percent, 100); // Cap at 100%

        echo json_encode([
            'percent' => $percent,
            'processed' => $done,
            'total' => $total
        ]);
    }

    public function export_error()
    {
        require FCPATH . 'vendor/autoload.php';

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $errors = $this->session->userdata('errors') ?? [];

        foreach ($errors as $i => $row) {
            $sheet->fromArray($row, null, 'A' . ($i + 1));
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="data_gagal_import.xlsx"');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
    }


    public function form_import()
    {
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('warga/import');
        $this->load->view('template_admin/footer');
    }

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
            status_perkawinan.nama as status_kawin
        ')
            ->from('warga')
            ->join('keluarga', 'keluarga.id = warga.keluarga_id', 'left')
            ->join('dusun', 'dusun.id_dusun = keluarga.id_dusun', 'left')
            ->join('jenis_kelamin', 'jenis_kelamin.id = warga.jenis_kelamin_id', 'left')
            ->join('agama', 'agama.id = warga.agama_id', 'left')
            ->join('status_perkawinan', 'status_perkawinan.id = warga.status_perkawinan_id', 'left')
            ->where('warga.id', $id)
            ->get()
            ->row();

        // riwayat surat warga
        $data['riwayat_surat'] = $this->db
            ->select('
            data_surat.*,
            template_surat.nama_surat,
            arsip_surat.data_surat_id
            ')
            ->from('data_surat')
            ->join('template_surat', 'template_surat.id_template = data_surat.id_template', 'left')
            ->join('arsip_surat', 'arsip_surat.data_surat_id = data_surat.id', 'left')
            ->where('data_surat.nik', $data['warga']->no_nik)
            ->order_by('data_surat.created_at', 'DESC')
            ->get()
            ->result();

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('warga/detail', $data);
        $this->load->view('template_admin/footer');
    }

    public function download_surat($id_data_surat)
    {

        $surat = $this->db
            ->select('arsip_surat.filename')
            ->from('data_surat')
            ->join('arsip_surat', 'arsip_surat.data_surat_id = data_surat.id', 'left')
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
            redirect('warga');
        }
    }
}
