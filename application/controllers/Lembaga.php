<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Upload $upload
 * @property CI_Form_validation $form_validation
 * @property Lembaga_model $Lembaga_model
 */

class Lembaga extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Lembaga_model');
        $this->load->library('upload');
        $this->load->library('form_validation'); 
        $this->load->library('session'); 

    }

    public function index()
    {
        $data['lembaga'] = $this->Lembaga_model->get_all_lembaga();
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/lembaga/index', $data);
        $this->load->view('template_admin/footer');
    }

    public function create() {
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/lembaga/create');
        $this->load->view('template_admin/footer');
    }

   public function store()
    {
        $this->form_validation->set_rules('nama', 'Nama Lembaga', 'required|trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|trim');
        $this->form_validation->set_rules('tipe_struktur', 'Tipe Struktur', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('lembaga/create');
            return;
        }

        $slug = create_slug($this->input->post('nama', TRUE));

        $icon  = 'bi-building';
        $image = NULL;

        if (!empty($_FILES['image']['name'])) {

            $config['upload_path']   = './uploads/lembaga/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']      = 2048;
            $config['file_name']     = time() . '_' . $_FILES['image']['name'];

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $uploadData = $this->upload->data();
                $image      = $uploadData['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('lembaga/create');
                return;
            }
        }

        $data = [
            'nama'          => $this->input->post('nama', TRUE),
            'slug'          => $slug,
            'icon'          => $icon,
            'image'         => $image,
            'deskripsi'     => $this->input->post('deskripsi', TRUE),
            'tipe_struktur' => $this->input->post('tipe_struktur', TRUE),
            'created_at'    => date('Y-m-d H:i:s'),
        ];

        if($this->Lembaga_model->insert_lembaga($data))
        {
            $this->session->set_flashdata('success', 'Lembaga berhasil ditambahkan!');
        }else{
            $this->session->set_flashdata('error', 'Lembaga gagal ditambahkan!');
        }
        redirect('lembaga');
        
    }

    public function edit($id) {
        $data['lembaga'] = $this->Lembaga_model->get_lembaga_by_id($id);
        if (!$data['lembaga']) {
            show_404();
        }
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/lembaga/edit', $data);
        $this->load->view('template_admin/footer');
    }


    public function update($id)
    {
        $this->form_validation->set_rules('nama', 'Nama Lembaga', 'required|trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|trim');
        $this->form_validation->set_rules('tipe_struktur', 'Tipe Struktur', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('lembaga/edit/'.$id);
            return;
        }

        $slug = create_slug($this->input->post('nama', TRUE));

        $icon = $this->input->post('icon') ?: 'bi-building';

        $image = $this->input->post('old_image');

        if (!empty($_FILES['image']['name'])) {

            $config['upload_path']   = FCPATH . 'uploads/lembaga/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size']      = 2048;
            $config['encrypt_name']  = TRUE;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('image')) {

                $uploadData = $this->upload->data();
                $image = $uploadData['file_name'];

                if (!empty($this->input->post('old_image'))) {
                    $oldPath = FCPATH . 'uploads/lembaga/' . $this->input->post('old_image');
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('lembaga/edit/'.$id);
                return;
            }
        }



        $data = [
            'nama'          => $this->input->post('nama', TRUE),
            'slug'          => $slug,
            'icon'          => $icon,
            'image'         => $image,
            'deskripsi'     => $this->input->post('deskripsi', TRUE),
            'tipe_struktur' => $this->input->post('tipe_struktur', TRUE),
        ];

        if ($this->Lembaga_model->update_lembaga($id, $data)) {
            $this->session->set_flashdata('success', 'Data lembaga berhasil diperbarui!');
        } else {
            $this->session->set_flashdata('error', 'Terjadi kesalahan, data gagal diperbarui.');
        }

        redirect('lembaga');
    }

    public function delete($id) {
    $lembaga = $this->Lembaga_model->get_lembaga_by_id($id);

    if ($lembaga) {
        if ($lembaga->image && file_exists('./uploads/lembaga/' . $lembaga->image)) {
            unlink('./uploads/lembaga/' . $lembaga->image);
        }

        if ($this->Lembaga_model->delete_lembaga($id)) {
            $this->session->set_flashdata('success', 'Lembaga berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Terjadi kesalahan saat menghapus data lembaga!');
        }
    } else {
        $this->session->set_flashdata('error', 'Data lembaga tidak ditemukan!');
    }
    redirect('lembaga');
    }


}
