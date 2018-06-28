<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_lintasan Extends CI_model{
    
    function __construct()
    {
        parent::__construct();
    }
    
    //NOTE : lintasan - input
    public function lintasan_input($data){
        $this->db->insert('m03_lintasan_jadwal', $data); 
    }
    
    //NOTE : lintasan - del
    public function lintasan_del($id){
        $this->db->where('id',$id)->delete('m03_lintasan_jadwal');
        
    }

    //NOTE : lintasan - find
    public function lintasan_find($id){
        $query = $this->db->where('id', $id)
        ->limit(1)
        ->get('m03_lintasan_jadwal');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return array();
        }
    }
    
    //NOTE : lintasan - find by id asal & id Tujuan
    public function lintasan_findById($id_asal,$id_tujuan){
        $query = $this->db->select('jarak,poin')
                          ->where('id_daerah_asal', $id_asal)
                          ->where('id_daerah_tujuan', $id_tujuan)
                          ->limit(1)
                          ->get('m03_lintasan_jadwal');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return array();
        }
    }
    
    // NOTE : lintasan - update
    public function lintasan_update($id, $data)
    {
        $this->db->where('id', $id)
            ->update('m03_lintasan_jadwal', $data);
    }
}