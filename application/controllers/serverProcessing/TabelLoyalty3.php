<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TabelLoyalty3 extends CI_Controller {
 
    function __construct(){
        parent::__construct();
        $this->load->model('serverProcessing/m_tabel_loyalty3');
    }
  
    function get_data($cari)
    {
        $list = $this->m_tabel_loyalty3->get_datatables($cari);
        $data = array(); 
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->nama;
            
                          
            $row[] = $field->max;
            $row[] = $field->keterangan;
            
            $btn1='';
            $btn2='';
            
            if($field->ordering == 0){
                if($field->ordering == count($list)-1){
                    $btn1='';
                    $btn2='';
                }else{
                    $btn1='<button class="btn label label-primary " onclick="orderDown(\''.$field->tipe.'\','.$field->id.','.$field->ordering.')" title="Down"><i class="fa fa-arrow-down"></i></button>';
                    $btn2='';
                }
            }else if($field->ordering == count($list)-1){
                $btn1='<button class="btn label label-primary " onclick="orderUp(\''.$field->tipe.'\','.$field->id.','.$field->ordering.')" title="Up"><i class="fa fa-arrow-up"></i></button>';
                $btn2='';
                
            }else{
                $btn1='<button class="btn label label-primary " onclick="orderUp(\''.$field->tipe.'\','.$field->id.','.$field->ordering.')" title="Up"><i class="fa fa-arrow-up"></i></button>';
                $btn2='<button class="btn label label-primary " onclick="orderDown(\''.$field->tipe.'\','.$field->id.','.$field->ordering.')" title="Down"><i class="fa fa-arrow-down"></i></button>';
                
            }
            $row[] = $btn1.$btn2;
            
            //FUTURE : check user level
            $btn1='';
            if($this->session->userdata('userlevel') == 0 && $field->ordering == count($list)-1) {
                $btn1='<button class="btn label label-danger " onclick="delLoyalty('.$field->id.',\''.$field->tipe.'\')" title="Delete"><i class="fa fa-trash"></i></button>';
            }
            $row[] ='<button class="btn label label-info " onclick="editLoyalty('.$field->id.',\''.$field->tipe.'\','.$field->max.',\''.$field->nama.'\',\''.$field->keterangan.'\')" title="Update"><i class="fa fa-edit "></i></button>'.$btn1;
            
    $data[] = $row; 
        } 
        $output = array( 
            "draw" => $_POST['draw'], 
            "recordsTotal" => $this->m_tabel_loyalty3->count_all(), 
            "recordsFiltered" => $this->m_tabel_loyalty3->count_filtered(), 
            "data" => $data, ); //output dalam format JSON 
        echo json_encode($output); } }
