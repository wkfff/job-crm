<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_laporan Extends CI_model{
    
    function __construct()
    {
        parent::__construct();
    }
    
   
    
    // NOTE : Pengambilan laporan keluhan belum selesai range by date
    public function laporan_a($dateA,$dateB){
        $query = $this->db
            ->where('tgl_komplain >=',$dateA)
            ->where('tgl_komplain <=',$dateB)
        ->get('v02_komplain');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    // NOTE : Pengambilan laporan keluhan yg selesai range by date
    public function laporan_b($dateA,$dateB){
        $query = $this->db
            ->where('tgl_komplain >=',$dateA)
            ->where('tgl_komplain <=',$dateB)
        ->get('v06_arsip');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
    
    // NOTE : Pengambilan laporan semua keluhan range by date
    public function laporan_c($dateA,$dateB){
        $query = $this->db
            ->where('tgl_komplain >=',$dateA)
            ->where('tgl_komplain <=',$dateB)
        ->get('v02_komplain_h');
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }
}
