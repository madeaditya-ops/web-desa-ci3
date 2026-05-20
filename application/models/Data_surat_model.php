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

    public function count_surat_keluar($id_user)
    {
        $this->db->where('id_user', $id_user);
        $this->db->where('status', 'disetujui');
        return $this->db->count_all_results($this->table);
    }

    public function count_total_surat($id_user)
    {
        $this->db->where('id_user', $id_user);
        return $this->db->count_all_results($this->table);
    }

    public function get_surat_keluar_per_hari($id_user)
    {
        $this->db->select("DAY(created_at) as hari, COUNT(*) as jumlah");
        $this->db->where('id_user', $id_user);
        $this->db->where('status', 'disetujui');
        $this->db->where('YEAR(created_at)', date('Y'));
        $this->db->where('MONTH(created_at)', date('m'));
        $this->db->group_by('DAY(created_at)');
        $this->db->order_by('hari', 'ASC');
        return $this->db->get($this->table)->result();
    }

    public function get_surat_status_distribution($id_user)
    {
        $this->db->select("status, COUNT(*) as jumlah");
        $this->db->where('id_user', $id_user);
        $this->db->where_in('status', ['disetujui', 'ditolak']);
        $this->db->group_by('status');
        return $this->db->get($this->table)->result();
    }
    
}
