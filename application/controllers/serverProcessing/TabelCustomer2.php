<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TabelCustomer2 extends CI_Controller {
 
    function __construct(){
        parent::__construct();
        $this->load->model('serverProcessing/m_tabel_customer2');
    }
  
    function get_data()
    {
        $list = $this->m_tabel_customer2->get_datatables();
        $data = array(); 
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $field->userid;
            $row[] = $field->nama;
            //FUTURE : umur
                $biday = new DateTime($field->tgl_lahir);
                $today = new DateTime('today');
                $umur = $today->diff($biday);
            $row[] = $umur->y;
            $row[] = $field->gender;
            $row[] = $field->tgl_lahir;
            $row[] = $field->telp;
            $row[] = $field->email; 
            $row[] = "<button class='btn btn-success' onclick='complain(".$field->id.",\"".$field->nama."\",\"".$field->userid."\")' title='Tambah Komplain'>"
                    ."<i class='fa fa-plus-circle'></i> Complain </button>";
            
            
    $data[] = $row; 
        } 
        $output = array( 
            "draw" => $_POST['draw'], 
            "recordsTotal" => $this->m_tabel_customer2->count_all(), 
            "recordsFiltered" => $this->m_tabel_customer2->count_filtered(), 
            "data" => $data, ); //output dalam format JSON 
        echo json_encode($output); } }
