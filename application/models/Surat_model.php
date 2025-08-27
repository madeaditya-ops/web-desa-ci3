<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Surat_model extends CI_Model {

      public function get_all()
    {
        return $this->db->get('template_surat')->result();
    }

    public function insert_pengajuan($data) {
        return $this->db->insert('pengajuan_surat', $data);
    }

    public function get_all_pengajuan() {
        return $this->db->select('p.*, d.nama_dusun')
                        ->from('pengajuan_surat p')
                        ->join('dusun d', 'd.id_dusun = p.dusun_id', 'left')
                        ->order_by('p.id_pengajuan','DESC')
                        ->get()
                        ->result();
    }

    public function get_pengajuan($id) {
        return $this->db->get_where('pengajuan_surat', ['id_pengajuan' => $id])->row();
    }

    public function update_pengajuan($id, $data) {
        return $this->db->where('id_pengajuan', $id)
                        ->update('pengajuan_surat', $data);
    }

    public function get_template($jenis_surat, $dusun_id) {
        return $this->db->get_where('template_surat', [
            'jenis_surat' => $jenis_surat,
            'dusun_id' => $dusun_id
        ])->row();
    }
}
