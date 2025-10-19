<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Potensi_model extends CI_Model {
    public function get_all()
    {
        return $this->db->select('*')
                        ->from('potensi')
                        ->order_by('id_potensi', 'DESC')
                        ->get()
                        ->result_array();
    }

    // public function get_by_kategori($kategori) {
    //     $this->db->where('kategori', $kategori);
    //     return $this->db->get('potensi')->result_array();
    // }

}
