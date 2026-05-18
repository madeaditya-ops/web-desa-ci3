<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper('url');
         $this->load->model('Warga_model');
         $this->load->model('Keluarga_model');
         $this->load->model('Template_surat_model');
         $this->load->model('Potensi_model');
            $this->load->model('Galeri_model');
    }

    public function index()
    {
        $dusun_id = $this->session->userdata('dusun_id') ?: null;
         $this->load->model('Warga_model');
         $this->load->model('Keluarga_model');
            $this->load->model('Template_surat_model');

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
        $data['count_templates'] = $countTable('template_surat');
        $data['count_warga']     = $countTable('warga', $dusun_id);
        $data['count_keluarga']  = $countTable('keluarga', $dusun_id);
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

        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/dashboard', $data);
        $this->load->view('template_admin/footer');
    }
}
