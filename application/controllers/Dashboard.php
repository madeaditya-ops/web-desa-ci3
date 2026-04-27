<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 * @property CI_Session $session
 * 
 * @property Pengaduan_model $Pengaduan_model
 */


class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();   
        $this->load->database();
        $this->load->library('session');
        $this->load->model('Pengaduan_model');
        $this->load->helper('formatHariJam_helper');
        
    }

    public function index()
    {

        $dusun_id = $this->session->userdata('dusun_id') ?: null;

        // helper untuk hitung tabel dengan opsi filter dusun jika field ada
        $countTable = function($table, $dusun_id = null) {
            if ($dusun_id && $this->db->field_exists('dusun_id', $table)) {
                return (int) $this->db->where('dusun_id', $dusun_id)->count_all_results($table);
            }
            // fallback count all jika tidak ada field dusun_id atau tidak diberikan
            if ($this->db->table_exists($table)) {
                return (int) $this->db->count_all($table);
            }
            return 0;
        };

        // Hitung data utama
        $data['count_templates'] = $countTable('template_surat', $dusun_id);
        $data['count_potensi']   = $countTable('potensi', $dusun_id);
        $data['count_galeri']    = $countTable('galeri', $dusun_id);
        $data['count_peraturan'] = $countTable('peraturan', $dusun_id);
        $data['count_apbdes']    = $countTable('apbdes', $dusun_id);
        $data['count_berita']    = $countTable('berita', $dusun_id);
        $data['count_aparatur']  = $countTable('aparatur', $dusun_id);
        $data['count_arsip']     = $countTable('arsip_surat', $dusun_id);

        // Grafik: arsip surat 7 hari terakhir (tanggal dan jumlah)
        $labels = [];
        $values = [];
        $period = 6; // 0..6 = 7 hari
        for ($i = $period; $i >= 0; $i--) {
            $d = date('Y-m-d', strtotime("-{$i} days"));
            $labels[] = date('d M', strtotime($d));
            if ($this->db->table_exists('arsip_surat')) {
                $q = $this->db
                    ->select('COUNT(*) as cnt')
                    ->where('DATE(created_at)', $d)
                    ->get('arsip_surat')
                    ->row();
                $values[] = (int)($q->cnt ?? 0);
            } else {
                $values[] = 0;
            }
        }
        $data['chart_labels'] = $labels;
        $data['chart_values'] = $values;

        
        $data = array_merge($data, $this->_get_chart_kategori());
        $data['rata_rata_waktu'] = $this->Pengaduan_model->get_rata_rata_waktu();
        $data = array_merge($data, $this->_get_bar_pengaduan());
        

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/dashboard', $data);
        $this->load->view('template_admin/footer');
    }

    private function _get_chart_kategori()
    {
        $tahun = date('Y');

        $data_kategori = $this->Pengaduan_model->get_kategori_chart($tahun);

        $warna_kategori = [
            'Infrastruktur' => '#FF5733',
            'Pelayanan Administrasi' => '#007bff',
            'Lingkungan & Kesehatan' => '#28a745',
            'Sosial & Kesejahteraan' => '#ffc107',
            'Keamanan & Ketertiban' => '#dc3545',
            'Penyalahgunaan Wewenang' => '#6f42c1',
            'Lainnya' => '#6c757d'
        ];

        $labels = [];
        $values = [];
        $colors = [];

        foreach ($data_kategori as $row) {
            $labels[] = $row->nama_kategori;
            $values[] = (int)$row->total;
            $colors[] = $warna_kategori[$row->nama_kategori] ?? '#999999';
        }

        return [
            'pie_labels' => json_encode($labels),
            'pie_data'   => json_encode($values),
            'pie_colors' => json_encode($colors),
            'tahun'        => $tahun
        ];
        
    }

    private function _get_bar_pengaduan()
    {
        $tahun = date('Y');
        $result = $this->Pengaduan_model->get_pengaduan_per_bulan($tahun);

        // Inisialisasi 12 bulan = 0
        $data_bulanan = array_fill(1, 12, 0);

        foreach ($result as $row) {
            $data_bulanan[(int)$row->bulan] = (int)$row->total;
        }

        // Label bulan
        $labels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

        return [
            'bar_labels' => json_encode($labels),
            'bar_data'   => json_encode(array_values($data_bulanan)),
            'tahun_bar'  => $tahun
        ];
    }






    public function get_notifikasi(){

        $data = $this->Pengaduan_model->get_notifikasi();
        $jumlah = $this->Pengaduan_model->count_notifikasi();
        $last_id = $this->Pengaduan_model->get_last_pengaduan_id();

        echo json_encode([
            'jumlah' => $jumlah,
            'data' => $data,
            'last_id' => $last_id
        ]);

    }

    public function read_notifikasi(){
        $this->Pengaduan_model->read_notifikasi();

    }

    public function read_single_notifikasi($id_pengaduan){
        $this->Pengaduan_model->read_single_notifikasi($id_pengaduan);

        echo json_encode([
            'status' => 'ok'
        ]);
    }

}
