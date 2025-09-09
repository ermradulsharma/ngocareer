<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 25 Feb 2020 @01:29 pm
 */

class Sub_category extends Admin_controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Sub_category_model');        
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q      = urldecode($this->input->get('q', TRUE));
        $cid    = intval($this->input->get('cid'));
        $start  = intval($this->input->get('start'));


        $config['base_url'] = build_pagination_url(Backend_URL . 'job/sub_category/', 'start');
        $config['first_url'] = build_pagination_url(Backend_URL . 'job/sub_category/', 'start');


        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Sub_category_model->total_rows($cid,$q);
        $sub_categorys = $this->Sub_category_model->get_limit_data($config['per_page'], $start, $cid,$q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'sub_categorys' => $sub_categorys,
            'q' => $q,
            'cid' => $cid,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'category' => $this->getCategory(),
        );
        $this->viewAdminContent('job/sub_category/index', $data);
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url(Backend_URL . 'job/sub_category/create_action'),
            'id' => set_value('id'),
            'category_id' => set_value('category_id'),
            'name' => set_value('name'),
            'created_at' => set_value('created_at'),
            'updated_at' => set_value('updated_at'),
        );
        $this->viewAdminContent('job/sub_category/create', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'category_id' => (int) $this->input->post('category_id', TRUE),
                'name' => $this->input->post('name', TRUE),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            );

            $this->Sub_category_model->insert($data);
            $this->session->set_flashdata('message', '<p class="ajax_success">Sub_category Added Successfully</p>');
            redirect(site_url(Backend_URL . 'job/sub_category'));
        }
    }

    public function update($id)
    {
        $row = $this->Sub_category_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url(Backend_URL . 'job/sub_category/update_action'),
                'id' => set_value('id', $row->id),
                'category_id' => set_value('category_id', $row->category_id),
                'name' => set_value('name', $row->name),
                'created_at' => set_value('created_at', $row->created_at),
                'updated_at' => set_value('updated_at', $row->updated_at),
            );
            $this->viewAdminContent('job/sub_category/update', $data);
        } else {
            $this->session->set_flashdata('message', '<p class="ajax_error">Sub_category Not Found</p>');
            redirect(site_url(Backend_URL . 'job/sub_category'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        $id = $this->input->post('id', TRUE);
        if ($this->form_validation->run() == FALSE) {
            $this->update($id);
        } else {
            $data = array(
                'category_id' => (int) $this->input->post('category_id', TRUE),
                'name' => $this->input->post('name', TRUE),                
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $this->Sub_category_model->update($id, $data);
            $this->session->set_flashdata('message', '<p class="ajax_success">Sub_category Updated Successlly</p>');
            redirect(site_url(Backend_URL . 'job/sub_category/'));
        }
    }

    public function delete($id)
    {
        $row = $this->Sub_category_model->get_by_id($id);

        if ($row) {
            $this->Sub_category_model->delete($id);
            $this->session->set_flashdata('message', '<p class="ajax_success">Sub_category Deleted Successfully</p>');
            redirect(site_url(Backend_URL . 'job/sub_category'));
        } else {
            $this->session->set_flashdata('message', '<p class="ajax_error">Sub_category Not Found</p>');
            redirect(site_url(Backend_URL . 'job/sub_category'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('category_id', 'category id', 'trim|required|is_natural_no_zero', [
            'is_natural_no_zero' => 'Please Select Category'
        ]);
        $this->form_validation->set_rules('name', 'name', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function getCategory()
    {
        $this->db->select('id,name');
        $categories = $this->db->get('job_categories')->result();
        $data = [];
        foreach($categories as $cat ){
            $data[$cat->id] = $cat->name;
        }
        return $data;
    }
}
