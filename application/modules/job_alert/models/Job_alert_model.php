<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Job_alert_model extends Fm_model {

    public $table = 'job_alert_setup';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get total rows
    function total_rows()
    {       
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0)
    {
        $this->db->select('a.*, c.full_name');
        $this->db->select("IF(a.candidate_id=0, a.email, c.email) as email");
        $this->db->from("{$this->table} as a");
        $this->db->join('candidates as c', 'c.id = a.candidate_id', 'LEFT');
        $this->db->order_by($this->id, $this->order);        
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

}
