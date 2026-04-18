<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property User_model $User_model
 * @property Dusun_model $Dusun_model
 */
class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Dusun_model');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index() {
        $data['users'] = $this->User_model->get_users_with_dusun();
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/users/index', $data);
        $this->load->view('template_admin/footer');
    }

    public function create() {
        $data['dusun'] = $this->Dusun_model->get_all();
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/users/create', $data);
        $this->load->view('template_admin/footer');
    }

    public function store() {
        // Validasi
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules(
            'username',
            'Username',
            'required|trim|min_length[5]|is_unique[users.username]|alpha_numeric',
            ['is_unique' => 'Username sudah digunakan!']
        );
        $this->form_validation->set_rules(
            'password',
            'Password',
            'required|min_length[6]',
            ['min_length' => 'Password minimal 6 karakter']
        );
        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $dusun_id = $this->input->post('dusun_id');

            $data = [
                'nama'      => $this->input->post('nama'),
                'username'  => $this->input->post('username'),
                'password'  => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'role'      => $this->input->post('role'),
                'dusun_id'  => empty($dusun_id) ? NULL : $dusun_id
            ];

            $this->User_model->insert($data);
            $this->session->set_flashdata('success', 'User berhasil ditambahkan!');
            redirect('users');
        }
    }

    public function edit($id) {
        $data['user'] = $this->User_model->get_user_with_dusun_by_id($id);
        $data['dusun'] = $this->Dusun_model->get_all();
        if (!$data['user']) {
            show_404();
        }

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/users/edit', $data);
        $this->load->view('template_admin/footer');
    }

    public function update($id) {
        $old_data = $this->User_model->get_user_with_dusun_by_id($id);

        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules(
            'username',
            'Username',
            'required|trim|min_length[5]|alpha_numeric'
        );
        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $password = $old_data->password;
            if (!empty($this->input->post('password'))) {
                if (strlen($this->input->post('password')) < 6) {
                    $this->session->set_flashdata('error', 'Password minimal 6 karakter!');
                    redirect('users/edit/'.$id);
                    return;
                }
                $password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
            }
            
            $dusun_id = $this->input->post('dusun_id');

            $data = [
                'nama'      => $this->input->post('nama'),
                'username'  => $this->input->post('username'),
                'password'  => $password,
                'role'      => $this->input->post('role'),
                'dusun_id'  => empty($dusun_id) ? NULL : $dusun_id
            ];

            $this->User_model->update($id, $data);
            $this->session->set_flashdata('success', 'User berhasil diperbarui!');
            redirect('users');
        }
    }

    public function delete($id) {
        $user = $this->User_model->get_user_with_dusun_by_id($id);

        if (!$user) {
            $this->session->set_flashdata('error', 'Data user tidak ditemukan!');
            redirect('users');
            return;
        }

        if ($user->role == 'superadmin') {
            $this->session->set_flashdata('error', 'User dengan role Super Admin tidak dapat dihapus!');
            redirect('users');
            return;
        }

        $this->User_model->delete($id);
        $this->session->set_flashdata('success', 'User berhasil dihapus!');
        redirect('users');
    }

}
