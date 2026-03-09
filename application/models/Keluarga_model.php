<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keluarga_model extends CI_Model {

  public function get_all()
{
    $this->db->select('keluarga.*, dusun.nama_dusun');
    $this->db->from('keluarga');
    $this->db->join('dusun', 'dusun.id_dusun = keluarga.id_dusun', 'left');
    return $this->db->get()->result();
}

    public function get_by_id($id)
    {
        return $this->db->get_where('keluarga', ['id' => $id])->row();
    }

    public function insert($data)
    {
        return $this->db->insert('keluarga', $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update('keluarga', $data);
    }

    public function delete($id)
    {
        return $this->db->delete('keluarga', ['id' => $id]);
    }
}
