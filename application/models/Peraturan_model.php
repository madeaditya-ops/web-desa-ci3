<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peraturan_model extends CI_Model {
    private $table = 'peraturan';
    private $primary_key = 'id_peraturan';

    public function get_all_peraturan() {
    return $this->db
                ->order_by('id_peraturan', 'DESC')
                ->get('peraturan')
                ->result_array();
    }

    public function get_all() {
        $this->db->order_by($this->primary_key, 'DESC'); 
        return $this->db->get($this->table)->result();
    }

    // Mengambil data by ID
    public function get_by_id($id) {
        return $this->db->get_where($this->table, [$this->primary_key => $id])->row();
    }

    // Menambah data baru
    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    // Mengupdate data
    public function update($id, $data) {
        return $this->db->where($this->primary_key, $id)->update($this->table, $data);
    }

    // Menghapus data
    public function delete($id) {
        return $this->db->delete($this->table, [$this->primary_key => $id]);
    }

}
