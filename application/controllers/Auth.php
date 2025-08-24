<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Users');
        $this->load->helper(['url','form','auth']);
        $this->load->library('session');
    }

    public function login()
    {
        if ($this->input->post()) {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);

            // 🔎 Debug input
            log_message('error', 'DEBUG LOGIN | Input Username: '.$username.' | Input Password: '.$password);

            $user = $this->Users->check_login($username, $password);

            if ($user) {
                log_message('error', 'DEBUG LOGIN | User ditemukan: '.json_encode($user));

                $userdata = [
                    'id_user'   => $user->id_user,
                    'nama'      => $user->nama,
                    'username'  => $user->username,
                    'role'      => $user->role,
                    'logged_in' => TRUE
                ];
                $this->session->set_userdata($userdata);

                // Redirect sesuai role
                if ($user->role == 'admin') {
                    redirect('dashboard/admin');
                } elseif ($user->role == 'kades') {
                    redirect('dashboard/kades');
                } elseif ($user->role == 'kadus') {
                    redirect('dashboard/kadus');
                }
            } else {
                log_message('error', 'DEBUG LOGIN | User tidak ditemukan / password salah');
                $this->session->set_flashdata('error', 'Username atau password salah!');
                redirect('auth/login');
            }
        } else {
            $this->load->view('auth/login');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
