<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template_surat_model extends CI_Model {

    public function get_all() {
        return $this->db->get('template_surat')->result();
    }

    public function get_all_kecuali_pengantar()
{
    return $this->db
        ->where('level_akses', 'admin')
        ->order_by('nama_surat', 'ASC')
        ->get('template_surat')
        ->result();
}


     public function get_active()
    {
        return $this->db->where('is_active',1)->get('template_surat')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('template_surat', ['id_template' => $id])->row();
    }

    public function insert($data) {
        return $this->db->insert('template_surat', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id_template', $id)->update('template_surat', $data);
    }

    public function delete($id) {
        return $this->db->delete('template_surat', ['id_template' => $id]);
    }

    // kalau mau join dengan tabel dusun
    public function get_with_dusun() {
        $this->db->select('template_surat.*, dusun.nama_dusun, dusun.kode_dusun');
        $this->db->from('template_surat');
        $this->db->join('dusun', 'dusun.id_dusun = template_surat.dusun_id', 'left');
        return $this->db->get()->result();
    }

    public function get_by_level_akses($level_akses) {
        return $this->db->get_where('template_surat', ['level_akses' => $level_akses])->result();
    }

    public function get_surat_list() {
        $this->db->select('id_template, nama_surat, nomor_template_surat');
        $this->db->where('level_akses', 'admin');
        $this->db->order_by('nama_surat', 'ASC');
        return $this->db->get('template_surat')->result();
    }

    public function get_last_nomor_by_template($id_template, $tahun)
{
    $this->db->select('nomor_pengantar');
    $this->db->from('data_surat_pending');
    $this->db->where('id_template', $id_template);
    $this->db->like('created_at', $tahun, 'after');
    $this->db->order_by('id', 'DESC');
    $this->db->limit(1);

    return $this->db->get()->row();
}

}

