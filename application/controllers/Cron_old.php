<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Author: Iqbal Hossen
 * Date : 2020-03-04
 */

class Cron_old extends MX_Controller
{

    function index()
    {        
        //die('Job Alert is Stop');
        $this->sendJobAlertForSubscribers();
        $this->sendJobAlertToCandidateForAllCategory();
        $this->sendJobAlertToCandidateForSelectedCategory();
    }
    
    private function sendJobAlertToCandidateForSelectedCategory()
    {
         
        //Get job alert info & candidate info
        $this->db->select('jas.candidate_id, jas.location, jas.lat, jas.lng, jas.distance, GROUP_CONCAT(j.id) as job_ids');
        $this->db->select('c.full_name, c.email');
        $this->db->from('job_alert_setup as jas');
        $this->db->join('candidates as c', 'c.id=jas.candidate_id', 'INNER');

        $this->db->join('jobs as j', 'FIND_IN_SET(j.job_category_id, jas.job_category_ids) > 0', 'INNER');
        $this->db->where('j.status', 'Published');
        $this->db->where('j.created_at >=', date('Y-m-d 00:00:00', strtotime('-1 Day')));
        $this->db->where('j.created_at <=', date('Y-m-d 23:59:59', strtotime('-1 Day')));

        $this->db->where('jas.status', 'On');
        $this->db->group_by('jas.candidate_id');
        $jobAlerts = $this->db->get()->result();
         
        if (!$jobAlerts) {
            return false;
        }

        foreach ($jobAlerts as $job) {
           
            $this->db->select('j.job_category_id');
            $this->db->select('j.id, j.title, j.location, j.deadline, j.salary_type');
            $this->db->select('j.salary_min, j.salary_max, j.salary_currency');
            $this->db->select('IFNULL(j.AdvertiserName, u.company_name) as company');
            $this->db->from('jobs as j');
            $this->db->join('users as u', 'u.id=j.user_id', 'LEFT');
            $this->db->where_in('j.id', explode(',', $job->job_ids));
            $this->db->order_by('j.id', 'ASC');
            $this->db->limit(20);
            $data['jobs'] = $this->db->get()->result();
           
            $body = $this->load->view('job_alert_layout', $data, true);
            
//            echo ( $body );
            $prams = array(
                'candidate_id' => $job->candidate_id,
                'send_to' => $job->email,
                'subject' => 'NGO Career || Job Alert', //trim($subject, ', '),
                'body' => $body,
            );

            echo Modules::run('mail/sendJobAlerts', $prams);
        }
    }

    private function sendJobAlertToCandidateForAllCategory()
    {
        $this->db->select('j.job_category_id');
        $this->db->select('j.id, j.title, j.location, j.deadline, j.salary_type');
        $this->db->select('j.salary_min, j.salary_max, j.salary_currency');
        $this->db->select('IFNULL(j.AdvertiserName, u.company_name) as company');
        $this->db->from('jobs as j');
        $this->db->join('users as u', 'u.id=j.user_id', 'LEFT');
        $this->db->where('j.created_at >=', date('Y-m-d 00:00:00', strtotime('-1 Day')));
        $this->db->where('j.created_at <=', date('Y-m-d 23:59:59', strtotime('-1 Day')));
        $this->db->limit(20);
        $this->db->order_by('j.id', 'ASC');
        $data['jobs'] = $this->db->get()->result();
        if(empty($data['jobs'])){
            return false;
        }
        $body = $this->load->view('job_alert_layout', $data, true);
        
        $this->db->select('jas.id, jas.candidate_id, c.full_name, c.email');
        $this->db->from('job_alert_setup as jas');
        $this->db->join('candidates as c', 'c.id = jas.candidate_id', 'INNER');
        $this->db->where('jas.status', 'On');
        $this->db->where('c.status', 'Active');
        $this->db->where('jas.job_category_ids', 0);
        $candidates = $this->db->get()->result();

        foreach ($candidates as $i => $candidate) {
            $prams = array(
                'candidate_id' => $candidate->id,
                'send_to' => $candidate->email,
                'subject' => 'NGO Career || Job Alert', // trim($subject, ', '),
                'body' => $body,
            );

            Modules::run('mail/sendJobAlerts', $prams);

            if ($i > 0 && $i % 10 == 0) {
                sleep(5);
            }
        }
    }

    private function sendJobAlertForSubscribers(){
        $this->db->select('j.job_category_id');
        $this->db->select('j.id, j.title, j.location, j.deadline, j.salary_type');
        $this->db->select('j.salary_min, j.salary_max, j.salary_currency');
//        $this->db->select('u.company_name,j.AdvertiserName');
        $this->db->select('IFNULL(j.AdvertiserName, u.company_name) as company');
        $this->db->from('jobs as j');
        $this->db->join('users as u', 'u.id=j.user_id', 'LEFT');
        $this->db->where('j.created_at >=', date('Y-m-d 00:00:00', strtotime('-1 Day')));
        $this->db->where('j.created_at <=', date('Y-m-d 23:59:59', strtotime('-1 Day')));
        $this->db->limit(20);
        $this->db->order_by('j.id', 'ASC');
        $data['jobs'] = $this->db->get()->result();
        if(empty($data['jobs'])){
            return false;
        }
        $body = $this->load->view('job_alert_layout', $data, true);

        $this->db->select('n.name, n.email');
        $this->db->from('newsletter_subscribers as n');
        $this->db->where('n.status', 'Subscribe');
        $subscribers = $this->db->get()->result();

        foreach ($subscribers as $i => $subscriber) {
            $prams = array(
                'candidate_id' => 0,
                'send_to' => $subscriber->email,
                'subject' => 'NGO Career || Job Alert', //trim($subject, ', '),
                'body' => $body,
            );

            Modules::run('mail/sendJobAlerts', $prams);

            if ($i > 0 && $i % 10 == 0) {
                sleep(5);
            }
        }
    }

    function alter()
    {
//        $this->db->query("ALTER TABLE `jobs` CHANGE `hit_count` `hit_count` INT(11) NOT NULL DEFAULT '0';");
//        $this->db->query("UPDATE `jobs` SET `hit_count` = '0';");
//        $this->db->query("ALTER TABLE `jobs` ADD `jobg8` VARCHAR(5000) NULL AFTER `status`;");
//        $this->db->query("ALTER TABLE `jobs` ADD `DisplayReference` VARCHAR(20) NULL AFTER `status`;");
        
//        $this->db->truncate('jobs');
        
//        $this->db->query("ALTER TABLE `job_favourites` DROP FOREIGN KEY `FK_job_favourites_jobs`;");
//        $this->db->query("ALTER TABLE `job_favourites` ADD CONSTRAINT `FK_job_favourites_jobs` FOREIGN KEY (`job_id`) REFERENCES `jobs`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;");	
//        $this->db->query("ALTER TABLE `job_email_to_friends` DROP FOREIGN KEY `FK_job_email_to_friends_jobs`; ");
//        $this->db->query("ALTER TABLE `job_email_to_friends` ADD CONSTRAINT `FK_job_email_to_friends_jobs` FOREIGN KEY (`job_id`) REFERENCES `jobs`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;");

    }

}
