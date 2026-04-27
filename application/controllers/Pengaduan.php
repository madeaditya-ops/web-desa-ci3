<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Upload $upload
 * @property CI_Config $config
 * @property CI_Form_validation $form_validation
 * @property CI_Email $email
 * @property Pengaduan_model $Pengaduan_model
 */

class Pengaduan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pengaduan_model');
        $this->load->library(['form_validation','session','email']);
        $this->load->helper(['url','geo','form']);
        date_default_timezone_set('Asia/Makassar');
    }

    public function index()
    {
        $data['title'] = "Pengaduan Masyarakat Desa Blahbatuh";
        $data['turnstile_site_key'] = $this->config->item('turnstile_site_key');
        $data['kategori_pengaduan'] = $this->Pengaduan_model->get_kategori_pengaduan();
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('landing/pengaduan');
        $this->load->view('template/footer');
    }

    public function word_limit($str)
    {
        if (str_word_count(strip_tags($str)) > 80) {
            $this->form_validation->set_message(
                'word_limit',
                'Deskripsi maksimal 80 kata.'
            );
            return FALSE;
        }

        return TRUE;
    }


    public function validasi_teks($str)
    {
        // Tolak jika huruf yang sama berulang lebih dari 3 kali
        if (preg_match('/(.)\1{3,}/', $str)) {
            $this->form_validation->set_message(
                'validasi_teks',
                'Teks mengandung huruf berulang yang tidak wajar.'
            );
            return FALSE;
        }

        // Tolak jika tidak mengandung minimal 1 vokal
        if (!preg_match('/[aiueoAIUEO]/', $str)) {
            $this->form_validation->set_message(
                'validasi_teks',
                'Teks harus mengandung kata yang jelas.'
            );
            return FALSE;
        }

        // Hitung rasio vokal terhadap total huruf
        $huruf = preg_replace('/[^a-zA-Z]/', '', $str);
        $jumlahHuruf = strlen($huruf);

        if ($jumlahHuruf > 0) {
            $jumlahVokal = preg_match_all('/[aiueoAIUEO]/', $huruf);
            $rasio = $jumlahVokal / $jumlahHuruf;

            // Jika rasio vokal terlalu kecil (<20%), kemungkinan random
            if ($rasio < 0.2) {
                $this->form_validation->set_message(
                    'validasi_teks',
                    'Teks tidak terdeteksi sebagai kalimat yang valid.'
                );
                return FALSE;
            }
        }

        // Tambahan validasi: tolak jika teks panjang tapi hanya satu kata tanpa spasi
        if ($jumlahHuruf > 10 && !preg_match('/\s/', $str)) {
            $this->form_validation->set_message(
                'validasi_teks',
                'Teks terlalu acak dan tidak membentuk kata yang jelas.'
            );
            return FALSE;
        }

        return TRUE;
    }




    public function store()
    {
        $this->form_validation->set_rules(
            'nama_pelapor',
            'Nama',
            'required|max_length[100]|regex_match[/^[a-zA-Z\s]+$/]',
            [
                'required'    => 'Nama wajib diisi.',
                'max_length'  => 'Nama maksimal 100 karakter.',
                'regex_match' => 'Nama hanya boleh huruf dan spasi, tanpa angka atau simbol.'
            ]
        );
        $this->form_validation->set_rules(
            'email_pelapor',
            'Email',
            'valid_email|max_length[100]',
            [
                'valid_email' => 'Format email tidak valid.',
                'max_length'  => 'Email maksimal 100 karakter.'
            ]
        );
        $this->form_validation->set_rules(
            'kategori_pengaduan',
            'Kategori Pengaduan',
            'required|in_list[' . implode(',', array_column($this->Pengaduan_model->get_kategori_pengaduan(), 'id_kategori')) . ']',
            [
                'required' => 'Kategori pengaduan wajib dipilih.',
                'in_list'  => 'Kategori pengaduan tidak valid.'
            ]
        );
        $this->form_validation->set_rules(
            'deskripsi',
            'Deskripsi',
            'required|max_length[500]|callback_word_limit|callback_validasi_teks',
            [
                'required'   => 'Deskripsi wajib diisi.',
                'max_length' => 'Deskripsi maksimal 500 karakter.',
            ]
        );
        $this->form_validation->set_rules('latitude','Latitude','required');
        $this->form_validation->set_rules('longitude','Longitude','required');
        $this->form_validation->set_rules('lokasi_pengaduan','Lokasi','required');

        if ($this->form_validation->run() === FALSE) {

            $this->session->set_flashdata('errors', $this->form_validation->error_array());
            $this->session->set_flashdata('old', $this->input->post());

            redirect('pengaduan');
        }


        // VALIDASI TURNSTILE

        $turnstileResponse = $this->input->post('cf-turnstile-response');

        if (!$this->verifyTurnstile($turnstileResponse)) {
            $this->session->set_flashdata(
                'error',
                'Verifikasi CAPTCHA gagal. Silakan coba lagi.'
            );
            redirect('pengaduan');
        }

  
        // VALIDASI LOKASI 
        $lat = (float) $this->input->post('latitude');
        $lng = (float) $this->input->post('longitude');

        if (!$this->validateLocation($lat, $lng)) {
             $this->session->set_flashdata( 'error', 'Pengaduan gagal. Lokasi berada di luar wilayah Desa Blahbatuh.' ); 
             redirect('pengaduan'); 
        }


        // UPLOAD FOTO
        $config = [
            'upload_path'   => './uploads/pengaduan/',
            'allowed_types' => 'jpg|jpeg|png',
            'max_size'      => 2048,
            'encrypt_name'  => TRUE
        ];

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('foto_bukti')) {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('pengaduan');
        }

        $file = $this->upload->data('file_name');
        $nama = $this->input->post('nama_pelapor', true);
        $email = $this->input->post('email_pelapor', true);
        $email = $email ? strtolower($email) : null;
        $deskripsi = $this->input->post('deskripsi', true);

        $data = [
            'nama_pelapor'  => ucwords(strtolower($nama)),
            'email_pelapor' => strtolower($email),
            'id_kategori'   => $this->input->post('kategori_pengaduan', true),
            'deskripsi'     => ucfirst(strtolower($deskripsi)),
            'lokasi_pengaduan' => $this->input->post('lokasi_pengaduan', true),
            'latitude'         => $lat,
            'longitude'        => $lng,
            'foto_bukti'       => $file,
            'created_at'       => date('Y-m-d H:i:s'),
            'is_read'       => 0
        ];

        $this->Pengaduan_model->insert($data);

        // Kirim notifikasi ke email desa
        $this->sendEmailNotification($data, $file);

        $this->session->set_flashdata(
            'success',
            'Pengaduan berhasil dikirim'
        );
        

        redirect('pengaduan');
        
    }




    private function verifyTurnstile($turnstileResponse)
    {
        if (!$turnstileResponse) {
            return false;
        }

        $secretKey = $this->config->item('turnstile_secret_key');


        $postData = http_build_query([
            'secret'   => $secretKey,
            'response' => $turnstileResponse,
        ]);

        

        $context = stream_context_create([
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'content' => $postData,
                'timeout' => 10
            ]
        ]);

        $result = file_get_contents(
            "https://challenges.cloudflare.com/turnstile/v0/siteverify",
            false,
            $context
        );

        if ($result === FALSE) {
            return false;
        }

        $response = json_decode($result);

        return (isset($response->success) && $response->success === true);
    }

    private function validateLocation($lat, $lng)
    {
        $geojson = json_decode(
            file_get_contents(FCPATH.'assets/geojson/kelurahan.geojson'),
            true
        );

        foreach ($geojson['features'] as $feature) {
            if ($feature['properties']['nm_kelurahan'] !== 'Blahbatuh') {
                continue;
            }

            $geometry = $feature['geometry'];

            if ($geometry['type'] === 'MultiPolygon') {
                foreach ($geometry['coordinates'] as $polygon) {
                    $outerRing = $polygon[0];
                    $cleanPolygon = array_map(function($coord) {
                        return [$coord[0], $coord[1]]; // [lng, lat]
                    }, $outerRing);

                    if (pointInPolygon($lng, $lat, $cleanPolygon)) {
                        return true;
                    }
                }
            } elseif ($geometry['type'] === 'Polygon') {
                $outerRing = $geometry['coordinates'][0];
                $cleanPolygon = array_map(function($coord) {
                    return [$coord[0], $coord[1]];
                }, $outerRing);

                if (pointInPolygon($lng, $lat, $cleanPolygon)) {
                    return true;
                }
            }
        }

        return false;
    }




    private function sendEmailNotification($data, $file)
    {
        $this->email->from('no-reply@desablahbatuh.site', 'Sistem Pengaduan Desa');
        $this->email->to('vdwipayanti@gmail.com');
        $this->email->subject('Pengaduan Baru Masuk');

        $email_data = [
            'nama'      => $data['nama_pelapor'],
            'email'     => $data['email_pelapor'],
            'lokasi'    => $data['lokasi_pengaduan'],
            'deskripsi' => $data['deskripsi'],
            'tanggal'   => $data['created_at'],

        ];

        $message = $this->load->view('email/pengaduan_notification', $email_data, TRUE);

        $this->email->message($message);

        if (!empty($file)) {
            $this->email->attach(FCPATH.'uploads/pengaduan/'.$file);
        }

        $this->email->send(); 
        $this->email->clear(TRUE);

    }
}


