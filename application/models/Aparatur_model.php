<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aparatur_model extends CI_Model {

    public function get_all() {
        return $this->db->get('aparatur')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('aparatur', ['id_aparatur' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert('aparatur', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id_aparatur', $id)->update('aparatur', $data);
    }

    public function delete($id) {
        return $this->db->delete('aparatur', ['id_aparatur' => $id]);
    }
}
