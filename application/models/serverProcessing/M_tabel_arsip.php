<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class M_tabel_arsip extends CI_Model { 
 
    var $table = 'p03_arsip'; //nama tabel dari database
    var $column_order = array('tiket', 'nama','cabang','area','kapal','kategori','tgl_komplain','telp','email',null); //field yang ada di table user
    var $column_search = array('tiket','nama','cabang','area','kapal','kategori','tgl_komplain','telp','email'); //field yang diizin untuk pencarian 
    var $order = array('tiket' => 'desc'); // default order 
 
    public function __construct()
    { 
        parent::__construct();
    }
  
    private function _get_datatables_query($cabang,$area,$kategori)
    {
         
        $this->db->from($this->table);
        $this->db->select('id_arsip,tiket, nama,cabang,area,kapal,kategori,tgl_komplain,telp,email'); 
        
        if($cabang != 'semua'){
            $this->db->where('cabang',$cabang);
        } 
        
        if($area != 'semua'){
            $this->db->where('area',$area);
        }
        
        if($kategori != 'semua'){
            $this->db->where('kategori',$kategori);
        }
        
        $i = 0;
        
        foreach ($this->column_search as $item) // looping awal
        {
            if($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {
                                 
                if($i===0) // looping awal
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
        
        
    }
 
    function get_datatables($cabang,$area,$kategori)
    {
        $this->_get_datatables_query($cabang,$area,$kategori);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered($cabang,$area,$kategori)
    {
        $this->_get_datatables_query($cabang,$area,$kategori);
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
 
}
