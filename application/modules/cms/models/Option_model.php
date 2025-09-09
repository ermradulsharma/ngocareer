<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Option_model extends Fm_model {

    public $table = 'cms_options';
    public $id = 'id';
    public $type = 'type';
    public $order = 'DESC';

    function __construct() {
        parent::__construct();
    }

// get data type only category
    function get_cats() {
        $this->db->where($this->type, 'category');
        return $this->db->get($this->table)->result();
    }

// get total rows
    function total_rows() {        
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

// get data with limit and search
    function get_limit_data($limit, $start = 0) {
        $this->db->order_by($this->id, $this->order);                
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }


}
