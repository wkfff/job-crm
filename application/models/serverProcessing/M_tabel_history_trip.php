<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class M_tabel_history_trip extends CI_Model { 
 
    var $table = 'p01_perjalanan'; //nama tabel dari database
    var $column_order = array(null,"b.nama_asal", "c.nama_tujuan", "a.tgl_berangkat","a.kendaraan", "d.alias", "a.penumpang","a.penumpang_bayi"); //field yang ada di table user
    var $search = '';
 
    public function __construct()
    { 
        parent::__construct();
    }
       
    function get_datatables($id)
    {
        if($_POST['search']['value']){
            $cari = $_POST['search']['value'];
            $this->search = "where a.id_customer = ".$id." AND (b.nama_asal REGEXP '".$cari." OR c.nama_tujuan REGEXP '".$cari."' OR a.tgl_berangkat LIKE '".$cari."%' OR a.kendaraan REGEXP '".$cari."' OR d.alias REGEXP '".$cari."' OR a.penumpang = '".$cari."' OR a.penumpang_bayi = '".$cari."')";
        }else{
            $this->search ="where a.id_customer = ".$id."";
        }
        
        if(isset($_POST['order']) && $_POST['length'] != -1) 
        {
            $query = $this->db->query("select a.id_perjalanan, a.id_customer, a.tgl_berangkat, a.kendaraan, d.alias as golongan, a.penumpang, a.penumpang_bayi,a.id_pelabuhan_asal,a.id_pelabuhan_tujuan, b.nama_asal, c.nama_tujuan from p01_perjalanan a left join m03_lintasan_awal b on  b.id =a.id_pelabuhan_asal left join m03_lintasan_tujuan c on c.id = a.id_pelabuhan_tujuan left join m04_golongan d on d.id_gol = a.golongan ".$this->search." order by ".$this->column_order[$_POST['order']['0']['column']]." ".$_POST['order']['0']['dir']." limit ".$_POST['start'].",".$_POST['length']."");
        }else if($_POST['length'] != -1){
            $query = $this->db->query("select a.id_perjalanan, a.id_customer, a.tgl_berangkat, a.kendaraan, d.alias as golongan, a.penumpang, a.penumpang_bayi,a.id_pelabuhan_asal,a.id_pelabuhan_tujuan, b.nama_asal, c.nama_tujuan from p01_perjalanan a left join m03_lintasan_awal b on  b.id =a.id_pelabuhan_asal left join m03_lintasan_tujuan c on c.id = a.id_pelabuhan_tujuan left join m04_golongan d on d.id_gol = a.golongan ".$this->search." order by a.tgl_berangkat limit ".$_POST['start'].",".$_POST['length']."");
        }
        
        return $query->result();
    }
 
    function count_filtered()
    {
        
        $query = $this->db->query("select a.id_perjalanan, a.id_customer, a.tgl_berangkat, a.kendaraan, d.alias as golongan, a.penumpang, a.penumpang_bayi, b.nama_asal, c.nama_tujuan from p01_perjalanan a left join m03_lintasan_awal b on  b.id =a.id_pelabuhan_asal left join m03_lintasan_tujuan c on c.id = a.id_pelabuhan_tujuan left join m04_golongan d on d.id_gol = a.golongan ".$this->search."");
        
        return $query->num_rows();
    }
 
    public function count_all($id)
    {
        $this->db->from($this->table);
        $this->db->where('id_customer',$id);
        return $this->db->count_all_results();
    }
 
}