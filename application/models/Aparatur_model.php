<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aparatur_model extends CI_Model {

    private $table = 'aparatur';

    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id_aparatur' => $id])->row();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id_aparatur', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['id_aparatur' => $id]);
    }
}
