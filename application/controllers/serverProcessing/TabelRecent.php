<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TabelRecent extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('serverProcessing/m_tabel_recent');
    }
  
    function get_data($id)
    {
        $fetch_data = $this->m_tabel_recent->get_datatables($id);

        $data = array();
        $i = 1;
        foreach($fetch_data as $row)  
        {
            $sub_array = array();  
//            $sub_array[] = $i;
            $sub_array[] = $row->tgl_berangkat;
            if($row->kendaraan == 'Tidak Berkendara'){
                $sub_array[] = 'Penumpang';
            }else{
                $sub_array[] = $row->alias;
            }
            $sub_array[] = $row->asal."-".$row->tujuan;
//            $sub_array[] = $row->tujuan;
            $sub_array[] = $row->jarak;
            $sub_array[] = $row->poin;

            $i++;

            $data[] = $sub_array;
        }
            $output = array(  
                "draw" => $_POST['draw'], 
                "recordsTotal" => $this->m_tabel_recent->count_all(), 
                "recordsFiltered" => $this->m_tabel_recent->count_filtered(), 
                "data" => $data, ); //output dalam format JSON  
           echo json_encode($output);} 
}