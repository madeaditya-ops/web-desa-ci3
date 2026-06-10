<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Upload $upload
 * @property CI_Form_validation $form_validation
 * @property CI_URI $uri
 * @property Lembaga_model $Lembaga_model
 */

class Anggota_lembaga extends SuperAdmin_Middleware {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Lembaga_model');
    }

    public function index($lembaga_id)
    {   

        $data['lembaga'] = $this->Lembaga_model->get_lembaga_by_id($lembaga_id);
        $data['anggota'] = $this->Lembaga_model->get_anggota_by_lembaga($lembaga_id);

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/lembaga/anggota_lembaga/index', $data);
        $this->load->view('template_admin/footer');
    }

    public function create($lembaga_id = null){
        if (!$lembaga_id) {
            show_404();
        }
        
        $data['lembaga'] = $this->Lembaga_model->get_lembaga_by_id($lembaga_id);

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/lembaga/anggota_lembaga/create', $data);
        $this->load->view('template_admin/footer');
    }

    public function store(){
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim');
        $this->form_validation->set_rules('status', 'Status', 'required|trim');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('anggota_lembaga/create');
            return;
        } 

        $lembaga_id = $this->input->post('lembaga_id');
        $urutan = $this->Lembaga_model->get_next_urutan('anggota_lembaga', $lembaga_id);
        $foto = null;

        if (!empty($_FILES['foto']['name'])) {

            $config['upload_path']   = './uploads/anggota_lembaga/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']      = 2048;
            $config['file_name']     = time() . '_' . $_FILES['foto']['name'];

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $uploadData = $this->upload->data();
                $foto      = $uploadData['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('lembaga/create');
                return;
            }
        }

        $data = [
            'lembaga_id' => $lembaga_id,
            'nama' => $this->input->post('nama'),
            'jabatan' => $this->input->post('jabatan'),
            'status' => $this->input->post('status'),
            'foto' => $foto,
            'urutan' => $urutan
        ];

        if($this->Lembaga_model->insert_anggota_lembaga($data)){
            $this->session->set_flashdata('success', 'Anggota lembaga berhasil ditambahkan!');
        } else {
            $this->session->set_flashdata('error', 'Anggota lembaga gagal ditambahkan!');
        }
        redirect('anggota_lembaga/index/' . $lembaga_id);

    }


    public function edit($id){
        $data['anggota'] = $this->Lembaga_model->get_anggota_by_id($id);


        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/lembaga/anggota_lembaga/edit', $data);
        $this->load->view('template_admin/footer');
    }

    public function update($id){
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim');
        $this->form_validation->set_rules('status', 'Status', 'required|trim');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect('anggota_lembaga/edit/'.$id);
            return;
        } 

        $lembaga_id = $this->input->post('lembaga_id');


        $foto = $this->input->post('old_foto'); 
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path']   = './uploads/anggota_lembaga/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size']      = 2048;
            $config['file_name']     = time() . '_' . $_FILES['foto']['name'];

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $uploadData = $this->upload->data();
                $foto      = $uploadData['file_name'];

                if (!empty($this->input->post('old_foto')) && file_exists('./uploads/lembaga/'.$this->input->post('old_foto'))) {
                    unlink('./uploads/anggota_lembaga/'.$this->input->post('old_foto'));
                }
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('anggota_lembaga/edit/'.$id);
                return;
            }
        }

        $data = [
            'lembaga_id' => $lembaga_id,
            'nama' => $this->input->post('nama'),
            'jabatan' => $this->input->post('jabatan'),
            'status' => $this->input->post('status'),
            'foto' => $foto,
        ];

        if($this->Lembaga_model->update_anggota_lembaga($id, $data) ){
            $this->session->set_flashdata('success', 'Anggota lembaga berhasil diedit!');
        } else {
            $this->session->set_flashdata('error', 'Anggota lembaga gagal diedit!');
        }
        redirect('anggota_lembaga/index/' . $lembaga_id);
    }

    public function delete($id) 
    {
        $anggota = $this->Lembaga_model->get_anggota_by_id($id);

        if ($anggota) {
            $lembaga_id = $anggota['lembaga_id']; 
            if (!empty($anggota['foto']) && file_exists('./uploads/anggota_lembaga/' . $anggota['foto'])) {
                unlink('./uploads/anggota_lembaga/' . $anggota['foto']);
            }
            if ($this->Lembaga_model->delete_anggota($id)) {
                $this->Lembaga_model->reset_urutan('anggota_lembaga', $lembaga_id);
                $this->session->set_flashdata('success', 'Anggota lembaga berhasil dihapus!');
            } else {
                $this->session->set_flashdata('error', 'Terjadi kesalahan saat menghapus data anggota!');
            }

            redirect('anggota_lembaga/index/' . $lembaga_id);

        } else {
            $this->session->set_flashdata('error', 'Data anggota tidak ditemukan!');
            redirect('lembaga');
        }
    }

}
