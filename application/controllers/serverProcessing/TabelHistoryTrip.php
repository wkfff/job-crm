<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TabelHistoryTrip extends CI_Controller {
 
    function __construct(){
        parent::__construct();
        $this->load->model('serverProcessing/m_tabel_history_trip');
    }
  
    function get_data($id)
    {
        $fetch_data = $this->m_tabel_history_trip->get_datatables($id);

        $data = array();
        $i = 1;
        foreach($fetch_data as $row)  
        {
            $sub_array = array();   
            $sub_array[] = $i;
            $sub_array[] = $row->nama_asal; 
            $sub_array[] = $row->nama_tujuan;
            $sub_array[] = $row->tgl_berangkat;
            $sub_array[] = $row->kendaraan;
            $sub_array[] = $row->golongan;
            $sub_array[] = $row->penumpang;
            $sub_array[] = $row->penumpang_bayi;
            $sub_array[] = '<button class="btn btn-danger " onclick="perjalanan_del('.$row->id_perjalanan.','.$row->id_customer.','.$row->id_pelabuhan_asal.','.$row->id_pelabuhan_tujuan.')"><i class="fa fa-trash-o"></i></button>';

            $i++;

            $data[] = $sub_array;
        }
            $output = array(  
                "draw" => $_POST['draw'], 
                "recordsTotal" => $this->m_tabel_history_trip->count_all($id), 
                "recordsFiltered" => $this->m_tabel_history_trip->count_filtered(), 
                "data" => $data, ); //output dalam format JSON  
           echo json_encode($output);} 
    
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


