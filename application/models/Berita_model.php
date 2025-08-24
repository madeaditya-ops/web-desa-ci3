<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita_model extends CI_Model {
    public function get_latest_berita($limit = 8) {
        return $this->db
                    ->order_by('id_berita', 'DESC')
                    ->limit($limit)
                    ->get('berita')
                    ->result_array();
    }

}

