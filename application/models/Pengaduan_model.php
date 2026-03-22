<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaduan_model extends CI_Model {
    public function get_all() {
        return $this->db
            ->order_by('created_at', 'DESC')
            ->get('pengaduan')
            ->result();
    }

    public function get_by_id($id) {
        $query = $this->db
            ->get_where('pengaduan', array('id_pengaduan' => $id));
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

    public function get_notifikasi() {
        return $this->db
            ->where('is_read', 0)
            ->order_by('id_pengaduan', 'DESC')
            ->limit(5)
            ->get('pengaduan')
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

    public function get_arsip($start_date = null, $end_date = null)
    {
        $this->db
            ->where('status', 'selesai')
            ->order_by('created_at', 'DESC');

        if ($start_date && $end_date) {
            $this->db->where('DATE(created_at) >=', $start_date);
            $this->db->where('DATE(created_at) <=', $end_date);
        }

        return $this->db
            ->get('pengaduan')
            ->result();
    }

}
