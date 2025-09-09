<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 2020-03-20
 */

class Package extends Admin_controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Package_model');
        $this->load->helper('package');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        $config['base_url'] = build_pagination_url(Backend_URL . 'package/', 'start');
        $config['first_url'] = build_pagination_url(Backend_URL . 'package/', 'start');

        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Package_model->total_rows($q);
        $packages = $this->Package_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'packages' => $packages,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'role_id' => $this->role_id,
        );
        $this->viewAdminContent('package/package/index', $data);
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url(Backend_URL . 'package/create_action'),
            'id' => set_value('id'),
            'name' => set_value('name'),
            'price' => set_value('price'),
            'duration' => set_value('duration'),
            'type' => set_value('type', 'Job')
        );
        $this->viewAdminContent('package/package/create', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'name' => $this->input->post('name', TRUE),
                'price' => $this->input->post('price', TRUE),
                'duration' => $this->input->post('duration', TRUE),
                'type' => $this->input->post('type', TRUE),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $this->Package_model->insert($data);
            $this->session->set_flashdata('msgs', 'Package Added Successfully');
            redirect(site_url(Backend_URL . 'package'));
        }
    }

    public function update($id)
    {
        $row = $this->Package_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url(Backend_URL . 'package/update_action'),
                'id' => set_value('id', $row->id),
                'name' => set_value('name', $row->name),
                'price' => set_value('price', $row->price),
                'duration' => set_value('duration', $row->duration),
                'type' => set_value('type', $row->type)
            );
            $this->viewAdminContent('package/package/update', $data);
        } else {
            $this->session->set_flashdata('msge', 'Package Not Found');
            redirect(site_url(Backend_URL . 'package'));
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
                'name' => $this->input->post('name', TRUE),
                'price' => $this->input->post('price', TRUE),
                'duration' => $this->input->post('duration', TRUE),
                'type' => $this->input->post('type', TRUE),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $this->Package_model->update($id, $data);
            $this->session->set_flashdata('msgs', 'Package Updated Successlly');
            redirect(site_url(Backend_URL . 'package/update/' . $id));
        }
    }

    public function _menu()
    {
        return add_main_menu('Package', 'admin/package', 'package', 'fa-hand-o-right');

    }

    public function _rules()
    {
        $this->form_validation->set_rules('name', 'name', 'trim|required');
        $this->form_validation->set_rules('price', 'price', 'trim|required|numeric');
        $this->form_validation->set_rules('duration', 'duration', 'trim|required');
        $this->form_validation->set_rules('type', 'type', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}
