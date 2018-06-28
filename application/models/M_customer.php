<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_customer Extends CI_model{
    
    function __construct()
    {
        parent::__construct();
    }
 
    //NOTE : cabang - get 
    public function branch_get(){
        $query = $this->db->select()
        ->get('m07_cabang'); 
        if($query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return array();
        }
    }
    //Cabang

    //NOTE : customer - del
    public function customer_del($id){
        $this->db->where('id',$id)->delete('m02_customer');
        
    }

    //NOTE : customer - find
    public function customer_find($id){ 
        $query = $this->db->where('id', $id)
        ->limit(1)
        ->get('m02_customer');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return array();
        }
    }
    

    //NOTE : customer - get
    public function customer_get(){
        $query = $this->db->select()
        ->order_by('id','desc')
        ->get('m02_customer');
        if($query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return array();
        }
    }

    //NOTE : customer - input
    public function customer_input($data){
        $this->db->insert('m02_customer', $data);
    }

    //NOTE : customer - search
    public function customer_search($val){
        $query = $this->db->select()
        ->or_like('nama',$val)
        ->or_like('nik',$val)
        ->or_like('userid',$val)
        ->or_like('tgl_lahir',$val)
        ->or_like('gender',$val)
        ->or_like('alamat',$val)
        ->or_like('telp',$val)
        ->or_like('email',$val)
        ->or_like('job',$val)
        ->or_like('perusahaan',$val)
        ->or_like('nama_sosmed',$val)
        ->order_by('id','asc')
        ->get('m02_customer');
        if($query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return array();
        }
    }

    //NOTE : check email
    public function check_email($email)
	{
		$query = $this->db->where('email',$email)
						  ->limit(1)
						  ->get('m02_customer');
		
		return $query;
    }
    
    //NOTE : check pass
    public function check_pass($pass)
	{
		$query = $this->db->where('passport',$pass)
						  ->limit(1)
						  ->get('m02_customer');
		
		return $query;
    }
    
    //NOTE : check nik
    public function check_nik($nik)
	{
		$query = $this->db->where('nik',$nik)
						  ->limit(1)
						  ->get('m02_customer');
		
		return $query;
    }
    
    //NOTE : check telp
    public function check_telp($telp)
	{
		$query = $this->db->where('telp',$telp)
						  ->limit(1)
						  ->get('m02_customer');
		
		return $query;
	}

    //NOTE : customer - check email
    public function customerCheck_email($email){
        $valid = FALSE;
        $query = $this->db->select('email')
        ->where('email',$email)
        ->limit(1)
        ->get('m02_customer');
        if ($query->num_rows() > 0) {
            return $valid;
        } else {
            $valid = TRUE;
            return $valid;
        }
    }

    //NOTE : customer - check nik
    public function customerCheck_nik($nik){
        $valid = FALSE;
        $query = $this->db->select('nik')
        ->where('nik',$nik)
        ->limit(1)
        ->get('m02_customer');
        if ($query->num_rows() > 0) {
            return $valid;
        } else {
            $valid = TRUE;
            return $valid;
        }
    }

    //NOTE : customer - check telp
    public function customerCheck_telp($telp){
        $valid = FALSE;
        $query = $this->db->select('telp')
        ->where('telp',$telp)
        ->limit(1)
        ->get('m02_customer');
        if ($query->num_rows() > 0) {
            return $valid;
        } else {
            $valid = TRUE;
            return $valid;
        }
    }
    
    //NOTE : customer - check  passport
    public function customerCheck_pass($pass){
        $valid = FALSE;
        $query = $this->db->select('passport')
        ->where('passport',$pass)
        ->limit(1)
        ->get('m02_customer');
        if ($query->num_rows() > 0) {
            return $valid;
        } else {
            $valid = TRUE;
            return $valid;
        }
    }

    // NOTE : Customer - update
    public function customer_update($id, $data)
    {
        $this->db->where('id', $id)
            ->update('m02_customer', $data);
    }
    
    
    
    // NOTE : Customer - Trip frequent add
    public function frequent_add($id)
    {
        $freq = $this->customer_find($id)->trip_freq + 1;
        $data = array('trip_freq'=>$freq);
        
        $this->db->where('id',$id)
            ->update('m02_customer',$data);
    }
    
    // NOTE : Customer - last activity
    public function customer_lastAct($id)
    {
        $query = $this->db->query('select tgl_berangkat, b.nama_asal as asal, c.nama_asal as tujuan from p01_perjalanan a left join m03_lintasan_awal b on a.id_pelabuhan_asal = b.id left join m03_lintasan_awal c on a.id_pelabuhan_tujuan = c.id where id_customer = '.$id.' order by tgl_berangkat DESC');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return array('tgl_berangkat'=>'0');
        }
    }

    // NOTE : ID Check
    public function IDcek(){
        $query = $this->db->select('userid')
        ->order_by('id', 'desc')
        ->limit(1)
        ->get('m02_customer');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return '000001';
        }
    }
    //Customer


    //PORT
    // NOTE : Port Get
    public function port_get(){
        $query = $this->db->select()
        ->order_by('nama_asal','asc')
        ->get('m03_lintasan_awal');
        if($query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return array();
        }
    }

    //NOTE : port - jadwal Ambil Lintasan
    public function port_jadwal($id){
        $query = $this->db->select('id_daerah_tujuan')
                        ->where('id_daerah_asal', $id)
        ->get('m03_lintasan_jadwal');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    // NOTE : Port Find
    public function port_find($id){
        $query = $this->db->where('id', $id)
        ->get('m03_lintasan_awal');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    //PORT


    //KENDARAAN
    // NOTE : Kendaraan Get
    public function kendaraan_get(){
        $query = $this->db->select()
        ->get('m04_golongan');
        if($query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return array();
        }
    }
    //KENDARAAN


    //PERJALANAN
    // NOTE : Perjalanan Input
    public function perjalanan_input($data){
        $this->db->insert('p01_perjalanan', $data);
    }

    // NOTE : Perjalanan Del
    public function perjalanan_del($id){
        $this->db->where('id_perjalanan',$id)->delete('p01_perjalanan');
    }
    //PERJALANAN


    //SHIP
    // NOTE : Ship Get
    public function ship_get(){
        $query = $this->db->select()
        ->order_by('nama_kapal','asc')
        ->get('m05_kapal');
        if($query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return array();
        }
    }
    //SHIP


    //ARSIP
    // NOTE : Arsip - Get
    public function arsip_get(){
        $query = $this->db->select()
        ->get('p03_arsip');
        if($query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return array();
        }
    }

    // NOTE : Arsip - Find
    public function arsip_find($id){
        $query = $this->db->where('id_arsip', $id)
        ->limit(1)
        ->get('p03_arsip');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return array();
        }
    }
    //ARSIP


    //COMPLAIN
    // NOTE : Complain Input
    public function complain_input($data){
        $this->db->insert('p02_komplain',$data);
        $this->db->insert('h01_komplain',$data);
    }

    // NOTE : Complain Arsip
    public function complain_arsip($data){
        $this->db->insert('p03_arsip',$data);
    }

    // NOTE : Complain update
    public function complain_update($id,$data){
        $this->db->where('id_komplain', $id)
        ->update('p02_komplain', $data);
        $this->db->where('id_komplain', $id)
        ->update('h01_komplain', $data);
    }

    // NOTE : Complain - Del
    public function complain_del($id){
        $this->db->where('id_komplain',$id)->delete('p02_komplain');
    }
    
    // NOTE : Complain - Del By id customer
    public function complain_del2($id){
        $this->db->where('id_customer',$id)->delete('p02_komplain');
    }
    
    //NOTE : History Complain - del by id customer
    public function hcomplain_del2($id){
        $this->db->where('id_customer',$id)->delete('h01_komplain'); 
    }

    // NOTE : Complain Search
    public function complain_search($val){
        $search = "WHERE tiket LIKE  '".$val."%' OR tgl_komplain LIKE '".$val."%' OR c.nama REGEXP '".$val."' OR a.area LIKE '".$val."%' OR d.nama_kapal LIKE '".$val."%' OR a.kategori LIKE '".$val."%' OR b.nama REGEXP '".$val."' OR a.isi_komplain REGEXP '".$val."' OR status LIKE '".$val."%'";
        $query = $this->db->query("select a.id_komplain,a.id_customer,a.tiket,a.tgl_komplain, DATE_ADD(date(a.tgl_komplain), INTERVAL a.prioritas DAY) as batas,DATEDIFF(DATE_ADD(date(a.tgl_komplain), INTERVAL a.prioritas DAY),curdate()) as dif,b.nama,b.userid,b.telp,b.email,a.id_cabang,c.nama as cabang,a.id_divisi,e.nama as divisi, a.area, d.nama_kapal as kapal, a.kategori, a.prioritas, a.isi_komplain, a.`status`,a.created_by,a.updated_by,a.branch_date,a.confirm_date,a.completed_date,a.footage_cabang,a.footage_confirm,a.keterangan  from p02_komplain a left join m02_customer b on a.id_customer = b.id left join m07_cabang c on c.id_cabang =a.id_cabang left join m05_kapal d on d.id_kapal=a.id_kapal left join m06_divisi e on a.id_divisi = e.id_divisi ".$search);
        
        if($query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return array();
        }

    }

    // NOTE : Complain Find
    public function complain_find($id){
        $query = $this->db->query("select a.id_komplain,a.id_customer,a.tiket,a.tgl_komplain, DATE_ADD(date(a.tgl_komplain), INTERVAL a.prioritas DAY) as batas,DATEDIFF(DATE_ADD(date(a.tgl_komplain), INTERVAL a.prioritas DAY),curdate()) as dif,b.nama,b.userid,b.telp,b.email,a.id_cabang,c.nama as cabang,a.id_divisi,e.nama as divisi, a.area, d.nama_kapal as kapal, a.kategori, a.prioritas, a.isi_komplain, a.`status`,a.created_by,a.updated_by,a.branch_date,a.confirm_date,a.completed_date,a.footage_cabang,a.footage_confirm,a.keterangan  from p02_komplain a left join m02_customer b on a.id_customer = b.id left join m07_cabang c on c.id_cabang =a.id_cabang left join m05_kapal d on d.id_kapal=a.id_kapal left join m06_divisi e on a.id_divisi = e.id_divisi where id_komplain = '".$id."' limit 1");
        if ($query->num_rows() > 0) {
            return $query->row(); 
        } else {
            return array();
        }
    }

    // NOTE : Complain find By Cabang
    public function complain_find_cabang($id_cabang){
        $query = $this->db->query("select a.id_komplain,a.id_customer,a.tiket,a.tgl_komplain, DATE_ADD(date(a.tgl_komplain), INTERVAL a.prioritas DAY) as batas,DATEDIFF(DATE_ADD(date(a.tgl_komplain), INTERVAL a.prioritas DAY),curdate()) as dif,b.nama,b.userid,b.telp,b.email,a.id_cabang,c.nama as cabang,a.id_divisi,e.nama as divisi, a.area, d.nama_kapal as kapal, a.kategori, a.prioritas, a.isi_komplain, a.`status`,a.created_by,a.updated_by,a.branch_date,a.confirm_date,a.completed_date,a.footage_cabang,a.footage_confirm,a.keterangan  from p02_komplain a left join m02_customer b on a.id_customer = b.id left join m07_cabang c on c.id_cabang =a.id_cabang left join m05_kapal d on d.id_kapal=a.id_kapal left join m06_divisi e on a.id_divisi = e.id_divisi where a.id_cabang = '".$id_cabang."' AND a.status = '0' order by dif ASC");
        
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    // NOTE : Complain find By Divisi
    public function complain_find_divisi($id_divisi){
        $query = $this->db->query("select a.id_komplain,a.id_customer,a.tiket,a.tgl_komplain, DATE_ADD(date(a.tgl_komplain), INTERVAL a.prioritas DAY) as batas,DATEDIFF(DATE_ADD(date(a.tgl_komplain), INTERVAL a.prioritas DAY),curdate()) as dif,b.nama,b.userid,b.telp,b.email,a.id_cabang,c.nama as cabang,a.id_divisi,e.nama as divisi, a.area, d.nama_kapal as kapal, a.kategori, a.prioritas, a.isi_komplain, a.`status`,a.created_by,a.updated_by,a.branch_date,a.confirm_date,a.completed_date,a.footage_cabang,a.footage_confirm,a.keterangan  from p02_komplain a left join m02_customer b on a.id_customer = b.id left join m07_cabang c on c.id_cabang =a.id_cabang left join m05_kapal d on d.id_kapal=a.id_kapal left join m06_divisi e on a.id_divisi = e.id_divisi where a.id_divisi = '".$id_divisi."' AND a.status = '0' order by dif ASC");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    //COMPLAIN

}
