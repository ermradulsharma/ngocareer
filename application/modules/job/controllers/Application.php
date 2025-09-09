<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 21 Feb 2020 @04:37 pm
 */

class Application extends Admin_controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Application_model');
        $this->load->helper('application');
        $this->load->library('form_validation');
    }

    public function index()
    {        
        $start = intval($this->input->get('start'));
        $status = $this->input->get('status', TRUE);
        $date = $this->input->get('date', TRUE);
        
        $config['base_url'] = build_pagination_url(Backend_URL . 'job/application/', 'start');
        $config['first_url'] = build_pagination_url(Backend_URL . 'job/application/', 'start');

        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Application_model->total_rows();
        $applications = $this->Application_model->get_limit_data($config['per_page'], $start,$status,$date);                
        
//        echo $this->db->last_query();

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'applications' => $applications,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'status' => $status,
            'date' => $date,
        );
        $this->viewAdminContent('job/application/index', $data);
    }
   

}
