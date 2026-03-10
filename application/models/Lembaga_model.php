<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lembaga_model extends CI_Model {

    public function get_all_lembaga()
    {
        return $this->db
                    ->order_by('id', 'ASC')
                    ->get('lembaga')
                    ->result_array();
    }

    public function get_lembaga_by_id($id)
    {
        return $this->db
                    ->where('id', $id)
                    ->get('lembaga')
                    ->row_array();
    }




    public function get_lembaga_by_slug($slug)
    {
        return $this->db
                    ->where('slug', $slug)
                    ->get('lembaga')
                    ->row_array();
    }

    public function get_anggota_by_lembaga($lembaga_id)
    {
        return $this->db
                    ->where('lembaga_id', $lembaga_id)
                    ->where('status', 'aktif')
                    ->order_by('urutan', 'ASC')
                    ->get('anggota_lembaga')
                    ->result_array();
    }

    public function get_anggota_by_id($id){
        return $this->db
                    ->where('id', $id)
                    ->get('anggota_lembaga')
                    ->row_array();
    }


    public function get_anggota_by_slug($slug)
    {
        return $this->db
                    ->select('anggota_lembaga.*')
                    ->from('anggota_lembaga')
                    ->join('lembaga', 'lembaga.id = anggota_lembaga.lembaga_id')
                    ->where('lembaga.slug', $slug)
                    ->where('anggota_lembaga.status', 'aktif')
                    ->order_by('urutan', 'ASC')
                    ->get()
                    ->result_array();
    }

    public function get_bidang_by_slug($slug)
    {
        $this->db->select('lembaga_bidang.*');
        $this->db->from('lembaga_bidang');
        $this->db->join('lembaga', 'lembaga.id = lembaga_bidang.lembaga_id');
        $this->db->where('lembaga.slug', $slug);
        $this->db->order_by('lembaga_bidang.urutan', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_bidang_by_lembaga($lembaga_id)
    {
        return $this->db
                    ->where('lembaga_id', $lembaga_id)
                    ->order_by('urutan', 'ASC')
                    ->get('lembaga_bidang')
                    ->result_array();
    }

    public function get_bidang_by_id($id){
        return $this->db
                    ->where('id', $id)
                    ->get('lembaga_bidang')
                    ->row_array();
    }

    public function insert_lembaga($data)
    {
        return $this->db->insert('lembaga', $data);
    }

    public function update_lembaga($id, $data)
    {
        return $this->db->where('id', $id)->update('lembaga', $data);
    }

    public function delete_lembaga($id)
    {
        return $this->db->delete('lembaga', ['id' => $id]);
    }

    public function get_next_urutan($table, $lembaga_id)
    {
        $this->db->select_max('urutan');
        $this->db->where('lembaga_id', $lembaga_id);
        $query = $this->db->get($table);

        $result = $query->row_array();

        if ($result['urutan'] == null) {
            return 1;
        }

        return $result['urutan'] + 1;
    }



    public function insert_anggota_lembaga($data)
    {
        return $this->db->insert('anggota_lembaga', $data);
    }

    public function update_anggota_lembaga($id, $data)
    {
        return $this->db->where('id', $id)->update('anggota_lembaga', $data);
    }

    public function reset_urutan($table, $lembaga_id)
    {
        $data = $this->db
                    ->where('lembaga_id', $lembaga_id)
                    ->order_by('urutan', 'ASC')
                    ->get($table)
                    ->result_array();

        $no = 1;
        foreach ($data as $row) {
            $this->db->where('id', $row['id'])
                    ->update($table, ['urutan' => $no++]);
        }
    }



    public function delete_anggota($id)
    {
        return $this->db->delete('anggota_lembaga', ['id' => $id]);
    }

    public function insert_bidang_lembaga($data){
        return $this->db->insert('lembaga_bidang', $data);
    }

    public function update_bidang_lembaga($id, $data){
        return $this->db->where('id', $id)->update('lembaga_bidang', $data);
    }

    public function delete_bidang_lembaga($id){
        return $this->db->delete('lembaga_bidang', ['id' => $id]);
    }

    

}
