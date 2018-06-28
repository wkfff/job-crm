<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_complain_chart Extends CI_model{

    function __construct()
    { 
        parent::__construct();
    }
    
    

    //NOTE : All Komplain - get semua komplain
    public function complain_chart_all($tahun){
        $query = $this->db->query("SELECT YEAR(a.tgl_komplain) as tahun,MONTH(a.tgl_komplain) as bulan,count(a.id_komplain) as 'total' from h01_komplain a where YEAR(a.tgl_komplain) = '".$tahun."' group by YEAR(a.tgl_komplain),MONTH(a.tgl_komplain) ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    

    //NOTE : All Komplain - get komplain by tahun, cabang
    public function complain_chart_cabang($tahun, $cabang){
        $query = $this->db->query("SELECT year(a.tgl_komplain) as tahun ,month(a.tgl_komplain) as bulan ,a.id_cabang,b.nama,count(a.id_komplain) as total from h01_komplain a left join m07_cabang b on b.id_cabang = a.id_cabang where year(a.tgl_komplain) = '".$tahun."' and a.id_cabang = '".$cabang."' group by a.id_cabang,year(a.tgl_komplain),month(a.tgl_komplain) ");
        
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    //NOTE : All Komplain - get komplain by tahun, cabang, kategori
    public function complain_chart_kategori($tahun,$cabang,$kategori){
        $query = $this->db->query("SELECT year(a.tgl_komplain) as tahun ,month(a.tgl_komplain) as bulan ,a.id_cabang,b.nama,count(a.id_komplain) as total from h01_komplain a left join m07_cabang b on b.id_cabang = a.id_cabang where year(a.tgl_komplain) = '".$tahun."' and a.id_cabang = '".$cabang."' and a.kategori = '".$kategori."' group by a.id_cabang,year(a.tgl_komplain),month(a.tgl_komplain) ");
        
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    //NOTE : All Komplain - get komplain by tahun, kategori
    public function complain_chart_kategori2($tahun,$kategori){
        $query = $this->db->query("SELECT year(a.tgl_komplain) as tahun ,month(a.tgl_komplain) as bulan ,a.id_cabang,b.nama,count(a.id_komplain) as total from h01_komplain a left join m07_cabang b on b.id_cabang = a.id_cabang where year(a.tgl_komplain) = '".$tahun."' and a.kategori = '".$kategori."' group by year(a.tgl_komplain),month(a.tgl_komplain) ");
        
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    
    



    //NOTE : All Komplain - mengambil tahun
    public function complain_get_year(){
        $query = $this->db->query("SELECT YEAR(a.tgl_komplain) as tahun from h01_komplain a group by YEAR(a.tgl_komplain),MONTH(a.tgl_komplain) order by tahun DESC limit 1");
    
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    //NOTE : All Komplain - mengambil semua tahun
    public function complain_get_years(){
        $query = $this->db->query("SELECT YEAR(a.tgl_komplain) as tahun from h01_komplain a group by YEAR(a.tgl_komplain) order by tahun DESC");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }            
    }
    
    //    TODO : #####################################################################################################################################
    
    //NOTE : Done Komplain - get all done complain
    public function done_complain_all($tahun){
        $query = $this->db->query("SELECT year(a.tgl_komplain) as tahun ,month(a.tgl_komplain) as bulan ,a.cabang,b.nama,count(a.id_arsip) as total from p03_arsip a left join m07_cabang b on b.id_cabang = a.cabang where YEAR(a.tgl_komplain) = '".$tahun."' group by a.cabang,year(a.tgl_komplain),month(a.tgl_komplain)");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }  
    }
    
    //NOTE : Done Komplain - get komplain by tahun, cabang
    public function done_complain_chart_cabang($tahun, $cabang){
        $query = $this->db->query("SELECT year(a.tgl_komplain) as tahun ,month(a.tgl_komplain) as bulan ,b.id_cabang,b.nama,count(a.id_arsip) as total from p03_arsip a left join m07_cabang b on b.nama = a.cabang where year(a.tgl_komplain) = '".$tahun."' and b.id_cabang = '".$cabang."' group by b.id_cabang,year(a.tgl_komplain),month(a.tgl_komplain) ");
        
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    //NOTE : Done Komplain - get komplain by tahun, cabang, kategori
    public function done_complain_chart_kategori($tahun, $cabang, $kategori){
        $query = $this->db->query("SELECT year(a.tgl_komplain) as tahun ,month(a.tgl_komplain) as bulan ,b.id_cabang,b.nama,count(a.id_arsip) as total from p03_arsip a left join m07_cabang b on b.nama = a.cabang where year(a.tgl_komplain) = '".$tahun."' and b.id_cabang = '".$cabang."' and a.kategori = '".$kategori."' group by b.id_cabang,year(a.tgl_komplain),month(a.tgl_komplain) ");
        
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    //NOTE : Done Komplain - get komplain by tahun, kategori
    public function done_complain_chart_kategori2($tahun,$kategori){
        $query = $this->db->query("SELECT year(a.tgl_komplain) as tahun ,month(a.tgl_komplain) as bulan ,b.id_cabang,b.nama,count(a.id_arsip) as total from p03_arsip a left join m07_cabang b on b.nama = a.cabang where year(a.tgl_komplain) = '".$tahun."' and a.kategori = '".$kategori."' group by year(a.tgl_komplain),month(a.tgl_komplain) ");
        
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
//    TODO : #####################################################################################################################################
    
    //NOTE : Belum Komplain - get all not done complain
    public function belum_complain_all($tahun){
        $query = $this->db->query("SELECT year(a.tgl_komplain) as tahun ,month(a.tgl_komplain) as bulan ,count(a.id_komplain) as total from p02_komplain a left join m07_cabang b on b.id_cabang = a.id_cabang where YEAR(a.tgl_komplain) = '".$tahun."' group by year(a.tgl_komplain),month(a.tgl_komplain)");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }  
    }
    
    //NOTE : Belum Komplain - get komplain by tahun, cabang
    public function belum_complain_chart_cabang($tahun, $cabang){
        $query = $this->db->query("SELECT year(a.tgl_komplain) as tahun ,month(a.tgl_komplain) as bulan ,a.id_cabang,b.nama,count(a.id_komplain) as total from p02_komplain a left join m07_cabang b on b.id_cabang = a.id_cabang where year(a.tgl_komplain) = '".$tahun."' and a.id_cabang = '".$cabang."' group by a.id_cabang,year(a.tgl_komplain),month(a.tgl_komplain) ");
        
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    //NOTE : Belum Komplain - get komplain by tahun, cabang, kategori
    public function belum_complain_chart_kategori($tahun, $cabang, $kategori){
        $query = $this->db->query("SELECT year(a.tgl_komplain) as tahun ,month(a.tgl_komplain) as bulan ,a.id_cabang,b.nama,count(a.id_komplain) as total from p02_komplain a left join m07_cabang b on b.id_cabang = a.id_cabang where year(a.tgl_komplain) = '".$tahun."' and a.id_cabang = '".$cabang."' and a.kategori = '".$kategori."' group by a.id_cabang,year(a.tgl_komplain),month(a.tgl_komplain) ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    //NOTE : Belum Komplain - get komplain by tahun, kategori
    public function belum_complain_chart_kategori2($tahun,$kategori){
        $query = $this->db->query("SELECT year(a.tgl_komplain) as tahun ,month(a.tgl_komplain) as bulan ,a.id_cabang,b.nama,count(a.id_komplain) as total from p02_komplain a left join m07_cabang b on b.id_cabang = a.id_cabang where year(a.tgl_komplain) = '".$tahun."' and a.kategori = '".$kategori."' group by a.id_cabang,year(a.tgl_komplain),month(a.tgl_komplain) ");
        
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    //    TODO : #####################################################################################################################################
    // NOTE : kategori Komplain - get komplain by tahun
    public function complain_kategori_chart1($tahun){
        $query = $this->db->query("SELECT year(a.tgl_komplain) as tahun, a.kategori ,month(a.tgl_komplain) as bulan ,count(a.id_komplain) as total from h01_komplain a left join m07_cabang b on b.id_cabang = a.id_cabang where year(a.tgl_komplain) = '".$tahun."' group by a.kategori,year(a.tgl_komplain),month(a.tgl_komplain) ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    // NOTE : kategori Komplain - get komplain by tahun & kategori
    public function complain_kategori_chart2($tahun,$kategori){
        $query = $this->db->query("SELECT year(a.tgl_komplain) as tahun, a.kategori ,month(a.tgl_komplain) as bulan ,count(a.id_komplain) as total from h01_komplain a left join m07_cabang b on b.id_cabang = a.id_cabang where year(a.tgl_komplain) = '".$tahun."' and a.kategori = '".$kategori."' group by a.kategori,year(a.tgl_komplain),month(a.tgl_komplain) ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
        
    //    TODO : #####################################################################################################################################
    //NOTE : cabang komplain - get by tahun 
    public function complain_cabang_chart1($tahun){
        $query = $this->db->query("SELECT b.nama, year(a.tgl_komplain) as tahun,count(a.id_komplain) as total from h01_komplain a left join m07_cabang b on b.id_cabang = a.id_cabang where year(a.tgl_komplain) = '".$tahun."' group by a.id_cabang,year(a.tgl_komplain)");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    //NOTE : cabang komplain - get by tahun & kategori 
    public function complain_cabang_chart2($tahun,$kategori){
        $query = $this->db->query("SELECT b.nama, year(a.tgl_komplain) as tahun,count(a.id_komplain) as total from h01_komplain a left join m07_cabang b on b.id_cabang = a.id_cabang where year(a.tgl_komplain) = '".$tahun."' and a.kategori = '".$kategori."' group by a.id_cabang,year(a.tgl_komplain)");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
     //NOTE : Done cabang komplain - get by tahun 
    public function complain_done_cabang_chart1($tahun){
        $query = $this->db->query("SELECT b.nama, year(a.tgl_komplain) as tahun,count(a.id_arsip) as total from p03_arsip a left join m07_cabang b on b.nama = a.cabang where year(a.tgl_komplain) = '".$tahun."' group by a.cabang,year(a.tgl_komplain)");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    //NOTE : Done cabang komplain - get by tahun  & kategori
    public function complain_done_cabang_chart2($tahun,$kategori){
        $query = $this->db->query("SELECT b.nama, year(a.tgl_komplain) as tahun,count(a.id_arsip) as total from p03_arsip a left join m07_cabang b on b.nama = a.cabang where year(a.tgl_komplain) = '".$tahun."' and a.kategori = '".$kategori."' group by a.cabang,year(a.tgl_komplain)");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    //NOTE : cabang komplain - get by tahun 
    public function complain_belum_cabang_chart1($tahun){
        $query = $this->db->query("SELECT b.nama, year(a.tgl_komplain) as tahun,count(a.id_komplain) as total from p02_komplain a left join m07_cabang b on b.id_cabang = a.id_cabang where year(a.tgl_komplain) = '".$tahun."' group by a.id_cabang,year(a.tgl_komplain)");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    //NOTE : cabang komplain - get by tahun & kategori
    public function complain_belum_cabang_chart2($tahun,$kategori){
        $query = $this->db->query("SELECT b.nama, year(a.tgl_komplain) as tahun,count(a.id_komplain) as total from p02_komplain a left join m07_cabang b on b.id_cabang = a.id_cabang where year(a.tgl_komplain) = '".$tahun."' and a.kategori = '".$kategori."' group by a.id_cabang,year(a.tgl_komplain)");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    //    TODO : #####################################################################################################################################
    //NOTE : General - get kategori
    public function complain_get_kategori(){
        $query = $this->db->distinct()
                ->select('kategori')
                ->get('h01_komplain');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
}
