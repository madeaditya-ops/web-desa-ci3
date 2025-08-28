<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_model extends CI_Model {

    /* ==========================
     *   TEMPLATE SURAT
     * ========================== */

    // Ambil semua template surat
    public function get_all_template() {
        return $this->db->get('template_surat')->result();
    }

    // Ambil template berdasarkan id
    public function get_template_by_id($id) {
        return $this->db->get_where('template_surat', ['id_template' => $id])->row();
    }

    // Insert template surat baru
    public function insert_template($data) {
        return $this->db->insert('template_surat', $data);
    }

    // Update template surat
    public function update_template($id, $data) {
        return $this->db->where('id_template', $id)
                        ->update('template_surat', $data);
    }

    // Hapus template surat
    public function delete_template($id) {
        return $this->db->where('id_template', $id)
                        ->delete('template_surat');
    }

    // Ambil template berdasarkan jenis surat + dusun
    public function get_template($jenis_surat, $dusun_id) {
        return $this->db->get_where('template_surat', [
            'jenis_surat' => $jenis_surat,   // pastikan kolom ini ada
            'dusun_id'    => $dusun_id
        ])->row();
    }

    /* ==========================
     *   PENGAJUAN SURAT
     * ========================== */

    // Insert pengajuan surat
    public function insert_pengajuan($data) {
        return $this->db->insert('pengajuan_surat', $data);
    }

    public function insert($data)
{
    return $this->db->insert($this->table, $data);
}


    // Ambil semua pengajuan + join dusun
    public function get_all_pengajuan() {
        return $this->db->select('p.*, d.nama_dusun')
                        ->from('pengajuan_surat p')
                        ->join('dusun d', 'd.id_dusun = p.dusun_id', 'left')
                        ->order_by('p.id_pengajuan','DESC')
                        ->get()
                        ->result();
    }

    // Ambil pengajuan by id
    public function get_pengajuan($id) {
        return $this->db->get_where('pengajuan_surat', ['id_pengajuan' => $id])->row();
    }

    // Update pengajuan
    public function update_pengajuan($id, $data) {
        return $this->db->where('id_pengajuan', $id)
                        ->update('pengajuan_surat', $data);
    }

    // Hapus pengajuan
    public function delete_pengajuan($id) {
        return $this->db->where('id_pengajuan', $id)
                        ->delete('pengajuan_surat');
    }

      protected $table = 'template_surat';  // ✅ jangan private

    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    

    
    public function get_by_id($id)
    {
        return $this->db->where('id_template', $id)->get($this->table)->row();
    }


    public function update($id, $data)
    {
        return $this->db->where('id_template', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id_template', $id)->delete($this->table);
    }
}
