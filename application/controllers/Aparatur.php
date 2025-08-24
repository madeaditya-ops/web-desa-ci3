<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @property CI_Input $input
 * @property CI_Upload $upload
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 * @property Aparatur_model $Aparatur_model
 */
class Aparatur extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Aparatur_model');
        $this->load->helper(['url','form']);
        $this->load->library('upload');
    }

    public function index()
    {
        $data['aparatur'] = $this->Aparatur_model->get_all();
        
            $this->load->view('template_admin/header');
             $this->load->view('template_admin/sidebar');
              $this->load->view('kades/aparatur/index', $data);
             $this->load->view('template_admin/footer');
    }

    public function tambah()
{
    if ($this->input->post()) {
        $foto = null;

        // Upload foto hanya jika ada file
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path'] = './uploads/aparatur/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;
            $this->upload->initialize($config);

            if ($this->upload->do_upload('foto')) {
                $foto = $this->upload->data('file_name');
            } else {
                // Upload gagal tapi tetap insert tanpa foto
                $this->session->set_flashdata('error', $this->upload->display_errors());
            }
        }

        // Data siap insert
        $data = [
            'nama' => $this->input->post('nama'),
            'jabatan' => $this->input->post('jabatan'),
            'foto' => $foto
        ];

        // Debugging, bisa dihapus setelah yakin
        // var_dump($data); die();

        $insert = $this->Aparatur_model->insert($data);

        if($insert){
            $this->session->set_flashdata('success', 'Data berhasil ditambahkan!');
        } else {
            $this->session->set_flashdata('error', 'Data gagal ditambahkan!');
        }

        redirect('aparatur');
    } else {
        // Load view tambah
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/aparatur/tambah');
        $this->load->view('template_admin/footer');
    }
}

    public function edit($id)
    {
        $data['aparatur'] = $this->Aparatur_model->get_by_id($id);

        if ($this->input->post()) {
            $config['upload_path'] = './uploads/aparatur/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;
            $this->upload->initialize($config);

            $foto = $data['aparatur']->foto;
            if (!empty($_FILES['foto']['name'])) {
                if ($this->upload->do_upload('foto')) {
                    $foto = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('aparatur/edit/'.$id);
                }
            }

            $update = [
                'nama' => $this->input->post('nama'),
                'jabatan' => $this->input->post('jabatan'),
                'foto' => $foto
            ];

            $this->Aparatur_model->update($id, $update);
            redirect('aparatur');
        } else {
           
             $this->load->view('template_admin/header');
             $this->load->view('template_admin/sidebar');
              $this->load->view('kades/aparatur/edit', $data);
             $this->load->view('template_admin/footer');
        }
    }

    public function hapus($id)
    {
        $this->Aparatur_model->delete($id);
        redirect('aparatur');
    }
}
