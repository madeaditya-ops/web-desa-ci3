<?php
class Layanan_model extends CI_Model {

    protected $table = 'layanan_surat';

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function get_menunggu_admin()
    {
        return $this->db->where('status','menunggu_admin')->get($this->table)->result();
    }

    public function get_menunggu_kades()
    {
        return $this->db->where('status','menunggu_kades')->get($this->table)->result();
    }

    public function update_status($id, $status)
    {
        $this->db->where('id',$id)->update($this->table, ['status'=>$status]);
    }
}
