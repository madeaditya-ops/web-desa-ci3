<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_model extends CI_Model {

    private $table = 'template_surat';

    public function get_all()
    {
        $this->db->select('template_surat.*, dusun.nama_dusun');
        $this->db->from($this->table);
        $this->db->join('dusun', 'template_surat.dusun_id = dusun.id_dusun', 'left');
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        $this->db->select('template_surat.*, dusun.nama_dusun');
        $this->db->from($this->table);
        $this->db->join('dusun', 'template_surat.dusun_id = dusun.id_dusun', 'left');
        $this->db->where('template_surat.id_template', $id);
        return $this->db->get()->row();
    }

    public function get_by_role($role = 'admin')
    {
        $this->db->select('template_surat.*, dusun.nama_dusun');
        $this->db->from($this->table);
        $this->db->join('dusun', 'template_surat.dusun_id = dusun.id_dusun', 'left');
        $this->db->where('template_surat.level_akses', $role);
        $this->db->order_by('template_surat.nama_surat', 'ASC');
        return $this->db->get()->result();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        return $this->db->where('id_template', $id)->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->delete($this->table, ['id_template' => $id]);
    }
}
