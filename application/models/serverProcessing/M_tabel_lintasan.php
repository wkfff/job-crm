<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class M_tabel_lintasan extends CI_Model { 
 
     var $column_order = array(null, 'id','nama_asal','nama_tujuan','jarak','poin',null);
    var $search = ' ';
    
    public function __construct()
    { 
        parent::__construct();
    }
  
     
    function get_datatables($cari)
    {
        $cari = urldecode($cari);
        if($cari != 'null')
            {
                $this->search = "WHERE (b.nama_asal LIKE '".$cari."' OR a.jarak LIKE '".$cari."' OR a.poin LIKE '".$cari."' )";
            }else{
            $this->search = "";
        }
        
        if(isset($_POST['order']) && $_POST['length'] != -1) 
        {
            $query = $this->db->query("select a.id,a.id_daerah_asal,b.nama_asal,a.id_daerah_tujuan,c.nama_asal as nama_tujuan,jarak,a.poin from m03_lintasan_jadwal a inner join m03_lintasan_awal b on b.id = a.id_daerah_asal inner join m03_lintasan_awal c on c.id = a.id_daerah_tujuan ".$this->search." order by ".$this->column_order[$_POST['order']['0']['column']]." ".$_POST['order']['0']['dir']." limit ".$_POST['start'].",".$_POST['length']."");
        }else if($_POST['length'] != -1){
            $query = $this->db->query("select a.id,a.id_daerah_asal,b.nama_asal,a.id_daerah_tujuan,c.nama_asal as nama_tujuan,jarak,a.poin from m03_lintasan_jadwal a inner join m03_lintasan_awal b on b.id = a.id_daerah_asal inner join m03_lintasan_awal c on c.id = a.id_daerah_tujuan ".$this->search." order by a.id ASC limit ".$_POST['start'].",".$_POST['length']."");
        }
        
        return $query->result();
    }
 
    function count_filtered()
    {
        $query = $this->db->query("select a.id,a.id_daerah_asal,b.nama_asal,a.id_daerah_tujuan,c.nama_asal as nama_tujuan,jarak,a.poin from m03_lintasan_jadwal a inner join m03_lintasan_awal b on b.id = a.id_daerah_asal inner join m03_lintasan_awal c on c.id = a.id_daerah_tujuan ".$this->search."");
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $query = $this->db->query("select a.id,a.id_daerah_asal,b.nama_asal,a.id_daerah_tujuan,c.nama_asal as nama_tujuan,jarak,a.poin from m03_lintasan_jadwal a inner join m03_lintasan_awal b on b.id = a.id_daerah_asal inner join m03_lintasan_awal c on c.id = a.id_daerah_tujuan ");
    
        return $query->num_rows();
    }
 
}
