<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita_model extends CI_Model {
    public function get_latest_berita($limit = 8) {
        return $this->db
                    ->order_by('id_berita', 'DESC')
                    ->limit($limit)
                    ->get('berita')
                    ->result_array();
    }
    public function get_all() {
        return $this->db->get('berita')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('berita', ['id_berita' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert('berita', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id_berita', $id)->update('berita', $data);
    }

    public function delete($id) {
        return $this->db->delete('berita', ['id_berita' => $id]);
    }

}

