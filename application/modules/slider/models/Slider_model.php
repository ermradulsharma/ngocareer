<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Slider_model extends Fm_model {

    public $table   = 'cms';
    public $id      = 'id';

    function __construct() {
        parent::__construct();
    }

    // get total rows
    function total_rows() {       
        $this->db->from($this->table);
        $this->db->where('post_type','slide');
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data() {
        
        $this->db->select('id,post_title,content,thumb,status');
        $this->db->from('cms');        
        $this->db->order_by('page_order', 'ASC');        
        $this->db->where('post_type','slide');
        return $this->db->get()->result();
    }
    
    // get data by id
    function get_by_id($id){
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

}
