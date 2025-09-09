<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 03 Mar 2020 @01:18 pm
 */

class Organization_type extends Admin_controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Organization_type_model');
        $this->load->helper('organization_type');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        $config['base_url'] = build_pagination_url(Backend_URL . 'job/organization_type/', 'start');
        $config['first_url'] = build_pagination_url(Backend_URL . 'job/organization_type/', 'start');

        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Organization_type_model->total_rows($q);
        $organization_types = $this->Organization_type_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'organization_types' => $organization_types,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'name' => set_value('name')
        );
        $this->viewAdminContent('job/organization_type/index', $data);
    }

    public function create_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $data = array(
                'name' => $this->input->post('name', TRUE),
                'created_at' => date('Y-m-d H:i:s'),
            );

            $this->Organization_type_model->insert($data);
            $this->session->set_flashdata('msgs', 'Organization Type Added Successfully');
            redirect(site_url(Backend_URL . 'job/organization_type'));
        }
    }

    public function update($id)
    {
        $row = $this->Organization_type_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url(Backend_URL . 'job/organization_type/update_action'),
                'id' => set_value('id', $row->id),
                'name' => set_value('name', $row->name)
            );
            $this->viewAdminContent('job/organization_type/update', $data);
        } else {
            $this->session->set_flashdata('msge', 'Organization Type Not Found');
            redirect(site_url(Backend_URL . 'job/organization_type'));
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
                'name' => $this->input->post('name', TRUE)
            );

            $this->Organization_type_model->update($id, $data);
            $this->session->set_flashdata('msgs', 'Organization Type Updated Successfully');
            redirect(site_url(Backend_URL . 'job/organization_type/'));
        }
    }

    public function delete($id)
    {
        $row = $this->Organization_type_model->get_by_id($id);
        if ($row) {
            $this->Organization_type_model->delete($id);
            $this->session->set_flashdata('msgs', 'Organization Type Deleted Successfully');
            redirect(site_url(Backend_URL . 'job/organization_type'));
        } else {
            $this->session->set_flashdata('msge', 'Organization_type Not Found');
            redirect(site_url(Backend_URL . 'job/organization_type'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('name', 'name', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}
