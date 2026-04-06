<?php
class Notifikasi_model extends CI_Model
{
    protected $table = 'notifikasi';

    public function tambah($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function get_unread($user_id, $role)
    {
        return $this->db
            ->where([
                'user_id' => $user_id,
                'role' => $role,
                'is_read' => 0
            ])
            ->order_by('created_at','DESC')
            ->get($this->table)
            ->result();
    }

    public function tandai_dibaca($id)
    {
        return $this->db
            ->where('id', $id)
            ->update($this->table, ['is_read'=>1]);
    }
}
