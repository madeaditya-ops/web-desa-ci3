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
         if ($this->session->userdata('logged_in')) {

        $role = $this->session->userdata('role');

        if ($role == 'kades') {
            redirect('dashboard');
        } elseif ($role == 'admin') {
            redirect('admin');
        } elseif ($role == 'kadus') {
            redirect('kadus');
        } else {
            redirect('landing');
        }
    }
        $this->load->view('auth/login');
    }

    public function login() {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);

        $user = $this->User_model->cek_login($username);

        if (!$user || !password_verify($password, $user->password)) {
            $this->session->set_flashdata('error', 'Username atau password salah!');
            redirect('login');
            return;
        }

        $this->session->set_userdata([
            'id_user'   => $user->id_user,
            'username'  => $user->username,
            'nama'      => $user->nama,
            'role'      => $user->role,
            'dusun_id'  => $user->dusun_id,
            'logged_in' => true
        ]);

        if ($user->role == 'kades') {
            redirect('dashboard');
        } elseif ($user->role == 'admin') {
            redirect('admin');
        } elseif ($user->role == 'kadus') {
            redirect('kadus');
        } else {
            redirect('login');
        }
         
    }
    

    public function logout() {
        $this->session->sess_destroy();
        redirect('landing');
    }
}
