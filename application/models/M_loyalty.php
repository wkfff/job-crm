<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_loyalty Extends CI_model{
    
    function __construct()
    {
        parent::__construct();
    }
    
    //NOTE : loyalty - input
    public function loyalty_input($data){
        $this->db->insert('m08_achievement', $data); 
    }
    
    //NOTE : Order get
    public function loyalty_order_get($tipe_loyalty){
        $query = $this->db->select('count(id) as urut')
                          ->where('tipe',$tipe_loyalty)
                          ->get('m08_achievement');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return array();
        }
    }
    
    //NOTE : Order find
    public function loyalty_order_find($tipe,$order){
        $query = $this->db->where('tipe = "'.$tipe.'" AND ordering = '.$order.'')
                          ->limit(1)
                          ->get('m08_achievement');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return array();
        }
    }
    
    //NOTE : Order up
    public function loyalty_order_up($id,$order){
        $data = array('ordering'=>$order-1);
        $this->db->where('id', $id)
            ->update('m08_achievement', $data);
    }
    
    //NOTE : Order Down
    public function loyalty_order_down($id,$order){
        $data = array('ordering'=>$order+1);
        $this->db->where('id', $id)
            ->update('m08_achievement', $data);
    }
    
    //NOTE : loyalty - del
    public function loyalty_del($id){
        $this->db->where('id',$id)->delete('m08_achievement');
    }

    //NOTE : loyalty - find
    public function loyalty_find($id){
        $query = $this->db->where('id', $id)
        ->limit(1)
        ->get('m08_achievement');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return array();
        }
    }
    
    // NOTE : loyalty - update
    public function loyalty_update($id, $data)
    {
        $this->db->where('id', $id)
            ->update('m08_achievement', $data);
    }
    
    // NOTE : loyalty - get 
    public function loyalty_get()
    {
        $query = $this->db->query('select * from  m08_achievement order by tipe , ordering ');
        if($query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    // NOTE : count - perjalanan
    public function count_perjalanan($id){
        $query = $this->db->query('select count(a.id_perjalanan) as perjalanan from p01_perjalanan a where a.id_customer = '.$id.'');
        if($query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return array();
        }
    }
    
     // NOTE : count - customer care
    public function count_customer($id){
        $query = $this->db->query('select count(a.id_komplain) as komplain from p02_komplain a where a.id_customer = '.$id.'');
        if($query->num_rows() > 0 ) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    // NOTE : count - perjalanan lintasan
    public function count_lintasan($id){
        $query = $this->db->query('select b.nama_asal as asal,c.nama_asal as tujuan,a.id_pelabuhan_asal,a.id_pelabuhan_tujuan,count(a.id_customer) as perjalanan from p01_perjalanan a left join m03_lintasan_awal b on a.id_pelabuhan_asal = b.id left join m03_lintasan_awal c on a.id_pelabuhan_tujuan = c.id where a.id_customer = '.$id.' group by a.id_pelabuhan_asal, a.id_pelabuhan_tujuan order by perjalanan desc limit 3');
        if($query->num_rows() > 0 ) {
            return $query->result(); 
        } else {
            return array();
        }
    }
    
    // NOTE : Loyalty - check level
    public function loyalty_check_level($tipe,$max){
        $query = $this->db->query('select a.ordering from m08_achievement a where a.max <= '.$max.' and a.tipe = "'.$tipe.'" order by a.max desc limit 1');
        if($query->num_rows() > 0 ) {
            return $query->row(); 
        } else {
            $query = $this->db->query('select a.ordering from m08_achievement a where a.tipe = "'.$tipe.'" order by a.max limit 1');
             if($query->num_rows() > 0 ) {
                    return $query->row(); 
                } else {
                    return array();
                }
        }
    }
}
