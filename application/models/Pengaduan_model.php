<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaduan_model extends CI_Model {
    public function get_all() {
        return $this->db
            ->select('pengaduan.*, kategori_pengaduan.nama_kategori')
            ->from('pengaduan')
            ->join('kategori_pengaduan', 'kategori_pengaduan.id_kategori = pengaduan.id_kategori', 'left')
            ->join('dusun', 'dusun.id_dusun = pengaduan.id_dusun', 'left')
            ->order_by('pengaduan.created_at', 'DESC')
            ->get()
            ->result();
    }

    public function get_by_id($id) {
        $query = $this->db
            ->select('pengaduan.*, kategori_pengaduan.nama_kategori, users.nama as id_kadus, dusun.nama_dusun')
            ->from('pengaduan')
            ->join('kategori_pengaduan', 'kategori_pengaduan.id_kategori = pengaduan.id_kategori', 'left')
            ->join('users', 'users.id_user = pengaduan.id_kadus', 'left')
            ->join('dusun', 'dusun.id_dusun = pengaduan.id_dusun', 'left')
            ->where('pengaduan.id_pengaduan', $id)
            ->get();

        return $query->row();
    }


    public function insert($data) {
        return $this->db->insert('pengaduan', $data);
    }

    public function update ($id, $data) {
        return $this->db
            ->where('id_pengaduan', $id)
            ->update('pengaduan', $data);
    }

    public function get_by_dusun($id_dusun)
    {
        return $this->db
            ->select('pengaduan.*, dusun.nama_dusun, kategori_pengaduan.nama_kategori')
            ->from('pengaduan')
            ->join('dusun', 'dusun.id_dusun = pengaduan.id_dusun', 'left')
            ->join('kategori_pengaduan', 'kategori_pengaduan.id_kategori = pengaduan.id_kategori', 'left')
            ->where('pengaduan.id_dusun', $id_dusun)
            ->order_by('created_at', 'DESC')
            ->get()
            ->result();
    }


    // Super admin
    public function count_pending () {
        return $this->db->where('status', 'pending')
            ->count_all_results('pengaduan');
    }

    public function count_diproses () {
        return $this->db->where('status', 'diproses')
            ->count_all_results('pengaduan');
    }

    public function count_ditolak () {
        return $this->db->where('status', 'ditolak')
            ->count_all_results('pengaduan');
    }

    public function count_selesai () {
        return $this->db->where('status', 'selesai')
            ->count_all_results('pengaduan');
    }

    public function total_pengaduan () {
        return $this->db->count_all('pengaduan');
    }

    public function get_notifikasi()
    {
        return $this->db
            ->select(' pengaduan.*, users.nama as nama_kadus')
            ->from('pengaduan')
            ->join(
                'users',
                'users.id_user = pengaduan.id_kadus',
                'left')
            ->where('pengaduan.is_read', 0)
            ->order_by('pengaduan.id_pengaduan', 'DESC')
            ->limit(5)
            ->get()
            ->result();
    }

    public function count_notifikasi() {
        return $this->db
            ->where('is_read', 0)
            ->count_all_results('pengaduan');
    }

    public function read_notifikasi(){

        $this->db->set('is_read',1);
        $this->db->where('is_read',0);
        $this->db->update('pengaduan');

    }

    public function read_single_notifikasi($id_pengaduan){
        $this->db->where('id_pengaduan', $id_pengaduan);
        $this->db->where('is_read', 0);
        $this->db->update('pengaduan', ['is_read' => 1]);
    }

    public function get_last_pengaduan_id() {
        return $this->db
            ->select_max('id_pengaduan')
            ->where('is_read', 0)
            ->get('pengaduan')
            ->row()
            ->id_pengaduan;
    }

     //untuk filter table berdasarkan status
    public function get_by_status($status)
    {
        return $this->db
            ->select('pengaduan.*, kategori_pengaduan.nama_kategori')
            ->from('pengaduan')
            ->join('kategori_pengaduan', 'kategori_pengaduan.id_kategori = pengaduan.id_kategori', 'left')
            ->where('pengaduan.status', $status)
            ->order_by('pengaduan.created_at', 'DESC')
            ->get()
            ->result();
    }

    


    //Kadus
    
    public function count_pending_kadus ($id_dusun) {
        return $this->db
            ->where('status', 'pending')
            ->where('id_dusun', $id_dusun)
            ->count_all_results('pengaduan');
    }

    public function count_diproses_kadus ($id_dusun) {
        return $this->db
            ->where('status', 'diproses')
            ->where('id_dusun', $id_dusun)
            ->count_all_results('pengaduan');
    }

    public function count_ditolak_kadus ($id_dusun) {
        return $this->db
            ->where('status', 'ditolak')
            ->where('id_dusun', $id_dusun)
            ->count_all_results('pengaduan');
    }

    public function count_selesai_kadus ($id_dusun) {
        return $this->db
            ->where('status', 'selesai')
            ->where('id_dusun', $id_dusun)
            ->count_all_results('pengaduan');
    }

    public function total_pengaduan_kadus ($id_dusun) {
        return $this->db
            ->where('id_dusun', $id_dusun)
            ->count_all_results('pengaduan');
    }

    public function get_by_status_kadus($status, $id_dusun)
    {
        return $this->db
            ->select('pengaduan.*, kategori_pengaduan.nama_kategori')
            ->from('pengaduan')
            ->join('kategori_pengaduan', 'kategori_pengaduan.id_kategori = pengaduan.id_kategori', 'left')
            ->where('pengaduan.id_dusun', $id_dusun)
            ->where('pengaduan.status', $status)
            ->order_by('pengaduan.created_at', 'DESC')
            ->get()
            ->result();
    }


    // Notifikasi kadus
    public function get_notifikasi_kadus($id_dusun) {
        return $this->db
            ->where('id_dusun', $id_dusun)
            ->where('status', 'pending')
            ->where('is_read_kadus', 0)
            ->order_by('id_pengaduan', 'DESC')
            ->limit(5)
            ->get('pengaduan')
            ->result();
    }

    public function count_notifikasi_kadus($id_dusun) {
        return $this->db
            ->where('id_dusun', $id_dusun)
            ->where('status', 'pending')
            ->where('is_read_kadus', 0)
            ->count_all_results('pengaduan');
    }

    public function read_notifikasi_kadus() {
        $this->db->set('is_read_kadus', 1);
        $this->db->where('status', 'pending');
        $this->db->where('is_read_kadus', 0);
        $this->db->update('pengaduan');
    }

    public function read_single_notifikasi_kadus($id_pengaduan) {
        $this->db->where('id_pengaduan', $id_pengaduan);
        $this->db->update('pengaduan', ['is_read_kadus' => 1]);
    }

    public function get_last_pengaduan_id_kadus() {
        return $this->db
            ->select_max('id_pengaduan')
            ->where('status', 'pending')
            ->where('is_read_kadus', 0)
            ->get('pengaduan')
            ->row()
            ->id_pengaduan;
    }



    public function get_arsip($start_date = null, $end_date = null, $dusun_id = null)
    {
        $this->db
            ->select('p.*, k.nama_kategori')
            ->from('pengaduan p')
            ->join('kategori_pengaduan k', 'k.id_kategori = p.id_kategori', 'left')
            ->where('p.status', 'selesai')
            ->order_by('p.created_at', 'DESC');

        if ($dusun_id != null) {
            $this->db->where('p.id_dusun', $dusun_id);
        }

        if ($start_date && $end_date) {
            $this->db->where('DATE(p.created_at) >=', $start_date);
            $this->db->where('DATE(p.created_at) <=', $end_date);
        }

        return $this->db
            ->get()
            ->result();
    }

    // kategori_pengaduan
    public function get_kategori_pengaduan() {
        return $this->db
            ->get('kategori_pengaduan')
            ->result();
    }

    //pie chart kategori pengaduan
    public function get_kategori_chart($tahun)
    {
        $this->db->select('k.nama_kategori, COUNT(p.id_pengaduan) as total');
        $this->db->from('pengaduan p');
        $this->db->join('kategori_pengaduan k', 'p.id_kategori = k.id_kategori', 'left');

        $this->db->where('p.status !=', 'ditolak');
        $this->db->where('YEAR(p.created_at)', $tahun);

        $this->db->group_by('k.id_kategori');
        $this->db->order_by('total', 'DESC');

        return $this->db->get()->result();
    }



    public function get_rata_rata_waktu(){
        $query = $this->db->query("
            SELECT 
                AVG(TIMESTAMPDIFF(DAY, created_at, finished_at)) AS rata_rata_waktu
            FROM pengaduan
            WHERE status = 'selesai'
            AND finished_at IS NOT NULL
        ");

        $row = $query->row();
        return $row ? ($row->rata_rata_waktu ?? 0) : 0;
    }

    public function get_pengaduan_per_bulan($tahun)
    {
        $query = $this->db->query("
            SELECT 
                MONTH(created_at) AS bulan,
                COUNT(*) AS total
            FROM pengaduan
            WHERE YEAR(created_at) = ?
            AND status != 'ditolak'
            GROUP BY MONTH(created_at)
            ORDER BY MONTH(created_at)
        ", [$tahun]);

        return $query->result();
    }

    //ambil data dusun
    public function get_dusun(){
        return $this->db
            ->get('dusun')
            ->result();
    }
}
