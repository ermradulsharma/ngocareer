<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Application_model extends Fm_model {    

    function __construct()
    {
        parent::__construct();
    }

    // get total rows
    function total_rows()
    {       
        $this->db->from('job_applications as a');
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0,$status=null,$date=null)
    {

        $this->db->select('j.title as job_title');
        $this->db->select('a.*,c.id as can_id,c.full_name,c.picture, c.mobile_number, c.email, cv.id as cv_id');
        $this->db->from('job_applications as a');        
        $this->db->join('candidate_cv as cv', 'cv.id=a.candidate_cv_id', 'LEFT');
        $this->db->join('candidates as c', 'c.id=a.candidate_id', 'LEFT');
        $this->db->join('jobs as j', 'j.id=a.job_id', 'LEFT');
        $this->db->order_by('a.id', 'DESC');
        
        if($status){ $this->db->where('a.status', $status ); }
        if($date){ $this->db->where('a.applied_at >=', $date ); }
       
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
        
        
        
    }

}
