<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cms_model extends Fm_model {

    public $table   = 'cms';
    public $id      = 'id';
    public $status  = 'status';
    public $post_type = 'post_type';
    public $order   = 'ASC';

    function __construct() {
        parent::__construct();
    }   

// get row
    function get_row($id = 0) {
        $this->db->where('id', $id);
        $this->db->from($this->table);
        return $this->db->get()->row();
    }

// get total rows
    function total_rows($q = NULL) {
        $this->_page_query($q);
        $this->db->from($this->table);
        return $this->db->get()->num_rows();
    }

// get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {        
        $this->db->select('id,parent_id,post_title,post_url,status,page_order,created,modified');        
        $this->db->order_by('page_order', 'ASC');
        $this->_page_query($q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    function _page_query($q){
        if ($q) {
            $this->db->group_start();
            $this->db->like('post_title', $q);
            $this->db->or_like('content', $q);
            $this->db->group_end();
        }
        $this->db->where('parent_id', 0);
        $this->db->where('post_type', 'page');
    }

// get data with limit and search
    function get_data_for_post($limit, $start = 0, $q = NULL) {
        $this->db->where('post_type', 'post');
        if ($q) {
            $this->db->group_start();
            $this->db->like('post_title', $q);
            $this->db->or_like('content', $q);
            $this->db->group_end();
        }
        $this->db->order_by($this->id, $this->order);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

// get total rows in post
    function total_rows_post($q = NULL) {
        $this->db->where('post_type', 'post');
        if ($q) {
            $this->db->group_start();
            $this->db->like('post_title', $q);
            $this->db->or_like('content', $q);
            $this->db->group_end();
        }
        $this->db->from($this->table);
        return $this->db->get()->num_rows();
    }
    
    function get_revisions($id) {
        $this->db->order_by('id', 'DESC');
        $this->db->where('parent_id', $id);
        $this->db->where('status', 'Revision');
        return $this->db->get($this->table)->result();
    }  
    
    function get_restore_point($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row();
    }    
    
}
