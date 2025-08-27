<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dusun_model extends CI_Model {

    public function get_all() {
        return $this->db->get('dusun')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('dusun', ['id_dusun' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert('dusun', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id_dusun', $id)->update('dusun', $data);
    }

    public function delete($id) {
        return $this->db->delete('dusun', ['id_dusun' => $id]);
    }
}
