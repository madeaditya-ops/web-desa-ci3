<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_surat_pending_model extends CI_Model
{
    protected $table = 'data_surat_pending';

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function get_pending()
    {
        return $this->db
            ->order_by('created_at','DESC')
            ->get($this->table)
            ->result();
    }

    public function get_by_id($id)
    {
        return $this->db
            ->get_where($this->table, ['id'=>$id])
            ->row_array();
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['id'=>$id]);
    }
}
