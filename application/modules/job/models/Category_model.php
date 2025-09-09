<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Category_model extends Fm_model
{

    public $table = 'job_categories';
    public $id = 'id';
    public $order = 'ASC';

    function __construct()
    {
        parent::__construct();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        if ($q) { $this->db->like('name', $q); }
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('count(*)');        
	$this->db->where('category_id', "{$this->table}.id", false, false);
	$sql = $this->db->get_compiled_select('job_sub_categories');  

                
        
	$this->db->select("{$this->table}.*");        
	$this->db->select("({$sql}) as Qty");
        
        
        if ($q) { $this->db->like('name', $q); }
        $this->db->order_by($this->id, $this->order);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

}