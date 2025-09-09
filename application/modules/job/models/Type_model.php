<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Type_model extends Fm_model
{

    public $table = 'job_types';
    public $id = 'id';
    public $order = 'ASC';

    function __construct()
    {
        parent::__construct();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        $this->db->from($this->table);
        if ($q) {
            $this->db->like('id', $q);
            $this->db->or_like('name', $q);
        }        
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {       
	$this->db->select('count(*)');        
	$this->db->where('job_type_id', "{$this->table}.id", false, false);        
	$sql = $this->db->get_compiled_select('jobs');                
        
	$this->db->select("{$this->table}.*");        
	$this->db->select("({$sql}) as qty");
        
        $this->db->order_by($this->id, $this->order);
        if ($q) {
            $this->db->like('id', $q);
            $this->db->or_like('name', $q);
        }
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

}