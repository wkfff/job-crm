<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Archive extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        if($this->session->userdata('islogincrm')!=NULL){
            if($this->session->userdata('islogincrm')!=TRUE){
                redirect('login');
            }
        }else{
            redirect('login');
        }

        $this->load->model('m_customer');
        $this->load->model('m_complain_chart');

    }

    public function index(){

        $this->load->view('common/v_main-header');
        $this->load->view('common/v_main-sidebar');
        $this->load->view('common/v_main-navbar');
        $data['arsip'] = $this->m_customer->arsip_get();
        $data['cabang'] = $this->m_customer->branch_get();
        $data['kategori'] = $this->m_complain_chart->complain_get_kategori();
        $this->load->view('backend/v_archive',$data);
        $this->load->view('common/v_main-footer');

    }
}