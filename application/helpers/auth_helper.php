<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function cek_login() {
    $CI =& get_instance();
    if (!$CI->session->userdata('logged_in')) {
        redirect('auth/login');
    }
}

function cek_role($role) {
    $CI =& get_instance();
    if ($CI->session->userdata('role') != $role) {
        redirect('auth/login');
    }
}
