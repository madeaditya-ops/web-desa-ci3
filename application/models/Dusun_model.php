<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dusun_model extends CI_Model {

    private $table = 'dusun';

    
    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    public function get_name($id_dusun) {
        $row = $this->db->get_where('dusun', ['id_dusun' => $id_dusun])->row();
        return $row ? $row->nama_dusun : null;
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id_dusun' => $id])->row();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id_dusun', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['id_dusun' => $id]);
    }
}
