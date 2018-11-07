<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;  

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
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

        $this->load->library('excel'); 
        $this->load->model('m_user');
        $this->load->model('m_customer');
        $this->load->model('m_complain_chart');
        $this->load->model('m_loyalty');
        $this->load->model('m_lintasan');
    }

    public function index(){

        $level = $this->session->userdata('ldap_level');

        
        $this->load->view('common/v_main-header');
        $this->load->view('common/v_main-sidebar');
        $this->load->view('common/v_main-navbar');
        $data['tahun'] = $this->m_complain_chart->complain_get_years();
        $data['kategori'] = $this->m_complain_chart->complain_get_kategori();
        if( $level == 0 || $level == 1){
            $data['customer'] = $this->m_customer->customer_get();
            $data['cabang'] = $this->m_customer->branch_get();
            $data['divisi'] = $this->m_user->divisi_get(); 
            $this->load->view('backend/v_main',$data);
        }else if($level == 3 ){
            $id_cabang = $this->session->userdata('ldap_branch_id');
            $id_divisi = $this->session->userdata('ldap_division_id');
            if( $id_cabang == 110){
                $data['komplain'] = $this->m_customer->complain_find_divisi($id_divisi);
            }else{
                $data['komplain'] = $this->m_customer->complain_find_cabang($id_cabang);
            }
            $this->load->view('backend/v_branch',$data);
        }else if($level == 2 || $level == 4){
            $data['customer'] = $this->m_customer->customer_get();
            $data['cabang'] = $this->m_customer->branch_get();
            $this->load->view('backend/v_information',$data);
        }
        
        $this->load->view('common/v_main-footer');
    }

    


   
    //CUSTOMERPROFILING
    //NOTE : Customer - delete
    public function customer_del($id)
    {
        $this->m_customer->customer_del($id);
        $this->m_customer->complain_del2($id);
        $this->m_customer->hcomplain_del2($id);
    }
    
    //NOTE : Customer - delete bulk
    public function customer_del_bulk(){
        $data_ids = $_REQUEST['data_ids'];
        $data_id_array = explode(",", $data_ids); 
        if(!empty($data_id_array)) {
            foreach($data_id_array as $id) { 
                $this->m_customer->customer_del($id);
                $this->m_customer->complain_del2($id);
                $this->m_customer->hcomplain_del2($id);
            }
        }
    }
    
    //NOTE : Customer - get
    public function customer_get($id){
        $data = $this->m_customer->customer_find($id);
        echo json_encode($data); 
    }

    //NOTE : Customer - check email
    public function check_email()
	{
		$email= $this->input->post('email');
		$result = $this->m_customer->check_email($email)->num_rows();
		echo $result;
    }
    
    //NOTE : Customer - last activity
    public function customer_lastAct($id)
    {
        $data = $this->m_customer->customer_lastAct($id);
        echo json_encode($data);
    }
    
    //NOTE : Customer - check nik
    public function check_nik()
	{
		$nik = $this->input->post('nik');
		$result = $this->m_customer->check_nik($nik)->num_rows();
		echo $result;
    }
    
    //NOTE : Customer - check passport
    public function check_pass()
	{
		$pass = $this->input->post('passport');
		$result = $this->m_customer->check_pass($pass)->num_rows();
		echo $result;
    }
    
    //NOTE : Customer - check telp
    public function check_telp()
	{
		$telp = $this->input->post('telp');
		$result = $this->m_customer->check_telp($telp)->num_rows();
		echo $result;
	}

    //NOTE : Customer - input
    public function customer_input()
    {
        $this->form_validation->set_rules('nik','NIK','trim');
        $this->form_validation->set_rules('passport','Passport','trim');
        $this->form_validation->set_rules('nama','Nama Lengkap','required|trim|min_length[4]');
        $this->form_validation->set_rules('notelp','No Telp/HP','required|trim');
        $this->form_validation->set_rules('email','Email','required|trim|valid_email');
        $this->form_validation->set_rules('hari','Tanggal Lahir','required');
        $this->form_validation->set_rules('bulan','Tanggal Lahir','required');
        $this->form_validation->set_rules('tahun','Tanggal Lahir','required');
        $this->form_validation->set_rules('tmp_lahir','Tempat Lahir','trim|required');
        $this->form_validation->set_rules('perusahaan','Perusahaan','trim');
        $this->form_validation->set_rules('alamat','Alamat','trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('Failed', '<strong>Gagal!</strong> Pastikan data yang anda isikan benar!');
            redirect('dashboard');
        }else{
            $id = $this->m_customer->IDcek();
            if ($id == '000001'){
                $userid = date("Y").date("m").$id;
            }else {
                $idnew = substr((string)$id->userid,-6);
                $userid = date("Y").date("m").$idnew + 1;
            }

            // variable init
            $created_by = $this->session->userdata('nama');
            $created_date = date('Y-m-d');
            $nama = $this->input->post('nama');
            $nik = set_value('nik');
            if($nik == 0){
                $nik = '';
            }
            if($nik != ''){
                if(!$this->m_customer->customerCheck_nik($nik)){
                    $this->session->set_flashdata('Failed', '<strong>Gagal!</strong> NIK sudah terfdaftar!');
                    redirect('dashboard');
                }
            }else{
                $nik = NULL;
            }
            $notelp = $this->input->post('notelp');
            if(!$this->m_customer->customerCheck_telp($notelp)){
                $this->session->set_flashdata('Failed', '<strong>Gagal!</strong> No telp sudah terfdaftar!');
                redirect('dashboard');
            }
            $email = $this->input->post('email');
            if(!$this->m_customer->customerCheck_email($email)){
                $this->session->set_flashdata('Failed', '<strong>Gagal!</strong> Email sudah terfdaftar!');
                redirect('dashboard');
            }
            $pass = set_value('passport');
            if($pass == '0'){
                $pass = '';
            }
            if($pass != ''){
                if(!$this->m_customer->customerCheck_pass($pass)){
                    $this->session->set_flashdata('Failed', '<strong>Gagal!</strong> No Passport sudah terfdaftar!');
                    redirect('dashboard');
                }
            }else{
                $pass = NULL;
            }
            
            $warga = $this->input->post('warga');
            $gender = $this->input->post('gender');
            //ttl
            $tahun = $this->input->post('tahun');
            $bulan = $this->input->post('bulan');
            $hari = $this->input->post('hari');
            $tmp_lahir = $this->input->post('tmp_lahir');
            $ttl = $tahun.'-'.$bulan.'-'.$hari;
            //ttl
            //Pekerjaan
            $perusahaan = $this->input->post('perusahaan');
            if($this->input->post('pekerjaan')=='1'){
                $job = $this->input->post('pekerjaan2');
            }else{
                $job = $this->input->post('pekerjaan');
            }
            //Pekerjaan
            $alamat = $this->input->post('alamat');
            
            $sosmed = $this->input->post('sosmed');
                if($sosmed == null){
                    $sosmed = '-';
                }
            $nama_sosmed = $this->input->post('nama_sosmed');
                if($nama_sosmed == null){
                    $nama_sosmed = '-';
                }
            $data = array('userid'=> $userid, 'nama'=> $nama, 'telp' => $notelp, 'tgl_lahir' => $ttl,'tempat_lahir' => $tmp_lahir,
                            'gender'=>'','alamat'=>$alamat,'email'=>$email,'job'=>$job,'perusahaan'=>$perusahaan,
                            'sosmed'=>$sosmed,'nama_sosmed'=>$nama_sosmed, 'gender'=>$gender, 'created_by'=>$created_by, 
                            'created_date'=>$created_date,'nik'=>$nik,'warga'=>$warga,'passport'=>$pass);
            try{
                $this->m_customer->customer_input($data);
                $this->session->set_flashdata('Success', '<strong>Sukses!</strong> Data Pelanggan berhasil ditambahkan!');
                redirect('dashboard');
            }catch(Exception $e){
                $this->session->set_flashdata('Failed', '<strong>Gagal!</strong> Data Pelanggan gagal ditambahkan, terjadi kesalahan!');
                redirect('dashboard');
            }
        }
    }

    //NOTE : Customer - update
    public function customer_update(){
        $this->form_validation->set_rules('d_nik','NIK','trim');
        $this->form_validation->set_rules('d_passport','Passport','trim');
        $this->form_validation->set_rules('d_nama','Nama Lengkap','required|trim|min_length[4]');
        $this->form_validation->set_rules('d_telp','No Telp/HP','required|trim');
        $this->form_validation->set_rules('d_email','Email','required|trim|valid_email');
        $this->form_validation->set_rules('d_company','Perusahaan','trim');
        $this->form_validation->set_rules('d_tmplahir','Tempat lahir','required|trim');
        $this->form_validation->set_rules('d_alamat','Alamat','trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('Failed', '<strong>Gagal!</strong> Pastikan data yang anda isikan benar!');
            redirect('dashboard');
        }else{
            
            $nik_old = $this->input->post('d_nik_old');
            $nik = $this->input->post('d_nik');
            if($nik == $nik_old){
                if($nik == 0){
                    $nik = '';
                }
                
                if($nik != ''){
                    if(!$this->m_customer->customerCheck_nik($nik)){
                        $this->session->set_flashdata('Failed', '<strong>Gagal!</strong> NIK sudah terdaftar!');
                        redirect('dashboard');
                    }
                }else{
                    $nik = NULL;
                }
            }
            
            $pass_old = $this->input->post('d_passport_old');
            $pass = $this->input->post('d_passport');
            if($pass == $pass_old){
               if($pass == '0'){
                $pass = '';
                }
                if($pass != ''){
                    if(!$this->m_customer->customerCheck_pass($pass)){
                        $this->session->set_flashdata('Failed', '<strong>Gagal!</strong> No Passport sudah terfdaftar!');
                        redirect('dashboard');
                    }
                }else{
                    $pass = NULL;
                } 
            }
            
            
            $id = $this->input->post('d_id');
            $nama = $this->input->post('d_nama');
            $telp = $this->input->post('d_telp');
            $email = $this->input->post('d_email');
            $tmp_lahir = $this->input->post('d_tmplahir');
            $updated_by = $this->session->userdata('ldap_name');
            $updated_date = date('Y-m-d');
                //ttl
                $tahun = $this->input->post('d_tahun');
                $bulan = $this->input->post('d_bulan');
                $hari = $this->input->post('d_hari');
                //ttl
            $ttl = $tahun.'-'.$bulan.'-'.$hari;
            $gender = $this->input->post('d_gender');
            $warga = $this->input->post('d_warga');
            //Pekerjaan
            $perusahaan = $this->input->post('d_company');
            if($this->input->post('d_job')=='1'){
                $job = $this->input->post('d_job2');
            }else{
                $job = $this->input->post('d_job');
            }
            //Pekerjaan
            $alamat = $this->input->post('d_alamat');
            
            $sosmed = $this->input->post('d_sosmed');
                if($sosmed == null){
                    $sosmed = '-';
                }
            $nama_sosmed = $this->input->post('d_nama_sosmed');
                if($nama_sosmed == null){
                    $nama_sosmed = '-';
                }
            $data = array( 'nik'=>$nik,'passport'=>$pass,'nama'=> $nama, 'telp' => $telp, 'tgl_lahir' => $ttl, 'tempat_lahir' => $tmp_lahir,
                            'gender'=>'','alamat'=>$alamat,'email'=>$email,'job'=>$job,'perusahaan'=>$perusahaan,
                            'sosmed'=>$sosmed,'nama_sosmed'=>$nama_sosmed, 'gender'=>$gender, 'updated_by'=>$updated_by,
                            'updated_date'=>$updated_date, 'warga'=>$warga);
            try{
                $this->m_customer->customer_update($id,$data);
                $this->session->set_flashdata('Success', '<strong>Sukses!</strong> Data Pelanggan berhasil diupdate!');
                redirect('dashboard');
            }catch(Exception $e){
                $this->session->set_flashdata('Failed', '<strong>Gagal!</strong> Data Pelanggan gagal diupdate, terjadi kesalahan!');
                redirect('dashboard');
            }
        }
    }
    
    //NOTE : Count - customer and perjalan
    public function count_cp($id){
        $data1 = $this->m_loyalty->count_perjalanan($id);
        $data2 = $this->m_loyalty->count_customer($id);
        $data = array_merge($data1,$data2);
        echo json_encode($data);
        
    }
    
    //NOTE : Count - lintasan
    public function count_lintasan($id){
        $data = $this->m_loyalty->count_lintasan($id);
        echo json_encode($data);
    }

    // NOTE : Kendaraan Get
    public function kendaraan_get(){
        $data = $this->m_customer->kendaraan_get();
        echo json_encode($data);
    }
    //kendaraan

    // NOTE : Perjalanan - Input
    public function perjalanan_input($id){
        $data = $this->input->post();
        try{
            $this->m_customer->perjalanan_input($data);
            $this->m_customer->frequent_add($id);
        
            $poin = $this->m_lintasan->lintasan_findById($data['id_pelabuhan_asal'],$data['id_pelabuhan_tujuan']);
            $customer = $this->m_customer->customer_find($id);
            
            $data2 = array('trip_poin'=>$poin->poin+$customer->trip_poin,'trip_jarak'=>$poin->jarak+$customer->trip_jarak);
            $this->m_customer->customer_update($id,$data2);
            
            $level_jarak = $this->m_loyalty->loyalty_check_level('jarak',$customer->trip_jarak);
            $level_freq = $this->m_loyalty->loyalty_check_level('trip',$customer->trip_freq);
            $level_poin = $this->m_loyalty->loyalty_check_level('poin',$customer->trip_poin);
            $data2 = array('freq_level'=>$level_freq->ordering,'poin_level'=>$level_poin->ordering,'jarak_level'=>$level_jarak->ordering);
            $this->m_customer->customer_update($id,$data2);
            
            echo json_encode($data);
        }catch(Exception $e){
            echo json_encode($data);
        }
        
    }

    // NOTE : Perjalanan - Delete
    public function perjalanan_del(){
        $data = $this->input->post();
        $poin = $this->m_lintasan->lintasan_findById($data['id_pelabuhan_asal'],$data['id_pelabuhan_tujuan']);
        $customer = $this->m_customer->customer_find($data['id_customer']);
            
        $data2 = array('trip_freq'=>$customer->trip_freq-1,'trip_poin'=>$customer->trip_poin-$poin->poin,'trip_jarak'=>$customer->trip_jarak-$poin->jarak);
        $this->m_customer->customer_update($data['id_customer'],$data2);
        
        $level_jarak = $this->m_loyalty->loyalty_check_level('jarak',$customer->trip_jarak);
        $level_freq = $this->m_loyalty->loyalty_check_level('trip',$customer->trip_freq);
        $level_poin = $this->m_loyalty->loyalty_check_level('poin',$customer->trip_poin);
        $data2 = array('freq_level'=>$level_freq->ordering,'poin_level'=>$level_poin->ordering,'jarak_level'=>$level_jarak->ordering);
        $this->m_customer->customer_update($id,$data2);
        
        $this->m_customer->perjalanan_del($data['id']);
    }

    //Perjalanan
    //CUSRTOMER PROFILING

    // NOTE : Cabang Get
    public function branch_get(){
        $data = $this->m_customer->branch_get();
        echo json_encode($data);
    }
    
    public function branch_get2(){
        $data = $this->m_customer->branch_get();
        $this->output->set_content_type('application/json');
        echo json_encode($data);
    }
    
    //BRANCH

    //PORT
    // NOTE : port - Get
    public function port_get(){
        $data = $this->m_customer->port_get();
        echo json_encode($data);
    }

    public function port_jadwal($id){
        $data = $this->m_customer->port_jadwal($id);
        echo json_encode($data);
    }

    // NOTE : Pelabuhan Find
    public function port_find($id){
        $data = $this->m_customer->port_find($id);
        echo json_encode($data);
    }
    //PORT

    
    

    
    //SHIP
    // NOTE : Kapal Get
    public function ship_get(){
        $data = $this->m_customer->ship_get();
        echo json_encode($data);
    }
    //SHIP


    //COMPLAIN
    //NOTE : Complain Input
    public function complain_input($id_cabang,$tiket,$divisi){
        if($id_cabang == 110){
         $datam = $this->m_user->user_get_cabang($divisi);   
        }else{
        $datam = $this->m_user->user_get_cabang($id_cabang);
        }
        $mail = array();
        $nama = array();
        $i = 0;

        foreach($datam as $row){ 

            //$this->sendemail($row->nameuser,$row->nama,$tiket);
            $mail[$i] =  $row->nameuser;
            // $nama[] =  $row->nama;
            $i++;
            
        }
        $len = sizeof($mail);
        
        


        $data = $this->input->post();
        $this->m_customer->complain_input($data);

        try{
            $data = $this->sendemail($mail,$tiket);
//            $data = array('Mailres'=>TRUE);
            echo json_encode($data);
        }catch(Exception $e){
            $data = array('Mailres'=>FALSE);
            echo json_encode($data);    
        }
        
        //  echo json_encode($data);

               
    }

    //MAIL SETTING
    // NOTE : Complain email setting
    function sendemail($email,$tiket)
    {
//         require_once("mail/class.phpmailer.php");
        
        

        require_once("mail/PHPMailer.php");
        require_once("mail/Exception.php");
        require_once("mail/SMTP.php");

        $mail = new PHPMailer(true);
        
        try{
            
            $mail->isSMTP();
//            $mail->SMTPDebug = 4; 
//            $mail->Host = "mail.indonesiaferry.co.id";
//            $mail->Host = "10.1.107.124";
            $mail->Host = "10.1.107.125";
//            $mail->SMTPAuth = false;
            $mail->Username = "devmail@indonesiaferry.co.id";
            $mail->Password = "P@ssw0rd-123"; 
            $mail->Port = 25;
            $mail->SMTPAuth   = true;                  // enable SMTP authentication
            $mail->SMTPSecure = "tls";
            $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
//            $mail->SMTPAutoTLS = false;
//            $mail->attach('./assets/img/logo-asdp-dashboard.png'); 
            $mail->AddEmbeddedImage('./assets/img/logo-asdp-dashboard.png', 'logo');
            $mail->IsHTML(true);
            $mail->From       = "noreply@indonesiaferry.co.id";
            $mail->FromName   = "Customer Relationship Management PT.ASDP Indonesia Ferry";
        $html_message ="<body style='margin: 20px;'>"
                        ."<div style='backgound-color:#348ecd'><img src='cid:logo'><center><h1>Customer Relationship Management</h1></center></div>"
                        
                        ."<p>Dear, user cabang</p>"
                        ."<p>Cabang anda mendapat keluhan dengan no tiket : <strong>".$tiket."</strong>, silahkan membuka aplikasi crm indonesia ferry.</p>"
                        ."<p>Terima kasih</p>"
                        ."<p><strong>PT. ASDP Indonesia Ferry</strong></p>"
                        ."</body>";
//        require_once('mail/mailsettings.php');
            
            $mail->Subject    = "Customer Relationship Management PT.ASDP Indonesia Ferry";
            
            $mail->MsgHTML($html_message);
            
            $len = sizeof($email);

            for($i=0;$i<$len;$i++){

                $mail->AddAddress($email[$i]);

            }
            
            $mail->send();
            // $mail->AddCC($email);
            // $mail->AddReplyTo($email);
            // $mail->AddAddress($email);
//            $data = array('res'=>TRUE);
            $data = $mail->send();
            $this->output->set_content_type('application/json');
            return json_encode($data);
        } catch (Exception $e) {
            $this->output->set_content_type('application/json');
            return json_encode( $mail->ErrorInfo); 
        }
            
            // return $mail->send();
                
    }
    //MAIL SETTING

    // NOTE : Complain Status update
    public function complain_status_update($id){
        $data = array('status'=>'1');
        $this->m_customer->complain_update($id,$data);
        echo json_encode($data);
    }

    // NOTE : Complain - Del
    public function complain_del($id){
        $this->m_customer->complain_del($id);
    }

    // NOTE : Complain - Find
    public function complain_find($id){
        $data = $this->m_customer->complain_find($id);
        echo json_encode($data);
    }

    // NOTE : Complain Update
    public function complain_update(){
        $this->form_validation->set_rules('id_komplain_cabang', 'ID Komplain', 'required');
        $this->form_validation->set_rules('tindakan_cabang', 'Tindakan', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('Failed', 'Pastikan data terisi');
            redirect('dashboard');
        }else{

            $id_komplain = $this->input->post('id_komplain_cabang');
            $keterangan = $this->input->post('tindakan_cabang');
            $tiket = $this->input->post('tiket');
            $filename = $this->uploadFootage(1,$tiket);
            $date = date('Y-m-d H:i:s');

            $data = array('keterangan'=>$keterangan,'status'=>'2','branch_date'=>$date,'footage_cabang'=>$filename);

            try{
                $this->m_customer->complain_update($id_komplain,$data);
                $this->session->set_flashdata('Success','<strong>Sukses!</strong> Tindakan berhasil disimpan');
                redirect('dashboard');
            }catch(Exception $e){
                $this->session->set_flashdata('Failed', '<strong>Gagal!</strong> Terjadi Kesalahan');
                redirect('dashboard');
            }

        }
    }

    
    // NOTE : Complain Confirm
    public function confirm(){
        $id = $this->input->post('confirm');
        $tiket = $this->input->post('confirm_tiket');
        $date = date('Y-m-d H:i:s');
        $filename = $this->uploadFootage(2,$tiket);
        $data = array('status'=>'3','confirm_date'=> $date, 'updated_by'=>$this->session->userdata('nama'),'footage_confirm'=>$filename);
        try{
            $this->m_customer->complain_update($id,$data);
            
            $this->session->set_flashdata('Success','<strong>Sukses!</strong> Data komplain berhasil di konfirmasi');
            redirect('dashboard#tab_content2-confirm');
        }catch(exception $e){
            $this->session->set_flashdata('Failed','<strong>Gagal!</strong> terjadi kesalahan saat konfirmasi');
            redirect('dashboard#tab_content2-confirm');
        }

    }

    // NOTE : Arsip - find
    public function arsip_find($id){
        $data = $this->m_customer->arsip_find($id);
        echo json_encode($data);
    }

    // NOTE : Arsip - Complain Add to Arsip
    public function complain_arsip(){
        $id_komplain = $this->input->post('id_komplain_arsip');

        $tiket = $this->input->post('tiket_arsip');
        $nama = $this->input->post('nama_arsip');
        $cabang = $this->input->post('cabang_arsip');
        $kapal = $this->input->post('kapal');
        $area = $this->input->post('area_arsip');
        $kategori = $this->input->post('kategori_arsip');
        $created_by = $this->input->post('created_by_arsip');
        $finished_by = $this->input->post('finished_by_arsip');
        $dif = $this->input->post('dif_arsip');
        $isi = $this->input->post('isi_arsip');
        $tindakan = $this->input->post('tindakan_arsip');
        $telp = $this->input->post('telp_arsip');
        $prioritas = $this->input->post('prioritas_arsip');
        $email = $this->input->post('email_arsip');
        $tgl_komplain = $this->input->post('tgl_komplain_arsip');
        $tgl_cabang = $this->input->post('tgl_cabang_arsip');
        $tgl_confirm = $this->input->post('tgl_confirm_arsip');
        $tgl_completed = date('Y-m-d H:i:s');
        $status = $this->input->post('status_arsip');

        $data = array('tiket'=>$tiket,'nama'=>$nama,'cabang'=>$cabang,'area'=>$area,
                'kategori'=>$kategori,'created_by'=>$created_by,'finished_by'=>$finished_by,
                'dif'=>$dif,'isi'=>$isi,'tindakan'=>$tindakan,'telp'=>$telp,'email'=>$email,
                'tgl_komplain'=>$tgl_komplain,'tgl_cabang'=>$tgl_cabang,'tgl_confirm'=>$tgl_confirm,'tgl_completed'=>$tgl_completed,
            'status'=>$status,'kapal'=>$kapal,'prioritas'=>$prioritas);

        try{
            $this->m_customer->complain_arsip($data);
            $this->m_customer->complain_del($id_komplain);
            $this->session->set_flashdata('Success','<strong>Sukses!</strong> Data berhasil disimpan!');
            redirect('dashboard#tab_content2-confirm');

        }catch(exception $e){
            $this->session->set_flashdata('Failed','<strong>Gagal!</strong> Data gagal disimpan!');
            redirect('dashboard#tab_content2-confirm');
        }        

    }
    
    //COMPLAIN

    //SEARCHING
    // NOTE : Searching
    public function search(){
        $val = $_GET['search-bar'];
        $data['customer'] = $this->m_customer->customer_search($val);
        $data['complain'] = $this->m_customer->complain_search($val);
        $this->load->view('common/v_main-header');
        $this->load->view('common/v_main-sidebar');
        $this->load->view('common/v_main-navbar');
        $this->load->view('backend/v_search',$data);
        $this->load->view('common/v_main-footer');
    }
    //SEARCHING

    


    //USER
    // NOTE : User - Get
    public function userGet(){
        $data = $this->m_user->user_get();
        $this->output->set_content_type('application/json');
        echo json_encode($data);
    }

    // NOTE : User - del
    public function user_del($id){
        $this->m_user->user_del($id);
    }

    // NOTE : User - input
    public function user_input(){
        $this->form_validation->set_rules('name','Nama','required|trim|min_length[4]');
        $this->form_validation->set_rules('username','Username','required|trim|min_length[4]');
        $this->form_validation->set_rules('password','Password','required|trim');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('Failed', '<strong>Gagal!</strong> Pastikan data yang anda isikan benar!');
            redirect('user');
        }else{

            // variable init
            $username = $this->input->post('username');
            $passwd = $this->input->post('password');
            $level = $this->input->post('level');
            $name = $this->input->post('name');
            if($level == 3){
                $cabang = $this->input->post('cabang');
                if($cabang == 110){
                    $divisi = $this->input->post('divisi');
                }
            }else{
                $cabang = 0;
                $divisi = NULL;
            }
            

            $valid_user = $this->m_user->username_check($username);

            if(!$valid_user){
                $this->session->set_flashdata('Failed', '<strong>Gagal!</strong> Username sudah terdaftar!');
                redirect('user');
            }
            
            $data = array('nameuser'=> $username, 'nama'=>$name, 'passwd'=> sha1($passwd), 'level' => $level, 'cabang' => $cabang,'divisi'=> $divisi);
            try{
                $this->m_user->user_input($data);
                $this->session->set_flashdata('Success', '<strong>Sukses!</strong> Data user berhasil ditambahkan!');
                redirect('user');
            }catch(Exception $e){
                $this->session->set_flashdata('Failed', '<strong>Gagal!</strong> Data user ditambahkan, terjadi kesalahan!');
                redirect('user');
            }
        }
    }

    // NOTE : User - Ganti Password
    public function userPassChange(){
        $this->form_validation->set_rules('oldpass', 'Password Lama', 'required');
        $this->form_validation->set_rules('newpass', 'Password Baru', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('passChangedFailed', TRUE);
            $uri = $this->input->post('uri');
            redirect($uri);
        }else{
            $uri = $this->input->post('uri');
            $id = $this->session->userdata('userid');
            $newpass = $this->input->post('newpass');
            $oldpass = $this->input->post('oldpass');

            if(sha1($oldpass) == $this->session->userdata('passwd')){
                $data = array('passwd'=>sha1($newpass));
                
                try{
                    $this->m_user->user_update($id,$data);
                    $this->session->set_userdata('passwd',sha1($newpass));
                    $this->session->set_flashdata('passChangedSuccess', TRUE);
                    redirect($uri);
                }catch(Exception $e){
                    $this->session->set_flashdata('fatalError', TRUE);
                    redirect($uri);
                }
            }else{
                $this->session->set_flashdata('passChangedFailed2', TRUE);
                redirect($uri);
            }
        }
    }
    //USER
    
    // NOTE : Loyalty - Get
    public function loyalty_get()
    {
        $data = $this->m_loyalty->loyalty_get();
        echo json_encode($data);
    }


    //UPLOAD CUSTOMER
    // NOTE : Customer Upload
    public function customer_upload(){
        //Path of files were you want to upload on localhost (C:/xampp/htdocs/ProjectName/uploads/excel/)	 
    $configUpload['upload_path'] = FCPATH.'upload/';
    $configUpload['allowed_types'] = 'xls|xlsx|csv';
    $configUpload['max_size'] = '500000';
    $this->load->library('upload', $configUpload);
    $this->upload->do_upload('userfile');	
    $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
    $file_name = $upload_data['file_name']; //uploded file name
    $extension=$upload_data['file_ext'];    // uploded file extension
   
//$objReader =PHPExcel_IOFactory::createReader('Excel5');     //For excel 2003 
$objReader= PHPExcel_IOFactory::createReader('Excel2007');	// For excel 2007 	  
     //Set to read only
     $objReader->setReadDataOnly(true); 		  
   //Load excel file
    $objPHPExcel=$objReader->load(FCPATH.'upload/'.$file_name);		 
    $totalrows=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();   //Count Number of rows avalable in excel      	 
    $objWorksheet=$objPHPExcel->setActiveSheetIndex(0);    
        
     //loop from first data untill last data
     $total = 0; $success = 0; $error = 0; 
        
        if($objWorksheet->getCellByColumnAndRow(2,1)->getValue()!='Nama'){
            $this->session->set_flashdata('Failed', '<strong>Gagal!</strong> Format data yang anda upload salah');
            redirect('dashboard');
        }
     for($i=2;$i<=$totalrows;$i++)
     {
        $id = $this->m_customer->IDcek();
        if ($id == '000001'){
            $userid = date("Y").date("m").$id;
        }else {
            $idnew = substr((string)$id->userid,-6);
            $userid = date("Y").date("m").$idnew + 1;
        }

         $nik   = $objWorksheet->getCellByColumnAndRow(0,$i)->getValue();
         $pass  = $objWorksheet->getCellByColumnAndRow(1,$i)->getValue();
         $nama  = $objWorksheet->getCellByColumnAndRow(2,$i)->getValue(); //Excel Column 2
         $tmp_lahir = $objWorksheet->getCellByColumnAndRow(3,$i)->getValue(); //Excel Column 3
         $tgl_lahir = $objWorksheet->getCellByColumnAndRow(4,$i)->getValue(); //Excel Column 3
         $gender = $objWorksheet->getCellByColumnAndRow(5,$i)->getValue(); //Excel Column 3
         $alamat = $objWorksheet->getCellByColumnAndRow(6,$i)->getValue(); //Excel Column 3
         $warga = $objWorksheet->getCellByColumnAndRow(7,$i)->getValue(); //Excel Column 3
         $telp = $objWorksheet->getCellByColumnAndRow(8,$i)->getValue(); //Excel Column 3
         $email = $objWorksheet->getCellByColumnAndRow(9,$i)->getValue(); //Excel Column 3
         $job = $objWorksheet->getCellByColumnAndRow(10,$i)->getValue(); //Excel Column 3
         $perusahaan = $objWorksheet->getCellByColumnAndRow(11,$i)->getValue(); //Excel Column 3
         $sosmed = $objWorksheet->getCellByColumnAndRow(12,$i)->getValue(); //Excel Column 3
         $nama_sosmed = $objWorksheet->getCellByColumnAndRow(13,$i)->getValue(); //Excel Column 3
               
             
         $res = explode('-',$tgl_lahir);
         $tgl_lahir = $res[2].'-'.$res[1].'-'.$res[0];

         $data = array('userid'=>$userid,'nik'=>$nik, 'nama'=>$nama, 'tempat_lahir'=>$tmp_lahir,
                        'warga'=>$warga,'tgl_lahir'=>$tgl_lahir,'gender'=>$gender,'alamat'=>$alamat,
                        'telp'=>$telp,'email'=>$email,'job'=>$job,'perusahaan'=>$perusahaan,
                        'sosmed'=>$sosmed,'nama_sosmed'=>$nama_sosmed,'passport'=>$pass);

         $total++;
         
        if($this->m_customer->check_nik($nik)->num_rows() != 0  && $nik != ''){
            $error++;
        }else if($this->m_customer->check_pass($pass)->num_rows() != 0  && $pass != ''){
            $error++;
        }else if ($this->m_customer->check_email($email)->num_rows() != 0){
            $error++;
        }else if ($this->m_customer->check_telp($telp)->num_rows() != 0 ){
            $error++;
        }else{

            try{
                $this->m_customer->customer_input($data); 
                $success++;
            }catch(exception $e){
                $this->session->set_flashdata('Failed', '<strong>Gagal!</strong> keterangan:'.$e);
                unlink('upload/'.$file_name); //File Deleted After uploading in database .			 
                redirect('dashboard');    
            }

        }
        $this->session->set_flashdata('Info','<strong>Selesai!</strong> Total Data: <font><b>'.$total.'</b></font> , Data yang sukses di upload : <font ><b>'.$success.'</b></font> , Data yang gagal : <font ><b>'.$error.'</b></font> !');
     }
        unlink('upload/'.$file_name); //File Deleted After uploading in database .			 
        redirect('dashboard');
    }


    //EXPORT DATA
    //export ke dalam format excel
    //NOTE : Customer Export excel
    public function export_excel(){
        $data['customer'] = $this->m_customer->customer_get();

        $this->load->view('backend/v_download',$data);
   }

    //NOTE : Customer Download Excel
   public function download_excel(){
    $excel = new PHPExcel();
    
    // Settingan awal file excel
    $excel->getProperties()->setCreator('Customer Relationship Management - '.$this->session->userdata('nama').'')
          ->setLastModifiedBy('Customer Relationship Management - '.$this->session->userdata('nama').'')             
          ->setTitle("Data Pelanggan")             
          ->setSubject("Pelanggan")             
          ->setDescription("Laporan Semua Data Pelanggan")             
          ->setKeywords("Data Pelanggan");
          
          // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
    $style_col = array(  'font' => array('bold' => true), // Set font nya jadi bold  
          'alignment' => array(    
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)    
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)  
                            ),  
          'borders' => array(    
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis    
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis    
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis    
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis  
                            ),
          'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'EFF0F1')
        ));// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
    $style_row = array(  
        'alignment' => array(    
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, // Set text jadi di tengah secara vertical (middle)  
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
                            ),  
        'borders' => array(    
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis    
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis    
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis    
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis  
        ));
    
        $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA PELANGGAN - PT. ASDP Indonesia Ferry"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:O1'); // Set Merge Cell pada kolom A1 sampai F1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(24); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "UserID");
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "NIK"); // Set kolom A1 dengan tulisan "NIK"
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "Passport"); // Set kolom B1 dengan tulisan "Nama"
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "Nama"); // Set kolom B1 dengan tulisan "Nama"
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "Tempat Lahir"); // Set kolom C1 dengan tulisan "Tempat lahir"
        $excel->setActiveSheetIndex(0)->setCellValue('F3', "Tanggal Lahir"); // Set kolom D1 dengan tulisan "Tanggal Lahir"
        $excel->setActiveSheetIndex(0)->setCellValue('G3', "Jenis Kelamin"); // Set kolom E1 dengan tulisan "Jenis Kelamin"
        $excel->setActiveSheetIndex(0)->setCellValue('H3', "Alamat"); // Set kolom F1 dengan tulisan "Alamat"
        $excel->setActiveSheetIndex(0)->setCellValue('I3', "Kewarganegaraan");
        $excel->setActiveSheetIndex(0)->setCellValue('J3', "No Telp");
        $excel->setActiveSheetIndex(0)->setCellValue('K3', "Email");
        $excel->setActiveSheetIndex(0)->setCellValue('L3', "Pekerjaan");
        $excel->setActiveSheetIndex(0)->setCellValue('M3', "Nama Perusahaan");
        $excel->setActiveSheetIndex(0)->setCellValue('N3', "Sosmed");
        $excel->setActiveSheetIndex(0)->setCellValue('O3', "Nama Sosmed");
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('O3')->applyFromArray($style_col);
        // Set height baris ke 1, 2 dan 3
        // $excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
        // $excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
        // $excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
        // Buat query untuk menampilkan semua data siswa
        // $sql = $pdo->prepare("SELECT * FROM siswa");
        // $sql->execute(); // Eksekusi querynya$no = 1; // Untuk penomoran tabel, di awal set dengan 1

        $data = $this->m_customer->customer_get();

        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        // while($data = $sql->fetch()){ // Ambil semua data dari hasil eksekusi $sql  
        foreach ($data as $row){
            $excel->setActiveSheetIndex(0)->setCellValueExplicit('A'.$numrow, $row->userid, PHPExcel_Cell_DataType::TYPE_STRING);  
            $excel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$numrow, $row->nik, PHPExcel_Cell_DataType::TYPE_STRING);
            $excel->setActiveSheetIndex(0)->setCellValueExplicit('C'.$numrow, $row->passport, PHPExcel_Cell_DataType::TYPE_STRING);
            //$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $row->nik);    
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $row->nama);  
            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $row->tempat_lahir);    // Khusus untuk no telepon. kita set type kolom nya jadi STRING  
            $excel->setActiveSheetIndex(0)->setCellValueExplicit('F'.$numrow, $row->tgl_lahir, PHPExcel_Cell_DataType::TYPE_STRING);    
            $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $row->gender);
            $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $row->alamat);    
            $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $row->warga);
            $excel->setActiveSheetIndex(0)->setCellValueExplicit('J'.$numrow, $row->telp, PHPExcel_Cell_DataType::TYPE_STRING);
            $excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $row->email);
            $excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $row->job);
            $excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $row->perusahaan);
            $excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $row->sosmed);
            $excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $row->nama_sosmed);
            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)  
            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);  
            $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);  
            $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);  
            $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);  
            $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);  
            $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_row);    
            $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);    
            // $no++; // Tambah 1 setiap kali looping  
            $numrow++; // Tambah 1 setiap kali looping}
        }
            // Set width kolom
            $excel->getActiveSheet()->getColumnDimension('A')->setWidth(30); // Set width kolom A
            $excel->getActiveSheet()->getColumnDimension('B')->setWidth(30); // Set width kolom B
            $excel->getActiveSheet()->getColumnDimension('C')->setWidth(30); // Set width kolom C
            $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
            $excel->getActiveSheet()->getColumnDimension('E')->setWidth(15); // Set width kolom E
            $excel->getActiveSheet()->getColumnDimension('F')->setWidth(30); // Set width kolom F
            $excel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
            $excel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
            $excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
            $excel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
            $excel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
            $excel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
            $excel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
            $excel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
            $excel->getActiveSheet()->getColumnDimension('O')->setWidth(30);

            
            // Set orientasi kertas jadi LANDSCAPE
            $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            // Set judul file excel nya
            $excel->getActiveSheet(0)->setTitle("Laporan Data Customer");
            $excel->setActiveSheetIndex(0);
            // Proses file 
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
            // header("Content-type: application/vnd-ms-excel");
            header('Content-Disposition: attachment; filename="DataCustomer'.date('d').date('m').date('Y').'.xlsx" '); // Set nama file excel nya
            header('Cache-Control: max-age=0');
            $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            ob_end_clean();
            $write->save('php://output');
        
   }


   //JSON for Graph komplain

    // NOTE : JSON FOR COMPLAIN CHART
    // FIXME : ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //FUTURE : Data (Tahun) - Total semua komplain
   public function chart_complain_all($tahun){
       $data = $this->m_complain_chart->complain_chart_all($tahun);
       $this->output->set_content_type('application/json');
       echo json_encode($data);
   }
    
    //FUTURE : Data (Tahun) - Komplain yang sudah selesai
    public function chart_complain_done_all($tahun){
       $data = $this->m_complain_chart->done_complain_all($tahun);
       $this->output->set_content_type('application/json');
       echo json_encode($data);
   }
    
    //FUTURE : Data (Tahun) - Komplain yang belum selesai
    public function chart_complain_belum_all($tahun){
       $data = $this->m_complain_chart->belum_complain_all($tahun);
       $this->output->set_content_type('application/json');
       echo json_encode($data);
   }
    // FIXME : ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    //FUTURE : Data (Tahun,Cabang) - Total semua komplain
   public function chart_complain_cabang($tahun,$cabang){
        $data = $this->m_complain_chart->complain_chart_cabang($tahun,$cabang);
        $this->output->set_content_type('application/json');
        echo json_encode($data);
   }

    //FUTURE : Data (Tahun,Cabang) - Komplain yang sudah selesai
    public function chart_complain_done_cabang($tahun,$cabang){
        $data = $this->m_complain_chart->done_complain_chart_cabang($tahun,$cabang);
        $this->output->set_content_type('application/json');
        echo json_encode($data);
   }
    
    //FUTURE : Data (Tahun,Cabang) - Komplain yang belum selesai
    public function chart_complain_belum_cabang($tahun,$cabang){
        $data = $this->m_complain_chart->belum_complain_chart_cabang($tahun,$cabang);
        $this->output->set_content_type('application/json');
        echo json_encode($data);
   }
    
    // FIXME : ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    
    //FUTURE : Data (Tahun,Cabang,Kategori) - Total semua komplain
   public function chart_complain_kategori($tahun,$cabang,$kategori){
        $data = $this->m_complain_chart->complain_chart_kategori($tahun,$cabang,$kategori);
        $this->output->set_content_type('application/json');
        echo json_encode($data);
   }
    
    //FUTURE : Data (Tahun,Cabang,Kategori) - Komplain yang sudah selesai
   public function chart_complain_done_kategori($tahun,$cabang,$kategori){
        $data = $this->m_complain_chart->done_complain_chart_kategori($tahun,$cabang,$kategori);
        $this->output->set_content_type('application/json');
        echo json_encode($data);
   }
    
    //FUTURE : Data (Tahun,Cabang,Kategori) - Komplain yang belum selesai
   public function chart_complain_belum_kategori($tahun,$cabang,$kategori){
        $data = $this->m_complain_chart->belum_complain_chart_kategori($tahun,$cabang,$kategori);
        $this->output->set_content_type('application/json');
        echo json_encode($data);
   }
    
    // FIXME : ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    
    //FUTURE : Data (Tahun,Kategori) - Total Semua Komplain
   public function chart_complain_kategori2($tahun,$kategori){
        $data = $this->m_complain_chart->complain_chart_kategori2($tahun,$kategori);
        $this->output->set_content_type('application/json');
        echo json_encode($data);
    }
    
    //FUTURE : Data (Tahun,Kategori) - Komplain yang sudah selesai
    public function chart_complain_done_kategori2($tahun,$kategori){
        $data = $this->m_complain_chart->done_complain_chart_kategori2($tahun,$kategori);
        $this->output->set_content_type('application/json');
        echo json_encode($data);
    }
    
    //FUTURE : Data (Tahun,Kategori) - Komplain yang belum selesai
    public function chart_complain_belum_kategori2($tahun,$kategori){
        $data = $this->m_complain_chart->belum_complain_chart_kategori2($tahun,$kategori);
        $this->output->set_content_type('application/json');
        echo json_encode($data);
    }
    
    // FIXME : ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    
    //NOTE : JSON FOR KATEGORI CHART
    //FUTURE : Data (Tahun) - Komplain berdasarkan kategori
    public function kategori_chart_complain1($tahun){
        $data = $this->m_complain_chart->complain_kategori_chart1($tahun);
        $this->output->set_content_type('application/json');
        echo json_encode($data);
    }
    
    //FUTURE : Data (Tahun,Kategori) - Komplain berdasarkan kategori
    public function kategori_chart_complain2($tahun,$kategori){
        $data = $this->m_complain_chart->complain_kategori_chart2($tahun,$kategori);
        $this->output->set_content_type('application/json');
        echo json_encode($data);
    }
    
     // FIXME : ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    
    //NOTE : JSON FOR CABANG CHART
    //FUTURE : Data (Tahun) - Komplain berdasarkan cabang
    public function cabang_chart_complain1($tahun){
        $data = $this->m_complain_chart->complain_cabang_chart1($tahun);
        $this->output->set_content_type('application/json');
        echo json_encode($data);
    }
    
    //FUTURE : Data (Tahun,Kategori) - Komplain berdasarkan cabang
    public function cabang_chart_complain2($tahun,$kategori){
        $data = $this->m_complain_chart->complain_cabang_chart2($tahun,$kategori);
        $this->output->set_content_type('application/json');
        echo json_encode($data);
    }
    
    //FUTURE : Data Done (Tahun) - Komplain berdasarkan cabang
    public function cabang_done_chart_complain1($tahun){
        $data = $this->m_complain_chart->complain_done_cabang_chart1($tahun);
        $this->output->set_content_type('application/json');
        echo json_encode($data);
    }
    
    //FUTURE : Data Done (Tahun,Kategori) - Komplain berdasarkan cabang
    public function cabang_done_chart_complain2($tahun,$kategori){
        $data = $this->m_complain_chart->complain_done_cabang_chart2($tahun,$kategori);
        $this->output->set_content_type('application/json');
        echo json_encode($data);
    }
    
    //FUTURE : Data Belum (Tahun) - Komplain berdasarkan cabang
    public function cabang_belum_chart_complain1($tahun){
        $data = $this->m_complain_chart->complain_belum_cabang_chart1($tahun);
        $this->output->set_content_type('application/json');
        echo json_encode($data);
    }
    
    //FUTURE : Data Belum (Tahun,Kategori) - Komplain berdasarkan cabang
    public function cabang_belum_chart_complain2($tahun,$kategori){
        $data = $this->m_complain_chart->complain_belum_cabang_chart2($tahun,$kategori);
        $this->output->set_content_type('application/json');
        echo json_encode($data);
    }
    // FIXME : ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    
   public function chart_get_year(){
    $data = $this->m_complain_chart->complain_get_year();
    $this->output->set_content_type('application/json');
    echo json_encode($data);
   }

   //JSON for Graph komplain
    
    
    //NOTE : Upload - bukti konfirmasi dan bukti dari cabang
    public function uploadFootage($no,$tiket){

        if($no == 1){
            $configUpload['upload_path'] = FCPATH.'upload/footage_branch';
            $configUpload['allowed_types'] = '*';//'gif|jpg|jpeg|png';
            $configUpload['max_size'] = '10240';
            $configUpload['max_filename'] = '255';
        }else{
            $configUpload['upload_path'] = FCPATH.'upload/footage_confirm';
            $configUpload['allowed_types'] = 'jpg|jpeg|png|wav|mp3|ogg|aiff|zip|rar';
            $configUpload['max_size'] = '5120';
            $configUpload['max_filename'] = '255';
        }
        $this->load->library('upload', $configUpload);
//        $this->upload->do_upload('userfile');	
        
        
        
        if($this->upload->do_upload('userfile'))
        {
            $file = $this->upload->data();
            $file_name = $file['file_name']; //uploded file name
            $extension = $file['file_ext'];    // uploded file extension
            $finalName = $tiket.$extension;
            $file_path = $file['file_path'];
            $file = $file['full_path'];
            
            
            rename($file, $file_path.$finalName);
                        
        }
        else
        {
            $this->session->set_flashdata('Failed', '<strong>Gagal!</strong> '.$this->upload->display_errors());
            
            redirect('dashboard');
        }
        return $finalName;
        
    }
    
//    NOTE : Download bukti dari cabang
public function download1($fileName = NULL) {   
//   if ($fileName) {
    $file =  FCPATH.'upload/footage_branch/'. $fileName;
    // check file exists    
    if (file_exists ( $file )) {
     // get file content
     $data = file_get_contents ( $file );
     //force download
     force_download ( 'Bukti Tindakan-'.$fileName, $data );
//    } else {
     // Redirect to base url
//     redirect ( 'dashboard');
    }
   }
//  }
    
    public function download2($fileName = NULL) {   
//   if ($fileName) {
    $file =  FCPATH.'upload/footage_confirm/'. $fileName;
    // check file exists    
    if (file_exists ( $file )) {
     // get file content
     $data = file_get_contents ( $file );
     //force download
     force_download ( 'Bukti Konfirmasi-'.$fileName, $data );
//    } else {
     // Redirect to base url
//     redirect ( 'dashboard');
    }
   }





    

}
