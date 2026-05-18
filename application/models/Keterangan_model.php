<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keterangan_model extends CI_Model {

    public function get_all() {
        return $this->db->get('keterangan')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('keterangan', ['id_keterangan' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert('keterangan', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id_keterangan', $id)->update('keterangan', $data);
    }

    public function delete($id) {
        return $this->db->delete('keterangan', ['id_keterangan' => $id]);
    }
}