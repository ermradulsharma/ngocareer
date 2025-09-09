<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_category_model extends Fm_model {

    public $table = 'job_sub_categories';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get total rows
    function total_rows($cid=0, $q = NULL)
    {
        if ($q) { $this->db->like('name', $q); }
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0,$cid=0, $q = NULL)
    {
        $this->db->order_by($this->id, $this->order);
        if ($cid) { $this->db->where('category_id', $cid ); }
        if ($q) { $this->db->like('name', $q); }
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

}
