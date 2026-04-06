<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Upload $upload
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 * @property Keluarga_model $Keluarga_model
 */
class Keluarga extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Keluarga_model');
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

        $this->load->view('template_admin/header', $data);
        $this->load->view('template_admin/sidebar');
        $this->load->view('keluarga/tambah', $data);
        $this->load->view('template_admin/footer');
    }

    public function simpan()
    {
        $data = [
            'id_dusun' => $this->input->post('id_dusun'),
            'no_kk' => $this->input->post('no_kk'),
            'nama_kepala_keluarga' => $this->input->post('nama_kepala_keluarga'),
            'alamat' => $this->input->post('alamat')
        ];

        $this->Keluarga_model->insert($data);
        redirect('keluarga');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Keluarga';
        $data['keluarga'] = $this->Keluarga_model->get_by_id($id);
        $data['dusun'] = $this->db->get('dusun')->result();

        $this->load->view('template_admin/header', $data);
        $this->load->view('template_admin/sidebar');
        $this->load->view('keluarga/edit', $data);
        $this->load->view('template_admin/footer');
    }

    public function update($id)
    {
        $data = [
            'id_dusun' => $this->input->post('id_dusun'),
            'no_kk' => $this->input->post('no_kk'),
            'nama_kepala_keluarga' => $this->input->post('nama_kepala_keluarga'),
            'alamat' => $this->input->post('alamat')
        ];

        $this->Keluarga_model->update($id, $data);
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

    if(!$keluarga_id){
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
        ->join('hubungan','hubungan.id = warga.hubungan_id','left')
        ->where('warga.keluarga_id',$keluarga_id)
        ->order_by('warga.hubungan_id','ASC')
        ->get()
        ->result();

    echo json_encode($data);
}


public function detail($id)
{

$data['keluarga'] = $this->db
->select('keluarga.*, dusun.nama_dusun')
->from('keluarga')
->join('dusun','dusun.id_dusun = keluarga.id_dusun','left')
->where('keluarga.id',$id)
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
->join('hubungan','hubungan.id=warga.hubungan_id','left')
->where('warga.keluarga_id',$id)
->order_by('warga.hubungan_id','ASC')
->get()
->result();

$this->load->view('template_admin/header');
$this->load->view('template_admin/sidebar');
$this->load->view('keluarga/detail',$data);
$this->load->view('template_admin/footer');

}

public function edit_foto($id)
{

$data['warga'] = $this->db
->get_where('warga',['id'=>$id])
->row();

$data['title'] = 'Edit Foto Warga';

$this->load->view('template_admin/header',$data);
$this->load->view('template_admin/sidebar');
$this->load->view('keluarga/edit_foto',$data);
$this->load->view('template_admin/footer');

}

public function update_foto($id)
{

$warga = $this->db->get_where('warga',['id'=>$id])->row();

$nik = $warga->no_nik;

$config['upload_path'] = './uploads/foto_warga/';
$config['allowed_types'] = 'jpg|jpeg|png';
$config['max_size'] = 2048;
$config['file_name'] = $nik;

$this->load->library('upload',$config);

if($this->upload->do_upload('foto')){

$upload = $this->upload->data();

$filename = $upload['file_name'];

$this->db->where('id',$id);
$this->db->update('warga',[
'foto'=>$filename
]);

}

redirect('keluarga/detail/'.$warga->keluarga_id);

}

}
