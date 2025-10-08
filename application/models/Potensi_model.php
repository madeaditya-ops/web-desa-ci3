<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Potensi_model extends CI_Model {
    public function get_all()
    {
        return $this->db->select('*')
                        ->from('potensi')
                        ->order_by('id_potensi', 'DESC')
                        ->get()
                        ->result_array();
    }

    public function get_all_potensi() {
        return $this->db->order_by('id_potensi', 'DESC')->get('potensi')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('potensi', ['id_potensi' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert('potensi', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id_potensi', $id)->update('potensi', $data);
    }

    public function delete($id) {
        return $this->db->delete('potensi', ['id_potensi' => $id]);
    }

}
