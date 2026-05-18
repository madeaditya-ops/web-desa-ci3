<?php
class Master_data_model extends CI_Model
{
    // =========================
    // JENIS KELAMIN
    // =========================
    public function get_jenis_kelamin()
    {
         return $this->db
            ->order_by('nama', 'ASC')
            ->get('jenis_kelamin')
            ->result();
    }

    // =========================
    // STATUS PERKAWINAN (dari DB)
    // =========================
    public function get_status_perkawinan()
    {
        return $this->db
            ->order_by('nama', 'ASC')
            ->get('status_perkawinan')
            ->result();
    }

    // =========================
    // AGAMA
    // =========================
    public function get_agama()
    {
        return $this->db
            ->order_by('nama', 'ASC')
            ->get('agama')
            ->result();
    }
}