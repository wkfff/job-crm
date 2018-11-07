<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
        
        $this->load->model('m_user');
        $this->load->model('m_customer'); 
    }
    
    public function index()
    {
        $data['user'] = $this->m_user->user_get();
        $data['cabang'] = $this->m_customer->branch_get();
        $data['divisi'] = $this->m_user->divisi_get(); 
        
        $this->load->view('common/v_main-header');
        $this->load->view('common/v_main-sidebar');
        $this->load->view('common/v_main-navbar');
        $this->load->view('backend/v_useradm',$data);
        $this->load->view('common/v_main-footer');
    }

}
