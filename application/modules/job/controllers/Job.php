<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 2020-02-04
 */

class Job extends Admin_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Job_model');
        $this->load->model('Transaction');
        $this->load->helper('job');
        $this->load->helper('job/category');
        $this->load->helper('job/type');
        $this->load->helper('job/sector');
        $this->load->helper('job/benefit');
        $this->load->helper('job/skill');
        $this->load->helper('candidate/candidate');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $category = intval($this->input->get('category', TRUE));
        $status = $this->input->get('status', TRUE);
        $deadline = $this->input->get('deadline', TRUE);
        $user = intval($this->input->get('user', TRUE));
        $start = intval($this->input->get('start'));

        $config['base_url'] = build_pagination_url(Backend_URL . 'job/', 'start');
        $config['first_url'] = build_pagination_url(Backend_URL . 'job/', 'start');

        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Job_model->total_rows($q, $category, $status, $deadline, $user, $this->user_id, $this->role_id);
        $jobs = $this->Job_model->get_limit_data($config['per_page'], $start, $q, $category, $status, $deadline, $user, $this->user_id, $this->role_id);

//        echo $this->db->last_query();

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'jobs' => $jobs,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'category' =>  $category,
            'status' =>  $status,
            'deadline' =>  $deadline,
            'user' =>  $user,
        );
        $this->viewAdminContent('job/job/index', $data);
    }

    public function preview($id)
    {
        $row = $this->Job_model->get_jobs_by_id($id, $this->user_id, $this->role_id);
        
        if ($row) {
            $data = array(
                'id' => $row->id,
                'job_category_id' => getJobCategoryName($row->job_category_id),
                'package_id' => $row->package_id,
                'sub_cat_id' => getJobSubCategoryName($row->sub_category_id),
                'title' => $row->title,
                'location' => $row->location,
                'lat' => $row->lat,
                'lng' => $row->lng,
                'country_id' => $row->country_id,
                'job_type_id' => getJobTypeName($row->job_type_id),
                'description' => $row->description,
                'job_benefit_ids' => getJobBenefitName($row->job_benefit_ids),
                'job_skill_ids' => getJobSkillsName($row->job_skill_ids),
                'deadline' => globalDateFormat($row->deadline),
                'vacancy' => sprintf('%02d', $row->vacancy),
                'salary_type' => $row->salary_type,
                'salary_min' => $row->salary_min,
                'salary_max' => $row->salary_max,
                'salary_period' => $row->salary_period,
                'salary_currency' => $row->salary_currency,
                'status' => $row->status,
                'hit_count' => $row->hit_count,
                'recruiters_note' => $row->recruiters_note,
                'admin_note' => $row->admin_note,
                'created_at' => globalDateTimeFormat($row->created_at),
                'updated_at' => globalDateTimeFormat($row->updated_at),
                'login_role_id' => $this->role_id,
            );
            $this->viewAdminContent('job/job/preview', $data);
        } else {
            $this->session->set_flashdata('msge', 'Job Not Found');
            redirect(site_url(Backend_URL . 'job'));
        }
    }
    
    public function applicants($id)
    {
        $status = $this->input->get('status', TRUE);
        $date = $this->input->get('date', TRUE);
        
        $this->db->select('a.*,c.id as can_id,c.full_name,c.picture, c.mobile_number, c.email, cv.id as cv_id');
        $this->db->from('job_applications as a');        
        $this->db->join('candidate_cv as cv', 'cv.id=a.candidate_cv_id', 'LEFT');
        $this->db->join('candidates as c', 'c.id=a.candidate_id', 'LEFT');
        $this->db->order_by('a.id', 'DESC');        
        $this->db->where('a.job_id', $id);
        
        if($status){ $this->db->where('a.status', $status ); }
        if($date){ $this->db->where('a.applied_at >=', $date ); }
        
        $applicants = $this->db->get()->result();    
        
        
        $data = [
            'applicants' => $applicants,                
            'start' => 0,                
            'id' => $id,
            'status' => $status,
            'date' => $date,
        ];                
        
        $this->viewAdminContent('job/job/applicants', $data);
        
    }
    
    public function application_status() {
        ajaxAuthorized();
        
        $application_id = $this->input->post("application_id");
        $status = $this->input->post("status");
        $candidate_id = $this->input->post("candidate_id");
       
        $application_Info = $this->Job_model->get_application_by_id($application_id);
        if (empty($application_Info)) {
            echo ajaxRespond('Fail', 'The job you are trying to access doesn\'t exists!!');
            exit;
        }
        
        $this->db->where('id',$application_id);
        $result = $this->db->update('job_applications',array('status'=>$status, 'viewed'=>'Yes'));
        
        if ($result) {
            echo ajaxRespond('OK', $result);
        } else {
            echo ajaxRespond('Fail', 'Application Status Could\'t be Updated!');
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url(Backend_URL . 'job/create_action'),
            'id' => set_value('id'),
            'user_id' => set_value('user_id', $this->user_id ),
            'package_id' => set_value('package_id'),
            'job_category_id' => set_value('job_category_id'),
            'sub_cat_id' => set_value('sub_cat_id'),
            'title' => set_value('title'),            
            'location' => set_value('location'),
            'lat' => set_value('lat'),
            'lng' => set_value('lng'),
            'country_id' => set_value('country_id'),
            'job_type_id' => set_value('job_type_id'),
            'description' => set_value('description'),
            'job_benefit_ids' => set_value('job_benefit_ids'),
            'job_skill_ids' => set_value('job_skill_ids'),
            'deadline' => set_value('deadline'),
            'vacancy' => set_value('vacancy'),
            'salary_type' => set_value('salary_type', 'Negotiable'),
            'salary_min' => set_value('salary_min'),
            'salary_max' => set_value('salary_max'),
            'salary_period' => set_value('salary_period', 'Monthly'),
            'salary_currency' => set_value('salary_currency', '&pound;'),
            'status' => set_value('status', 'Draft'),            
            'is_feature' => set_value('is_feature', '0'),            
            'recruiters_note' => set_value('recruiters_note'),
            'admin_note' => set_value('admin_note'),
            'login_role_id' => $this->role_id
        );
        
        if(in_array($this->role_id, [1,2,3])){
            $data['status_option'] = array('Draft' => 'Draft', 'Pending' => 'Pending', 'Published' => 'Publish', 'Suspend' => 'Suspend', 'Archive' => 'Archive');
        } else {
            $data['status_option'] = array('Draft' => 'Draft', 'Pending' => 'Submit for Approval', 'Published' => 'Publish');
        }
        
        $this->viewAdminContent('job/job/create', $data);
    }

    public function create_action()
    {
        $this->_rules();

        $status = $this->input->post('status', TRUE);
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } elseif ($this->role_id == 4 && !in_array($status, ['Draft', 'Pending'])){
            $this->session->set_flashdata('msge', 'Please change job status.');
            $this->create();
        } else {
            $job_benefit_ids = $this->input->post('job_benefit_ids', TRUE);
            if(is_null($job_benefit_ids)){ $job_benefit_ids = [0]; }
            $job_skill_ids = $this->input->post('job_skill_ids', TRUE);  
            if(is_null($job_skill_ids)){ $job_skill_ids = [0]; }
            $data = array(
                'package_id' => (int)$this->input->post('package_id', TRUE),
                'job_category_id' => (int)$this->input->post('job_category_id', TRUE),
                'sub_category_id' => $this->fixSubCategory(),
                'title' => $this->input->post('title', TRUE),                
                'location' => $this->input->post('location', TRUE),
                'lat' => $this->input->post('lat', TRUE),
                'lng' => $this->input->post('lng', TRUE),
                'country_id' => (int)$this->input->post('country_id', TRUE),
                'job_type_id' => (int)$this->input->post('job_type_id', TRUE),
                'description' => $_POST['description'],
                'job_benefit_ids' => implode (',', $job_benefit_ids),
                'job_skill_ids' => implode (',', $job_skill_ids),
                'deadline' => $this->input->post('deadline', TRUE),
                'vacancy' => (int) $this->input->post('vacancy'),
                'salary_type' => $this->input->post('salary_type', TRUE),
                'salary_period' => $this->input->post('salary_period', TRUE),
                'status' => $this->input->post('status', TRUE),
                'is_feature' => (int) $this->input->post('is_feature'),
                'recruiters_note' => $this->input->post('recruiters_note', TRUE),
                'admin_note' => $this->input->post('admin_note', TRUE),
                'created_at' => date('Y-m-d H:i:s')
            );

            if($this->role_id == 4){
                $data['user_id'] = $this->user_id; // Company, Organisation ID
            } else {
                $data['user_id'] = (int)$this->input->post('user_id', TRUE); // Company, Organisation ID
            }

            $salary_type = $this->input->post('salary_type', TRUE);
            if($salary_type == 'Range'){
                $data['salary_min'] = (int)$this->input->post('salary_min');
                $data['salary_max'] = (int) $this->input->post('salary_max');
                $data['salary_currency'] = $this->input->post('salary_currency', TRUE);
                $data['salary_period'] = $this->input->post('salary_period', TRUE);
            } elseif ($salary_type == 'Fixed'){
                $data['salary_min'] = $this->input->post('salary_fixed', TRUE);
                $data['salary_max'] = null;
                $data['salary_currency'] = $this->input->post('salary_currency_fixed', TRUE);
                $data['salary_period'] = $this->input->post('salary_period', TRUE);
            } else{
                $data['salary_min'] = null;
                $data['salary_max'] = null;
                $data['salary_currency'] = null;
                $data['salary_period'] = null;
            }

            $job_id = $this->Job_model->insert($data);

            if($this->role_id == 4 && $status == 'Pending'){
                sendMail('onPostNewJobMailToAdmin', [
                    'sender_id' => $this->user_id,
                    'job_title' => $data['title'],
                    'job_update_url' => site_url(Backend_URL.'job/update/'.$job_id),
                    'user_name' => getUserNameByID($this->user_id),
                ]);
            }

            if($job_id){
                sendMail('onJobNotificationForAdmin', [
                    'job_title' => $this->input->post('title', TRUE),
                    'update_url' => site_url(Backend_URL.'job/update/'.$job_id),
                ]);
            }
            
            $this->session->set_flashdata('msgs', 'Job Added Successfully');
            redirect(site_url(Backend_URL . "job/payment_form/{$job_id}"));
        }
    }

    private function fixSubCategory(){
        $sub_cat_id  = $this->input->post('sub_cat_id');
        
        //Get Existing sub category check
        $exist_id = $this->Job_model->getSubCatById($this->input->post('sub_cat_id'));

        if(!$exist_id){
             //Insert Subcategory
            if(!empty($sub_cat_id)){
                $sub_cat_data = array(
                    'category_id' => $this->input->post('job_category_id', TRUE),
                    'name' => $this->input->post('sub_cat_id', TRUE),
                );
                $sub_cat_id = $this->Job_model->insert_sub_category($sub_cat_data);
            }
        }
        return $sub_cat_id;
    }

    public function update($id)
    {
        $row = $this->Job_model->get_jobs_by_id($id, $this->user_id, $this->role_id);
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url(Backend_URL . 'job/update_action'),
                'id' => set_value('id', $row->id),
                'user_id' => set_value('user_id', $row->user_id),
                'package_id' => set_value('package_id', $row->package_id),
                'job_category_id' => set_value('job_category_id', $row->job_category_id),
                'sub_cat_id' => set_value('sub_cat_id', $row->sub_category_id),
                'title' => set_value('title', $row->title),
                'location' => set_value('location', $row->location),
                'lat' => set_value('lat', $row->lat),
                'lng' => set_value('lng', $row->lng),
                'country_id' => set_value('country_id', $row->country_id),
                'job_type_id' => set_value('job_type_id', $row->job_type_id),
                'description' => set_value('description', $row->description),
                'job_benefit_ids' => set_value('job_benefit_ids', $row->job_benefit_ids),
                'job_skill_ids' => set_value('job_skill_ids', $row->job_skill_ids),
                'deadline' => set_value('deadline', $row->deadline),
                'vacancy' => set_value('vacancy', $row->vacancy),
                'salary_type' => set_value('salary_type', $row->salary_type),
                'salary_min' => set_value('salary_min', $row->salary_min),
                'salary_max' => set_value('salary_max', $row->salary_max),
                'salary_currency' => $row->salary_currency,
                'salary_period' => set_value('salary_period', $row->salary_period),
                'status' => set_value('status', $row->status),
                'is_feature' => set_value('is_feature', $row->is_feature),                    
                'hit_count' => set_value('hit_count', $row->hit_count),
                'recruiters_note' => set_value('recruiters_note', $row->recruiters_note),
                'admin_note' => set_value('admin_note', $row->admin_note),
                'login_role_id' => $this->role_id
            );
            if(in_array($this->role_id, [1,2,3])){
                $data['status_option'] = array('Draft' => 'Draft', 'Pending' => 'Pending', 'Published' => 'Publish', 'Suspend' => 'Suspend', 'Archive' => 'Archive');
            } else {
                $data['status_option'] = array('Draft' => 'Draft', 'Pending' => 'Submit for Approval', 'Published' => 'Publish');
            }

            $this->viewAdminContent('job/job/update', $data);
        } else {
            $this->session->set_flashdata('msge', 'Job Not Found');
            redirect(site_url(Backend_URL . 'job'));
        }
    }

    public function update_action()
    {        
        $this->_rules();
        $id = (int)$this->input->post('id', TRUE);
        $status = $this->input->post('status', TRUE);

        if ($this->form_validation->run() == FALSE) {
            $this->update($id);
        } elseif ($this->role_id == 4 && !in_array($status, ['Draft', 'Pending'])){
            $this->session->set_flashdata('msge', 'Please change job status.');
            $this->update($id);
        } else {
            $job_benefit_ids = $this->input->post('job_benefit_ids', TRUE);
            if(is_null($job_benefit_ids)){ $job_benefit_ids = [0]; }
            $job_skill_ids = $this->input->post('job_skill_ids', TRUE);  
            if(is_null($job_skill_ids)){ $job_skill_ids = [0]; }
            
            $data = array(
                'package_id' => (int)$this->input->post('package_id', TRUE),
                'job_category_id' => (int)$this->input->post('job_category_id', TRUE),
                'sub_category_id' => $this->fixSubCategory(),
                'title' => $this->input->post('title', TRUE),
                'location' => $this->input->post('location', TRUE),
                'lat' => $this->input->post('lat', TRUE),
                'lng' => $this->input->post('lng', TRUE),
                'country_id' => (int)$this->input->post('country_id', TRUE),
                'job_type_id' => (int)$this->input->post('job_type_id', TRUE),
                'description' => $_POST['description'],
                'job_benefit_ids' => implode (',', $job_benefit_ids),
                'job_skill_ids' => implode (',', $job_skill_ids),
                'deadline' => $this->input->post('deadline', TRUE),
                'vacancy' => (int) $this->input->post('vacancy'),
                'salary_type' => $this->input->post('salary_type', TRUE),
                'status' => $this->input->post('status', TRUE),
                'is_feature' => (int) $this->input->post('is_feature'),
                'recruiters_note' => $this->input->post('recruiters_note', TRUE),
                'admin_note' => $this->input->post('admin_note', TRUE),
                'updated_at' => date('Y-m-d H:i:s')
            );

            if($this->role_id == 4){
                $data['user_id'] = $this->user_id; // Company, Organisation ID
            } else {
                $data['user_id'] = (int)$this->input->post('user_id', TRUE); // Company, Organisation ID
            }

            $salary_type = $this->input->post('salary_type', TRUE);
            if($salary_type == 'Range'){
                $data['salary_min'] = (int)$this->input->post('salary_min');
                $data['salary_max'] = (int) $this->input->post('salary_max');
                $data['salary_currency'] = $this->input->post('salary_currency', TRUE);
                $data['salary_period'] = $this->input->post('salary_period', TRUE);
            } elseif ($salary_type == 'Fixed'){
                $data['salary_min'] = $this->input->post('salary_fixed', TRUE);
                $data['salary_max'] = null;
                $data['salary_currency'] = $this->input->post('salary_currency_fixed', TRUE);
                $data['salary_period'] = $this->input->post('salary_period', TRUE);
            } else{
                $data['salary_min'] = null;
                $data['salary_max'] = null;
                $data['salary_currency'] = null;
                $data['salary_period'] = null;
            }

            $this->Job_model->update($id, $data);

            if($this->role_id == 4 && $status == 'Pending'){
                sendMail('onPostNewJobMailToAdmin', [
                    'sender_id' => $this->user_id,
                    'job_title' => $data['title'],
                    'job_update_url' => site_url(Backend_URL.'job/update/'.$id),
                    'user_name' => getUserNameByID($this->user_id),
                ]);
            }

            $this->session->set_flashdata('msgs', 'Job Updated Successfully');
            redirect(site_url(Backend_URL . 'job/update/' . $id));
        }
    }

    public function archive($id)
    {
        $row = $this->Job_model->get_jobs_by_id($id, $this->user_id, $this->role_id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'package_id' => $row->package_id,
                'job_category_id' => $row->job_category_id,
                'title' => $row->title,
                'location' => $row->location,
                'job_type_id' => $row->job_type_id,                
                'job_benefit_ids' => $row->job_benefit_ids,
                'job_skill_ids' => $row->job_skill_ids,
                'deadline' => $row->deadline,
                'vacancy' => $row->vacancy,
                'salary' => Ngo::getSalary(
                        $row->salary_type, 
                        $row->salary_min, 
                        $row->salary_max, 
                        $row->salary_period, 
                        $row->salary_currency
                        ),
                'status' => $row->status,
                'hit_count' => $row->hit_count,
                'recruiters_note' => $row->recruiters_note,
                'admin_note' => $row->admin_note,
                'created_at' => globalDateTimeFormat($row->created_at),
                'updated_at' => globalDateTimeFormat($row->updated_at),
            );
            $this->viewAdminContent('job/job/archive', $data);
        } else {
            $this->session->set_flashdata('msge', 'Job Not Found');
            redirect(site_url(Backend_URL . 'job'));
        }
    }


    public function archive_action($id)
    {
        $row = $this->Job_model->get_jobs_by_id($id, $this->user_id, $this->role_id);

        if ($row) {
            $this->db->set('status','Archive');
            $this->db->where('id', $id );
            $this->db->update('jobs');
            $this->session->set_flashdata('msgs', 'Job Deleted Successfully');
            redirect(site_url(Backend_URL . 'job'));
        } else {
            $this->session->set_flashdata('msge', 'Job Not Found');
            redirect(site_url(Backend_URL . 'job'));
        }
    }


    public function _menu()
    {
        // return add_main_menu('Job', 'job', 'job', 'fa-hand-o-right');
         return buildMenuForMoudle([
            'module' => 'Jobs',
            'icon' => 'fa-files-o',
            'href' => 'job',
            'children' => [
                [
                    'title' => 'All Jobs',
                    'icon' => 'fa fa-circle-o',
                    'href' => 'job'
                ],
                [
                    'title' => ' |_ Add New',
                    'icon' => 'fa fa-plus',
                    'href' => 'job/create'
                ], [
                    'title' => 'Applications',
                    'icon' => 'fa fa-plus',
                    'href' => 'job/application'
                ], [
                    'title' => 'Job Category',
                    'icon' => 'fa fa-circle-o',
                    'href' => 'job/category'
                ], [
                    'title' => 'Sub Category',
                    'icon' => 'fa fa-circle-o',
                    'href' => 'job/sub_category'
                ], [
                    'title' => 'Job Type',
                    'icon' => 'fa fa-circle-o',
                    'href' => 'job/type'
                ], [
                    'title' => 'Job Sector',
                    'icon' => 'fa fa-circle-o',
                    'href' => 'job/sector',
                ], [
                    'title' => 'Job Skill',
                    'icon' => 'fa fa-circle-o',
                    'href' => 'job/skill'
                ], [
                    'title' => 'Manage Benefit',
                    'icon' => 'fa fa-circle-o',
                    'href' => 'job/benefit'
                ], [
                    'title' => 'Organization Type',
                    'icon' => 'fa fa-circle-o',
                    'href' => 'job/organization_type'
                ]
            ]


        ]);
    }

    public function _rules()
    {
        if($this->role_id != 4){
            $this->form_validation->set_rules('user_id', 'company', 'trim|required|numeric|is_natural_no_zero', [
                'is_natural_no_zero' => 'please select company'
            ]);
        }
        $this->form_validation->set_rules('package_id', 'package', 'trim|required|numeric|is_natural_no_zero', [
            'is_natural_no_zero' => 'please select package'
        ]);
        $this->form_validation->set_rules('job_category_id', 'job category', 'trim|required|numeric|is_natural_no_zero', [
            'is_natural_no_zero' => 'please select job category'
        ]);

        $this->form_validation->set_rules('title', 'title', 'trim|required');
        $this->form_validation->set_rules('location', 'location', 'trim|required');
        $this->form_validation->set_rules('country_id', 'country', 'trim|required|numeric|is_natural_no_zero');
        $this->form_validation->set_rules('job_type_id', 'job type', 'trim|required|numeric');
        $this->form_validation->set_rules('description', 'description', 'trim|required');
        $this->form_validation->set_rules('job_benefit_ids[]', 'job benefits', 'trim');
        $this->form_validation->set_rules('job_skill_ids[]', 'job skills', 'trim');
        $this->form_validation->set_rules('deadline', 'deadline', 'trim|required');
        $this->form_validation->set_rules('vacancy', 'vacancy', 'trim|required');
        $this->form_validation->set_rules('salary_type', 'salary type', 'trim|required');
        $this->form_validation->set_rules('salary_min', 'salary min', 'trim|numeric');
        $this->form_validation->set_rules('salary_max', 'salary max', 'trim|numeric');
        $this->form_validation->set_rules('salary_period', 'salary period', 'trim');
        $this->form_validation->set_rules('status', 'status', 'trim|required');
        $this->form_validation->set_rules('recruiters_note', 'recruiters note', 'trim');
        $this->form_validation->set_rules('admin_note', 'admin note', 'trim');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
    
    public function get_sub_category($category_id) {
        
        echo getJobSubCategoryDropDown($category_id);
    }
    
    public function payment_form($job_id) {
        $data['id'] = $job_id;
        $data['email'] = getLoginUserData('user_mail');

        $this->db->select('p.id as package_id, p.name, p.price, p.duration');
        $this->db->where('j.id', $job_id);
        $this->db->from('jobs as j');
        $this->db->join('packages as p', 'p.id = j.package_id', 'LEFT');
        $data['payment_data'] = $this->db->get()->row();
        
        $this->db->where('ref_id', $job_id );
        $row = $this->db->get('transactions')->row();
        if($row){
            
            $data = array(
		'id'            => $row->id,
		'table'         => $row->table,
		'ref_id'        => $row->ref_id,
		'paid_amount'   => $row->paid_amount,		
		'payment_status' => $row->payment_status,
		'email'         => $row->email,
		'created_at'    => $row->created_at,
	    );
            
            $this->viewAdminContent('job/job/payment_info', $data);
        } else {            
            
            $this->viewAdminContent('job/job/payment_form', $data);
        }       
    }
    
    private function explore( $array ){        
        $output = '<table class="table table-striped no-margin table-bordered">';
        foreach($array as $key=>$log ){
            $row = is_array($log) ? $this->explore($log) : $log;
            $output .= '<tr>';
                $output .= '<td width="100">'. $key .'</td>';
                $output .= '<td width="5">:</td>';
                $output .= '<td>'. $row .'</td>';
            $output .= ' </tr>';
        }
        $output .= '</table>';
        return $output;
    }
    
    public function make_payment()
    {
        
        //include Stripe PHP library
        require_once APPPATH.'third_party/stripe/init.php';
        \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
        
        //Get job id
        $id = (int)$this->input->post('job_id');

        $this->db->select('p.id as package_id, p.name, p.price, p.duration');
        $this->db->where('j.id', $id);
        $this->db->from('jobs as j');
        $this->db->join('packages as p', 'p.id = j.package_id');
        $payment_data = $this->db->get()->row();
        
//        dd( $payment_data );

        $message = null;
        $success = false;
        $charge = null;
        $chargeJson = null;
        $data = [];
        
        //Get job information by Job Id
        $row = $this->Job_model->get_jobs_by_id($id, $this->user_id, $this->role_id);
        if(empty($row)){
            $message = "The job you are trying to access doesn\'t exists!";
            echo json_encode(['success' => $success, 'message' => $message, 'data' => $data]);
            exit;
        }

        try {

            //Creates timestamp that is needed to make up orderid
            $timestamp = strftime('Y');
            //You can use any alphanumeric combination for the orderid. Although each transaction must have a unique orderid.
            $orderid = $timestamp.'-'.$id;
            $amount = $payment_data->price;
            
            //add customer to stripe
//            $customer = \Stripe\Customer::create(array(
//                        'email' => $this->input->post('email'),
//                        'source' => $this->input->post('stripeToken')
//            ));
//            pp($customer['Message']);
            
            //charge a credit or a debit card
            $charge = \Stripe\Charge::create([
                'amount'      => $amount*100,
                'currency'    => $this->config->item('stripe_currency'),
                'source'      => $this->input->post('stripeToken'),
                'description' => $row->title,
                'metadata'    => [
                    'job_id' => $orderid,
                ],
            ]);
           
        } catch (\Stripe\Error\Card $e) {
            // Since it's a decline, \Stripe\Error\Card will be caught
            $body = $e->getJsonBody();
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            $body = $e->getJsonBody();
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            $body = $e->getJsonBody();
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            $body = $e->getJsonBody();
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            $body = $e->getJsonBody();
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            $body = $e->getJsonBody();
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $body = $e->getJsonBody();
        }
        //Get response message
        $message = isset($body['error']['message']) ? $body['error']['message'] : null;
        
        if ($charge) {
            //retrieve charge details
            $chargeJson = $charge->jsonSerialize();
            
            //check whether the charge is successful
            if ($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1) {

                $data = [
                    'balance_transaction' => $chargeJson['balance_transaction'],
                    'receipt_url'         => $chargeJson['receipt_url'],
                    'order_id'            => $orderid,
                ];
                
                // insert response into db
                $saveData = array(
                    'ref_id' => $id,
                    'package_id' => $payment_data->package_id,
                    'paid_amount' => $amount,
                    'response' => json_encode($chargeJson),
                    'payment_status' => $chargeJson['status'],
                    'email' => $this->input->post('email'),
                    'created_at' => date("Y-m-d H:i:s"),
                    'table' => 'jobs',
                );

                $this->Transaction->insert_transaction($saveData);

                $success = true;
                $message = 'Payment made successfully.';

                $this->db->select('j.id as job_id, j.title, j.user_id, u.first_name, u.last_name, u.email');
                $this->db->where('j.id', $id);
                $this->db->from('jobs as j');
                $this->db->join('users as u', 'u.id = j.user_id');
                $job_details = $this->db->get()->row();
                if ($job_details) {
                    sendMail('onPaymentJob', [
                        'full_name' => $job_details->first_name.' '.$job_details->last_name,
                        'job_title' => $job_details->title,
                        'job_url' => site_url(Backend_URL.'job/update/'. $job_details->job_id ),
                        'receiver_id' => $job_details->user_id,
                        'receiver_email' => $job_details->email,
                        'cc' => getSettingItem('IncomingEmail'),
                    ]);
                }

            } else {

                // insert response into db
                $success = false;
                $message = 'Something went wrong.';
            }
        }

        echo json_encode([
            'success' => $success, 
            'message' => $message, 
            'data' => $data
        ]);        
    }
}