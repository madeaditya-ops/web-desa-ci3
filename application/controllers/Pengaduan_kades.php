<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Upload $upload
 * @property CI_Email $email
 * @property Pengaduan_model $Pengaduan_model
 */


class Pengaduan_kades extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pengaduan_model');
        $this->load->library(['upload','email', 'session']);

    }

    
    public function index()
    {
        $data['pengaduan'] = $this->Pengaduan_model->get_all();
        $data['count_pending'] = $this->Pengaduan_model->count_pending();
        $data['count_diproses'] = $this->Pengaduan_model->count_diproses();
        $data['count_ditolak'] = $this->Pengaduan_model->count_ditolak();
        $data['count_selesai'] = $this->Pengaduan_model->count_selesai();
        $data['total_pengaduan'] = $this->Pengaduan_model->total_pengaduan();
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/pengaduan/index', $data);
        $this->load->view('template_admin/footer');
    }

    public function detail($id_pengaduan)
    {
        $data['pengaduan'] = $this->Pengaduan_model->get_by_id($id_pengaduan);
        $this->Pengaduan_model->read_single_notifikasi($id_pengaduan);
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/pengaduan/detail', $data);
        $this->load->view('template_admin/footer');
    }

    //Verifikasi Pengaduan
    public function verifikasi ($id) {
        $pengaduan = $this->Pengaduan_model->get_by_id($id);
        if (!$pengaduan){
            show_404();
        }

        $aksi = $this->input->post('aksi');
        if ($aksi == 'proses') {
            $data = [
                'status' => 'diproses',
            ];

            $message = 'Pengaduan berhasil diverifikasi dan sedang diproses';
        } elseif ($aksi == 'tolak') {
            $data = [
                'status' => 'ditolak',
                'keterangan_verifikasi' => $this->input->post('keterangan_verifikasi')
            ];

            $message = 'Pengaduan berhasil ditolak';

        } else {
            $this->session->set_flashdata('error','Aksi tidak valid');
            redirect('pengaduan_kades/detail/'.$id);
        }
        $this->Pengaduan_model->update($id, $data);

        $this->sendEmailNotification($id);

        $this->session->set_flashdata('success', $message); 

        session_write_close();

        redirect('pengaduan_kades/detail/'.$id);
    }



    //Selesaikan Pengaduan
    public function selesai ($id) {
        $pengaduan = $this->Pengaduan_model->get_by_id($id);
        if (!$pengaduan){
            show_404();
        }
        
        $data = [
            'status' => 'selesai'
        ];
        
        if (!empty($_FILES['foto_tindaklanjut']['name'])) {

        $config['upload_path']   = './uploads/pengaduan_tindaklanjut/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048;
        $config['encrypt_name']  = TRUE;

        $this->upload->initialize($config);

        if ($this->upload->do_upload('foto_tindaklanjut')) {

            $upload_data = $this->upload->data();
            $data['foto_tindaklanjut'] = $upload_data['file_name'];

        } else {
            echo $this->upload->display_errors();
            return;
        }
    }

        $this->Pengaduan_model->update($id, $data);

        $this->sendEmailNotification($id);

        $this->session->set_flashdata(
            'success',
            'Pengaduan berhasil diselesaikan'
        );

        session_write_close();
        redirect('pengaduan_kades/detail/'.$id);
    }

    private function sendEmailNotification($id)
    {
        $pengaduan = $this->Pengaduan_model->get_by_id($id);

        $subject = '';
        $message = '';

        if (empty($subject) || empty($message)) {
            log_message('error', 'Email tidak dikirim karena Subjek/Pesan kosong untuk ID: ' . $id);
            return;
        }
        
        $this->email->from('no-reply@desablahbatuh.site', 'Sistem Pengaduan Desa');
        $this->email->to($pengaduan->email_pelapor);
        


        if ($pengaduan->status == 'diproses') {
            $subject = 'Pengaduan Anda Sedang Diproses';
            $message = "
                Yth. {$pengaduan->nama_pelapor},
                \n\nPengaduan Anda terkait \"{$pengaduan->deskripsi}\" telah diverifikasi dan sedang dalam proses penanganan.
                \n\nTerima kasih telah menggunakan layanan pengaduan desa.
                \n\nHormat kami,\nKantor Desa Blahbatuh";
        } elseif ($pengaduan->status == 'ditolak') {
            $subject = 'Pengaduan Anda Ditolak';
            $message = "
                Yth. {$pengaduan->nama_pelapor},
                \n\nPengaduan Anda terkait \"{$pengaduan->deskripsi}\" telah diverifikasi.
                \n\nNamun, setelah dilakukan pemeriksaan, pengaduan tersebut tidak dapat diproses lebih lanjut dengan alasan berikut:
                \n{$pengaduan->keterangan_verifikasi}
                \n\nHormat kami,\nKantor Desa Blahbatuh";
        } elseif ($pengaduan->status == 'selesai') {
            $subject = 'Pengaduan Anda Telah Selesai';
            $message = "
                Yth. {$pengaduan->nama_pelapor},
                \n\nPengaduan Anda terkait \"{$pengaduan->deskripsi}\" telah selesai ditindaklanjuti.
                \n\nHormat kami,\nKantor Desa Blahbatuh";

            if (!empty($pengaduan->foto_tindaklanjut)) {
                $file_path = FCPATH.'uploads/pengaduan_tindaklanjut/'.$pengaduan->foto_tindaklanjut;
                if (file_exists($file_path)) {
                    $this->email->attach($file_path);
                }
            }
        }



        $this->email->subject($subject);
        $this->email->message($message);
        @$this->email->send(); 


        $this->email->clear(TRUE);
    }




}

