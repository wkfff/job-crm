<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        if($this->session->userdata('ldap_sso')!=NULL && $this->session->userdata('ldap_sso') == 0){
            if($this->session->userdata('ldap_sso')!=TRUE){
                redirect('login');
            }
        }else{
            redirect('login');
        }
        
        $this->load->model('m_customer');
        $this->load->model('m_lintasan');

    }
    
    public function index(){
        $data['lintasan'] = $this->m_customer->port_get();
        $this->load->view('common/v_main-header');
        $this->load->view('common/v_main-sidebar');
        $this->load->view('common/v_main-navbar');
        $this->load->view('backend/v_setting_lintasan',$data);
        $this->load->view('common/v_main-footer');
    }
    
   
    
    //NOTE : Lintasan - Input
    public function lintasan_input(){
        $data = $this->input->post();
        try{
            $this->m_lintasan->lintasan_input($data);
            echo json_encode(array('message'=>'sukses'));
        }catch(exception $e){
            echo json_encode(array('message'=>'gagal'));
        }
    }
    
    //NOTE : Lintasan - update
    public function lintasan_update(){
        $data = $this->input->post();
        try{
            $this->m_lintasan->lintasan_update($data['id'],$data);
            echo json_encode(array('message'=>'sukses'));
        }catch(exception $e){
            echo json_encode(array('message'=>'gagal'));
        }
    }
    
    //NOTE : Lintasan - Delete
    public function lintasan_del(){
        $data = $this->input->post('id');
        try{
            $this->m_lintasan->lintasan_del($data);
            echo json_encode(array('message'=>'sukses'));
        }catch(exception $e){
            echo json_encode(array('message'=>'gagal'));
        }
    }
    
    //NOTE : Lintasan - Delete bulk
    public function lintasan_del_bulk(){
        $data_ids = $_REQUEST['data_ids'];
        $data_id_array = explode(",", $data_ids); 
        if(!empty($data_id_array)) {
            foreach($data_id_array as $id) {
                $this->m_lintasan->lintasan_del($id);
            }
        }
    }
    
    
    
}
