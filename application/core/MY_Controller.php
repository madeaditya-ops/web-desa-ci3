<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu.');
            redirect('login');
        }
    }

    protected function _redirect_to_home() {
        $role = $this->session->userdata('role');
        $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman tersebut!');

        if ($role == 'admin') {
            redirect('admin');
        } elseif ($role == 'kadus') {
            redirect('kadus');
        } else {
            redirect('dashboard'); 
        }
    }
}

class Kades_Middleware extends MY_Controller {
    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role') !== 'kades') {
            $this->_redirect_to_home();
        }
    }
}

class Admin_Middleware extends MY_Controller {
    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role') !== 'admin') {
            $this->_redirect_to_home();
        }
    }
}

class Kadus_Middleware extends MY_Controller {
    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('role') !== 'kadus') {
            $this->_redirect_to_home();
        }
    }
}