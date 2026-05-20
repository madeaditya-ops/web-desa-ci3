<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_kadus_model extends CI_Model
{
    protected $table = 'arsip_surat';

    public function count_total_surat($id_user)
    {
        return $this->db
            ->where('id_user', $id_user)
            ->count_all_results($this->table);
    }

    public function count_by_status($id_user, $status)
    {
        return $this->db
            ->where('id_user', $id_user)
            ->where('status', $status)
            ->count_all_results($this->table);
    }

    public function get_surat_status_distribution($id_user)
    {
        return $this->db
            ->select('status, COUNT(*) as jumlah')
            ->from($this->table)
            ->where('id_user', $id_user)
            ->where_in('status', ['menunggu', 'disetujui', 'ditolak'])
            ->group_by('status')
            ->get()
            ->result();
    }

    public function get_surat_per_bulan($id_user)
    {
        return $this->db
            ->select('MONTH(created_at) as bulan, COUNT(*) as jumlah')
            ->from($this->table)
            ->where('id_user', $id_user)
            ->where('YEAR(created_at)', date('Y'))
            ->group_by('MONTH(created_at)')
            ->order_by('bulan', 'ASC')
            ->get()
            ->result();
    }

    public function get_surat_terbaru($id_user, $limit = 5)
    {
        return $this->db
            ->select('arsip_surat.*, template_surat.nama_surat as judul_surat')
            ->from($this->table)
            ->join('template_surat', 'template_surat.id_template = arsip_surat.id_template', 'left')
            ->where('arsip_surat.id_user', $id_user)
            ->order_by('arsip_surat.created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }
}