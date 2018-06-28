<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class M_tabel_complain extends CI_Model { 
 
    var $table = 'p02_komplain'; //nama tabel dari database
    var $column_order = array("tiket", "userid", "nama","tgl_komplain", "cabang", "kategori","dif","status"); //field yang ada di table user
    var $search = '';
 
    public function __construct()
    { 
        parent::__construct();
    }
       
    function get_datatables()
    {
        if($_POST['search']['value']){
            $cari = $_POST['search']['value'];
            $this->search = "where (a.tiket REGEXP '".$cari." OR b.userid REGEXP '".$cari."' OR b.nama REGEXP '".$cari."' OR a.tgl_komplain REGEXP '".$cari."' OR c.nama REGEXP '".$cari."' OR a.kategori REGEXP '".$cari."' OR a.status REGEXP '".$cari."')";
        }else{
            $this->search ='';
        }
        
        if(isset($_POST['order']) && $_POST['length'] != -1) 
        {
            $query = $this->db->query("select a.id_komplain,a.tiket,a.tgl_komplain, DATEDIFF(DATE_ADD(date(a.tgl_komplain), INTERVAL a.prioritas DAY),curdate()) as dif,b.nama,b.userid, c.nama as cabang, a.kategori, a.prioritas, a.`status` from p02_komplain a left join m02_customer b on a.id_customer = b.id left join m07_cabang c on c.id_cabang =a.id_cabang left join m05_kapal d on d.id_kapal=a.id_kapal left join m06_divisi e on a.id_divisi = e.id_divisi ".$this->search." order by ".$this->column_order[$_POST['order']['0']['column']]." ".$_POST['order']['0']['dir']." limit ".$_POST['start'].",".$_POST['length']."");
        }else if($_POST['length'] != -1){
            $query = $this->db->query("select a.id_komplain,a.tiket,a.tgl_komplain, DATEDIFF(DATE_ADD(date(a.tgl_komplain), INTERVAL a.prioritas DAY),curdate()) as dif,b.nama,b.userid, c.nama as cabang, a.kategori, a.prioritas, a.`status` from p02_komplain a left join m02_customer b on a.id_customer = b.id left join m07_cabang c on c.id_cabang =a.id_cabang left join m05_kapal d on d.id_kapal=a.id_kapal left join m06_divisi e on a.id_divisi = e.id_divisi ".$this->search." order by a.id_komplain limit ".$_POST['start'].",".$_POST['length']."");
        }
        
        return $query->result();
    }
 
    function count_filtered()
    {
        
        $query = $this->db->query("select a.id_komplain,a.tiket,a.tgl_komplain, DATEDIFF(DATE_ADD(date(a.tgl_komplain), INTERVAL a.prioritas DAY),curdate()) as dif,b.nama,b.userid, c.nama as cabang, a.kategori, a.prioritas, a.`status` from p02_komplain a left join m02_customer b on a.id_customer = b.id left join m07_cabang c on c.id_cabang =a.id_cabang left join m05_kapal d on d.id_kapal=a.id_kapal left join m06_divisi e on a.id_divisi = e.id_divisi ".$this->search."");
        
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
 
}
