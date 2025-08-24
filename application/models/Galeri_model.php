<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Galeri_model extends CI_Model {
    public function get_latest_galeri($limit = 6) {
        return $this->db
                    ->order_by('id_galeri', 'DESC')
                    ->limit($limit)
                    ->get('galeri')
                    ->result_array();
    }
}