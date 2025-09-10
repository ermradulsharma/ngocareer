<?php

defined('BASEPATH') or exit('No direct script access allowed');

class My_account extends Frontend_controller
{

    // every thing coming form Frontend Controller
    private $userdata;
    public $candidate_id = 0;
    public $candidate_email = null;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('job/job');
        $this->load->library('form_validation');
        $this->load->model('Candidate_model');
        $this->load->model('Frontend_model');
        // Load facebook oauth library 
        $this->load->library('facebook');
        // Load google oauth library 
        $this->load->library('google');

        //Get Jobseeker Information From Session
        $session_value = $this->session->userdata('value');
        $this->userdata = !empty($session_value) ? json_decode(base64_decode($session_value)) : array();
        $this->candidate_id = getLoginCandidatetData('id');
        $this->candidate_email = getLoginCandidatetData('email');
    }

    private function isLogin()
    {
        if (!$this->candidate_id) {
            redirect('/logout');
        }

        // Redirect to login page if the user not logged in 
        if (!$this->session->userdata('loggedIn')) {
            redirect('/login');
        }
    }
    public function profile()
    {

        $this->isLogin();

        // Get user info from session 
        $candidate = $this->Candidate_model->getCurrentJobseeker($this->candidate_id);
        $data = array(
            'id' => set_value('id', $candidate->id),
            'first_name' => set_value('first_name', $candidate->first_name),
            'last_name' => set_value('last_name', $candidate->last_name),
            'full_name' => set_value('full_name', $candidate->full_name),
            'email' => set_value('email', $candidate->email),
            'year' => set_value('year', substr($candidate->date_of_birth, 0, 4)),
            'month' => set_value('month', intval(substr($candidate->date_of_birth, 5, 2))),
            'day' => set_value('day', intval(substr($candidate->date_of_birth, 6, 8))),
            'gender' => set_value('gender', $candidate->gender),
            'marital_status' => set_value('marital_status', $candidate->marital_status),
            'country_id' => set_value('country_id', $candidate->country_id),
            'permanent_address' => set_value('permanent_address', $candidate->permanent_address),
            'present_address' => set_value('present_address', $candidate->present_address),
            'home_phone' => set_value('home_phone', $candidate->home_phone),
            'mobile_number' => set_value('mobile_number', $candidate->mobile_number),
            'career_summary' => set_value('career_summary', $candidate->career_summary),
            'qualifications' => set_value('qualifications', $candidate->qualifications),
            'keywords' => set_value('keywords', $candidate->keywords),
            'additional_information' => set_value('additional_information', $candidate->additional_information),
            'picture' => $candidate->picture,
            'meta_title' => 'My Profile'
        );

        $years = $months = $days = [];
        for ($year = 1950; $year <= date("Y"); $year++) {
            $years[$year] = $year;
        }

        for ($m = 1; $m <= 12; $m++) {
            $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
            $months[$m] = $month;
        }

        for ($d = 1; $d <= 31; $d++) {
            $days[$d] = ($d <= 9) ? '0' . $d : $d;;
        }
        $data['years'] = $years;
        $data['months'] = $months;
        $data['days'] = $days;

        // Load user profile view 
        $this->viewCandidateArea('profile', $data);
    }

    public function profile_update()
    {
        $this->form_validation->set_rules('first_name', 'first name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'last name', 'trim|required');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('day', 'Day', 'trim|required');
        $this->form_validation->set_rules('month', 'Month', 'trim|required');
        $this->form_validation->set_rules('year', 'Year', 'trim|required');
        $this->form_validation->set_rules('marital_status', 'Marital Status', 'trim|required');
        $this->form_validation->set_rules('country_id', 'country_id', 'trim|required');
        $this->form_validation->set_rules('permanent_address', 'permanent_address', 'trim|required');
        $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required');

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $this->profile();
        } else {
            $month  = (strlen($this->input->post('month')) == 1) ? '0' . $this->input->post('month') : $this->input->post('month');
            $day    = (strlen($this->input->post('day')) == 1) ? '0' . $this->input->post('day') : $this->input->post('day');
            $date_of_birth = $this->input->post('year') . "-{$month}-{$day}";

            $data = array(
                'first_name' => $this->input->post('first_name', TRUE),
                'last_name' => $this->input->post('last_name', TRUE),
                'full_name' => $this->input->post('first_name', TRUE) . ' ' . $this->input->post('last_name', TRUE),
                'date_of_birth' => $date_of_birth,
                'gender' => $this->input->post('gender', TRUE),
                'marital_status' => $this->input->post('marital_status', TRUE),
                'country_id' => (int) $this->input->post('country_id', TRUE),
                'permanent_address' => $this->input->post('permanent_address', TRUE),
                'present_address' => $this->input->post('present_address', TRUE),
                'home_phone' => $this->input->post('home_phone', TRUE),
                'mobile_number' => $this->input->post('mobile_number', TRUE),
                'career_summary' => $this->input->post('career_summary', TRUE),
                'qualifications' => $this->input->post('qualifications', TRUE),
                'keywords' => $this->input->post('keywords', TRUE),
                'additional_information' => $this->input->post('additional_information', TRUE)
            );

            $result = $this->Candidate_model->update_profile($this->candidate_id, $data);
            if ($result) {
                $this->session->set_flashdata('msgs', 'Candidate Profile Updated Successfully.');
            } else {
                $this->session->set_flashdata('msge', "Candidate Profile Could't Updated.");
            }
            redirect(site_url('myaccount/profile'));
        }
    }

    public function profile_picture_upload()
    {
        ajaxAuthorized();
        $status = "";
        $msg = "";

        if (empty($this->candidate_id)) {
            $status = "error";
            $msg = "The job seeker not a valid.";
        }

        if ($status != 'error') {
            $config['upload_path'] = './uploads/profile_picture/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 1024 * 1;
            $config['encrypt_name'] = TRUE;

            // create an uploads/profile_picture folder if not already exist in uploads dir
            if (!is_dir('uploads/profile_picture')) {
                mkdir('./uploads/profile_picture', 0777, true);
            }

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('upload_picture')) {
                $status = 'error';
                $msg = $this->upload->display_errors('', '');
            } else {
                $data = $this->upload->data();
                $updateField = array(
                    'picture' => 'uploads/profile_picture/' . $data['file_name']
                );

                $candidate_id = $this->Candidate_model->profile_picture_update($this->candidate_id, $updateField);

                if ($candidate_id) {
                    $status = "success";
                    $msg = "You have successfully uploaded photo.";
                } else {
                    unlink($data['full_path']);
                    $status = "error";
                    $msg = "Something went wrong when saving the photo, please try again.";
                }
            }

            @unlink($_FILES['upload_picture']);
        }

        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    //This function use for job alert
    public function alert()
    {
        $this->isLogin();

        //Get job alert sent mail
        $mailbox = $this->Candidate_model->get_job_alert_mailbox($this->candidate_id);

        //Get job alert setup information by candidate id
        $job_alert_Info = $this->Candidate_model->get_job_alert_info($this->candidate_id);
        $data = array(
            'mailbox'           => $mailbox,
            'status'            => set_value('status', isset($job_alert_Info->status) ? $job_alert_Info->status : 'On'),
            'job_category_ids'  => set_value('job_category_ids', isset($job_alert_Info->job_category_ids) ? $job_alert_Info->job_category_ids : null),
            'location'          => set_value('location', isset($job_alert_Info->location) ? $job_alert_Info->location : null),
            'lat'               => set_value('lat', isset($job_alert_Info->lat) ? $job_alert_Info->lat : null),
            'lng'               => set_value('lng', isset($job_alert_Info->lng) ? $job_alert_Info->lng : null),
            'distance'          => set_value('distance', isset($job_alert_Info->distance) ? $job_alert_Info->distance : null),
            'email_frequency'   => set_value('email_frequency', isset($job_alert_Info->email_frequency) ? $job_alert_Info->email_frequency : null),
            'keywords'   => set_value('keywords', isset($job_alert_Info->keywords) ? $job_alert_Info->keywords : []),
            'meta_title'        => 'My Applied Jobs'
        );

        $this->viewCandidateArea('alert', $data);
    }

    //This function use for save job alert setup information
    public function alert_action()
    {
        ajaxAuthorized();
        if (empty($this->candidate_id)) {
            echo ajaxRespond('Fail', 'The candidate you are trying to access doesn\'t exists!!');
            exit;
        }

        $post = $this->input->post();
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors();
            echo ajaxRespond('Fail', $error);
            exit;
        }

        //        if(empty($post['job_category_ids'])){
        //            echo ajaxRespond('Fail', 'At least one job category must be selected!');
        //            exit;
        //        }

        //Get job alert setup information by candidate id
        $job_alert_Info = $this->Candidate_model->get_job_alert_info($this->candidate_id);
        $saveData = array(
            'candidate_id ' => $this->candidate_id,
            'job_category_ids' => !empty($post['job_category_ids']) ? implode(',', $post['job_category_ids']) : 0,
            'location'     => isset($post['location']) ? $post['location'] : null,
            'lat'    => isset($post['lat']) ? $post['lat'] : null,
            'lng'   => isset($post['lng']) ? $post['lng'] : null,
            'distance'  => !empty($post['distance']) ? $post['distance'] : null,
            'email_frequency'  => isset($post['email_frequency']) ? $post['email_frequency'] : null,
            'keywords'  => $this->input->post('keywords'),
            'status'  => $post['status']
        );

        if ($job_alert_Info) {
            //Update data
            $saveData['updated_at'] = date("Y-m-d H:i:s");

            $this->db->where('id', $job_alert_Info->id);
            $this->db->update('job_alert_setup', $saveData);
            echo ajaxRespond('OK', 'Job alert information setup has been updated!');
        } else {
            $saveData['created_at'] = date("Y-m-d H:i:s");
            //Insert Data
            $this->db->insert('job_alert_setup', $saveData);
            echo ajaxRespond('OK', 'Job alert information setup has been created!');
        }
    }

    public function resume()
    {
        $this->isLogin();
        $data['meta_title'] = 'My Resume';
        $this->viewCandidateArea('resume', $data);
    }

    //This function use for Show the upload CV form
    public function cv()
    {
        $this->isLogin();
        $data['meta_title'] = 'My CVs';
        $this->viewCandidateArea('cv', $data);
    }

    //This function use for upload CV
    public function cv_upload()
    {
        ajaxAuthorized();
        $status = "";
        $msg = "";
        $file_element_name = 'upload_cv';

        if (empty($this->input->post('title'))) {
            $status = "error";
            $msg = "Please enter a title";
        }

        if ($status != "error") {
            $config['upload_path'] = './uploads/cv/';
            $config['allowed_types'] = 'doc|docx|pdf';
            $config['max_size'] = 1024 * 2;
            $config['encrypt_name'] = TRUE;

            // create an uploads/cv folder if not already exist in uploads dir
            if (!is_dir('uploads/cv')) {
                mkdir('./uploads/cv', 0777, true);
            }

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($file_element_name)) {
                $status = 'error';
                $msg = $this->upload->display_errors('', '');
            } else {
                $data = $this->upload->data();
                $saveField = array(
                    'candidate_id' => $this->candidate_id,
                    'title' => $this->input->post('title'),
                    'orig_name' => $data['orig_name'],
                    'file' => $data['file_name']
                );
                $file_id = $this->Candidate_model->insert_file($saveField);
                if ($file_id) {
                    $status = "success";
                    $msg = "You have successfully uploaded The CV.";
                } else {
                    unlink($data['full_path']);
                    $status = "error";
                    $msg = "Something went wrong when saving the CV, please try again.";
                }
            }
            @unlink($_FILES[$file_element_name]);
        }
        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function shortlisted_apply()
    {
        $status = "";
        $msg = "";
        if (empty($this->input->post('candidate_ids'))) {
            $status = "error";
            $msg = "Please login after apply for job";
        }
        if ($status != "error") {

            $config['upload_path'] = './uploads/cv/';
            $config['allowed_types'] = 'doc|docx|pdf';
            $config['max_size'] = 1024 * 2;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);


            if ($this->upload->do_upload("file_name_doc")) {

                $upload_data = $this->upload->data();

                $saveField = array(
                    'job_id' => $this->input->post('job_ids'),
                    'orig_name' => $this->input->post('company_nam'),
                    'title' => $this->input->post('job_title'),
                    'expected_salary' => $this->input->post('expected_salary'),

                    'candidate_id' => $this->input->post('candidate_ids'),
                    'full_name' => $this->input->post('full_name'),
                    'email' => $this->input->post('email'),
                    'contact' => $this->input->post('contact'),
                    'file_cv' => $upload_data['file_name']
                );

                $this->db->insert('candidates_apply_jobs', $saveField);

                $this->session->set_flashdata('msgs', 'Job apply Successfully.');
                redirect('/home/job-details/' . $this->input->post('job_ids'));
            } else {
                $this->viewFrontContent('frontend/404');
            }
        }
        echo json_encode(array('status' => $status, 'msg' => $msg));
    }


    // This function use get all CVs
    public function files()
    {
        $data['files'] = $this->Candidate_model->get_cvs_by_candidate($this->candidate_id);
        $this->load->view('frontend/candidate/files', $data);
    }

    //This function use for delete cv file & data
    public function delete_file($file_id)
    {
        $this->isLogin();
        if ($this->Candidate_model->delete_file($file_id)) {
            $status = 'success';
            $msg = 'The CV successfully deleted';
        } else {
            $status = 'error';
            $msg = 'Something went wrong when deleteing the CV, please try again';
        }
        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    //This function use for download cv file
    public function download($id, $application_id)
    {
        $this->load->helper('download');

        $file = $this->Candidate_model->get_cv_by_id($id);
        if ($file) {
            $this->db->set('viewed', 'Yes');
            $this->db->where('id', $application_id);
            $this->db->update('job_applications');
        }

        $filename = dirname(BASEPATH) . './uploads/cv/' . $file->file;
        if (file_exists($filename)) {
            $data = file_get_contents('./uploads/cv/' . $file->file);
            force_download($file->orig_name, $data);
        } else {
            $this->viewFrontContent('frontend/404');
        }
    }

    public function change_password()
    {
        $this->isLogin();
        $candidate = $this->Candidate_model->getCurrentJobseeker($this->candidate_id);
        $data = array(
            'id' => set_value('id', $candidate->id),
            'email' => set_value('email', $candidate->email),
            'old_password' => set_value('old_password'),
            'new_password' => set_value('new_password'),
            'confirm_password' => set_value('confirm_password'),
            'meta_title' => 'Change Password'
        );

        $this->viewCandidateArea('change_password', $data);
    }

    public function change_password_action()
    {
        $this->isLogin();
        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_password');

        $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $this->change_password();
        } else {


            $user = $this->db->select('password')->get_where('candidates', ['id' => $this->candidate_id])->row();
            $db_pass = $user->password;
            $verify = password_verify($old_password, $db_pass);

            if ($verify == true) {
                $hass_pass = password_encription($new_password);
                $this->db->update('candidates', ['password' => $hass_pass], ['id' => $this->candidate_id]);
                $this->session->set_flashdata('msgs', 'Password Change Successfully. Please login to Continue.');
            } else {
                $this->session->set_flashdata('msge', 'Old Password not match, please try again.');
            }

            redirect(site_url('myaccount/changepassword'));
        }
    }

    public function change_password_xxx()
    {
        ajaxAuthorized();
        $old_pass = $this->input->post('old_pass');
        $new_pass = $this->input->post('new_pass');
        $con_pass = $this->input->post('con_pass');

        if (!$old_pass or !$new_pass or !$con_pass) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Required all fields</p>');
            exit;
        }
        if ($new_pass != $con_pass) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Confirm Password Not Match</p>');
            exit;
        }

        $user       = $this->db->select('password')->get_where('students', ['id' => $this->student_id])->row();
        $db_pass    = $user->password;
        $verify     = password_verify($old_pass, $db_pass);

        if ($verify == true) {
            $hass_pass = password_encription($new_pass);
            $this->db->update('students', ['password' => $hass_pass], ['id' => $this->student_id]);
            echo ajaxRespond('OK', '<p class="ajax_success">Password Reset Successfully</p>');
        } else {
            echo ajaxRespond('Fail', '<p class="ajax_error">Old Password not match, please try again.</p>');
        }
    }

    public function job_apply($job_id)
    {

        $this->isLogin();

        //Get job information by ID

        $data['job'] = $this->Frontend_model->get_job_details($job_id);
        $data['userdata'] = $this->userdata;

        if ($data['job']) {
            $data = array(
                'my_email' => set_value('my_email', $this->candidate_email),
                'cover_letter' => set_value('cover_letter'),
                'candidate_cv_id' => set_value('candidate_cv_id'),
                'expected_salary' => set_value('expected_salary'),
                'job_id' => $data['job']->id,
                'candidate_id' => $this->candidate_id
            );
            $this->viewCandidateArea('job_application', $data);
        } else {
            $this->viewFrontContent('frontend/404');
        }
    }

    public function job_application_action()
    {
        $job = $this->Frontend_model->get_job_details($this->input->post('job_id'));
        if (empty($job)) {
            $this->viewFrontContent('frontend/404');
        }

        $this->form_validation->set_rules('job_id', 'Job Not Found', 'trim|required');
        $this->form_validation->set_rules('candidate_cv_id', 'My CV Format', 'trim|required');
        $this->form_validation->set_rules('expected_salary', 'expected salary', 'trim|required|numeric');
        $this->form_validation->set_rules('cover_letter', 'Cover Letter', 'trim|required');

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $this->job_apply($this->input->post('job_id'));
        } else {

            //If Candidate Job Apply Duplicate Check By CV Formate Wise
            $this->db->select('*');
            $this->db->from('job_applications');
            $this->db->where(array('job_id' => $job->id, 'candidate_id' => $this->candidate_id));
            $candidateJobApplyCount = $this->db->count_all_results();

            if ($candidateJobApplyCount >= 1) {
                $this->session->set_flashdata('msge', 'You already applied for this job.');
                redirect(site_url("myaccount/job-apply/{$job->id}/" . slugify($job->title) . '.html'));
            }

            $saveData = array(
                'job_id'            => (int) $this->input->post('job_id'),
                'candidate_id'      => $this->candidate_id,
                'candidate_cv_id'   => $this->input->post('candidate_cv_id'),
                'expected_salary'   => (int)$this->input->post('expected_salary'),
                'cover_letter'      => $this->input->post('cover_letter'),
            );

            if ($this->db->insert('job_applications', $saveData)) {
                sendMail('onJobApplyNotifyToRecruter', [
                    'receiver_id'    => $job->company_id,
                    'receiver_email' => $job->company_email,
                    'job_title'      => $job->title
                ]);
                $this->session->set_flashdata('msgs', 'Job apply has been successful!');
            } else {
                $this->session->set_flashdata('msge', "Job couldn't be applied. Please apply to again.");
            }

            redirect(site_url("myaccount/job-apply/{$job->id}/" . slugify($job->title) . '.html'));
        }
    }

    public function applied_job()
    {
        $this->isLogin();
        $data['applied_jobs'] = $this->Candidate_model->get_applied_job($this->candidate_id);
        $data['meta_title'] = 'My Applied Jobs';
        $this->viewCandidateArea('my_applied_job', $data);
    }

    public function shortlisted_jobs()
    {
        $this->isLogin();
        $data['shortlisted_jobs'] = $this->Candidate_model->get_shortlisted_jobs($this->candidate_id);
        $data['meta_title'] = 'My Saved Jobs';
        $this->viewCandidateArea('my_shortlisted_job', $data);
    }

    public function shortlist_job_insert()
    {
        ajaxAuthorized();
        $job_id = $this->input->post("job_id");
        $candidate_id = $this->input->post("candidate_id");
        if (empty($candidate_id)) {
            redirect(site_url('login'));
        }

        $is_exist = $this->Frontend_model->get_job_details($this->input->post("job_id"));
        if (empty($is_exist)) {
            echo ajaxRespond('Fail', 'The job you are trying to access doesn\'t exists!!');
            exit;
        }

        if ($this->candidate_id != $candidate_id) {
            echo ajaxRespond('Fail', 'The jobseeker you are trying to access doesn\'t exists!!');
            exit;
        }

        $shortListCount = $this->Candidate_model->shortlist_job_duplicate_check($job_id, $candidate_id);
        if ($shortListCount > 0) {
            echo ajaxRespond('Fail', 'The job has been already shortlisted!');
            exit;
        }

        $saveField = array(
            "job_id" => $job_id,
            "candidate_id" => $candidate_id
        );

        $result = $this->Candidate_model->shortlist_job_insert($saveField);
        if ($result) {
            echo ajaxRespond('OK', $result);
        } else {
            echo ajaxRespond('Fail', 'Job shortlist Could\'t be insert!');
        }
    }

    public function shortlisted_job_delete($job_favourite_id)
    {

        ajaxAuthorized();

        //If already exist shortlist job
        $this->db->select('*');
        $this->db->from('job_favourites');
        $this->db->where(array('id' => $job_favourite_id));
        $jobFavouriteCount = $this->db->count_all_results();

        if (empty($jobFavouriteCount)) {
            echo ajaxRespond('Fail', 'Sorry! Unable to shortlist job!');
            exit;
        }

        $result = $this->Candidate_model->delete_shortlisted_job($job_favourite_id);
        if ($result) {
            echo ajaxRespond('OK', 'You have removed this job from shortlist.!');
            exit;
        } else {
            echo ajaxRespond('Fail', 'Could\'t be deleted from shortlist!');
            exit;
        }
    }
}
