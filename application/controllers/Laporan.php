<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_laporan');
    }
    
    public function index(){
        $laporan = 1;
        $awal = '2017-12-01';
        $akhir = '2018-02-01';
        $tgl_awal = explode('-',$awal);
        $tgl_akhir = explode('-',$akhir);
        $data['tgl_awal'] = $tgl_awal[2].'-'.$tgl_awal[1].'-'.$tgl_awal[0];
        $data['tgl_akhir'] = $tgl_akhir[2].'-'.$tgl_akhir[1].'-'.$tgl_akhir[0];
        $data['opsi_laporan'] = 1;
        if($laporan == 1){
            $data['keluhan'] = $this->m_laporan->laporan_c($awal,$akhir);
            $data['laporan_title'] = 'Semua Keluhan';
        }else if($laporan == 2){
            $data['keluhan'] = $this->m_laporan->laporan_b($awal,$akhir);
            $data['laporan_title'] = 'keluhan Selesai';
        }else if($laporan == 3){
            $data['keluhan'] = $this->m_laporan->laporan_a($awal,$akhir);
            $data['laporan_title'] = 'Keluhan Belum Selesai';
        }
        $this->load->view('laporan/v_laporan_table',$data);
    }
    
    // NOTE : Cetak laporan keluhan by date
    public function laporan(){
        $laporan = $this->input->post('laporan_keluhan');
        $awal = $this->input->post('tgl_awal');
        $akhir = $this->input->post('tgl_akhir');
        $tgl_awal = explode('-',$awal);
        $tgl_akhir = explode('-',$akhir);
        $data['tgl_awal'] = $tgl_awal[2].'-'.$tgl_awal[1].'-'.$tgl_awal[0];
        $data['tgl_akhir'] = $tgl_akhir[2].'-'.$tgl_akhir[1].'-'.$tgl_akhir[0];
        $tgl_awal = $tgl_awal[2].'-'.$tgl_awal[1].'-'.$tgl_awal[0]; 
        $tgl_akhir = $tgl_akhir[2].'-'.$tgl_akhir[1].'-'.$tgl_akhir[0];
         $data['opsi_laporan'] = $this->input->post('laporan_keluhan');   
        if($laporan == 1){
            $data['keluhan'] = $this->m_laporan->laporan_c($awal,$akhir);
            $data['laporan_title'] = 'Semua Keluhan';
        }else if($laporan == 2){
            $data['keluhan'] = $this->m_laporan->laporan_b($awal,$akhir);
            $data['laporan_title'] = 'keluhan Selesai';
        }else if($laporan == 3){
            $data['keluhan'] = $this->m_laporan->laporan_a($awal,$akhir);
            $data['laporan_title'] = 'Keluhan Belum Selesai';
        }

        ob_start();
        $this->load->view('laporan/v_laporan_table',$data);
        $html = ob_get_contents();
//        $html = $this->load->view('laporan/v_laporan_table',$data);
        ob_end_clean(); 
        

        $pdfFilePath = 'Data Laporan Keluhan '.$tgl_awal.'-'.$tgl_akhir.'.pdf';
             
        require_once APPPATH. '/vendor/autoload.php';

        try {
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->debug = true;
            $mpdf->AddPage('L');
            
            $mpdf->WriteHTML($html);
        
            $mpdf->Output($pdfFilePath, "D");
        }catch (\Mpdf\MpdfException $e) { // Note: safer fully qualified exception 
            echo $e->getMessage();
        }
    }
}
