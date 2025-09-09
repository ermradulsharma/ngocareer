<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* Author: Khairul Azam
 * Date : 2016-11-04
 */

class Option extends Admin_controller {

    function __construct() {
        parent::__construct();
        $this->load->model('cms/Option_model', 'Option_model');        
        $this->load->library('form_validation');
        $this->load->helper('cms');
    }

    public function index() {
        $cms_options = $this->Option_model->get_cats();
        $data['categories'] = $cms_options;
        $this->viewAdminContent('cms/option/index', $data);
    }

    public function create() {
        $data = array(
            'button' => 'Create',
            'action' => site_url(Backend_URL . 'cms/category/create_action'),
            'id' => set_value('id'),
            'parent' => set_value('parent'),
            'type' => set_value('type'),
            'name' => set_value('name'),
            'url' => set_value('url'),
            'template' => set_value('template'),
            'description' => set_value('description'),
            'thumb' => set_value('thumb'),
        );
        $this->viewAdminContent('cms/option/form', $data);
    }

    public function create_action() {
        
        $photo = uploadPhoto($_FILES['thumb'],'uploads/cms_photos/', 'cms_categories_' . date('Y-m-d-H-i-s_') . rand(0, 9));
                
        $data = array(
            'parent' => $this->input->post('parent', TRUE),
            'type' => 'category',
            'name' => $this->input->post('name', TRUE),
            'url' => slugify($this->input->post('url', TRUE)),
            'template' => $this->input->post('template', TRUE),
            'description' => $this->input->post('description', TRUE),
            'thumb' => $photo,
        );
        $this->Option_model->insert($data);
        $this->session->set_flashdata('msgs', 'Create Record Success');
        redirect(site_url(Backend_URL . 'cms/category'));
    }

    public function update($id) {
        $row = $this->Option_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url(Backend_URL . 'cms/category/update_action'),
                'id' => set_value('id', $row->id),
                'parent' => set_value('parent', $row->parent),
                'type' => set_value('type', $row->type),
                'name' => set_value('name', $row->name),
                'url' => set_value('url', $row->url),
                'template' => set_value('template', $row->template),
                'description' => set_value('description', $row->description),
                'thumb' => set_value('thumb', $row->thumb),
            );
            $this->viewAdminContent('cms/option/form', $data);
        } else {
            $this->session->set_flashdata('msgw', 'Record Not Found');
            redirect(site_url(Backend_URL . 'cms/category'));
        }
    }

    public function update_action() {

        $cat_pic = $this->db->get_where('cms_options', ['id' => $this->input->post('id')])->row();
        $photo = uploadPhoto($_FILES['thumb'],'uploads/cms_photos/', 'cms_categories_' . date('Y-m-d-H-i-s_') . rand(0, 9));
        
        if (empty($_FILES['thumb']['name'])) {
            $photo = $cat_pic->thumb;
        } else {
            removeImage($cat_pic->thumb);
        }
        
        $data = array(
            'parent' => $this->input->post('parent', TRUE),
            'type' => 'category',
            'name' => $this->input->post('name', TRUE),
            'url' => slugify($this->input->post('url', TRUE)),
            'template' => $this->input->post('template', TRUE),
            'description' => $this->input->post('description', TRUE),
            'thumb' => $photo,
        );
        $this->Option_model->update($this->input->post('id', TRUE), $data);
        $this->session->set_flashdata('msgs', 'Update Record Success');
        redirect(site_url(Backend_URL . 'cms/category'));
    }

    public function delete($id) {
        $row = $this->Option_model->get_by_id($id);
        if ($row) {
            removeImage($row->thumb, 'cms_photos');
            $this->Option_model->delete($id);
            $this->session->set_flashdata('msgs', 'Delete Record Success');
            redirect(site_url(Backend_URL . 'cms/category'));
        } else {
            $this->session->set_flashdata('msgw', 'Record Not Found');
            redirect(site_url(Backend_URL . 'cms/category'));
        }
    }

    public function _rules() {
        $this->form_validation->set_rules('parent', 'parent', 'trim|required');
        $this->form_validation->set_rules('type', 'type', 'trim|required');
        $this->form_validation->set_rules('name', 'name', 'trim|required');
        $this->form_validation->set_rules('url', 'url', 'trim|required');
        $this->form_validation->set_rules('template', 'template', 'trim|required');
        $this->form_validation->set_rules('description', 'description', 'trim|required');
        $this->form_validation->set_rules('thumb', 'thumb', 'trim|required');
        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}
