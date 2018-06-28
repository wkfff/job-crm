<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TabelLintasan extends CI_Controller {
 
    function __construct(){
        parent::__construct();
        $this->load->model('serverProcessing/m_tabel_lintasan');
    }
  
    function get_data($cari)
    {
        $list = $this->m_tabel_lintasan->get_datatables($cari);
        $data = array(); 
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = "<input type='checkbox'  class='deleteRow' id='del_".$field->id."' value='".$field->id."'  />" ;
            $row[] = $field->nama_asal;
            
                          
            $row[] = $field->nama_tujuan;
            $row[] = $field->jarak;
            $row[] = $field->poin;
            
            //FUTURE : check user level
            $btn1='';
            if($this->session->userdata('userlevel') == 0) {
                $btn1='<button class="btn label label-danger " onclick="delLintasan('.$field->id.')" title="Delete"><i class="fa fa-trash"></i></button>';
            }
            $row[] =$btn1.'<button class="btn label label-info " onclick="editLintasan('.$field->id.','.$field->id_daerah_asal.','.$field->id_daerah_tujuan.','.$field->poin.','.$field->jarak.')" title="Detail"><i class="fa fa-edit "></i></button>';
            
    $data[] = $row; 
        } 
        $output = array( 
            "draw" => $_POST['draw'], 
            "recordsTotal" => $this->m_tabel_lintasan->count_all(), 
            "recordsFiltered" => $this->m_tabel_lintasan->count_filtered(), 
            "data" => $data, ); //output dalam format JSON 
        echo json_encode($output); } }
