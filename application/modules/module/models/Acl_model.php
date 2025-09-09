<?php  defined('BASEPATH') OR exit('No direct script access allowed');


class Acl_model extends Fm_model {

    public $table 	= 'acls';
    public $id 		= 'id';
    public $order 	= 'DESC';

    function __construct(){
        parent::__construct();
    }

    // get all
    function get_all(){      
		$this->db->select('acls.*, m.name');
		$this->db->from( $this->table );
		$this->db->join('modules as m', 'acls.module_id = m.id');		
                $this->db->order_by('module_id', 'ASC');
		$this->db->order_by($this->id, $this->order);
                $this->db->order_by('order_id', 'ASC');
		return $this->db->get()->result();
    }

    // get data by id
    function get_by_id($id){
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
	
    
    /*
     * this function wrote 2 times more in app/helpers/acl_helper.php
     */
    function checkPermission($access_key,$role_id){
        
       // dd($access_key);
        $query = $this->db->select('access')
			->from('role_permissions')
			->join('acls', 'acls.id = role_permissions.acl_id', 'left')
			->where('role_id',$role_id)
			->where('permission_key',$access_key)			
			->get()
			->row();
        //dd( $this->db->last_query() );
        return ($query);
        
    }
    
    
    
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id', $q);
	$this->db->or_like('module_id', $q);
	$this->db->or_like('permission_name', $q);
	$this->db->or_like('permission_key', $q);
	$this->db->or_like('order_id', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
	$this->db->or_like('module_id', $q);
	$this->db->or_like('permission_name', $q);
	$this->db->or_like('permission_key', $q);
	$this->db->or_like('order_id', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data){
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    // update data
    function update($id, $data){
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id){
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}