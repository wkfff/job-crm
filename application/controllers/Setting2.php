<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting2 extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        if($this->session->userdata('islogincrm')!=NULL && $this->session->userdata('userlevel') == 0){
            if($this->session->userdata('islogincrm')!=TRUE){
                redirect('login');
            }
        }else{
            redirect('login');
        }
        
        $this->load->model('m_customer');
        $this->load->model('m_loyalty');

    }
    
    
    public function index(){
        $this->load->view('common/v_main-header');
        $this->load->view('common/v_main-sidebar');
        $this->load->view('common/v_main-navbar');
        $this->load->view('backend/v_setting_loyalty');
        $this->load->view('common/v_main-footer');
    }
    
    //NOTE : Loyalty - Input
    public function loyalty_input(){
        $data = $this->input->post();
        $urut = $this->m_loyalty->loyalty_order_get($data['tipe'])->urut;
        
        try{
            $data += ['ordering'=>$urut];
            $this->m_loyalty->loyalty_input($data);
            echo json_encode(array('message'=>'sukses'));
        }catch(exception $e){
            echo json_encode(array('message'=>'gagal'));
        }
    }
    
    //NOTE : Loyalty - update
    public function loyalty_update(){
        $data = $this->input->post();
        try{
            $this->m_loyalty->loyalty_update($data['id'],$data);
            echo json_encode(array('message'=>'sukses'));
        }catch(exception $e){
            echo json_encode(array('message'=>'gagal'));
        }
    }
    
    //NOTE : Loyalty - Delete
    public function loyalty_del(){
        $data = $this->input->post('id');
        try{
            $this->m_loyalty->loyalty_del($data);
            echo json_encode(array('message'=>'sukses'));
        }catch(exception $e){
            echo json_encode(array('message'=>'gagal'));
        }
    }
    
    
    //NOTE : Loyalty - order Up
    public function loyalty_order_up(){
        $data = $this->input->post();
        $data_up = $this->m_loyalty->loyalty_order_find($data['tipe'],$data['order']-1);
        $id_up = $data_up->id;
        $order_up = $data_up->ordering;
        
        try{
            $this->m_loyalty->loyalty_order_down($id_up,$order_up);
            $this->m_loyalty->loyalty_order_up($data['id'],$data['order']);
            echo json_encode(array('message'=>'sukses'));
        }catch(exception $e){
            echo json_encode(array('message'=>'gagal'));
        }
    }
    
    //NOTE : Loyalty - order Up
    public function loyalty_order_down(){
        $data = $this->input->post();
        $data_down = $this->m_loyalty->loyalty_order_find($data['tipe'],$data['order']+1);
        $id_down = $data_down->id;
        $order_down = $data_down->ordering;
        
        try{
            $this->m_loyalty->loyalty_order_up($id_down,$order_down);
            $this->m_loyalty->loyalty_order_down($data['id'],$data['order']);
            echo json_encode(array('message'=>'sukses'));
        }catch(exception $e){
            echo json_encode(array('message'=>'gagal'));
        }
    }
    
}
