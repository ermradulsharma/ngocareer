<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Candidate_model extends CI_Model
{

    private $candidate_id;
    public function __construct()
    {
        parent::__construct();
        $this->candidate_id = getLoginCandidatetData('id');
    }

    public function store($saveField)
    {
        if ($this->db->insert('candidates', $saveField)) {
            $lastId = $this->db->insert_id();
            return $lastId;
        }

        return false;
    }

    public function insert_file($saveField)
    {
        if ($this->db->insert('candidate_cv', $saveField)) {
            $lastId = $this->db->insert_id();
            return $lastId;
        }
        return false;
    }

    public function get_cvs_by_candidate($id)
    {
        return $this->db->where('candidate_id', $id)
            ->get('candidate_cv')->result();
    }

    public function get_cv_by_id($file_id)
    {
        return $this->db->where('id', $file_id)
            ->get('candidate_cv')->row();
    }

    public function get_files()
    {
        return $this->db->select()
            ->from('candidate_cv')
            ->get()
            ->result();
    }

    public function get_file($file_id)
    {
        return $this->db->select()
            ->from('candidate_cv')
            ->where('id', $file_id)
            ->get()
            ->row();
    }

    public function delete_file($file_id)
    {
        $file = $this->get_file($file_id);
        if (!$this->db->where('id', $file_id)->delete('candidate_cv')) {
            return FALSE;
        }
        @unlink("./uploads/cv/{$file->file}");
        return TRUE;
    }

    /*
     * Insert / Update facebook profile data into the database
     * Insert / Update google profile data into the database
     * @param array the data for inserting into the table
     */

    public function checkFacebookGoogleUser($userData = array())
    {
        if (!empty($userData)) {
            //check whether user data already exists in database with same oauth info
            $this->db->select('id');
            $this->db->from('candidates');
            $this->db->where(array('oauth_provider' => $userData['oauth_provider'], 'oauth_uid' => $userData['oauth_uid']));
            $prevQuery = $this->db->get();
            $prevCheck = $prevQuery->num_rows();

            if ($prevCheck > 0) {
                $prevResult = $prevQuery->row_array();

                //update user data
                //                $userData['modified'] = date("Y-m-d H:i:s");
                //                $update = $this->db->update('candidates', $userData, array('id' => $prevResult['id']));
                //get user ID
                $userID = $prevResult['id'];
            } else {
                //insert user data
                $userData['created_at'] = date("Y-m-d H:i:s");
                $userData['modified'] = date("Y-m-d H:i:s");
                $insert = $this->db->insert('candidates', $userData);

                //get user ID
                $userID = $this->db->insert_id();
            }
        }

        //return user ID
        return $userID ? $userID : FALSE;
    }

    public function getCurrentJobseeker($id)
    {

        $this->db->select('*');
        $this->db->from('candidates');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }

    public function update_profile($id, $data)
    {

        $this->db->where('id', $id);
        if ($this->db->update('candidates', $data)) {
            return $id;
        }
        return false;
    }

    public function profile_picture_update($id, $data)
    {
        $this->db->where('id', $id);
        if ($this->db->update('candidates', $data)) {
            return $id;
        }
        return false;
    }

    public function get_applied_job($candidate_id)
    {
        $this->db->select('ja.id as job_application_id, ja.applied_at, ja.viewed, ja.status');
        $this->db->select('ja.expected_salary,j.id as job_id, j.title as job_title');
        $this->db->select('u.company_name as company_name, j.salary_min, j.salary_max, c.full_name');
        $this->db->from('job_applications as ja');
        $this->db->join('candidate_cv as ccv', 'ccv.id=ja.candidate_cv_id', 'left');
        $this->db->join('candidates as c', 'c.id=ccv.candidate_id', 'left');
        $this->db->join('jobs as j', 'j.id=ja.job_id', 'left');
        $this->db->join('users as u', 'u.id = j.user_id', 'LEFT');
        $this->db->where('c.id', $candidate_id);
        return $this->db->get()->result();
    }

    public function shortlist_job_insert($saveField)
    {
        if ($this->db->insert('job_favourites', $saveField)) {
            $lastId = $this->db->insert_id();
            return $lastId;
        }
        return false;
    }

    public function get_shortlisted_jobs($candidate_id)
    {
        $this->db->select('jf.id as job_favourite_id, j.deadline, j.id as job_id, j.title as job_title, u.company_name as company_name, c.full_name');
        $this->db->from('job_favourites as jf');
        $this->db->join('candidates as c', 'c.id=jf.candidate_id', 'LEFT');
        $this->db->join('jobs as j', 'j.id=jf.job_id', 'LEFT');
        $this->db->join('users as u', 'u.id = j.user_id', 'LEFT');
        $this->db->where(array('c.id' => $candidate_id));
        $query = $this->db->get();
        return $query->result();
    }

    public function delete_shortlisted_job($id)
    {
        $this->db->where('id', $id);
        if ($this->db->delete('job_favourites')) {
            return true;
        }
        return false;
    }

    public function shortlist_job_duplicate_check($job_id, $candidate_id)
    {
        $this->db->from('job_favourites');
        $this->db->where('job_id', $job_id);
        $this->db->where('candidate_id', $candidate_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_job_alert_info($candidate_id)
    {

        $this->db->from('job_alert_setup');
        $this->db->where('candidate_id', $candidate_id);
        return $this->db->get()->row();
    }

    public function get_job_alert_mailbox($candidate_id)
    {
        $this->db->from('mails');
        $this->db->where('mail_type', 'jobAlert');
        $this->db->where('receiver_id', $candidate_id);
        return $this->db->get()->result();
    }
}

/* End of file Candidate_model.php */
/* Location: ./application/models/Candidate_model.php */
