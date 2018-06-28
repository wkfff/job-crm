<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TabelCustomer extends CI_Controller {
 
    function __construct(){
        parent::__construct();
        $this->load->model('serverProcessing/m_tabel_customer'); 
    }
  
    function get_data()
    {
        $list = $this->m_tabel_customer->get_datatables();
        $data = array(); 
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = "<input type='checkbox'  class='deleteRow' id='del_".$field->id."' value='".$field->id."'  />" ;
            $row[] = $field->userid;
            
            //FUTURE : nik and pass check
            $nik = '-';
            if($field->nik){
                $nik = $field->nik;
            }else if ($field->passport){
                $nik = $field->passport;
            }
            $row[] = $nik;
                
            $row[] = $field->nama;
            $row[] = $field->telp;
            $row[] = $field->gender;
            $row[] = $field->tgl_lahir; 
            $row[] = $field->email;
            
            //FUTURE : check user level
            $btn1='';
            if($this->session->userdata('userlevel') == 0) {
                $btn1='<button class="btn label label-danger " onclick="delCustomer('.$field->id.')" title="Delete"><i class="fa fa-trash"></i></button>';
            }
            $row[] =$btn1.'<button class="btn label label-info " onclick="detailCustomer('.$field->id.')" title="Detail"><i class="fa fa-search "></i></button>';
            
    $data[] = $row; 
        } 
        $output = array( 
            "draw" => $_POST['draw'], 
            "recordsTotal" => $this->m_tabel_customer->count_all(), 
            "recordsFiltered" => $this->m_tabel_customer->count_filtered(), 
            "data" => $data, ); //output dalam format JSON 
        echo json_encode($output); } }
