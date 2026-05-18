<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita_model extends CI_Model {
    public function get_latest_berita($limit = 6) {
        return $this->db
                    ->order_by('created_at', 'DESC')
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

    public function get_by_slug($slug)
    {
        return $this->db->get_where('berita', ['slug' => $slug])->row_array();
    }

    //pagination
    public function count_berita()
    {
        return $this->db->count_all('berita');
    }

    public function get_berita_pagination($limit, $offset)
    {
        return $this->db->order_by('created_at', 'DESC')
                        ->limit($limit, $offset)
                        ->get('berita')
                        ->result();
    }


}



