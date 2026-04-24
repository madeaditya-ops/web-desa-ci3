<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arsip_model extends CI_Model
{
    protected $table = 'arsip_surat';

    public function add($data)
{
    // HAPUS created_at dari $data jika ada
    unset($data['created_at']);

    $this->db->set('created_at', 'NOW()', false);
    $this->db->insert($this->table, $data);
    return $this->db->insert_id();
}

public function getArsip($from = null, $to = null)
{
    $this->db->select('a.*, t.nomor_template_surat');
    $this->db->from('arsip_surat a');
    $this->db->join('template_surat t', 't.id_template = a.id_template', 'left');
    $this->db->join('users u', 'a.id_user = u.id_user', 'left');
    // $this->db->where('u.role', 'admin');
    $this->db->where('a.status', 'setuju');
    if (!empty($from)) {
        $this->db->where('DATE(COALESCE(a.tanggal_surat, a.created_at)) >=', $from, false);
    }

    if (!empty($to)) {
        $this->db->where('DATE(COALESCE(a.tanggal_surat, a.created_at)) <=', $to, false);
    }

    $this->db->order_by('COALESCE(a.tanggal_surat, a.created_at)', 'DESC', false);

    return $this->db->get()->result();
}



    // public function get_all()
    // {
    //     return $this->db
    //     ->select('a.*, t.nomor_template_surat')
    //     ->from('arsip_surat a')
    //     ->join('template_surat t', 't.id_template = a.id_template', 'left')
    //     ->join('users u', 'a.id_user = u.id_user', 'left')
    //     ->where('u.role', 'admin')
    //     ->where('a.status', 'setuju')
    //     ->where('a.id_admin IS NOT NULL')
    // ->order_by('COALESCE(a.tanggal_surat, a.created_at)', 'DESC', false)
    // ->get()
    // ->result();
    // }

    public function get_all()
{
    return $this->db
        ->select('a.*, t.nama_surat') 
        ->from('arsip_surat a')
        ->join('template_surat t', 't.id_template = a.id_template', 'left')
        // Filter status
        ->where('a.status', 'setuju')
        // Urutkan berdasarkan tanggal terbaru
        ->order_by('COALESCE(a.tanggal_surat, a.created_at)', 'DESC', false)
        ->get()
        ->result();
}
    public function get_by_ids(array $ids)
    {
        return $this->db->where_in('id', $ids)->order_by('created_at', 'DESC')->get($this->table)->result();
    }

    public function get_between($from = null, $to = null, $namaSurat = null)
{
    $this->db->select('arsip_surat.*, 
                       template_surat.nama_surat, 
                       template_surat.nomor_template_surat AS nomor_template_surat');

    $this->db->from('arsip_surat');
    $this->db->join('template_surat', 
                    'arsip_surat.id_template = template_surat.id_template', 
                    'left');
    $this->db->join('users',
                    'arsip_surat.id_user = users.id_user',
                    'left');

    // Filter hanya surat dari Admin
    $this->db->where('users.role', 'admin');

    // ===============================
    // FILTER TANGGAL SURAT
    // ===============================
    if (!empty($from)) {
        $this->db->where(
            'DATE(COALESCE(arsip_surat.tanggal_surat, arsip_surat.created_at)) >=',
            $from
        );
    }

    if (!empty($to)) {
        $this->db->where(
            'DATE(COALESCE(arsip_surat.tanggal_surat, arsip_surat.created_at)) <=',
            $to
        );
    }

    // ===============================
    // FILTER NAMA SURAT
    // ===============================
    if (!empty($namaSurat)) {
        $this->db->where('template_surat.nama_surat', $namaSurat);
    }

    return $this->db
        ->order_by('COALESCE(arsip_surat.tanggal_surat, arsip_surat.created_at)', 'DESC', false)
        ->get()
        ->result();
}


    public function get_by_id($id)
    {
        return $this->db->where('id', $id)->get('arsip_surat')->row();
    }

    // -------------------------
    // tambahan: statistik
    // -------------------------
    public function count_all()
    {
        return (int) $this->db
            ->from($this->table)
            ->join('users', 'arsip_surat.id_user = users.id_user', 'left')
            ->where('users.role', 'admin')
            ->count_all_results();
    }

    public function count_between($from, $to)
    {
        return (int) $this->db
            ->from($this->table)
            ->join('users', 'arsip_surat.id_user = users.id_user', 'left')
            ->where('users.role', 'admin')
            ->where('arsip_surat.created_at >=', $from)
            ->where('arsip_surat.created_at <=', $to)
            ->count_all_results();
    }

    /**
     * Mengembalikan array tanggal => count untuk $days terakhir (termasuk hari ini)
     * format key: 'YYYY-MM-DD'
     */
    public function counts_last_days($days = 7)
    {
        $start = date('Y-m-d 00:00:00', strtotime('-' . ($days - 1) . ' days'));
        $this->db->select("DATE(arsip_surat.created_at) as date, COUNT(*) as cnt", FALSE);
        $this->db->from('arsip_surat');
        $this->db->join('users', 'arsip_surat.id_user = users.id_user', 'left');
        $this->db->where('users.role', 'admin');
        $this->db->where('arsip_surat.created_at >=', $start);
        $this->db->group_by('DATE(arsip_surat.created_at)');
        $this->db->order_by('DATE(arsip_surat.created_at)', 'ASC');
        $rows = $this->db->get()->result();

        $out = [];
        foreach ($rows as $r) {
            $out[$r->date] = (int) $r->cnt;
        }
        return $out;
    }
}