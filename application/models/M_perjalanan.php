<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_perjalanan Extends CI_model{
    
    function __construct()
    {
        parent::__construct();
    }
    
    //NOTE : Frekuensi
    public function frekuensi($id_customer){
        $query = $this->db->query("select COUNT(a.id_customer) as frekuensi from p01_perjalanan a where a.id_customer = ".$id_customer."");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return array();
        }
    }
}
