<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TabelCustomer3 extends CI_Controller {
 
    function __construct(){
        parent::__construct();
        $this->load->model('serverProcessing/m_tabel_customer3');
        $this->load->model('m_perjalanan');
    }
  
    function get_data()
    {
        $list = $this->m_tabel_customer3->get_datatables();
        $data = array(); 
        $no = $_POST['start'];
        foreach ($list as $field) { 
            $no++;
            $row = array();
            $row[] = $field->userid;
            $row[] = $field->nama;
            $row[] = $field->telp;
            $row[] = $field->email; 
//            $row[] = $field->id;
//            $row[] = $this->m_perjalanan->frekuensi($field->id)->frekuensi.' perjalanan';
            $row[] = $field->trip_freq.' perjalanan';
            $row[] = "<button class='btn btn-success' onclick='recentAct(".$field->id.")' title='Recent Activity'>"
                    ."<i class='fa fa-history'></i> Recent Trip</button>";
            
            
    $data[] = $row; 
        } 
        $output = array( 
            "draw" => $_POST['draw'], 
            "recordsTotal" => $this->m_tabel_customer3->count_all(), 
            "recordsFiltered" => $this->m_tabel_customer3->count_filtered(), 
            "data" => $data, ); //output dalam format JSON 
        echo json_encode($output); } }
