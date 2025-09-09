<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Job_model extends Fm_model
{
    public $table = 'jobs';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    function get_jobs_by_id($id, $user_id, $role_id) {
        $this->db->select('j.*');
        $this->db->select('c.name as category_name');
        $this->db->where('j.id', $id);

        if($role_id == 4){
            $this->db->where('j.user_id', $user_id);
        }

        $this->db->from('jobs as j');
        $this->db->join('job_categories as c', 'j.job_category_id = c.id', 'LEFT');
        return $this->db->get()->row();
    }

    function total_rows($q = NULL, $category, $status, $deadline, $user, $user_id, $role_id)
    {
        $this->__search($q, $category, $status, $deadline, $user, $user_id, $role_id);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL, $category, $status, $deadline, $user, $user_id, $role_id)
    {
        $this->__search($q, $category, $status, $deadline, $user, $user_id, $role_id);
        $this->db->order_by($this->id, $this->order);
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    function __search($q = NULL, $category, $status, $deadline, $user, $user_id, $role_id)
    {
        if($user){
            $this->db->where('j.user_id', $user);
        }
        if($role_id == 4){
            $this->db->where('j.user_id', $user_id);
        }
        if($category){
            $this->db->where('j.job_category_id', $category);
        }
        if($status){
            $this->db->where('j.status', $status);
        }
        if($deadline){
            $this->db->where('j.deadline', $deadline);
        }

        if ($q) {
            $this->db->group_start();
            $this->db->like('j.id', $q);
            $this->db->or_like('j.job_category_id', $q);
            $this->db->or_like('j.title', $q);
            $this->db->or_like('j.location', $q);
            $this->db->or_like('j.deadline', $q);
            $this->db->or_like('j.status', $q);
            $this->db->group_end();
        }

        $this->db->select('j.*');
        $this->db->select('c.name as category_name');
        $this->db->from('jobs as j');
        $this->db->join('job_categories as c', 'j.job_category_id = c.id', 'LEFT');
    }
    
    function insert_sub_category($data) {
         if ($this->db->insert('job_sub_categories', $data)) {
            $lastId = $this->db->insert_id();
            return $lastId;
        }

        return false;
    }
    
    function getSubCatById($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $this->db->from('job_sub_categories');
        return $this->db->get()->row();
    }
    
    function get_application_by_id($id) {
        
        $this->db->where('id', $id);
        $this->db->from('job_applications');
        return $this->db->get()->row();
    }

}