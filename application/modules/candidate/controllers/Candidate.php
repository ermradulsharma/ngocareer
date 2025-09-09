<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Author: Imran Hossain
 * Date : 2021-07-05
 */

class Candidate extends Admin_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Candidate_model');
        $this->load->helper('candidate');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        $alert = $this->input->get('alert');
        $gender = $this->input->get('gender');
        $status = $this->input->get('status');

        $config['base_url'] = build_pagination_url(Backend_URL . 'candidate/', 'start');
        $config['first_url'] = build_pagination_url(Backend_URL . 'candidate/', 'start');

        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Candidate_model->total_rows($status, $gender, $alert, $q);
        $candidates = $this->Candidate_model->get_limit_data($config['per_page'], $start, $status, $gender, $alert, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'candidates' => $candidates,
            'alert' => $alert,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'gender' => $gender,
            'status' => $status,
            //'sql'        => $this->db->last_query();,
            'q' => $q,
        );
        $this->viewAdminContent('candidate/candidate/index', $data);
    }

    public function read($id)
    {
        $row = $this->Candidate_model->get_by_id($id);
        if ($row) {
            $cvs = $this->db->get_where('candidate_cv', ['candidate_id' => $id])->result();
            $data = array(
                'id' => $row->id,
                'oauth_provider' => $row->oauth_provider,
                'oauth_uid' => $row->oauth_uid,
                'first_name' => $row->first_name,
                'last_name' => $row->last_name,
                'full_name' => $row->full_name,
                'email' => $row->email,
                'password' => $row->password,
                'date_of_birth' => $row->date_of_birth,
                'marital_status' => $row->marital_status,
                'country_id' => $row->country_id,
                'permanent_address' => $row->permanent_address,
                'present_address' => $row->present_address,
                'home_phone' => $row->home_phone,
                'mobile_number' => $row->mobile_number,
                'gender' => $row->gender,
                'status' => $row->status,
                'picture' => $row->picture,
                'career_summary' => $row->career_summary,
                'qualifications' => $row->qualifications,
                'keywords' => $row->keywords,
                'additional_information' => $row->additional_information,
                'created_at' => $row->created_at,
                'modified' => $row->modified,
                'cvs' => $cvs
            );
            $this->viewAdminContent('candidate/candidate/read', $data);
        } else {
            $this->session->set_flashdata('msge', 'Candidate Not Found');
            redirect(site_url(Backend_URL . 'candidate'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url(Backend_URL . 'candidate/create_action'),
            'id' => set_value('id'),
            'first_name' => set_value('first_name'),
            'last_name' => set_value('last_name'),
            'full_name' => set_value('full_name'),
            'email' => set_value('email'),
            'password' => set_value('password'),
            'date_of_birth' => set_value('date_of_birth'),
            'marital_status' => set_value('marital_status'),
            'country_id' => set_value('country_id'),
            'permanent_address' => set_value('permanent_address'),
            'present_address' => set_value('present_address'),
            'home_phone' => set_value('home_phone'),
            'mobile_number' => set_value('mobile_number'),
            'gender' => set_value('gender'),
            'status' => set_value('status', 'Active'),
            'career_summary' => set_value('career_summary'),
            'qualifications' => set_value('qualifications'),
            'keywords' => set_value('keywords'),
            'additional_information' => set_value('additional_information'),
            'created_at' => set_value('created_at'),
            'modified' => set_value('modified'),
        );
        $this->viewAdminContent('candidate/candidate/create', $data);
    }

    public function create_action()
    {
        $this->_rules();
        $this->form_validation->set_rules('email', 'email', 'trim|valid_email|required|max_length[80]|is_unique[candidates.email]',
            [ 'is_unique' => 'This email already in used', 'valid_email' => 'Enter a valid email address']);
        $this->form_validation->set_rules('password', 'password', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'first_name' => $this->input->post('first_name', TRUE),
                'last_name' => $this->input->post('last_name', TRUE),
                'email' => $this->input->post('email', TRUE),
                'password' => password_encription($this->input->post('password', TRUE)),
                'date_of_birth' => ($this->input->post('date_of_birth', TRUE))?$this->input->post('date_of_birth', TRUE):null,
                'marital_status' => $this->input->post('marital_status', TRUE),
                'country_id' => intval($this->input->post('country_id', TRUE)),
                'permanent_address' => $this->input->post('permanent_address', TRUE),
                'present_address' => $this->input->post('present_address', TRUE),
                'home_phone' => $this->input->post('home_phone', TRUE),
                'mobile_number' => $this->input->post('mobile_number', TRUE),
                'gender' => $this->input->post('gender', TRUE),
                'status' => $this->input->post('status', TRUE),
                'career_summary' => $this->input->post('career_summary', TRUE),
                'qualifications' => $this->input->post('qualifications', TRUE),
                'keywords' => $this->input->post('keywords', TRUE),
                'additional_information' => $this->input->post('additional_information', TRUE),
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('candidates', $data);
            $this->session->set_flashdata('msgs', 'Candidate Added Successfully');
            redirect(site_url(Backend_URL . 'candidate'));
        }
    }

    public function update($id)
    {
        $row = $this->Candidate_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url(Backend_URL . 'candidate/update_action'),
                'id' => set_value('id', $row->id),
                'first_name' => set_value('first_name', $row->first_name),
                'last_name' => set_value('last_name', $row->last_name),
                'full_name' => set_value('full_name', $row->full_name),
                'email' => set_value('email', $row->email),
                'date_of_birth' => set_value('date_of_birth', $row->date_of_birth),
                'marital_status' => set_value('marital_status', $row->marital_status),
                'country_id' => set_value('country_id', $row->country_id),
                'permanent_address' => set_value('permanent_address', $row->permanent_address),
                'present_address' => set_value('present_address', $row->present_address),
                'home_phone' => set_value('home_phone', $row->home_phone),
                'mobile_number' => set_value('mobile_number', $row->mobile_number),
                'gender' => set_value('gender', $row->gender),
                'status' => set_value('status', $row->status),
                'career_summary' => set_value('career_summary', $row->career_summary),
                'qualifications' => set_value('qualifications', $row->qualifications),
                'keywords' => set_value('keywords', $row->keywords),
                'additional_information' => set_value('additional_information', $row->additional_information)
            );
            $this->viewAdminContent('candidate/candidate/update', $data);
        } else {
            $this->session->set_flashdata('msge', 'Candidate Not Found');
            redirect(site_url(Backend_URL . 'candidate'));
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
                'first_name' => $this->input->post('first_name', TRUE),
                'last_name' => $this->input->post('last_name', TRUE),
                'date_of_birth' => ($this->input->post('date_of_birth', TRUE))?$this->input->post('date_of_birth', TRUE):null,
                'marital_status' => $this->input->post('marital_status', TRUE),
                'country_id' => intval($this->input->post('country_id', TRUE)),
                'permanent_address' => $this->input->post('permanent_address', TRUE),
                'present_address' => $this->input->post('present_address', TRUE),
                'home_phone' => $this->input->post('home_phone', TRUE),
                'mobile_number' => $this->input->post('mobile_number', TRUE),
                'gender' => $this->input->post('gender', TRUE),
                'status' => $this->input->post('status', TRUE),
                'career_summary' => $this->input->post('career_summary', TRUE),
                'qualifications' => $this->input->post('qualifications', TRUE),
                'keywords' => $this->input->post('keywords', TRUE),
                'additional_information' => $this->input->post('additional_information', TRUE),
                'modified' => date('Y-m-d H:i:s'),
            );

            $this->Candidate_model->update($id, $data);
            $this->session->set_flashdata('msgs', 'Candidate Updated Successfully');
            redirect(site_url(Backend_URL . 'candidate/update/' . $id));
        }
    }

    public function delete($id)
    {
        $row = $this->Candidate_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'first_name' => $row->first_name,
                'last_name' => $row->last_name,
                'full_name' => $row->full_name,
                'email' => $row->email,
                'password' => $row->password,
                'date_of_birth' => $row->date_of_birth,
                'marital_status' => $row->marital_status,
                'country_id' => $row->country_id,
                'permanent_address' => $row->permanent_address,
                'present_address' => $row->present_address,
                'home_phone' => $row->home_phone,
                'mobile_number' => $row->mobile_number,
                'gender' => $row->gender,
                'status' => $row->status,
                'career_summary' => $row->career_summary,
                'qualifications' => $row->qualifications,
                'keywords' => $row->keywords,
                'additional_information' => $row->additional_information,
                'created_at' => $row->created_at,
                'modified' => $row->modified,
            );
            $this->viewAdminContent('candidate/candidate/delete', $data);
        } else {
            $this->session->set_flashdata('msge', 'Candidate Not Found');
            redirect(site_url(Backend_URL . 'candidate'));
        }
    }

    public function delete_action($id)
    {
        $row = $this->Candidate_model->get_by_id($id);

        if ($row) {
            $this->Candidate_model->delete($id);
            $this->session->set_flashdata('msgs', 'Candidate Deleted Successfully');
            redirect(site_url(Backend_URL . 'candidate'));
        } else {
            $this->session->set_flashdata('msge', 'Candidate Not Found');
            redirect(site_url(Backend_URL . 'candidate'));
        }
    }

    public function _menu()
    {
        // return add_main_menu('Candidate', 'candidate', 'candidate', 'fa-hand-o-right');
        return buildMenuForMoudle([
            'module' => 'Candidate',
            'icon' => 'fa-hand-o-right',
            'href' => 'candidate',
            'children' => [
                [
                    'title' => 'All Candidate',
                    'icon' => 'fa fa-bars',
                    'href' => 'candidate'
                ], [
                    'title' => ' |_ Add New',
                    'icon' => 'fa fa-plus',
                    'href' => 'candidate/create'
                ]
            ]
        ]);
    }

    public function _rules()
    {
        $this->form_validation->set_rules('first_name', 'first name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'last name', 'trim|required');
        $this->form_validation->set_rules('status', 'status', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function set_status()
    {
        $post_id = intval($this->input->post('post_id'));
        $status = $this->input->post('status');
        $this->db->set('status', $status)->where('id', $post_id)->update('candidates');

        switch ($status) {
            case 'Active':
                $status = '<i class="fa fa-check"></i> Active';
                $class = 'btn-success';
                break;
            case 'Pending':
                $status = '<i class="fa fa-hourglass-1"></i> Pending';
                $class = 'btn-warning';
                break;
            case 'Inactive':
                $status = '<i class="fa fa-ban"></i> Inactive';
                $class = 'btn-danger';
                break;
            default :
                $class = 'btn-default';
                $status = '<i class="fa fa-file-o" ></i> Draft';
        }
        echo json_encode([
            'Status' => $status .
                ' &nbsp; <i class="fa fa-angle-down"></i>',
            'Class' => $class
        ]);
    }

}