<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Arsip_model extends CI_Model
{
    protected $table = 'arsip_surat';

    public function add($data)
    {
        unset($data['created_at']);

        $this->db->set('created_at', 'NOW()', false);
        $this->db->insert($this->table, $data);

        return $this->db->insert_id();
    }

    public function getArsip($from = null, $to = null, $nama_surat = null)
    {
        $this->db->select('a.*, t.nomor_template_surat');
        $this->db->from('arsip_surat a');
        $this->db->join('template_surat t', 't.id_template = a.id_template', 'left');

        $this->db->where('a.status', 'disetujui');

        if (!empty($from)) {
            $this->db->where('DATE(a.created_at) >=', $from);
        }

        if (!empty($to)) {
            $this->db->where('DATE(a.created_at) <=', $to);
        }

        if (!empty($nama_surat)) {
            $this->db->group_start();
            $this->db->where('a.jenis_surat_tujuan', $nama_surat);
            $this->db->or_where('a.jenis_surat', $nama_surat);
            $this->db->group_end();
        }

        $this->db->order_by('a.created_at', 'DESC');

        return $this->db->get()->result();
    }

    public function get_all()
    {
        return $this->db
            ->select('
                a.*,

                t_asal.nama_surat AS nama_surat_asal,
                t_asal.jenis_template AS jenis_template_asal,

                t_tujuan.nama_surat AS nama_surat_tujuan,
                t_tujuan.jenis_template AS jenis_template_tujuan,

                ds.keterangan,
                ds.no_nasional AS no_nasional_kadus,

                a.no_nasional AS no_nasional_manual
            ')
            ->from('arsip_surat a')

            ->join('template_surat t_asal', 't_asal.id_template = a.id_template', 'left')

            ->join('template_surat t_tujuan', 't_tujuan.id_template = a.id_template_tujuan', 'left')

            ->join('data_surat ds', 'ds.id = a.data_surat_id', 'left')

            ->where('a.status', 'disetujui')

            ->order_by('COALESCE(a.tanggal_surat, a.created_at)', 'DESC', false)

            ->get()
            ->result();
    }

    public function get_by_ids(array $ids)
    {
        return $this->db
            ->where_in('id', $ids)
            ->order_by('created_at', 'DESC')
            ->get($this->table)
            ->result();
    }

    public function get_between($from = null, $to = null, $namaSurat = null)
    {
        $this->db->select('
            arsip_surat.*, 
            template_surat.nama_surat, 
            template_surat.nomor_template_surat
        ');

        $this->db->from('arsip_surat');

        $this->db->join(
            'template_surat',
            'arsip_surat.id_template = template_surat.id_template',
            'left'
        );

        $this->db->join(
            'users',
            'arsip_surat.id_user = users.id_user',
            'left'
        );

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
        return $this->db
            ->where('id', $id)
            ->get('arsip_surat')
            ->row();
    }

    // =========================
    // Statistik
    // =========================

    public function count_all()
    {
        return (int) $this->db
            ->where('status', 'disetujui')
            ->count_all_results($this->table);
    }

    public function count_between($from, $to)
    {
        return (int) $this->db
            ->where('status', 'disetujui')
            ->where('created_at >=', $from)
            ->where('created_at <=', $to)
            ->count_all_results($this->table);
    }

    public function counts_last_days($days = 7)
    {
        $start = date('Y-m-d 00:00:00', strtotime('-' . ($days - 1) . ' days'));

        $rows = $this->db
            ->select("DATE(created_at) as date, COUNT(*) as cnt", false)
            ->where('created_at >=', $start)
            ->group_by('DATE(created_at)')
            ->order_by('DATE(created_at)', 'ASC')
            ->get($this->table)
            ->result();

        $out = [];

        foreach ($rows as $r) {
            $out[$r->date] = (int) $r->cnt;
        }

        return $out;
    }

    public function counts_by_jenis()
    {
        $rows = $this->db
            ->select("jenis_surat, COUNT(*) as cnt", false)
            ->where('status', 'disetujui')
            ->group_by('jenis_surat')
            ->get($this->table)
            ->result();

        $out = [];

        foreach ($rows as $r) {
            $out[$r->jenis_surat] = (int) $r->cnt;
        }

        return $out;
    }
}