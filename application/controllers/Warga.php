<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Upload $insert_id
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
            'keterangan' => $this->input->post('keterangan')
        ];

        // Validasi wajib
        if (empty($data['no_nik']) || empty($data['nama']) || empty($data['hubungan_id']) || empty($data['jenis_kelamin_id']) || empty($data['agama_id'])) {
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


    public function import_excel()
    {
        require FCPATH . 'vendor/autoload.php';

        $file = $_FILES['file_excel']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $rows = $spreadsheet->getActiveSheet()->toArray();

        $insert = [];
        $berhasil = 0;
        $gagal = 0;

        foreach ($rows as $key => $row) {
            if ($key == 0) continue;

            $no_kk = trim((string)($row[2] ?? ''));
            $nik   = trim((string)($row[3] ?? ''));
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

            if (!$nik) continue;

            // cari dusun berdasarkan nama
            $dusun = $this->db->like('nama_dusun', trim((string)($row[1] ?? '')))->get('dusun')->row();
            $id_dusun = $dusun ? $dusun->id_dusun : 1;

            // cari keluarga
            $keluarga = $this->db->get_where('keluarga', ['no_kk' => $no_kk])->row();

            if (!$keluarga) {
                $nama_dusun_final = $dusun ? $dusun->nama_dusun : '-';
                $alamat_otomatis = 'Br. ' . $nama_dusun_final . ' /Kec. Blahbatuh Kab. Gianyar';

                $this->db->insert('keluarga', [
                    'no_kk' => $no_kk,
                    'nama_kepala_keluarga' => '-',
                    'id_dusun' => $id_dusun,
                    'alamat' => $alamat_otomatis
                ]);
                $keluarga_id = $this->db->insert_id();
            } else {
                $keluarga_id = $keluarga->id;
            }

            // ===============================
            // SET NAMA KEPALA KELUARGA OTOMATIS
            // ===============================
            if (strtolower(trim($hubungan)) == 'kepala keluarga') {
                $this->db->where('no_kk', $no_kk)
                    ->update('keluarga', [
                        'nama_kepala_keluarga' => $nama
                    ]);
            }

            // cek nik duplikat
            if ($this->db->get_where('warga', ['no_nik' => $nik])->row()) {
                $gagal++;
                continue;
            }

            // ambil ID dari master table
            $hubungan_id = $this->get_or_create_id('hubungan', $hubungan);
            $jenis_kelamin_id = $this->get_or_create_id('jenis_kelamin', $jk);
            $agama_id = $this->get_or_create_id('agama', $agama);
            $status_id = $this->get_or_create_id('status_perkawinan', $status_perkawinan);
            $kewarganegaraan_id = $this->get_or_create_id('kewarganegaraan', $kewarganegaraan);
            $pendidikan_id = $this->get_or_create_id('pendidikan', $pendidikan);

            $jk = ucfirst(strtolower($jk));
            if (!in_array($jk, ['Laki-laki', 'Perempuan'])) {
                $gagal++;
                continue;
            }

            // format tanggal
            $tgl = null;
            if (!empty($tanggal_lahir)) {
                $tgl = date('Y-m-d', strtotime($tanggal_lahir));
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
        }

        if (!empty($insert)) {
            $this->db->insert_batch('warga', $insert);
        }

        $this->session->set_flashdata(
            'message',
            "Import selesai. Berhasil: $berhasil | Gagal: $gagal"
        );

        redirect('warga');
    }


    public function preview_import_ajax()
    {
        require FCPATH . 'vendor/autoload.php';

        $file = $_FILES['file_excel']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $rows = $spreadsheet->getActiveSheet()->toArray();

        echo "<table class='table table-bordered table-sm'>";
        echo "<tr>
            <th>Desa</th>
            <th>ID Dusun</th>
            <th>No KK</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>ID Hubungan</th>
            <th>ID Status</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>ID JK</th>
            <th>ID Agama</th>
            <th>ID Kewargaan</th>
            <th>Keterangan</th>
            <th>ID Pendidikan</th>
            <th>Pekerjaan</th>
          </tr>";

        $no = 1;
        foreach ($rows as $key => $row) {
            if ($key == 0) continue;
            if ($no > 50) break; // batasi 50 baris preview

            echo "<tr>
                <td>" . ($row[0] ?? '') . "</td>
                <td>" . ($row[1] ?? '') . "</td>
                <td>" . ($row[2] ?? '') . "</td>
                <td>" . ($row[3] ?? '') . "</td>
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
        require FCPATH . 'vendor/autoload.php';

        if (!isset($_FILES['file_excel'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'File tidak ditemukan.'
            ]);
            return;
        }

        $file = $_FILES['file_excel']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $rows = $spreadsheet->getActiveSheet()->toArray();

        $insert = [];
        $errors = [];
        $berhasil = 0;
        $kepala_keluarga = []; // Kumpulkan data kepala keluarga untuk update

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
            $no_kk = trim((string)($row[2] ?? ''));
            $nik = preg_replace('/[^0-9]/', '', (string)($row[3] ?? ''));
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
            if ($jenis_kelamin_id <= 0) $errors_detail[] = "ID Jenis Kelamin tidak valid (harus > 0)";
            if ($agama_id <= 0) $errors_detail[] = "ID Agama tidak valid (harus > 0)";
            if ($pekerjaan == '') $errors_detail[] = "Pekerjaan kosong";

            if (!empty($errors_detail)) {
                $errors[] = "Baris $baris: " . implode(", ", $errors_detail);
                continue;
            }

            // ===============================
            // VALIDASI ID REFERENSI
            // ===============================
            $id_errors = [];

            if ($hubungan_id <= 0) $id_errors[] = "ID Hubungan tidak valid";
            if ($status_perkawinan_id <= 0) $id_errors[] = "ID Status Perkawinan tidak valid";
            if ($kewarganegaraan_id <= 0) $id_errors[] = "ID Kewarganegaraan tidak valid";
            if ($pendidikan_id <= 0) $id_errors[] = "ID Pendidikan tidak valid";
            if ($id_dusun <= 0) $id_errors[] = "ID Dusun tidak valid";

            if (!empty($id_errors)) {
                $errors[] = "Baris $baris: " . implode(", ", $id_errors);
                continue;
            }

            // ===============================
            // CEK DUPLIKAT NIK
            // ===============================
            if ($this->db->get_where('warga', ['no_nik' => $nik])->row()) {
                $errors[] = "Baris $baris: NIK ($nik) sudah terdaftar";
                continue;
            }

            // ===============================
            // VALIDASI DUSUN & SEMUA ID REFERENCE
            // ===============================
            $dusun = $this->db->get_where('dusun', ['id_dusun' => $id_dusun])->row();
            if (!$dusun) {
                $errors[] = "Baris $baris: ID Dusun ($id_dusun) tidak ditemukan - DATA TIDAK DIPROSES";
                continue;
            }

            // ℹ️ CATATAN PENTING: Jika semua validasi di atas PASS, baru kita proses ke database
            // Jika ada kegagalan, data TIDAK akan masuk ke database

            // ===============================
            // CEK / BUAT KELUARGA (AMAN: semua validasi sudah selesai)
            // ===============================
            $keluarga = $this->db
                ->get_where('keluarga', ['no_kk' => $no_kk])
                ->row();

            if (!$keluarga) {
                $nama_dusun_final = $dusun->nama_dusun;
                $alamat_otomatis = 'Br. ' . $nama_dusun_final . ' /Kec. Blahbatuh Kab. Gianyar';

                // Jika data saat ini adalah kepala keluarga, gunakan nama-nya
                $nama_kk = ($hubungan_id == 1) ? $nama : '-';

                $this->db->insert('keluarga', [
                    'no_kk' => $no_kk,
                    'nama_kepala_keluarga' => $nama_kk,
                    'id_dusun' => $id_dusun,
                    'alamat' => $alamat_otomatis
                ]);
                $keluarga_id = $this->db->insert_id();
            } else {
                $keluarga_id = $keluarga->id;

                // Jika data saat ini adalah kepala keluarga, update nama di keluarga
                if ($hubungan_id == 1) {
                    $this->db->where('no_kk', $no_kk)
                        ->update('keluarga', [
                            'nama_kepala_keluarga' => $nama
                        ]);
                }
            }

            // ===============================
            // SIMPAN JIKA KEPALA KELUARGA UNTUK VERIFIKASI
            // ===============================
            if ($hubungan_id == 1) {
                $kepala_keluarga[] = [
                    'no_kk' => $no_kk,
                    'nama' => $nama
                ];
            }

            // ===============================
            // FORMAT TANGGAL
            // ===============================
            $tgl = null;
            if (!empty($tanggal_lahir)) {
                $tgl = date('Y-m-d', strtotime($tanggal_lahir));
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
        }

        // ===============================
        // INSERT BATCH WARGA
        // ===============================
        if (!empty($insert)) {
            $this->db->insert_batch('warga', $insert);
        }

        // ===============================
        // UPDATE NAMA KEPALA KELUARGA DI TABEL KELUARGA
        // ===============================
        if (!empty($kepala_keluarga)) {
            foreach ($kepala_keluarga as $kk) {
                $this->db->where('no_kk', $kk['no_kk'])
                    ->update('keluarga', [
                        'nama_kepala_keluarga' => $kk['nama']
                    ]);
            }
        }

        if (!empty($errors)) {
            echo json_encode([
                'status' => 'error',
                'message' => implode("<br>", $errors)
            ]);
        } else {
            echo json_encode([
                'status' => 'success',
                'message' => "Import berhasil: $berhasil data."
            ]);
        }
    }

    public function start_import()
    {
        ignore_user_abort(true);
        set_time_limit(0);

        require FCPATH . 'vendor/autoload.php';

        $fileName = $this->input->post('file');
        $filePath = FCPATH . 'uploads/import/' . $fileName;

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
        $rows = $spreadsheet->getActiveSheet()->toArray();

        $this->session->set_userdata('total_rows', count($rows));
        $this->session->set_userdata('processed', 0);
        $this->session->set_userdata('errors', []);

        $chunk = 500;
        $kepala_keluarga_all = [];

        for ($i = 1; $i < count($rows); $i += $chunk) {

            $batch = array_slice($rows, $i, $chunk);
            $insert = [];
            $kepala_keluarga = [];

            foreach ($batch as $row) {

                // ===============================
                // AMBIL DATA SESUAI TEMPLATE 15 KOLOM (DENGAN ID)
                // ===============================
                $desa = trim((string)($row[0] ?? ''));
                $id_dusun = (int)filter_var(trim((string)($row[1] ?? '')), FILTER_SANITIZE_NUMBER_INT);
                $no_kk = trim((string)($row[2] ?? ''));
                $nik = preg_replace('/[^0-9]/', '', (string)($row[3] ?? ''));
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

                $baris = $i + count($batch) - array_search($row, $batch, true);

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
                if ($jenis_kelamin_id <= 0) $errors_detail[] = "ID Jenis Kelamin tidak valid";
                if ($agama_id <= 0) $errors_detail[] = "ID Agama tidak valid";
                if ($pekerjaan == '') $errors_detail[] = "Pekerjaan kosong";

                if (!empty($errors_detail)) {
                    $errors = $this->session->userdata('errors') ?? [];
                    $errors[] = "Baris $baris: " . implode(", ", $errors_detail);
                    $this->session->set_userdata('errors', $errors);
                    continue;
                }

                // ===============================
                // CEK DUPLIKAT NIK
                // ===============================
                if ($this->db->get_where('warga', ['no_nik' => $nik])->row()) {
                    $errors = $this->session->userdata('errors') ?? [];
                    $errors[] = "Baris $baris: NIK ($nik) sudah terdaftar";
                    $this->session->set_userdata('errors', $errors);
                    continue;
                }

                // ===============================
                // VALIDASI DUSUN & ID REFERENSI
                // ===============================
                $dusun = $this->db->get_where('dusun', ['id_dusun' => $id_dusun])->row();
                if (!$dusun) {
                    $errors = $this->session->userdata('errors') ?? [];
                    $errors[] = "Baris $baris: ID Dusun ($id_dusun) tidak ditemukan";
                    $this->session->set_userdata('errors', $errors);
                    continue;
                }

                $id_dusun = $dusun->id_dusun;

                // ===============================
                // VALIDASI ID REFERENSI
                // ===============================
                $id_errors = [];

                if ($hubungan_id <= 0) $id_errors[] = "ID Hubungan tidak valid";
                if ($status_perkawinan_id <= 0) $id_errors[] = "ID Status Perkawinan tidak valid";
                if ($kewarganegaraan_id <= 0) $id_errors[] = "ID Kewarganegaraan tidak valid";
                if ($pendidikan_id <= 0) $id_errors[] = "ID Pendidikan tidak valid";

                if (!empty($id_errors)) {
                    $errors = $this->session->userdata('errors') ?? [];
                    $errors[] = "Baris $baris: " . implode(", ", $id_errors);
                    $this->session->set_userdata('errors', $errors);
                    continue;
                }

                // ===============================
                // CEK / BUAT KELUARGA (AMAN: semua validasi sudah selesai)
                // ===============================
                $keluarga = $this->db
                    ->get_where('keluarga', ['no_kk' => $no_kk])
                    ->row();

                if (!$keluarga) {
                    $nama_dusun_final = $dusun->nama_dusun;
                    $alamat_otomatis = 'Br. ' . $nama_dusun_final . ' /Kec. Blahbatuh Kab. Gianyar';

                    // Jika data saat ini adalah kepala keluarga, gunakan nama-nya
                    $nama_kk = ($hubungan_id == 1) ? $nama : '-';

                    $this->db->insert('keluarga', [
                        'no_kk' => $no_kk,
                        'nama_kepala_keluarga' => $nama_kk,
                        'id_dusun' => $id_dusun,
                        'alamat' => $alamat_otomatis
                    ]);
                    $keluarga_id = $this->db->insert_id();
                } else {
                    $keluarga_id = $keluarga->id;

                    // Jika data saat ini adalah kepala keluarga, update nama di keluarga
                    if ($hubungan_id == 1) {
                        $this->db->where('no_kk', $no_kk)
                            ->update('keluarga', [
                                'nama_kepala_keluarga' => $nama
                            ]);
                    }
                }

                // ===============================
                // SIMPAN JIKA KEPALA KELUARGA
                // ===============================
                if ($hubungan_id == 1) {
                    $kepala_keluarga[] = [
                        'no_kk' => $no_kk,
                        'nama' => $nama
                    ];
                }

                // ===============================
                // FORMAT TANGGAL
                // ===============================
                $tgl = null;
                if (!empty($tanggal_lahir)) {
                    $tgl = date('Y-m-d', strtotime($tanggal_lahir));
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

                $processed = $this->session->userdata('processed') ?? 0;
                $this->session->set_userdata('processed', $processed + 1);
            }

            if (!empty($insert)) {
                $this->db->insert_batch('warga', $insert);
            }

            // ===============================
            // UPDATE KEPALA KELUARGA PER CHUNK
            // ===============================
            if (!empty($kepala_keluarga)) {
                foreach ($kepala_keluarga as $kk) {
                    $this->db->where('no_kk', $kk['no_kk'])
                        ->update('keluarga', [
                            'nama_kepala_keluarga' => $kk['nama']
                        ]);
                }
                $kepala_keluarga_all = array_merge($kepala_keluarga_all, $kepala_keluarga);
            }
        }

        unlink($filePath);
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

        echo json_encode(['percent' => $percent]);
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
            data_surat.arsip_id
            ')
            ->from('data_surat')
            ->join('template_surat', 'template_surat.id_template = data_surat.id_template', 'left')
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
            ->join('arsip_surat', 'arsip_surat.id = data_surat.arsip_id')
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
