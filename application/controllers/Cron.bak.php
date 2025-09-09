<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Author: Iqbal Hossen
 * Date : 2020-03-04
 */

class Cron extends MX_Controller {
    
    function index(){

        //Get job alert info & candidate info
        $this->db->select('jas.candidate_id, jas.location, jas.lat, jas.lng, GROUP_CONCAT(j.job_category_id) as category_ids, GROUP_CONCAT(j.id) job_ids');
        $this->db->select('c.full_name, c.email');
        $this->db->from('job_alert_setup as jas');
        $this->db->join('candidates as c', 'c.id=jas.candidate_id','INNER');
        
        //$this->db->join('jobs as j', 'FIND_IN_SET(j.job_category_id, jas.job_category_ids) > 0 and j.status="Published" and j.deadline>="'.date("Y-m-d").'"', 'INNER');
        
        $this->db->join('jobs as j', 'FIND_IN_SET(j.job_category_id, jas.job_category_ids) > 0', 'LEFT');
        $this->db->where('j.status', 'Published');
//        $this->db->where('j.deadline >=', date("Y-m-d"));
        $this->db->where('j.created_at >=', date("Y-m-d 00:00:00", strtotime('-1 Day')));
        $this->db->where('j.created_at <=', date("Y-m-d 23:59:59", strtotime('-1 Day')));

        $this->db->where('jas.status', 'On');
        $this->db->group_by('jas.candidate_id');
        $jobAlerts = $this->db->get()->result();
        
        pp( $this->db->last_query() );
//         dd( $this->db->last_query() );
      
        if(!$jobAlerts){
           return false; 
        }
                
        
        foreach ($jobAlerts as $job) {

            //Get Job Catgory Names
//            $this->db->select('name');            
//            $this->db->where_in('id', explode(',', $job->category_ids));            
//            $categorys = $this->db->get('job_categories')->result();
//            $subject = '';
//            foreach ($categorys as $category) {
//              $subject .= $category->name.', ';
//            }

            //Get jobs list 
            $this->db->select('j.job_category_id');
            $this->db->select('j.id, j.title, j.location, j.deadline, j.salary_type');
            $this->db->select('j.salary_min, j.salary_max, j.salary_currency');
            $this->db->select('u.company_name');
            $this->db->from('jobs as j');
            $this->db->join('users as u', 'u.id=j.user_id', 'left');
            $this->db->where_in('j.id', explode(',', $job->job_ids));            
            $data['jobs'] = $this->db->get()->result();
            pp( $this->db->last_query() );
//            dd( $data['jobs'] );
            $body = $this->load->view('job_alert_layout', $data, true );
            $prams = array(
                'candidate_id' => $job->candidate_id,
                'send_to' => $job->email,
                'subject' => 'NGO Career || Job Alert', //trim($subject, ', '),
                'body' => $body,
            );


           echo Modules::run('mail/sendJobAlerts', $prams );
        }
        
        
    }
    
}
