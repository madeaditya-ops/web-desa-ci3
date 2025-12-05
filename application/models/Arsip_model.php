<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arsip_model extends CI_Model
{
    protected $table = 'arsip_surat';

    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function get_all()
    {
        return $this->db->order_by('created_at', 'DESC')->get($this->table)->result();
    }

    public function get_by_ids(array $ids)
    {
        return $this->db->where_in('id', $ids)->order_by('created_at', 'DESC')->get($this->table)->result();
    }

    public function get_between($from, $to)
    {
        return $this->db->where('created_at >=', $from)->where('created_at <=', $to)->order_by('created_at', 'DESC')->get($this->table)->result();
    }

    // -------------------------
    // tambahan: statistik
    // -------------------------
    public function count_all()
    {
        return (int) $this->db->from($this->table)->count_all_results();
    }

    public function count_between($from, $to)
    {
        return (int) $this->db->where('created_at >=', $from)->where('created_at <=', $to)->from($this->table)->count_all_results();
    }

    /**
     * Mengembalikan array tanggal => count untuk $days terakhir (termasuk hari ini)
     * format key: 'YYYY-MM-DD'
     */
    public function counts_last_days($days = 7)
    {
        $start = date('Y-m-d 00:00:00', strtotime('-' . ($days - 1) . ' days'));
        $this->db->select("DATE(created_at) as date, COUNT(*) as cnt", FALSE);
        $this->db->where('created_at >=', $start);
        $this->db->group_by('DATE(created_at)');
        $this->db->order_by('DATE(created_at)', 'ASC');
        $rows = $this->db->get($this->table)->result();

        $out = [];
        foreach ($rows as $r) {
            $out[$r->date] = (int) $r->cnt;
        }
        return $out;
    }
}