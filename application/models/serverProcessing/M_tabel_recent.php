<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class M_tabel_recent extends CI_Model { 
 
    var $column_order = array("a.tgl_berangkat", "c.nama_asal", "d.nama_asal","b.jarak", "b.poin", "b.jarak"); //field yang ada di table user
    var $id_customer = 0;
 
    public function __construct()
    { 
        parent::__construct();
    }
       
    function get_datatables($id)
    {
        $this->id_customer = $id;
       
        if(isset($_POST['order']) && $_POST['length'] != -1) 
        {
            $query = $this->db->query("select a.tgl_berangkat,a.id_pelabuhan_asal,a.id_pelabuhan_tujuan,a.kendaraan
            ,e.alias,c.nama_asal as asal,d.nama_asal as tujuan,b.jarak,b.poin from p01_perjalanan a left join m03_lintasan_jadwal b on a.id_pelabuhan_asal = b.id_daerah_asal AND a.id_pelabuhan_tujuan = b.id_daerah_tujuan left join m03_lintasan_awal c on a.id_pelabuhan_asal = c.id left join m03_lintasan_awal d on a.id_pelabuhan_tujuan = d.id left join m04_golongan e on a.golongan = e.id_gol where a.id_customer = ".$this->id_customer."  order by ".$this->column_order[$_POST['order']['0']['column']]." ".$_POST['order']['0']['dir']." limit ".$_POST['start'].",".$_POST['length']."");
        }else if($_POST['length'] != -1){
            $query = $this->db->query("select a.tgl_berangkat,a.id_pelabuhan_asal,a.id_pelabuhan_tujuan,a.kendaraan
            ,e.alias,c.nama_asal as asal,d.nama_asal as tujuan,b.jarak,b.poin from p01_perjalanan a left join m03_lintasan_jadwal b on a.id_pelabuhan_asal = b.id_daerah_asal AND a.id_pelabuhan_tujuan = b.id_daerah_tujuan left join m03_lintasan_awal c on a.id_pelabuhan_asal = c.id left join m03_lintasan_awal d on a.id_pelabuhan_tujuan = d.id left join m04_golongan e on a.golongan = e.id_gol where a.id_customer = ".$this->id_customer." order by a.tgl_berangkat DESC limit ".$_POST['start'].",".$_POST['length']."");
        }
        
        return $query->result();
    }
 
    function count_filtered()
    {
        
        $query = $this->db->query("select a.tgl_berangkat,a.id_pelabuhan_asal,a.id_pelabuhan_tujuan,a.kendaraan
            ,e.alias,c.nama_asal as asal,d.nama_asal as tujuan,b.jarak,b.poin from p01_perjalanan a left join m03_lintasan_jadwal b on a.id_pelabuhan_asal = b.id_daerah_asal AND a.id_pelabuhan_tujuan = b.id_daerah_tujuan left join m03_lintasan_awal c on a.id_pelabuhan_asal = c.id left join m03_lintasan_awal d on a.id_pelabuhan_tujuan = d.id left join m04_golongan e on a.golongan = e.id_gol where a.id_customer = ".$this->id_customer."");
        
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $query = $this->db->query("select a.tgl_berangkat,a.id_pelabuhan_asal,a.id_pelabuhan_tujuan,a.kendaraan
            ,e.alias,c.nama_asal as asal,d.nama_asal as tujuan,b.jarak,b.poin from p01_perjalanan a left join m03_lintasan_jadwal b on a.id_pelabuhan_asal = b.id_daerah_asal AND a.id_pelabuhan_tujuan = b.id_daerah_tujuan left join m03_lintasan_awal c on a.id_pelabuhan_asal = c.id left join m03_lintasan_awal d on a.id_pelabuhan_tujuan = d.id left join m04_golongan e on a.golongan = e.id_gol where a.id_customer = ".$this->id_customer."");
        return $query->num_rows();
    }
 
}