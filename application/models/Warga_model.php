<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warga_model extends CI_Model {

   public function get_all()
{
    $this->db->select('w.*,
        h.nama as hubungan,
        jk.nama as jenis_kelamin,
        a.nama as agama,
        sp.nama as status_perkawinan,
        kw.nama as kewarganegaraan,
        p.nama as pendidikan,
        d.nama_dusun,
        k.no_kk
    ');
    $this->db->from('warga w');
    $this->db->join('hubungan h','w.hubungan_id=h.id', 'left');
    $this->db->join('jenis_kelamin jk','w.jenis_kelamin_id=jk.id', 'left');
    $this->db->join('agama a','w.agama_id=a.id', 'left');
    $this->db->join('status_perkawinan sp','w.status_perkawinan_id=sp.id', 'left');
    $this->db->join('kewarganegaraan kw','w.kewarganegaraan_id=kw.id', 'left');
    $this->db->join('pendidikan p','w.pendidikan_id=p.id', 'left');
    $this->db->join('keluarga k','w.keluarga_id=k.id', 'left');
    $this->db->join('dusun d','k.id_dusun=d.id_dusun', 'left');

    return $this->db->get()->result();
}

  public function get_by_id($id)
{
    $this->db->select('w.*');
    $this->db->from('warga w');
    $this->db->where('w.id', $id);
    return $this->db->get()->row();
}

    public function insert($data)
    {
        return $this->db->insert('warga', $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update('warga', $data);
    }

    public function delete($id)
    {
        return $this->db->delete('warga', ['id' => $id]);
    }
}
