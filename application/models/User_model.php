<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function cek_login($username) {
        return $this->db
            ->where('username', $username)
            ->get('users')
            ->row(); 
    }
}