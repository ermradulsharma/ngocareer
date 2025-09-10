<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Frontend extends Frontend_controller
{

    // every thing coming form Frontend Controller
    public $limit = 20;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('slider/slider');
        $this->load->helper('job/category');
        $this->load->model('Frontend_model');
        $this->load->library('form_validation');
        $this->load->helper('email');
    }

    public function blog($cat = null)
    {
        //$cat    = $this->uri->segment(2);
        $this->limit = 10;
        $archive = $this->input->get('archive');
        $page = intval($this->input->get('page'));
        $target = build_pagination_url('ngo-career-advice', 'page', true);
        $start = startPointOfPagination($this->limit, $page);

        $total = $this->Frontend_model->total_blog($cat, $archive);
        $posts_data = $this->Frontend_model->get_blog($this->limit, $start, $cat, $archive);
        $data = [
            'categories' => blogCatList(),
            'posts_data' => $posts_data,
            'pagination' => getPaginator($total, $page, $target, $this->limit),
            'sql' => '', //$this->db->last_query(),
            'cat' => $cat,
            'recent_posts' => $this->recentPost(),
            'recent_jobs' => $this->recentJobs(),
            'recent_comments' => $this->recentComments(),
            'allCategory' => $this->allCategory(),
            'meta_title' => 'Search Thousands of NGO Jobs Worldwide.',
            'meta_description' => 'Take the next  step in your career progression by searching and applying to thousands  of NGO Jobs at  NGOcareer.com.',
            'meta_keywords' => 'NGO career,  NGO vacancies, NGO Jobs, Charity Jobs, Not for profit jobs, Voluntary sector Jobs.',
        ];
        $this->viewFrontContent('frontend/category/blog-with-recent-post', $data);
    }

    private function recentPost()
    {
        $this->db->where('status', 'Publish');
        $this->db->where('post_type', 'post');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(10);
        return $this->db->get('cms')->result();
    }

    private function recentJobs()
    {
        $this->db->select('id, title');
        $this->db->where('status', 'Published');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(10);
        return $this->db->get('jobs')->result();
    }

    private function recentComments()
    {
        $this->db->select('id, comment');
        $this->db->where('status', 'Approve');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(10);
        return $this->db->get('cms_comments')->result();
    }

    private function allCategory()
    {
        $this->db->where('type', 'category');
        return $this->db->get('cms_options')->result();
    }

    public function blog_post()
    {
        $url = $this->uri->segment(3);;
        $blog = $this->Frontend_model->get_blog_post($url);
        $data = [
            'categories' => blogCatList(),
            'id' => $blog->id,
            'post_title' => $blog->post_title,
            'thumb' => $blog->thumb,
            'content' => $blog->content,
            'meta_title' => $blog->seo_title,
            'meta_description' => $blog->seo_description,
            'meta_keywords' => $blog->seo_keyword,
        ];
        $this->viewFrontContent('frontend/blog-single', $data);
    }

    public function browse_job()
    {
        $data = [
            'meta_title' => 'Search Thousands of NGO Jobs Worldwide.',
            'meta_description' => 'Take the next  step in your career progression by searching and applying to thousands  of NGO Jobs at  NGOcareer.com.',
            'meta_keywords' => 'NGO career,  NGO vacancies, NGO Jobs, Charity Jobs, Not for profit jobs, Voluntary sector Jobs.',
        ];

        $this->viewFrontContent('frontend/browse_job', $data);
    }

    public function jobSearch($cat_slug)
    {
        $cat_id = 0;
        if ($cat_slug) {
            $cat_data = $this->db->select('id')->get_where('job_categories', ['slug' => $cat_slug])->row();
            if ($cat_data) {
                $cat_id = $cat_data->id;
            }
        } else {
            $cat_id = ($this->input->get('cat')) ? intval($this->input->get('cat')) : 0;
        }

        $keyword = ($this->input->get('keyword'));
        $org = ($this->input->get('org')) ? (int)$this->input->get('org') : 0;
        $salary_range = ($this->input->get('salary_range')) ? $this->input->get('salary_range') : null;
        $type_id = ($this->input->get('type_id')) ? (int)$this->input->get('type_id') : 0;
        $country_id = ($this->input->get('country_id')) ? (int)$this->input->get('country_id') : 0;
        $posted = $this->input->get('posted');
        $deadline = $this->input->get('deadline');
        $sort_by = $this->input->get('sort_by');
        $location = ($this->input->get('location'));
        $lat = ($this->input->get('lat'));
        $lng = ($this->input->get('lng'));

        $page = intval($this->input->get('page'));
        $target = build_pagination_url('ngo-job-search', 'page', true);
        $start = startPointOfPagination($this->limit, $page);

        $CountryName = urldecode($cat_slug);
        preg_replace('/[^A-Za-z0-9\-]/', ' ', $CountryName);
        $CountryName = str_replace('_', ' ', $CountryName);



        $total = $this->Frontend_model->total_job($cat_id, $org, $type_id, $country_id, $keyword, $lat, $lng, $salary_range, $posted, $deadline, $sort_by, $location);

        $jobs = $this->Frontend_model->get_job($this->limit, $start, $cat_id, $org, $type_id, $country_id, $keyword, $lat, $lng, $salary_range, $posted, $deadline, $sort_by, $location);

        $data = array(
            'jobs' => $jobs,
            'Country' => $CountryName,
            'pagination' => getPaginator($total, $page, $target, $this->limit),
            'total_job' => $total,
            'keyword' => $keyword,
            'cat' => $cat_id,
            'salary_range' => $salary_range,
            'type_id' => $type_id,
            'country_id' => $country_id,
            'posted' => $posted,
            'deadline' => $deadline,
            'sort_by' => $sort_by,
            'location' => $location,
            'lat' => $lat,
            'lng' => $lng,
            'org' => $org,
            'meta_title' => 'Search Thousands of NGO Jobs Worldwide.',
            'meta_description' => 'Take the next  step in your career progression by searching and applying to thousands  of NGO Jobs at  NGOcareer.com.',
            'meta_keywords' => 'NGO career,  NGO vacancies, NGO Jobs, Charity Jobs, Not for profit jobs, Voluntary sector Jobs.',
            'sql' => $this->db->last_query(),
            'candidate_id' => $this->candidate_id,
        );

        $this->viewFrontContent('frontend/template/job-search', $data);
    }

    public function jobDetails($id)
    {
        $job = $this->Frontend_model->get_job_details($id);
        if ($job) {
            $this->hitCount($id);
            //Get related jobs list
            $page = intval($this->input->get('page'));
            $target = build_pagination_url("job-details/{$id}/" . slugify($job->title) . '.html', 'page', true);
            $start = startPointOfPagination($this->limit, $page);

            $cat_id = $job->job_category_id;
            $total = $this->Frontend_model->total_related_job($id, $cat_id);
            $relaated_jobs = $this->Frontend_model->get_related_job(10, $start, $id, $cat_id);

            $data = array(
                'job' => $job,
                'jobg8' => json_decode($job->jobg8, true),
                'meta_title' => 'Search Thousands of NGO Jobs Worldwide.',
                'meta_description' => 'Take the next  step in your career progression by searching and applying to thousands  of NGO Jobs at  NGOcareer.com.',
                'meta_keywords' => 'NGO career,  NGO vacancies, NGO Jobs, Charity Jobs, Not for profit jobs, Voluntary sector Jobs.',
                'relaated_jobs' => $relaated_jobs,
                'pagination' => getPaginator($total, $page, $target, $this->limit),
                'total_job' => $total,
                'candidate_id' => $this->candidate_id,
            );

            //            if(!$job->user_id){
            //                $data['job']->company_name = $data['jobg8']['AdvertiserName'];
            //                $data['job']->company_logo = 'uploads/no-photo.jpg';
            //            }                        

            $this->viewFrontContent('frontend/template/job-details', $data);
        } else {
            $this->viewFrontContent('frontend/404');
        }
    }

    private function hitCount($id, $table = 'jobs')
    {
        $this->db->set('hit_count', 'hit_count+1', false);
        $this->db->where('id', $id);
        $this->db->update($table);
    }

    public function events()
    {
        $keyword = $this->input->get('keyword');
        $cat_id = ($this->input->get('category')) ? (int)$this->input->get('category') : 0;

        $loc = $this->input->get('loc');
        $lat = $this->input->get('lat');
        $lng = $this->input->get('lng');

        $page = intval($this->input->get('page'));
        $target = build_pagination_url('events', 'page', true);
        $start = startPointOfPagination($this->limit, $page);

        $total = $this->Frontend_model->total_event($cat_id, $keyword, $lat, $lng);
        $events = $this->Frontend_model->get_event($this->limit, $start, $cat_id, $keyword, $lat, $lng);

        $data = array(
            'events' => $events,
            'pagination' => getPaginator($total, $page, $target, $this->limit),
            'total_job' => $total,
            'keyword' => $keyword,
            'category' => $cat_id,
            'location' => $loc,
            'lat' => $lat,
            'lng' => $lng,
            'meta_title' => 'Search Thousands of NGO Jobs Worldwide.',
            'meta_description' => 'Take the next  step in your career progression by searching and applying to thousands  of NGO Jobs at  NGOcareer.com.',
            'meta_keywords' => 'NGO career,  NGO vacancies, NGO Jobs, Charity Jobs, Not for profit jobs, Voluntary sector Jobs.',
            //            'sql' => $this->db->last_query()
        );
        $this->viewFrontContent('frontend/events', $data);
    }

    public function event_details($id)
    {
        // event as e
        $e = $this->Frontend_model->get_event_details($id);
        if ($e) {
            $e->meta_title = 'Search Thousands of NGO Jobs Worldwide.';
            $e->meta_description = 'Take the next  step in your career progression by searching and applying to thousands  of NGO Jobs at  NGOcareer.com.';
            $e->meta_keywords = 'NGO career,  NGO vacancies, NGO Jobs, Charity Jobs, Not for profit jobs, Voluntary sector Jobs.';
            $this->hitCount($id, 'events');
            //            $data = array(
            //                'title'     => $e->title,
            //                'image'     => $e->image,
            //                'location'  => $e->location,
            //                'category'  => $e->category_name,
            //                'date'      => GDF($e->start_date) .' '. GDF($e->end_date),
            //                'summary' => $e->summary,
            //                'organizer_name' => $e->organizer_name,
            //                'short_des' => $e->description,
            //                'full_des'  => $e->full_description,
            //                'lat'  => $e->lat,
            //                'lng'  => $e->lng,
            //                'event_link'  => $e->event_link,
            //            );

            $this->viewFrontContent('frontend/event_details', $e);
        } else {
            $this->viewFrontContent('frontend/404');
        }
    }

    public function shareByEmail()
    {
        ajaxAuthorized();
        $post = $this->input->post();

        $this->form_validation->set_rules('your_name', 'Your name', 'trim|required');
        $this->form_validation->set_rules('your_email', 'Your email', 'trim|required|valid_email');
        $this->form_validation->set_rules('friend_name', 'Friend name', 'trim|required');
        $this->form_validation->set_rules('friend_email', 'Friend email', 'trim|required|valid_email');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors();
            echo ajaxRespond('Fail', $error);
            exit;
        }

        //If already share by email for this job
        $this->db->where([
            'job_id' => $post['job_id'],
            'your_email' => $post['your_email'],
            'friend_email' => $post['friend_email']
        ]);
        $jobShareCount = $this->db->count_all_results('job_email_to_friends');
        if ($jobShareCount > 0) {
            echo ajaxRespond('Fail', 'This job has been already shared to this friend.');
            exit;
        }

        $share = array(
            'job_id' => $post['job_id'],
            'your_name' => $post['your_name'],
            'your_email' => $post['your_email'],
            'friend_name' => $post['friend_name'],
            'friend_email' => $post['friend_email']
        );
        $this->db->insert('job_email_to_friends', $share);
        $insert_id = $this->db->insert_id();


        $job_name = $this->db->select('title')->get_where('jobs', ['id' => $post['job_id']])->row();
        $email_var = [
            'sender_name' => $post['your_name'],
            'sender_email' => $post['your_email'],
            'receiver_name' => $post['friend_name'],
            'receiver_email' => $post['friend_email'],
            'job_url' => site_url("job-details/{$post['job_id']}/" . slugify($job_name->title) . ".html")
        ];
        sendMail('jobShareEmailToFriend', $email_var);

        if ($insert_id) {
            echo ajaxRespond('OK', 'Email send has been successfully!');
        } else {
            echo ajaxRespond('Fail', 'The email couldn\'t be sent to a friend.');
        }
    }

    public function companySearch()
    {

        $q = ($this->input->get('q'));
        $org_type_id = (int)$this->input->get('org_type');

        $page = intval($this->input->get('page'));
        $target = build_pagination_url('companies', 'page', true);
        $start = startPointOfPagination($this->limit, $page);

        $total = $this->Frontend_model->total_company($q, $org_type_id);
        $companies = $this->Frontend_model->get_company($this->limit, $start, $q, $org_type_id);

        $data = array(
            'companies' => $companies,
            'pagination' => getPaginator($total, $page, $target, $this->limit),
            'total_company' => $total,
            'q' => $q,
            'meta_title' => 'Search Thousands of NGO Jobs Worldwide.',
            'meta_description' => 'Take the next  step in your career progression by searching and applying to thousands  of NGO Jobs at  NGOcareer.com.',
            'meta_keywords' => 'NGO career,  NGO vacancies, NGO Jobs, Charity Jobs, Not for profit jobs, Voluntary sector Jobs.',
            'org_type_id' => $org_type_id,
        );

        $this->viewFrontContent('frontend/template/company-search', $data);
    }

    public function companyDetails($id)
    {

        $company = $this->Frontend_model->get_company_details($id);
        if ($company) {
            //Get company jobs list
            $page = intval($this->input->get('page'));
            $target = build_pagination_url("company-details/{$id}/" . slugify($company->company_name) . '.html', 'page', true);
            $start = startPointOfPagination($this->limit, $page);

            $total = $this->Frontend_model->total_company_job($id);
            $company_jobs = $this->Frontend_model->get_company_job($this->limit, $start, $id);

            $data = array(
                'company' => $company,
                'company_jobs' => $company_jobs,
                'pagination' => getPaginator($total, $page, $target, $this->limit),
                'total_job' => $total,
                'meta_title' => 'Search Thousands of NGO Jobs Worldwide.',
                'meta_description' => 'Take the next  step in your career progression by searching and applying to thousands  of NGO Jobs at  NGOcareer.com.',
                'meta_keywords' => 'NGO career,  NGO vacancies, NGO Jobs, Charity Jobs, Not for profit jobs, Voluntary sector Jobs.',
            );
            $this->viewFrontContent('frontend/template/company-details', $data);
        } else {
            $this->viewFrontContent('frontend/404');
        }
    }

    public function advertisers()
    {

        $q = ($this->input->get('q'));
        $page = intval($this->input->get('page'));
        $target = build_pagination_url('advertisers', 'page', true);

        $start = startPointOfPagination($this->limit, $page);

        $total = $this->Frontend_model->total_advertiser($q);
        $advertisers = $this->Frontend_model->get_advertiser($this->limit, $start, $q);


        $data = array(
            'advertisers' => $advertisers,
            'pagination' => getPaginator($total, $page, $target, $this->limit),
            'total_advertiser' => $total,
            'q' => $q,
            'meta_title' => 'Search Thousands of NGO Jobs Worldwide.',
            'meta_description' => 'Take the next  step in your career progression by searching and applying to thousands  of NGO Jobs at  NGOcareer.com.',
            'meta_keywords' => 'NGO career,  NGO vacancies, NGO Jobs, Charity Jobs, Not for profit jobs, Voluntary sector Jobs.',
        );

        $this->viewFrontContent('frontend/advertisers', $data);
    }

    public function advertiser_details($string)
    {
        $AdvertiserName = urldecode($string);
        preg_replace('/[^A-Za-z0-9\-]/', ' ', $AdvertiserName);

        $AdvertiserName = str_replace('_', ' ', $AdvertiserName);

        $page = intval($this->input->get('page'));
        $target = build_pagination_url("company/profile/{$string}", 'page', true);
        $start = startPointOfPagination($this->limit, $page);
        $total = $this->Frontend_model->total_advertiser_job($AdvertiserName);
        $Advertiser_jobs = $this->Frontend_model->get_advertiser_job($this->limit, $start, $AdvertiserName);


        $data = array(
            'Advertiser' => $AdvertiserName,
            'Advertiser_jobs' => $Advertiser_jobs,
            'pagination' => getPaginator($total, $page, $target, $this->limit),
            'total_job' => $total,
            'meta_title' => 'Search Thousands of NGO Jobs Worldwide.',
            'meta_description' => 'Take the next  step in your career progression by searching and applying to thousands  of NGO Jobs at  NGOcareer.com.',
            'meta_keywords' => 'NGO career,  NGO vacancies, NGO Jobs, Charity Jobs, Not for profit jobs, Voluntary sector Jobs.',
        );
        $this->viewFrontContent('frontend/template/advertiser-details', $data);
    }

    public function revision()
    {
        $current_id = $this->uri->segment(2);
        $past_id = $this->uri->segment(3);

        $data['current_data'] = $this->db->get_where('cms', ['id' => $current_id])->row();
        $data['past_data'] = $this->db->get_where('cms', ['id' => $past_id])->row();
        $data['meta_title'] = 'Revision ';
        $data['meta_description'] = 'Revision';
        $data['meta_keywords'] = 'Revision';

        $this->viewFrontContent('frontend/revision', $data);
    }

    public function alert_action()
    {
        ajaxAuthorized();
        $captcha = $this->input->post('g-recaptcha-response');
        if (!$captcha) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Please check the the captcha form.</p>');
            exit;
        }
        $secretKey = "6LdTfDAbAAAAANU0cQkfoV7xPBoK5T8Kkzdbij0d";
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) . '&response=' . urlencode($captcha);
        $response = file_get_contents($url);
        $responseKeys = json_decode($response, true);
        if ($responseKeys["success"] == false) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Please check the the captcha form.</p>');
            exit;
        }

        $post = $this->input->post();
        $email = $this->input->post('email');
        $exist = $this->db->from('job_alert_setup')->where('email', $email)->count_all_results();
        if ($exist) {
            echo ajaxRespond('Fail', 'This email already subscribed!');
            exit();
        }

        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors();
            echo ajaxRespond('Fail', $error);
            exit;
        }

        $saveData = array(
            'candidate_id ' => 0,
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('email'),
            'job_category_ids' => !empty($post['job_category_ids']) ? implode(',', $post['job_category_ids']) : 0,
            'location' => isset($post['location']) ? $post['location'] : null,
            'lat' => isset($post['lat']) ? $post['lat'] : null,
            'lng' => isset($post['lng']) ? $post['lng'] : null,
            'distance' => !empty($post['distance']) ? $post['distance'] : null,
            'email_frequency' => isset($post['email_frequency']) ? $post['email_frequency'] : null,
            'status' => 'On',
            'keywords' => $this->input->post('keywords'),
            'created_at' => date("Y-m-d H:i:s")
        );
        $this->db->insert('job_alert_setup', $saveData);

        sendMail('onJobAlertSubscribe', [
            'receiver_email' => $saveData['email'],
            'subject' => 'Job Alert Subscribe'
        ]);
        echo ajaxRespond('OK', 'Job alert information setup has been created!');
    }

    public function alert_action_listing_details()
    {
        ajaxAuthorized();
        $email = $this->input->post('email');
        $exist = $this->db->from('job_alert_setup')->where('email', $email)->count_all_results();
        if ($exist) {
            echo ajaxRespond('Fail', 'This email already subscribed!');
            exit();
        }

        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors();
            echo ajaxRespond('Fail', $error);
            exit;
        }

        $saveData = array(
            'candidate_id ' => 0,
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('email'),
            'job_category_ids' => $this->input->post('job_category'),
            'status' => 'On',
            'created_at' => date("Y-m-d H:i:s")
        );

        $this->db->insert('job_alert_setup', $saveData);
        echo ajaxRespond('OK', 'Job alert information setup has been created!');
    }

    public function alert_action_ldp()
    {
        ajaxAuthorized();
        $captcha = $this->input->post('g-recaptcha-response');
        if (!$captcha) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Please check the the captcha form.</p>');
            exit;
        }
        $secretKey = "6LdTfDAbAAAAANU0cQkfoV7xPBoK5T8Kkzdbij0d";
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) . '&response=' . urlencode($captcha);
        $response = file_get_contents($url);
        $responseKeys = json_decode($response, true);
        if ($responseKeys["success"] == false) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Please check the the captcha form.</p>');
            exit;
        }
        $email = $this->input->post('email');
        $exist = $this->db->from('job_alert_setup')->where('email', $email)->count_all_results();
        if ($exist) {
            echo ajaxRespond('Fail', '<p class="ajax_error">This email already subscribed!</p>');
            exit();
        }

        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors();
            echo ajaxRespond('Fail', $error);
            exit;
        }

        $saveData = array(
            'candidate_id ' => 0,
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('email'),
            'job_category_ids' => $this->input->post('job_category'),
            'status' => 'On',
            'created_at' => date("Y-m-d H:i:s")
        );

        $this->db->insert('job_alert_setup', $saveData);
        echo ajaxRespond('OK', '<p class="ajax_success">Job alert information setup has been created!</p>');
    }
    public function alert_subscribe()
    {

        $email = $this->input->post('email');
        $exist = $this->db->from('job_alert_subscribe')->where('email', $email)->count_all_results();
        if ($exist) {
            echo ajaxRespond('Fail', 'This email already subscribed!');
            exit();
        }

        $this->form_validation->set_rules('first_name', 'First name', 'required');
        $this->form_validation->set_rules('last_name', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('keywords', 'Keywords', 'trim|required');
        $this->form_validation->set_rules('email_frequency', 'Email frequency', 'required');

        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors();
            echo ajaxRespond('Fail', $error);
            exit;
        }

        $saveData = array(

            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('email'),
            'keywords' => $this->input->post('keywords'),
            'email_frequency' => $this->input->post('email_frequency'),
            'job_category_ids' => !empty($post['job_category_ids']) ? implode(',', $post['job_category_ids']) : 0,
            'status' => 'On',
            'created_at' => date("Y-m-d H:i:s")
        );

        $this->db->insert('job_alert_subscribe', $saveData);

        $this->session->set_flashdata('msgs', 'Job information setup has been subscribed');

        redirect('/home');

        echo ajaxRespond('OK', 'Job information setup has been subscribed!');
    }
    public function blog_archive_ul()
    {
        ajaxAuthorized();
        $year = $this->input->post('year') + 1;
        $html = '<ul>';
        $no_data = 1;
        for ($i = 1; $i <= 12; $i++) {
            $name = date("M - Y", strtotime(date($year . '-01-01') . " -$i months"));
            $value = date("Y-m", strtotime(date($year . '-01-01') . " -$i months"));
            $count = countArchiveComment($value);
            if ($count) {
                $html .= '<li><a href="ngo-career-advice?archive=' . $value . '">' . $name . $count . '</a></li>';
                $no_data = 0;
            }
        }
        $html .= '</ul>';
        if ($no_data == 1) {
            $html = '<p class="ajax_notice">No data found!</p>';
        }
        echo ajaxRespond('OK', $html);
    }
}
