<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Event_model extends Fm_model
{
    public $table = 'events';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    function get_event_by_id($id, $user_id, $role_id) {
        $this->db->select('e.*');
        $this->db->select('c.name as category_name');
        $this->db->where('e.id', $id);

        if($role_id == 4){
            $this->db->where('e.user_id', $user_id);
        }

        $this->db->from('events as e');
        $this->db->join('event_categories as c', 'e.event_category_id = c.id', 'LEFT');
        return $this->db->get()->row();
    }

    // get total rows
    function total_rows($q, $category, $status, $deadline, $user, $user_id, $role_id)
    {
        $this->__sql($q, $category, $status, $deadline, $user, $user_id, $role_id);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start, $q, $category, $status, $deadline, $user, $user_id, $role_id)
    {
        $this->db->order_by($this->id, $this->order);
        $this->__sql($q, $category, $status, $deadline, $user, $user_id, $role_id);
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    private function __sql($q, $category, $status, $deadline, $user, $user_id, $role_id){
        $this->db->from("{$this->table} as e");
        $this->db->join("event_categories as c", "c.id = e.event_category_id", "LEFT");
        $this->db->select("e.*, c.name as cat_name");
        if ($q) {
            $this->db->group_start();
            $this->db->like('title', $q);
            $this->db->or_like('location', $q);
            $this->db->or_like('event_link', $q);
            $this->db->or_like('summary', $q);
            $this->db->or_like('organizer_name', $q);            
            $this->db->or_like('remark', $q);
            $this->db->group_end();
        }
        if($role_id == 4){
            $this->db->where('e.user_id', $user_id);
        }
        if($user){
            $this->db->where('e.user_id', $user);
        }
        if($category){
            $this->db->where('e.event_category_id', $category);
        }
        if($status){
            $this->db->where('e.status', $status);
        }
        
    }

}