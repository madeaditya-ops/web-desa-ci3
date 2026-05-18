<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Galeri_model extends CI_Model {
    public function get_latest_galeri($limit = 6) {
        return $this->db
                    ->order_by('id_galeri', 'DESC')
                    ->limit($limit)
                    ->get('galeri')
                    ->result_array();
    }

    public function get_all_latest_galeri() {
        return $this->db
                    ->order_by('id_galeri', 'DESC')
                    ->get('galeri')
                    ->result();
    }

    public function get_all() {
        return $this->db->get('galeri')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('galeri', ['id_galeri' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert('galeri', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id_galeri', $id)->update('galeri', $data);
    }

    public function delete($id) {
        return $this->db->delete('galeri', ['id_galeri' => $id]);
    }

    // public function count_all()
    // {
    //     return $this->db->count_all('galeri');
    // }

}