<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Upload $upload
 * @property CI_Form_validation $form_validation
 * @property Aparatur_model $Aparatur_model
 */
class Aparatur extends SuperAdmin_Middleware {

    public function __construct() {
        parent::__construct();
        $this->load->model('Aparatur_model');
        $this->load->library('upload');
        $this->load->library('form_validation'); 
        $this->load->library('session');    
    } 

    public function index() {
        $data['aparatur'] = $this->Aparatur_model->get_all();
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/aparatur/index', $data);
        $this->load->view('template_admin/footer');
    }

    public function create() {
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/aparatur/create');
        $this->load->view('template_admin/footer');
    }

    public function store() {
        // Validasi
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            if (empty($_FILES['foto']['name'])) {
                $this->session->set_flashdata('error', 'Foto wajib diunggah!');
                $this->create();
                return; 
            }

            $config['upload_path']   = './uploads/aparatur/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']      = 2048; 
            $config['encrypt_name']  = TRUE; 

            $this->upload->initialize($config);

            if ($this->upload->do_upload('foto')) {
                $upload_data = $this->upload->data();
                $foto = $upload_data['file_name'];

                $data = [
                    'nama'    => $this->input->post('nama'),
                    'jabatan' => $this->input->post('jabatan'),
                    'foto'    => $foto
                ];

                $this->Aparatur_model->insert($data);
                $this->session->set_flashdata('success', 'Aparatur berhasil ditambahkan!');
                redirect('aparatur');
            } else {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error);
                $this->create();
            }
        }
    }

    public function edit($id) {
        $data['aparatur'] = $this->Aparatur_model->get_by_id($id);
        if (!$data['aparatur']) {
            show_404();
        }
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/aparatur/edit', $data);
        $this->load->view('template_admin/footer');
    }

    public function update($id) {
        $old_data = $this->Aparatur_model->get_by_id($id);

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $foto = $old_data->foto;

            if (!empty($_FILES['foto']['name'])) {
                $config['upload_path']   = './uploads/aparatur/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size']      = 2048;
                $config['encrypt_name']  = TRUE;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('foto')) {
                    $upload_data = $this->upload->data();
                    $foto = $upload_data['file_name']; 

                    // hapus file lama
                    if ($old_data->foto && file_exists('./uploads/aparatur/' . $old_data->foto)) {
                        unlink('./uploads/aparatur/' . $old_data->foto);
                    }
                } else {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect('aparatur/edit/' . $id);
                    return;
                }
            }

            $data = [
                'nama'    => $this->input->post('nama'),
                'jabatan' => $this->input->post('jabatan'),
                'foto'    => $foto
            ];

            $this->Aparatur_model->update($id, $data);
            $this->session->set_flashdata('success', 'Aparatur berhasil diperbarui!');
            redirect('aparatur');
        }
    }

    public function delete($id) {
        $aparatur = $this->Aparatur_model->get_by_id($id);

        if ($aparatur) {
            if ($aparatur->foto && file_exists('./uploads/aparatur/' . $aparatur->foto)) {
                unlink('./uploads/aparatur/' . $aparatur->foto);
            }
            $this->Aparatur_model->delete($id);
            $this->session->set_flashdata('success', 'Aparatur berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Data aparatur tidak ditemukan!');
        }
        redirect('aparatur');
    }
}
