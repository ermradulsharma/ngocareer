<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_model extends Fm_model {

    public $table = 'transactions';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        if ($q) {                        
            $this->db->like('t.ref_id', $q);
            $this->db->or_like('t.email', $q);            
        }
        $this->db->from('transactions as t');
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('t.id,ref_id,paid_amount,payment_status,email,t.created_at');
        $this->db->select('j.title as job_title');
        $this->db->from('transactions as t');
        $this->db->join('jobs as j','j.id=t.ref_id','LEFT');
        $this->db->order_by($this->id, $this->order);
        if ($q) {                        
            $this->db->like('t.ref_id', $q);
            $this->db->or_like('t.email', $q);
        }
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

}
