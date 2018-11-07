<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_core Extends CI_model{

    function __construct()
    {
        parent::__construct();

    }

    //NOTE : Login Check
    function cek_login($table,$where){
        $query = $this->db->limit(1)
                          ->get_where($table,$where);
		return $query;
	}

    //NOTE : Last Login
    function last_login($table,$data,$where){
        $this->db->where($where);
		$this->db->update($table,$data);
    }

    //NOTE : Update Table
    function update_table($table,$data,$where){
        $this->db->where($where);
		$this->db->update($table,$data);
    }

    //NOTE : Get Table
    function get_table($table){
        $query = $this->db->get($table);
		return $query;
	}

    //NOTE : Get Table where
    function get_table_where($table,$where){
        $query = $this->db->get_where($table,$where);
		return $query;
    }

    //NOTE : Find Table
    function find_table($table,$where){
        $query = $this->db->limit(1)
                          ->get_where($table,$where);
		return $query->row();
	}

    //NOTE : Delete Table
    function delete_table($table,$where){
        $this->db->delete($table,$where);
        if($this->db->affected_rows() == 0){
            return FALSE;
        }else{
            return TRUE;
        }
    }

    //NOTE : Input Table
    function input_table($table,$data){
		$this->db->insert($table,$data);
	}
}
