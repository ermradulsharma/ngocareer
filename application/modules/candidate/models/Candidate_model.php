<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Candidate_model extends Fm_model
{

    public $table = 'candidates as c';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get total rows
    function total_rows($status,$gender=null,$alert=null,$q = NULL)
    {
        $this->db->from($this->table);
        $this->__search($status,$gender,$alert,$q);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $status=null,$gender=null,$alert=null,$q = NULL)
    {
        $this->db->select('c.*');
        $this->__search($status,$gender,$alert,$q);
        $this->db->order_by($this->id, $this->order);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    private function __search($status,$gender,$alert,$q){
        if(!in_array($status, ['Any', null])) { $this->db->where('status', $status); }
        if(!in_array($gender, ['Any', null])) { $this->db->where('gender', $gender); }
        if($alert && $alert == 'Yes') {
            $this->db->join('job_alert_setup as a', 'c.id=a.candidate_id', 'INNER');
        }
        if($alert && $alert == 'No') {
            $this->db->join('job_alert_setup as a', 'c.id=a.candidate_id', 'LEFT');
            $this->db->where('candidate_id is null', false, false );
        }
        if ($q) {
            $this->db->group_start();
            $this->db->like('full_name', $q);
            $this->db->or_like('email', $q);
            $this->db->or_like('permanent_address', $q);
            $this->db->or_like('present_address', $q);
            $this->db->or_like('home_phone', $q);
            $this->db->or_like('mobile_number', $q);
            $this->db->or_like('keywords', $q);
            $this->db->group_end();
        }
        $this->db->where('c.status !=', 'Waiting');
    }
}