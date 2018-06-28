<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TabelArsip extends CI_Controller {
 
    function __construct(){
        parent::__construct();
        $this->load->model('serverProcessing/m_tabel_arsip');
    }
  
    function get_data($cabang,$area,$kategori)
    {
        $fetch_data = $this->m_tabel_arsip->get_datatables($cabang,$area,$kategori);
        $data = array();  
        $no = $_POST['start'];
        $kapal ='-';
        $i = 1;
        foreach($fetch_data as $row)  
        { 
            
            $sub_array = array();  
            $sub_array[] = $row->tiket;
            $sub_array[] = $row->nama;
            $sub_array[] = $row->cabang;
            $sub_array[] = $row->area;
            
            //NOTE : Kapal
            $kapal = "-";
            if($row->kapal){
                $kapal = $row->kapal;
            }
            $sub_array[] = $kapal;
            
            $sub_array[] = $row->kategori;
            $sub_array[] = $row->tgl_komplain;
            $sub_array[] = $row->telp;
            $sub_array[] = $row->email;
            $sub_array[] = ' <button  class="btn btn-primary" onclick="return detail_arsip('.$row->id_arsip.')"> <i class="fa fa-search"></i> Detail </button> ';

            $i++;

            $data[] = $sub_array;
            
        }
            $output = array(  
                "draw" => $_POST['draw'], 
                "recordsTotal" => $this->m_tabel_arsip->count_all(), 
                "recordsFiltered" => $this->m_tabel_arsip->count_filtered($cabang,$area,$kategori), 
                "data" => $data, ); //output dalam format JSON   
            
        echo json_encode($output); } 
    
    }
