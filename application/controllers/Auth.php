<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property User_model $User_model
 */

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
    }

    public function index() {
        $this->load->view('auth/login');
    }

    public function login() {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);

        $user = $this->User_model->cek_login($username);

        if (!$user) {
            $this->session->set_flashdata('error', 'Username atau Password Salah!');
            redirect('auth');
        } else {
            if (password_verify($password, $user->password)) {
                $this->session->set_userdata([
                    'id_user'   => $user->id_user,
                    'nama'      => $user->nama,
                    'username'  => $user->username,
                    'role'      => $user->role,
                    'dusun_id'  => $user->dusun_id,
                    'logged_in' => true
                ]);

                if ($user->role == 'superadmin') {
                    redirect('dashboard');
                } elseif ($user->role == 'admin') {
                    redirect('admin');
                } elseif ($user->role == 'kadus') {
                    redirect('kadus');
                } else {
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('error', 'Username atau Password Salah!');
                redirect('auth');
            }
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('landing');
    }
}
