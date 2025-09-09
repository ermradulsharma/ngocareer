<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
 * Author: Iqbal Hossen
 * Date : 2020-03-04
 */

class Cron extends MX_Controller
{

    function index()
    {
//        Modules::run('mail/cronReportToDev', 'link');
//        exit();
        $this->sendJobAlertToCandidateForAllCategory('Daily');
        $this->sendJobAlertToCandidateForSelectedCategory('Daily');
        $this->sendJobAlertUsingKeywords('Daily');
//        $this->sendJobAlertToCandidateForSelectedCategoryForSubscribers('Daily');

        $report = 'Daily Run<br/>' . "\r\n";

        $date = (int)date('d');
        if ($date == 1) {
            $this->sendJobAlertToCandidateForSelectedCategory('Monthly');
            $this->sendJobAlertToCandidateForAllCategory('Monthly');
            $this->sendJobAlertUsingKeywords('Monthly');
//            $this->sendJobAlertToCandidateForSelectedCategoryForSubscribers('Monthly');
            $this->sendJobAlertForSubscribers(); // Monthly Only
            $report .= 'Monthly Run<br/>' . "\r\n";
        }
        $day = date('D');
        if ($day == 'Mon') {
            $this->sendJobAlertToCandidateForSelectedCategory('Weekly');
            $this->sendJobAlertToCandidateForAllCategory('Weekly');
            $this->sendJobAlertUsingKeywords('Weekly');
//            $this->sendJobAlertToCandidateForSelectedCategoryForSubscribers('Weekly');
            $report .= 'Weekly Run<br/>' . "\r\n";
        }
        $this->submitSiteMap();
        Modules::run('mail/cronReportToDev', $report);
    }

    private function submitSiteMap()
    {
        $this->generateSiteMap();

        // create a new cURL resource
        $ch = curl_init();
        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/ping?sitemap=http://localhost/ngocareer//sitemap.xml");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        // grab URL and pass it to the browser
        curl_exec($ch);
        // close cURL resource, and free up system resources
        curl_close($ch);
    }

    private function generateSiteMap(){
        // create a new cURL resource
        $ch = curl_init();
        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, "http://localhost/ngocareer//sitemap?key=RmxpY2sgTWVkaWE=");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        // grab URL and pass it to the browser
        curl_exec($ch);
        // close cURL resource, and free up system resources
        curl_close($ch);
    }

    private function sendJobAlertUsingKeywords($frequency = 'Daily')
    {
        // Get job alert setup data
        $this->db->select('jas.id, jas.candidate_id, jas.lat, jas.lng, jas.distance, jas.email_frequency, c.full_name,jas.job_category_ids');
        $this->db->select("IF(jas.candidate_id=0, jas.email, c.email) as email");
        $this->db->select("jas.keywords");
        $this->db->from('job_alert_setup as jas');
        $this->db->join('candidates as c', 'c.id = jas.candidate_id', 'LEFT');
        $this->db->where('jas.status', 'On');
        $candidates = $this->db->get()->result();

        foreach ($candidates as $i => $candidate) {
            $this->db->select('j.job_category_id, u.logo');
            $this->db->select('j.id, j.title, j.location, j.deadline, j.salary_type');
            $this->db->select('j.salary_min, j.salary_max, j.salary_currency');
            $this->db->select('IFNULL(j.AdvertiserName, u.company_name) as company');
            $this->db->from('jobs as j');
            $this->db->join('users as u', 'u.id=j.user_id', 'LEFT');

            $this->db->group_start();
            $this->db->like('j.title', 'test');
            $keywords = explode(',', $candidate->keywords);
            foreach ($keywords as $keyword) {
                $this->db->or_like('j.title', $keyword);
                $this->db->or_like('j.description', $keyword);
            }
            $this->db->group_end();

            if ($frequency == 'Daily') {
                $this->db->where('j.created_at >=', date('Y-m-d 00:00:00', strtotime('-1 Day')));
                $this->db->where('j.created_at <=', date('Y-m-d 23:59:59', strtotime('-1 Day')));
            } elseif ($frequency == 'Weekly') {
                $this->db->where('j.created_at >=', date('Y-m-d 00:00:00', strtotime('-8 Days')));
                $this->db->where('j.created_at <=', date('Y-m-d 23:59:59', strtotime('-1 Day')));
            } else {
                $this->db->where('j.created_at >=', date('Y-m-01 00:00:00', strtotime('-1 Month')));
                $this->db->where('j.created_at <=', date('Y-m-31 23:59:59', strtotime('-1 Month')));
            }

            $this->db->order_by('j.id', 'ASC');
            $this->db->limit(20);
            $jobs = $this->db->get()->result();

            if (!$jobs) {
                return FALSE;
            }

            $data['jobs'] = $jobs;
            $data['unsubscribe_url'] = site_url('alert_unsubscribe?e=' . base64_encode($candidate->email));
            $body = $this->load->view('job_alert_layout', $data, true);
            $keywords = ($candidate->keywords) ? '"' . $candidate->keywords . '"' : '';

            $prams = array(
                'candidate_id' => $candidate->id,
                'send_to' => $candidate->email,
                'subject' => count($jobs) . ' new jobs available for your NGO Career job alert' . $keywords,
                'body' => $body,
            );

            Modules::run('mail/sendJobAlerts', $prams);

            if ($i > 0 && $i % 10 == 0) {
                sleep(5);
            }
        }
    }

    private function sendJobAlertToCandidateForAllCategory($frequency = 'Daily')
    {
        $frequency = 'Monthly';

        // Get job alert setup data
        $this->db->select('jas.id, jas.candidate_id, jas.lat, jas.lng, jas.distance, jas.email_frequency, c.full_name, jas.job_category_ids');
        $this->db->select("IF(jas.candidate_id=0, jas.email, c.email) as email");
        $this->db->from('job_alert_setup as jas');
        $this->db->join('candidates as c', 'c.id = jas.candidate_id', 'LEFT');
        $this->db->where('jas.status', 'On');
        $this->db->where('c.status', 'Active');
        $this->db->where('jas.job_category_ids', 0);
        $candidates = $this->db->get()->result();

        foreach ($candidates as $i => $candidate) {
            $this->db->select('j.job_category_id, u.logo');
            $this->db->select('j.id, j.title, j.location, j.deadline, j.salary_type');
            $this->db->select('j.salary_min, j.salary_max, j.salary_currency');
            $this->db->select('IFNULL(j.AdvertiserName, u.company_name) as company');
            $this->db->select('(
                    3959 * acos (
                    cos ( radians(' . $candidate->lat . ') )
                    * cos( radians( j.lat ) )
                    * cos( radians( j.lng ) - radians(' . $candidate->lng . ') )
                    + sin ( radians(' . $candidate->lat . ') )
                    * sin( radians( j.lat ) )
                  )
              ) AS distance');
            $this->db->from('jobs as j');
            $this->db->join('users as u', 'u.id=j.user_id', 'LEFT');
//            $this->db->where('jas.email_frequency',  $frequency );
            if ($frequency == 'Daily') {
                $this->db->where('j.created_at >=', date('Y-m-d 00:00:00', strtotime('-1 Day')));
                $this->db->where('j.created_at <=', date('Y-m-d 23:59:59', strtotime('-1 Day')));
            } elseif ($frequency == 'Weekly') {
                $this->db->where('j.created_at >=', date('Y-m-d 00:00:00', strtotime('-8 Days')));
                $this->db->where('j.created_at <=', date('Y-m-d 23:59:59', strtotime('-1 Day')));
            } else {
                $this->db->where('j.created_at >=', date('Y-m-01 00:00:00', strtotime('-1 Month')));
                $this->db->where('j.created_at <=', date('Y-m-31 23:59:59', strtotime('-1 Month')));
            }
//            $this->db->having('distance <=', 500);

            $this->db->order_by('distance', 'ASC');
            $this->db->order_by('j.id', 'ASC');
            $this->db->limit(20);
            $jobs = $this->db->get()->result();

            if (!$jobs) {
                return FALSE;
            }

            $data['jobs'] = $jobs;
            $data['unsubscribe_url'] = site_url('alert_unsubscribe?e=' . base64_encode($candidate->email));

            $body = $this->load->view('job_alert_layout', $data, true);
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

    private function sendJobAlertToCandidateForSelectedCategory($frequency = 'Daily')
    {
        //Get job alert info & candidate info
        $this->db->select('jas.candidate_id');
        $this->db->select('jas.location, jas.lat, jas.lng, jas.distance');
        $this->db->select("IF(jas.candidate_id=0, jas.email, c.email) as email");
        $this->db->select('jas.email_frequency');
        $this->db->select("GROUP_CONCAT(j.id) as job_ids");
        $this->db->select('c.full_name');
        $this->db->from('job_alert_setup as jas');
        $this->db->join('candidates as c', 'c.id = jas.candidate_id', 'LEFT');

        $this->db->join('jobs as j', 'FIND_IN_SET(j.job_category_id, jas.job_category_ids) > 0', 'INNER');
        $this->db->where('j.status', 'Published');
        $this->db->where('jas.email_frequency', $frequency);

        if ($frequency == 'Daily') {
            $this->db->where('j.created_at >=', date('Y-m-d 00:00:00', strtotime('-1 Day')));
            $this->db->where('j.created_at <=', date('Y-m-d 23:59:59', strtotime('-1 Day')));
        } elseif ($frequency == 'Weekly') {
            $this->db->where('j.created_at >=', date('Y-m-d 00:00:00', strtotime('-8 Days')));
            $this->db->where('j.created_at <=', date('Y-m-d 23:59:59', strtotime('-1 Day')));
        } else {
            $this->db->where('j.created_at >=', date('Y-m-01 00:00:00', strtotime('-1 Month')));
            $this->db->where('j.created_at <=', date('Y-m-31 23:59:59', strtotime('-1 Month')));
        }

        $this->db->where('jas.status', 'On');
        $this->db->group_by('jas.candidate_id');

        $jobAlerts = $this->db->get()->result();

        if (!$jobAlerts) {
            return false;
        }

        foreach ($jobAlerts as $job) {
            $this->db->select('j.job_category_id, c.name as category_name, u.logo');
            $this->db->select('j.id, j.title, j.location, j.deadline, j.salary_type');
            $this->db->select('j.salary_min, j.salary_max, j.salary_currency');
            $this->db->select('IFNULL(j.AdvertiserName, u.company_name) as company');
            $this->db->select('(
                    3959 * acos (
                    cos ( radians(' . $job->lat . ') )
                    * cos( radians( j.lat ) )
                    * cos( radians( j.lng ) - radians(' . $job->lng . ') )
                    + sin ( radians(' . $job->lat . ') )
                    * sin( radians( j.lat ) )
                  )
              ) AS distance');
            $this->db->from('jobs as j');
            $this->db->join('users as u', 'u.id=j.user_id', 'LEFT');
            $this->db->join('job_categories as c', 'c.id = j.job_category_id', 'LEFT');
            $this->db->where_in('j.id', explode(', ', $job->job_ids));
            $this->db->order_by('distance', 'ASC');
            $this->db->order_by('j.id', 'ASC');
            $this->db->having('distance <=', 500);
            $this->db->limit(20);
            $jobs = $this->db->get()->result();

            if (!$jobs) {
                return FALSE;
            }
            $data['jobs'] = $jobs;
            $data['unsubscribe_url'] = site_url('alert_unsubscribe?e=' . base64_encode($job->email));
            $body = $this->load->view('job_alert_layout', $data, true);
            $prams = array(
                'candidate_id' => $job->candidate_id,
                'send_to' => $job->email,
                'subject' => count($jobs) . ' new jobs available for your NGO Career job alert',
                'body' => $body,
            );
            echo Modules::run('mail/sendJobAlerts', $prams);
        }
    }

    private function sendJobAlertToCandidateForSelectedCategoryForSubscribers($frequency = 'Daily')
    {
        //Get job alert info & candidate info
        $this->db->select('jas.candidate_id');
        $this->db->select('jas.location, jas.lat, jas.lng, jas.distance');
        $this->db->select("IF(jas.candidate_id=0, jas.email, c.email) as email");
        $this->db->select('jas.email_frequency');
        $this->db->select("GROUP_CONCAT(j.id) as job_ids");
        $this->db->select('c.full_name');
        $this->db->from('job_alert_setup as jas');
        $this->db->join('candidates as c', 'c.id = jas.candidate_id', 'LEFT');

        $this->db->join('jobs as j', 'FIND_IN_SET(j.job_category_id, jas.job_category_ids) > 0', 'INNER');
        $this->db->where('j.status', 'Published');
        $this->db->where('jas.email_frequency', $frequency);

        if ($frequency == 'Daily') {
            $this->db->where('j.created_at >=', date('Y-m-d 00:00:00', strtotime('-1 Day')));
            $this->db->where('j.created_at <=', date('Y-m-d 23:59:59', strtotime('-1 Day')));
        } elseif ($frequency == 'Weekly') {
            $this->db->where('j.created_at >=', date('Y-m-d 00:00:00', strtotime('-8 Days')));
            $this->db->where('j.created_at <=', date('Y-m-d 23:59:59', strtotime('-1 Day')));
        } else {
            $this->db->where('j.created_at >=', date('Y-m-01 00:00:00', strtotime('-1 Month')));
            $this->db->where('j.created_at <=', date('Y-m-31 23:59:59', strtotime('-1 Month')));
        }

        $this->db->where('jas.status', 'On');
        $this->db->group_by('jas.candidate_id');

        $jobAlerts = $this->db->get()->result();

        if (!$jobAlerts) {
            return false;
        }

        foreach ($jobAlerts as $job) {
            $this->db->select('j.job_category_id, u.logo');
            $this->db->select('j.id, j.title, j.location, j.deadline, j.salary_type');
            $this->db->select('j.salary_min, j.salary_max, j.salary_currency');
            $this->db->select('IFNULL(j.AdvertiserName, u.company_name) as company');
            $this->db->select('(
                    3959 * acos (
                    cos ( radians(' . $job->lat . ') )
                    * cos( radians( j.lat ) )
                    * cos( radians( j.lng ) - radians(' . $job->lng . ') )
                    + sin ( radians(' . $job->lat . ') )
                    * sin( radians( j.lat ) )
                  )
              ) AS distance');
            $this->db->from('jobs as j');
            $this->db->join('users as u', 'u.id=j.user_id', 'LEFT');
            $this->db->where_in('j.id', explode(', ', $job->job_ids));
            $this->db->order_by('distance', 'ASC');
            $this->db->order_by('j.id', 'ASC');
            $this->db->having('distance <=', 500);
            $this->db->limit(20);
            $jobs = $this->db->get()->result();
            if (!$jobs) {
                return FALSE;
            }
            $data['jobs'] = $jobs;
            $data['unsubscribe_url'] = site_url('alert_unsubscribe?e=' . base64_encode($job->email));
            $body = $this->load->view('job_alert_layout', $data, true);
            $prams = array(
                'candidate_id' => $job->candidate_id,
                'send_to' => $job->email,
                'subject' => count($jobs) . ' new jobs available for your NGO Career job alert',
                'body' => $body,
            );
            echo Modules::run('mail/sendJobAlerts', $prams);
        }
    }

//    private function sendJobAlertToCandidateForSelectedCategoryForSubscribers( $frequency = 'Daily' )
//    {
//        //Get job alert info & candidate info
//        $this->db->select('jas.candidate_id, jas.location, jas.lat, jas.lng, jas.distance, jas.email');
//        $this->db->select('jas.email_frequency');
//        $this->db->select("GROUP_CONCAT(j.id) as job_ids");
//        $this->db->from('job_alert_setup as jas');
//
//        $this->db->join('jobs as j', 'FIND_IN_SET(j.job_category_id, jas.job_category_ids) > 0', 'INNER');
//        $this->db->where('j.status', 'Published');
//        $this->db->where('jas.email_frequency',  $frequency);
//
//        if($frequency == 'Daily'){
//            $this->db->where('j.created_at >=', date('Y-m-d 00:00:00', strtotime('-1 Day')));
//            $this->db->where('j.created_at <=', date('Y-m-d 23:59:59', strtotime('-1 Day')));
//        } elseif($frequency == 'Weekly'){
//            $this->db->where('j.created_at >=', date('Y-m-d 00:00:00', strtotime('-8 Days')));
//            $this->db->where('j.created_at <=', date('Y-m-d 23:59:59', strtotime('-1 Day')));
//        } else{
//            $this->db->where('j.created_at >=', date('Y-m-01 00:00:00', strtotime('-1 Month')));
//            $this->db->where('j.created_at <=', date('Y-m-31 23:59:59', strtotime('-1 Month')));
//        }
//
//        $this->db->where('jas.status', 'On');
//
//        $jobAlerts = $this->db->get()->result();
//
//        if (!$jobAlerts) {
//            return false;
//        }
//
//        foreach ($jobAlerts as $job) {
//            $this->db->select('j.job_category_id');
//            $this->db->select('j.id, j.title, j.location, j.deadline, j.salary_type');
//            $this->db->select('j.salary_min, j.salary_max, j.salary_currency');
//            $this->db->select('IFNULL(j.AdvertiserName, u.company_name) as company');
//            $this->db->select('(
//                    3959 * acos (
//                    cos ( radians('.$job->lat.') )
//                    * cos( radians( j.lat ) )
//                    * cos( radians( j.lng ) - radians('.$job->lng.') )
//                    + sin ( radians('.$job->lat.') )
//                    * sin( radians( j.lat ) )
//                  )
//              ) AS distance');
//            $this->db->from('jobs as j');
//            $this->db->join('users as u', 'u.id=j.user_id', 'LEFT');
//            $this->db->where_in('j.id', explode(', ', $job->job_ids));
//            $this->db->order_by('distance', 'ASC');
//            $this->db->order_by('j.id', 'ASC');
//            $this->db->having('distance <=', 500);
//            $this->db->limit(20);
//            $jobs = $this->db->get()->result();
//
//            if(!$jobs){
//                return FALSE;
//            }
//            $data['jobs'] = $jobs;
//            $body = $this->load->view('job_alert_layout', $data, true);
//
//            $prams = array(
//                'candidate_id' => $job->candidate_id,
//                'send_to' => $job->email,
//                'subject' => 'NGO Career || Job Alert', //trim($subject, ', '),
//                'body' => $body,
//            );
//            echo Modules::run('mail/sendJobAlerts', $prams);
//        }
//    }

    /* Finished */
    private function sendJobAlertForSubscribers()
    {
        $this->db->select('j.job_category_id');
        $this->db->select('j.id, j.title, j.location, j.deadline, j.salary_type');
        $this->db->select('j.salary_min, j.salary_max, j.salary_currency, u.logo');
//        $this->db->select('u.company_name,j.AdvertiserName');
        $this->db->select('IFNULL(j.AdvertiserName, u.company_name) as company');
        $this->db->from('jobs as j');
        $this->db->join('users as u', 'u.id=j.user_id', 'LEFT');
        $this->db->where('j.created_at >=', date('Y-m-d 00:00:00', strtotime('-1 Day')));
        $this->db->where('j.created_at <=', date('Y-m-d 23:59:59', strtotime('-1 Day')));
        $this->db->limit(10);
        $this->db->order_by('j.id', 'DESC');
        $data['jobs'] = $this->db->get()->result();
        if (empty($data['jobs'])) {
            return false;
        }

        $this->db->select('n.name, n.email');
        $this->db->from('newsletter_subscribers as n');
        $this->db->where('n.status', 'Subscribe');
        $subscribers = $this->db->get()->result();

        foreach ($subscribers as $i => $subscriber) {
            $data['unsubscribe_url'] = site_url('newsletter_unsubscribe?e=' . base64_encode($subscriber->email));
            $data['subscriber_email'] = $subscriber->email;
            $body = $this->load->view('job_alert_layout', $data, true);

            $prams = array(
                'candidate_id' => 0,
                'send_to' => $subscriber->email,
                'subject' => count($data['jobs']) . ' new jobs available for your NGO Career job alert',
                'body' => $body,
                'unsubscribe_url' => $data['unsubscribe_url'],
            );

            Modules::run('mail/sendJobAlerts', $prams);

            if ($i > 0 && $i % 10 == 0) {
                sleep(5);
            }
        }
    }
}
