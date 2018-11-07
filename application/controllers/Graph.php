<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Graph extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        if($this->session->userdata('ldap_sso')!=NULL){
            if($this->session->userdata('ldap_sso')!=TRUE){
                redirect('login');
            }
        }else{
            redirect('login');
        }

        $this->load->model('m_customer');
        $this->load->model('m_complain_chart');

    }

    public function index(){
        $level = $this->session->userdata('ldap_level');

        if($level == 0){
            $this->load->view('common/v_main-header');
            $this->load->view('common/v_main-sidebar');
            $this->load->view('common/v_main-navbar');
            $data['tahun'] = $this->m_complain_chart->complain_get_years();
            $data['kategori'] = $this->m_complain_chart->complain_get_kategori();
            $data['customer'] = $this->m_customer->customer_get();
            $data['cabang'] = $this->m_customer->branch_get();
            $this->load->view('backend/v_information',$data);
            $this->load->view('common/v_main-footer');
        }else{
            redirect('dashboard');
        }
        
    }
}
