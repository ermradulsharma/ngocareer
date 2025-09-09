<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2020-03-27
 */

class Job_alert extends Admin_controller{
    function __construct(){
        parent::__construct();
        $this->load->helper('job_alert');
        $this->load->model('Job_alert_model');
    }

    public function index(){        
        $start = intval($this->input->get('start'));
        
        $config['base_url'] = build_pagination_url( Backend_URL . 'job_alert/', 'start');
        $config['first_url'] = build_pagination_url( Backend_URL . 'job_alert/', 'start');

        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Job_alert_model->total_rows();
        $job_alerts = $this->Job_alert_model->get_limit_data($config['per_page'], $start);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'job_alerts' => $job_alerts,            
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'categories' => $this->_categories(),
        );                
        $this->viewAdminContent('job_alert/job_alert/index', $data);
    }   

    private function _categories(){
        $this->db->select('id,name');
        $categories = $this->db->get('job_categories')->result(); 
        $data = [];
        foreach ($categories as $c ){
            $data[$c->id] = $c->name;
        }
        return $data;
    }

    public function delete($id)
    {
        $row = $this->Job_alert_model->get_by_id($id);
        if ($row) {
            $this->Job_alert_model->delete($id);
            $this->session->set_flashdata('msgs', 'Delete Record Success');
            redirect(site_url(Backend_URL . 'job_alert'));
        } else {
            $this->session->set_flashdata('msge', 'Record Not Found');
            redirect(site_url(Backend_URL . 'job_alert'));
        }
    }

    public function _menu(){
        return add_main_menu('Job Alert', 'admin/job_alert', 'job_alert', 'fa-bell');        
    }
}