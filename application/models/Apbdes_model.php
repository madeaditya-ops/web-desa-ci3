<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apbdes_model extends CI_Model {
    public function get_tahun_dropdown($namafield)
    {
    $this->db->select('tahun');
    $query = $this->db->get('apbdes');

    $data = [" " => "--Pilih Tahun--"];
    foreach ($query->result() as $row) {
        $data[$row->tahun] = $row->tahun;
    }

    return form_dropdown($namafield, $data, "", "class='form-control form-custom' id='" . $namafield . "'");
    }

    public function get_judul_dropdown($namafield, $tahun = null)
    {
    if ($tahun) {
        $this->db->where('tahun', $tahun);
    }
    $query = $this->db->get('apbdes');

    $data = [" " => "--Pilih Judul--"];
    foreach ($query->result() as $row) {
        $data[$row->judul] = $row->judul;
    }

    return form_dropdown($namafield, $data, "", "class='form-control form-custom' id='" . $namafield . "'");
    }

    public function get_apbdes_by_tahun_judul($tahun, $judul)
    {
    $this->db->where('tahun', $tahun);
    $this->db->where('judul', $judul);
    $query = $this->db->get('apbdes');

    return $query->result();
    }



}
