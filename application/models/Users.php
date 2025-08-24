<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Model {

    private $table = "users";

    public function check_login($username, $password)
    {
        $this->db->where('username', $username);
        $user = $this->db->get($this->table)->row();

        if ($user) {
            // cek password hash
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }
        return false;
    }
}
