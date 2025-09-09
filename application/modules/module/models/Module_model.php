<?php 
defined('BASEPATH') OR exit('No direct script access allowed');


class Module_model extends Fm_model
{

    public $table = 'modules';
    public $id = 'id';
    public $order = 'ASC';

    function __construct(){
        parent::__construct();
    }

    // get all
    function get_all(){
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id){
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id', $q);
	$this->db->or_like('added_date', $q);
	$this->db->or_like('order', $q);
	$this->db->or_like('type', $q);
	$this->db->or_like('name', $q);
	$this->db->or_like('folder', $q);
	$this->db->or_like('description', $q);
	$this->db->or_like('status', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
	$this->db->or_like('added_date', $q);
	$this->db->or_like('order', $q);
	$this->db->or_like('type', $q);
	$this->db->or_like('name', $q);
	$this->db->or_like('folder', $q);
	$this->db->or_like('description', $q);
	$this->db->or_like('status', $q);
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