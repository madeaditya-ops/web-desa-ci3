<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template_surat_model extends CI_Model {

    public function get_all() {
        return $this->db->get('template_surat')->result();
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

}

