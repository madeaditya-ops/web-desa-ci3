<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 * @property CI_Upload $upload
 * @property CI_Email $email
 * @property CI_Input $input
 * @property Pengaduan_model $Pengaduan_model
 */


use Dompdf\Dompdf;

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

        if ($this->session->flashdata('trigger_email') == $id_pengaduan) {
            $this->session->keep_flashdata('success');
            $this->sendEmailNotification($id_pengaduan);
        }

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

        $this->session->set_flashdata('success', $message);
        $this->session->set_flashdata('trigger_email', $id); 

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

        $this->session->set_flashdata('success', 'Pengaduan berhasil diselesaikan');
        $this->session->set_flashdata('trigger_email', $id); 

        redirect('pengaduan_kades/detail/'.$id);
    }

    private function sendEmailNotification($id)
    {
        $pengaduan = $this->Pengaduan_model->get_by_id($id);
        if (!$pengaduan) return;

        if(empty($pengaduan->email_pelapor)) {
            return;
        }

        $data_email = [
            'nama_pelapor' => $pengaduan->nama_pelapor,
            'deskripsi'    => $pengaduan->deskripsi,
            'status'       => $pengaduan->status,
            'keterangan'   => $pengaduan->keterangan_verifikasi
        ];

        $subjects = [
            'diproses' => 'Pengaduan Anda Sedang Diproses',
            'ditolak'  => 'Pengaduan Anda Ditolak',
            'selesai'  => 'Pengaduan Anda Telah Selesai'
        ];
        $subject = $subjects[$pengaduan->status] ?? 'Update Status Pengaduan';

        $message = $this->load->view('email/pengaduan_status', $data_email, TRUE);

        $this->email->from('no-reply@desablahbatuh.site', 'Sistem Pengaduan Desa');
        $this->email->to($pengaduan->email_pelapor);
        $this->email->subject($subject);
        $this->email->message($message);

        if ($pengaduan->status == 'selesai' && !empty($pengaduan->foto_tindaklanjut)) {
            $file_path = FCPATH.'uploads/pengaduan_tindaklanjut/'.$pengaduan->foto_tindaklanjut;
            if (file_exists($file_path)) $this->email->attach($file_path);
        }

        if (!$this->email->send()) {
            echo $this->email->print_debugger();
            die(); // Hentikan proses untuk melihat error-nya
        }


        $this->email->clear(TRUE);
    }


    public function arsip()
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $data['pengaduan'] = $this->Pengaduan_model->get_arsip($start_date, $end_date);
        $this->load->view('template_admin/header');
        $this->load->view('template_admin/sidebar');
        $this->load->view('kades/pengaduan/arsip', $data);
        $this->load->view('template_admin/footer');
    }

    public function export_excel()
    {
        $start_date = $this->input->get('start_date');
        $end_date   = $this->input->get('end_date');

        $data['pengaduan'] = $this->Pengaduan_model->get_arsip($start_date, $end_date);
        $data['start_date'] = $start_date; 
        $data['end_date']   = $end_date;   

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=arsip_pengaduan.xls");

        $this->load->view('kades/pengaduan/arsip_excel', $data);
    }

    
    public function export_pdf()
    {
        $start_date = $this->input->get('start_date');
        $end_date   = $this->input->get('end_date');

        $data['pengaduan'] = $this->Pengaduan_model->get_arsip($start_date, $end_date);
        $data['start_date'] = $start_date;
        $data['end_date']   = $end_date;

        $html = $this->load->view('kades/pengaduan/arsip_pdf', $data, true);

        require_once FCPATH . 'vendor/autoload.php';
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $filename = "arsip_pengaduan_".$start_date."_sd_".$end_date.".pdf";
        $dompdf->stream($filename, ["Attachment" => true]);
    }




}

