<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 04 Feb 2020 @12:51 pm
 */

class Skill extends Admin_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Skill_model');
        $this->load->helper('skill');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        $config['base_url'] = build_pagination_url(Backend_URL . 'job/skill/', 'start');
        $config['first_url'] = build_pagination_url(Backend_URL . 'job/skill/', 'start');

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Skill_model->total_rows($q);
        $skills = $this->Skill_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'skills' => $skills,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'name' => set_value('name'),
        );
        $this->viewAdminContent('job/skill/index', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $data = array(
                'name' => $this->input->post('name', TRUE),
                'created_at' => date('Y-m-d H:i:s')
            );

            $this->Skill_model->insert($data);
            $this->session->set_flashdata('msgs', 'Skill Added Successfully');
            redirect(site_url(Backend_URL . 'job/skill'));
        }
    }

    public function update($id)
    {
        $row = $this->Skill_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url(Backend_URL . 'job/skill/update_action'),
                'id' => set_value('id', $row->id),
                'name' => set_value('name', $row->name),
            );
            $this->viewAdminContent('job/skill/update', $data);
        } else {
            $this->session->set_flashdata('msge', 'Skill Not Found');
            redirect(site_url(Backend_URL . 'job/skill'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        $id = (int)$this->input->post('id', TRUE);
        if ($this->form_validation->run() == FALSE) {
            $this->update($id);
        } else {
            $data = array(
                'name' => $this->input->post('name', TRUE),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $this->Skill_model->update($id, $data);
            $this->session->set_flashdata('msgs', 'Skill Updated Successfully');
            redirect(site_url(Backend_URL . 'job/skill/'));
        }
    }

    public function delete($id)
    {
        $row = $this->Skill_model->get_by_id($id);

        if ($row) {
            $this->Skill_model->delete($id);
            $this->session->set_flashdata('msgs', 'Skill Deleted Successfully');
            redirect(site_url(Backend_URL . 'job/skill'));
        } else {
            $this->session->set_flashdata('msge', 'Skill Not Found');
            redirect(site_url(Backend_URL . 'job/skill'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('name', 'name', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }


}