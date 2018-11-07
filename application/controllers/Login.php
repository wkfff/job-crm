<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();

        $this->load->model('m_user');
        $this->load->model('m_core');
    }
	
    public function index()
    {
        if($this->session->userdata('ldap_sso')!=NULL){
            if($this->session->userdata('ldap_sso') ==TRUE){
                redirect('dashboard');
            }
        }
            $this->load->view('common/v_header');
            $this->load->view('login/v_login');
            $this->load->view('common/v_footer');
    }

//    // NOTE : Autentikasi
//    public function auth($user, $pass)
//    {
//        if($this->m_user->user_find($user,$pass)){
//            $data =  array('verified'=>TRUE);
//        }else{
//            $data =  array('verified'=>FALSE);
//        }
//        $this->output->set_content_type('application/json');
//        echo json_encode($data);
//    }
//
//
//    public function auth_exec($username,$passwd)
//    {
//        $datam = $this->m_user->user_find($username,$passwd);
//
//        $id = $datam->id_user;
//        $nameuser = $datam->nameuser;
//        $name = $datam->nama;
//        $id_cabang = $datam->id_cabang;
//        $cabang = $datam->cabang;
//        $level = $datam->level;
//        $pass = $datam->passwd;
//        $id_divisi = $datam->divisi;
//        $divisi = $datam->nama_divisi;
//
//        $this->session->set_userdata('userid', $id);
//        $this->session->set_userdata('username', $nameuser);
//        $this->session->set_userdata('userlevel', $level);
//        $this->session->set_userdata('id_cabang',$id_cabang);
//        $this->session->set_userdata('cabang',$cabang);
//        $this->session->set_userdata('nama',$name);
//        $this->session->set_userdata('islogincrm',TRUE);
//        $this->session->set_userdata('passwd',$pass);
//        $this->session->set_userdata('id_divisi',$id_divisi);
//        $this->session->set_userdata('divisi',$divisi);
//
//        date_default_timezone_set("Asia/Jakarta");
//        $time = time();
//        $data = array('log'=> date("Y-m-d h:i:sa", $time));
//
//        $this->m_user->user_update($id,$data);
//
//        redirect('dashboard');
//
//    }

    public function logout(){
        $this->session->sess_destroy();
        redirect('login');
    }

    //NOTE : Login function
    public function login(){

        $this->form_validation->set_rules('username','Username','required|trim');
        $this->form_validation->set_rules('password','Password','required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('Failed','<strong>Login Gagal!</strong> - Pastikan data yang anda masukkan benar.');
            redirect('login');
        }else{
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $where = array(
                'nameuser' => $username
                );

            $cek_log = $this->m_user->username_check($where)->num_rows();
            $data = $this->m_user->username_check($where)->result();

            if($cek_log > 0){
                foreach($data as $row){

                    if($row->passwd == NULL){
                        $this->ldaplogin($username,$password,$row->freq,$row->id_user,$row->level,$row->cabang,$row->nama);
                    }else{
                        $hash = $this->config->item('ASDP_HASH');
                        $where = array(
                        'nameuser' => $username,
                        'passwd' => sha1($hash.$password.$hash),
                        );

                        $cek_log = $this->m_user->username_check($where)->num_rows();
                        if($cek_log > 0){
                            $data = $this->m_user->username_check($where)->result();

                            //TODO : Logging
//                        =============================================================
                            $datum = array(
                                'freq' => $row->freq + 1,
                            );
                            $where1 = array(
                                'name_user' => $row->name_user,
                            );
                            $this->m_user->last_login($datum,$where1);
//                        =============================================================
                            $data_session = array(
                                'ldap_id' => $row->id,
                                'ldap_username' => $row->nameuser,
                                'ldap_name' => $row->nama,
                                'ldap_division_id' => $row->divisi,
                                'ldap_division' => $this->m_core->find_table('m06_divisi',array('id_divisi'=>$row->divisi))->nama,
                                'ldap_branch_id' => $row->cabang,
                                'ldap_branch' => $this->m_core->find_table('m07_cabang',array('id_cabang'=>$row->cabang))->nama,
                                'ldap_level' => $row->level,
                                'ldap_password' =>$row->passwd,
                                'ldap_sso' => TRUE
                            );

                            $this->session->set_userdata($data_session);
                            redirect('dashboard');
                        }else{
                            $this->session->set_flashdata('Failed','<strong>Login Gagal!</strong> - Pastikan Username dan Password yang anda masukkan benar.');
                            redirect("login");
                        }
                    }
                }
            }else{
                $this->session->set_flashdata('Failed','<strong>Login Gagal!</strong> - Pastikan Username dan Password yang anda masukkan benar.');
                redirect("login");
            }
        }
    }

    //NOTE : LDAP Function
    public function ldapLogin($ldap_user,$ldap_password,$freq_log,$id,$level,$cabang_id,$nama){
        $ldap_dn = "DC=indonesiaferry,DC=co,DC=id";

        //TODO : cek username for easy
//        $ldap_user = $this->input->post('username');
        if(!strpos($ldap_user,'@')){
            $ldap_user = $ldap_user."@indonesiaferry.co.id";
        }
//        $ldap_password = $this->input->post('password');

        $username = explode('@',$ldap_user);


        //TODO : Cek Ldap connect (old ip 192.168.5.3)
        if(@!$this->ping('10.1.107.2')){
            $this->session->set_flashdata('Failed','<strong>Login Gagal!</strong> - Tidak dapat akses server Active Directory');
            redirect('login');
        }

        $ldap_con = ldap_connect('10.1.107.2',389);



//        ldap_set_option($ldap_con, LDAP_OPT_SIZELIMIT, 20);
        ldap_set_option($ldap_con, LDAP_OPT_REFERRALS, 0);
        ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION, 3);

        if(@ldap_bind($ldap_con,$ldap_user,$ldap_password)){
            $result = ldap_search($ldap_con,$ldap_dn,"(sAMAccountName=$username[0])") or exit("Unable to search");
            $entries = ldap_get_entries($ldap_con,$result);

//           print_r($entries);

            $LDAP_samaccountname = "";
            $LDAP_memberof = "";
            $LDAP_name = "";
            $LDAP_mail = "";
            $LDAP_dn = "";

            for ($x=0; $x<$entries['count']; $x++){

                //TODO : Username


                if (!empty($entries[$x]['samaccountname'][0])) {
                    $LDAP_samaccountname = $entries[$x]['samaccountname'][0];
                    if ($LDAP_samaccountname == "NULL"){
                        $LDAP_samaccountname= "";
                    }
                } else {
                    //#There is no samaccountname s0 assume this is an AD contact record so generate a unique username

                    $LDAP_uSNCreated = $entries[$x]['usncreated'][0];
                    $LDAP_samaccountname= "CONTACT_" . $LDAP_uSNCreated;
                }

                //TODO : Memberof


                if (!empty($entries[$x]['memberof'][0])) {
                    $LDAP_memberof = $entries[$x]['memberof'][0];
                    if ($LDAP_memberof == "NULL"){
                        $LDAP_memberof = "";
                    }
                }

                //TODO : DN
                 if (!empty($entries[$x]['cn'][0])) {
                    $LDAP_dn = $entries[$x]['cn'][0];
                    if ($LDAP_dn == "NULL"){
                        $LDAP_dn = "";
                    }
                }

//                system("ping www.google.com");

//                var_dump($LDAP_dn);

                //TODO : Name
                if (!empty($entries[$x]['givenname'][0])) {
                    $LDAP_name = $entries[$x]['givenname'][0];
                    if ($LDAP_name == "NULL"){
                        $LDAP_name = "";
                    }
                }

                //TODO : Email
			if (!empty($entries[$x]['mail'][0])) {
				$LDAP_mail = $entries[$x]['mail'][0];
				if ($LDAP_mail == "NULL"){
					$LDAP_mail = "";
				}
			}
            }

           $extract = explode(",",$LDAP_memberof);

            //FUTURE : Divisi
            $extract2 = explode('=',$extract[0]);
            $LDAP_division = $extract2[1];

            //FUTURE : Cabang
            $extract2 = explode('=',$extract[2]);
            $LDAP_branch = $extract2[1];

            $this->session->set_userdata('ldap_id',$id);
            $this->session->set_userdata('ldap_username',$LDAP_samaccountname);
            $this->session->set_userdata('ldap_name',$nama);
            $this->session->set_userdata('ldap_mail',$LDAP_mail);
            $this->session->set_userdata('ldap_division',$LDAP_division);
            $this->session->set_userdata('ldap_password',NULL);
            $this->session->set_userdata('ldap_level',$level);
//            $this->session->set_userdata('ldap_branch',$LDAP_branch);
            $this->session->set_userdata('ldap_branch',$this->m_core->find_table('m07_cabang',array('id_cabang'=>$cabang_id))->nama);
            $this->session->set_userdata('ldap_branch_id',$cabang_id);
            $this->session->set_userdata('ldap_sso',TRUE);

             //TODO : Logging
//                        =============================================================
                    $datum = array(
                        'freq' => $freq_log + 1
                    );
                    $where1 = array(
                        'nameuser' => $username[0]
                    );
                   $this->m_user->last_login($datum,$where1);
//                        =============================================================

            ldap_unbind($ldap_con); // Clean up after ourselves.
            redirect("dashboard",'refresh');

        }else{
            $this->session->set_flashdata('Failed','<strong>Login Gagal!</strong> - Pastikan Username dan Password yang anda masukkan benar.');
            redirect("login");
        }
    }



    //NOTE : fungsi PING
    function ping($host,$port=389,$timeout=6)
    {
        $fsock = fsockopen($host, $port, $errno, $errstr, $timeout);
        if ( ! $fsock )
        {
                return FALSE;
        }
        else
        {
                return TRUE;
        }
    }

	
}
