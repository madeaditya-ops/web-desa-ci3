<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function cek_login($username) {
        return $this->db
            ->where('username', $username)
            ->get('users')
            ->row(); 
    }

    public function insert($data) {
        return $this->db->insert('users', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id_user', $id)->update('users', $data);
    }

    public function delete($id) {
        return $this->db->delete('users', ['id_user' => $id]);
    }

     public function get_users_with_dusun() {
        $this->db->select('users.*, dusun.kode_dusun, dusun.nama_dusun');
        $this->db->from('users');
        $this->db->join('dusun', 'dusun.id_dusun = users.dusun_id', 'left'); // pakai left join biar data user tetap tampil meski dusunnya kosong
        return $this->db->get()->result();
    }

    public function get_user_with_dusun_by_id($id) {
        $this->db->select('users.*, dusun.kode_dusun, dusun.nama_dusun');
        $this->db->from('users');
        $this->db->join('dusun', 'dusun.id_dusun = users.dusun_id', 'left');
        $this->db->where('users.id_user', $id);
        return $this->db->get()->row();
    }
}
