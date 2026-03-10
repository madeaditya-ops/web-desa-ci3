<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApbdesGrafik_model extends CI_Model
{
    private $anggaran  = 'apbdes_anggaran';
    private $realisasi = 'apbdes_realisasi';


    public function get_pendapatan($tahun)
    {
        return (int) $this->db
            ->select_sum('jumlah')
            ->where('tahun', $tahun)
            ->where('kategori', 'pendapatan')
            ->get($this->anggaran)
            ->row()->jumlah;
    }

    public function get_anggaran_belanja($tahun)
    {
        return (int) $this->db
            ->select_sum('jumlah')
            ->where('tahun', $tahun)
            ->where('kategori', 'belanja')
            ->get($this->anggaran)
            ->row()->jumlah;
    }

    public function get_realisasi_belanja($tahun)
    {
        return (int) $this->db
            ->select_sum('r.jumlah')
            ->from($this->realisasi.' r')
            ->join($this->anggaran.' a','a.id = r.anggaran_id')
            ->where('a.tahun', $tahun)
            ->where('a.kategori', 'belanja')
            ->get()
            ->row()->jumlah;
    }


    public function get_rincian($tahun)
    {
        return $this->db
            ->where('tahun', $tahun)
            ->order_by('kategori','ASC')
            ->order_by('bidang','ASC')
            ->get($this->anggaran)
            ->result();
    }


    public function get_chart_data($tahun)
    {
        return [
            'pendapatan' => $this->get_pendapatan($tahun),
            'belanja'    => $this->get_anggaran_belanja($tahun),
            'realisasi'  => $this->get_realisasi_belanja($tahun),
            'silpa'       => $this->get_silpa($tahun),
        ];
    }

        public function get_silpa($tahun)
    {
        $pendapatan = $this->get_pendapatan($tahun);
        $realisasi  = $this->get_realisasi_belanja($tahun);

        return max($pendapatan - $realisasi, 0);
    }

    public function get_rincian_realisasi($tahun)
    {
        return $this->db
            ->select('
                a.bidang,
                a.uraian,
                a.sumber_dana,
                r.tanggal,
                r.jumlah,
                r.keterangan
            ')
            ->from('apbdes_realisasi r')
            ->join('apbdes_anggaran a', 'a.id = r.anggaran_id')
            ->where('a.tahun', $tahun)
            ->order_by('a.bidang ASC, r.tanggal ASC')
            ->get()
            ->result();
    }


}
