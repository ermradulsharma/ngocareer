<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Users_model extends Fm_model
{

    public $table = 'users';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get total rows
    function total_rows($q = NULL, $status = NULL, $role_id = 0)
    {
        $this->__search($role_id,$status,$q);
        $this->db->from('users as u');
        return $this->db->get()->num_rows();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL, $status = NULL, $role_id = 0)
    {
        $this->db->select('count(*)')->where('user_id', 'u.id', false, false );
	    $j_qty = $this->db->get_compiled_select('jobs');
	        
        $this->db->select('count(*)')->where('user_id', 'u.id', false, false );        
	    $e_qty = $this->db->get_compiled_select('events');
	
                
        $this->db->select('u.id,first_name,last_name,contact,u.status,email,created_at');
        $this->db->select('r.role_name,company_name,logo');
        $this->db->select("({$j_qty}) as j_qty, ({$e_qty}) as e_qty");        
        
        $this->db->from('users as u');
        $this->db->join('roles as r','r.id=u.role_id','LEFT');
        $this->__search($role_id,$status,$q);
        $this->db->order_by($this->id, $this->order);
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }
    
    function __search($role_id,$status,$q){
        $this->db->where('role_id >=', 2 );
        if ($role_id != 0) { 
            $this->db->where('role_id', $role_id);
        } 
        if ($status) { $this->db->where('status', $status); }
        if ($q) {
            $this->db->group_start();
            $this->db->like('first_name', $q);
            $this->db->or_like('last_name', $q);
            $this->db->or_like('company_name', $q);
            $this->db->or_like('email', $q);	
            $this->db->or_like('contact', $q);	
            $this->db->or_like('add_line1', $q);
            $this->db->or_like('add_line2', $q);
            $this->db->or_like('city', $q);
            $this->db->or_like('state', $q);
            $this->db->group_end();
        }
        $this->db->where('u.status !=', 'Waiting');
    }
}