<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Warga_model extends CI_Model
{

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
        k.no_kk,
        ket.nama_keterangan
    ');
        $this->db->from('warga w');
        $this->db->join('hubungan h', 'w.hubungan_id=h.id', 'left');
        $this->db->join('jenis_kelamin jk', 'w.jenis_kelamin_id=jk.id', 'left');
        $this->db->join('agama a', 'w.agama_id=a.id', 'left');
        $this->db->join('status_perkawinan sp', 'w.status_perkawinan_id=sp.id', 'left');
        $this->db->join('kewarganegaraan kw', 'w.kewarganegaraan_id=kw.id', 'left');
        $this->db->join('pendidikan p', 'w.pendidikan_id=p.id', 'left');
        $this->db->join('keluarga k', 'w.keluarga_id=k.id', 'left');
        $this->db->join('dusun d', 'k.id_dusun=d.id_dusun', 'left');
        $this->db->join('keterangan ket', 'w.id_keterangan = ket.id_keterangan', 'left');

        return $this->db->get()->result();
    }

    public function get_all_warga_admin()
    {
        return $this->db
            ->select('
            warga.nama,
            warga.no_nik,
            warga.tempat_lahir,
            warga.tanggal_lahir,
            warga.pekerjaan,
            jenis_kelamin.nama as jenis_kelamin,
            agama.nama as agama,
            status_perkawinan.nama as status_perkawinan,
            dusun.id_dusun as id_dusun,
            dusun.nama_dusun,
            dusun.kode_dusun
        ')
            ->from('warga')
            ->join('keluarga', 'keluarga.id = warga.keluarga_id')
            ->join('dusun', 'dusun.id_dusun = keluarga.id_dusun')
            ->join('jenis_kelamin', 'jenis_kelamin.id = warga.jenis_kelamin_id', 'left')
            ->join('agama', 'agama.id = warga.agama_id', 'left')
            ->join('status_perkawinan', 'status_perkawinan.id = warga.status_perkawinan_id', 'left')
            ->order_by('warga.nama', 'ASC')
            ->get()
            ->result();
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
