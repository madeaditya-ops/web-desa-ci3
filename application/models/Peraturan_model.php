<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peraturan_model extends CI_Model {
    public function get_all_peraturan() {
    return $this->db
                ->order_by('id_peraturan', 'DESC')
                ->get('peraturan')
                ->result_array();
    }

}
