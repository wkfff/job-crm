<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();

        $this->load->model('m_user');
    }
	
    public function index()
    {
        if($this->session->userdata('islogincrm')!=NULL){
            if($this->session->userdata('islogincrm') ==TRUE){
                redirect('dashboard');
            }
        }
            $this->load->view('common/v_header');
            $this->load->view('login/v_login');
            $this->load->view('common/v_footer');
    }

    // NOTE : Autentikasi
    public function auth($user, $pass)
    {
        if($this->m_user->user_find($user,$pass)){
            $data =  array('verified'=>TRUE);
        }else{
            $data =  array('verified'=>FALSE);
        }
        $this->output->set_content_type('application/json');
        echo json_encode($data);
    }

    
    public function auth_exec($username,$passwd)
    {
        $datam = $this->m_user->user_find($username,$passwd);

        $id = $datam->id_user;
        $nameuser = $datam->nameuser;
        $name = $datam->nama;
        $id_cabang = $datam->id_cabang;
        $cabang = $datam->cabang;
        $level = $datam->level;
        $pass = $datam->passwd;
        $id_divisi = $datam->divisi;
        $divisi = $datam->nama_divisi;

        $this->session->set_userdata('userid', $id);
        $this->session->set_userdata('username', $nameuser);
        $this->session->set_userdata('userlevel', $level);
        $this->session->set_userdata('id_cabang',$id_cabang);
        $this->session->set_userdata('cabang',$cabang);
        $this->session->set_userdata('nama',$name);
        $this->session->set_userdata('islogincrm',TRUE);
        $this->session->set_userdata('passwd',$pass);
        $this->session->set_userdata('id_divisi',$id_divisi);
        $this->session->set_userdata('divisi',$divisi);

        date_default_timezone_set("Asia/Jakarta");
        $time = time();
        $data = array('log'=> date("Y-m-d h:i:sa", $time));
        
        $this->m_user->user_update($id,$data);

        redirect('dashboard');

    }

    public function logout(){
        $this->session->sess_destroy();
        redirect('login');
    }

	
}
