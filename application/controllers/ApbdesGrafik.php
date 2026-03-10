<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApbdesGrafik extends CI_Controller {

    public function index()
    {
        $tahun = $this->input->get('tahun') ?? date('Y');
        $this->load->model('ApbdesGrafik_model');

        $data = [
            'tahun' => $tahun,
            'total_anggaran' => (int) $this->ApbdesGrafik_model->total_anggaran_belanja($tahun),
            'total_realisasi' => (int) $this->ApbdesGrafik_model->total_realisasi_belanja($tahun),
            'rincian' => $this->ApbdesGrafik_model->rincian_belanja($tahun)
        ];

        $this->load->view('apbdes/index', $data);
    }
}
