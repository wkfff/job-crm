<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TabelComplain extends CI_Controller {
 
    function __construct(){
        parent::__construct();
        $this->load->model('serverProcessing/m_tabel_complain');
    }
  
    function get_data()
    {
        $fetch_data = $this->m_tabel_complain->get_datatables();
        $data = array(); 
        $no = $_POST['start'];
        $kapal ='-';
        $i = 1;
        foreach($fetch_data as $row)  
        { 
            if($row->status == '3' && $this->session->userdata('userlevel') == '1'){
                
            }else{
            $sub_array = array();  
            $sub_array[] = $row->tiket;
            $sub_array[] = $row->userid;
            $sub_array[] = $row->nama;
            $sub_array[] = substr($row->tgl_komplain,0,16);
            $sub_array[] = $row->cabang;
            
            $plus ='';
            $diff = $row->dif;
            $dif = $row->dif;
            if($diff < 0 ){
                $diff = 1;
                
                $dif = $row->dif*-1;
                $str = '+'.$dif.' hari';
            }else if ( $diff == 0){
                $diff = 1;
                $str = 'deadline';
            }else{
                $str = $dif.' hari';
            }

            $batas = 100/$diff;

            if($batas <= 40){
                $bar = 'progress-bar-info progress-bar-striped active';
            }else if ($batas <=70){
                $bar = 'progress-bar-warning progress-bar-striped active';
            }else{
                $bar = 'progress-bar-danger progress-bar-striped active';
            }

            $sub_array[] = $row->kategori;
            $sub_array[] = ' <div class="progress">
                                <div class="progress-bar '.$bar.'" role="progressbar" 
                                    aria-valuemin="0" aria-valuemax="100" style="width:'. $batas .'%">
                                    '.$str.'
                                </div>
                            </div> ';
            $status = $this->status($row->status);
            $sub_array[] = $status;
//            $btn1 = '<button class="btn btn-danger " onclick="complain_del('.$row->id_komplain.')"><i class="fa fa-trash"></i></button>';
            $btn1 = '';

            if($this->session->userdata('userlevel') != 0){
                $btn1 ='';
            }

            $sub_array[] = $btn1.'<button class="btn btn-info " onclick="complain_detail('.$row->id_komplain.')"><i class="fa fa-search"></i></button>';

            $i++;

            $data[] = $sub_array;
            }
        }
            $output = array(  
                "draw" => $_POST['draw'], 
                "recordsTotal" => $this->m_tabel_complain->count_all(), 
                "recordsFiltered" => $this->m_tabel_complain->count_filtered(), 
                "data" => $data, ); //output dalam format JSON   
            
        echo json_encode($output); } 
    
    function status($val){
        $res = "";
        switch ($val) {
            case '0':
                $res = "Dikirim ke Cabang";
                break;
            case '1':
                $res = "Diterima oleh Cabang";
                break;
            case '2':
                $res = "Ditindaklanjuti oleh Cabang";
                break;
            case '3':
                $res = "Disampaikan ke Pengguna Jasa";
                break;
            case '4':
                $res = "Tidak Ditindaklanjuti";
                break;
            case '5':
                $res = "Selesai";
                break;
            default:
                # code...
                break;
        }
        return $res;
    }

}


