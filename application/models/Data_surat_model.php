<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_surat_model extends CI_Model
{
    protected $table = 'data_surat';

  public function insert($data)
{
    $this->db->insert('data_surat', $data);
    return $this->db->insert_id(); // 🔥 WAJIB ADA
}


      public function get_all()
    {
        return $this->db->order_by('nama','ASC')->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id'=>$id])->row();
    }

    
    
}
