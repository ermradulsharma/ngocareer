<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends Fm_model {

    public $table = 'settings';
    public $id = 'id';
    public $order = 'ASC';

    function __construct() {
        parent::__construct();
    }     

    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id', $q);
        $this->db->or_like('label', $q);
        $this->db->or_like('value', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id', $q);
        $this->db->or_like('label', $q);
        $this->db->or_like('value', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }    
}
