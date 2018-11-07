<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user Extends CI_model{
    
    function __construct()
    {
        parent::__construct();
    }
    
    // NOTE : Divisi get
    public function divisi_get(){
        $query = $this->db
        ->get('m06_divisi');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    // NOTE : user get
    public function user_get(){
        $query = $this->db->query('SELECT a.id_user,a.nama,a.nameuser,a.passwd,a.divisi,b.nama as cabang,a.cabang as id_cabang, c.nama as nama_divisi,a.`level`,a.log from m01_user a left join m07_cabang b on a.cabang = b.id_cabang left join m06_divisi c on a.divisi = c.id_divisi order by id_user ASC');
        
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    // NOTE : user get cabang
    public function user_get_cabang($id_cabang){
        $query = $this->db->query("SELECT a.id_user,a.nama,a.nameuser,a.passwd,a.divisi,b.nama as cabang,a.cabang as id_cabang, c.nama as nama_divisi,a.`level`,a.log from m01_user a left join m07_cabang b on a.cabang = b.id_cabang left join m06_divisi c on a.divisi = c.id_divisi where id_cabang = '".$id_cabang."' order by id_user ASC");
        
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    // NOTE : user get divisi
    public function user_get_divisi($id_divisi){
        $query = $this->db->query("SELECT a.id_user,a.nama,a.nameuser,a.passwd,a.divisi,b.nama as cabang,a.cabang as id_cabang, c.nama as nama_divisi,a.`level`,a.log from m01_user a left join m07_cabang b on a.cabang = b.id_cabang left join m06_divisi c on a.divisi = c.id_divisi where id_divisi = '".$id_divisi."' order by id_user ASC");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    // NOTE : user find
    public function user_find($username){
        $query = $this->db->query("SELECT a.id_user,a.nama,a.nameuser,a.passwd,a.divisi,b.nama as cabang,a.cabang as id_cabang, c.nama as nama_divisi,a.`level`,a.log from m01_user a left join m07_cabang b on a.cabang = b.id_cabang left join m06_divisi c on a.divisi = c.id_divisi where nameuser = '".$username."' limit 1");
        
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return array();
        }
    }

    // NOTE : Check username
    public function username_check($where){
        $query = $this->db->where($where)
                          ->limit(1)
                          ->get('m01_user');
        return $query;
    }

    //NOTE : Last Login
    public function last_login($data,$where){
        $this->db->where($where)
        ->update('m01_user', $data);
    }


    // NOTE : user input
    public function user_input($data){
        $this->db->insert('m01_user', $data);
    }

    // NOTE : user del
    public function user_del($id){
        $this->db->where('id_user',$id)->delete('m01_user');
    }

    //NOTE : user update
    public function user_update($id, $data){
        $this->db->where('id_user', $id)
        ->update('m01_user', $data);
    }

    


}
