<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Upload $upload
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 * @property Keluarga_model $Keluarga_model
 */
class Keluarga extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Keluarga_model');
         $this->load->model('Warga_model');
        $this->load->model('Dusun_model');
    }

    public function index()
    {
        $data['title'] = 'Data Keluarga';
        $data['keluarga'] = $this->Keluarga_model->get_all();

        $this->load->view('template_admin/header', $data);
        $this->load->view('template_admin/sidebar');
        $this->load->view('keluarga/index', $data);
        $this->load->view('template_admin/footer');
    }

 public function tambah()
{
    $data['title'] = 'Tambah Keluarga';
    $data['dusun'] = $this->db->get('dusun')->result();

    // 🔥 TAMBAHAN MASTER
    $data['hubungan'] = $this->db->get('hubungan')->result();
    $data['agama'] = $this->db->get('agama')->result();
    $data['jenis_kelamin'] = $this->db->get('jenis_kelamin')->result();
    $data['status_perkawinan'] = $this->db->get('status_perkawinan')->result();
    $data['pendidikan'] = $this->db->get('pendidikan')->result();
    $data['kewarganegaraan'] = $this->db->get('kewarganegaraan')->result();

    $this->load->view('template_admin/header', $data);
    $this->load->view('template_admin/sidebar');
    $this->load->view('keluarga/tambah', $data);
    $this->load->view('template_admin/footer');
}

   public function simpan()
{
    // ===============================
    // 1. SIMPAN KELUARGA
    // ===============================
    $data_keluarga = [
        'id_dusun' => $this->input->post('id_dusun'),
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

    redirect('keluarga');
}


public function edit($id)
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
    $this->load->view('keluarga/edit', $data);
    $this->load->view('template_admin/footer');
}

    public function update($id)
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

    redirect('keluarga');
}




    public function delete($id)
    {
        $this->Keluarga_model->delete($id);
        redirect('keluarga');
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


    public function detail($id)
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
        $this->load->view('keluarga/detail', $data);
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
        $this->load->view('keluarga/edit_foto', $data);
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

        redirect('keluarga/detail/' . $warga->keluarga_id);
    }
}
