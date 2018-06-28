<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class M_tabel_loyalty1 extends CI_Model { 
 
     var $column_order = array('ordering', 'nama','max','keterangan',null,null);
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
                $this->search = "AND (ordering = '".$cari."' OR max = '".$cari."' OR keterangan LIKE '".$cari."' )";
            }else{
            $this->search = "";
        }
        
        if(isset($_POST['order']) && $_POST['length'] != -1) 
        {
            $query = $this->db->query("select * from m08_achievement where tipe = 'jarak' ".$this->search." order by ".$this->column_order[$_POST['order']['0']['column']]." ".$_POST['order']['0']['dir']." limit ".$_POST['start'].",".$_POST['length']."");
        }else if($_POST['length'] != -1){
            $query = $this->db->query("select * from m08_achievement where tipe = 'jarak' ".$this->search." order by ordering ASC limit ".$_POST['start'].",".$_POST['length']."");
        }
        
        return $query->result();
    }
 
    function count_filtered()
    {
        $query = $this->db->query("select * from m08_achievement where tipe = 'jarak' ".$this->search."");
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $query = $this->db->query("select * from m08_achievement where tipe = 'jarak'");
    
        return $query->num_rows();
    }
 
}
