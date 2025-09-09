<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 2016-10-05
 */

class Users extends Admin_controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->helper('users');
//        $this->load->helper('company/company');
        $this->load->library('form_validation');       
    }
    
    public function index() {
        $q          = urldecode($this->input->get('q', TRUE));
        $status     = urldecode($this->input->get('status', TRUE));
        $role_id    = intval($this->input->get('role_id', TRUE));
        $start      = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = Backend_URL . 'users?q='.$q.'&role_id='.$role_id.'&status='.$status;
            $config['first_url'] = Backend_URL . 'users?q='.$q.'&role_id='.$role_id.'&status='.$status;
        } else {
            $config['base_url'] = Backend_URL . 'users/';
            $config['first_url'] = Backend_URL . 'users/';
        }

        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Users_model->total_rows($q, $status , $role_id);
        $users = $this->Users_model->get_limit_data($config['per_page'], $start, $q, $status , $role_id);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'users_data' => $users,
            'q' => $q,
            'role_id' => $role_id,
            'status' => $status,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->viewAdminContent('users/users/index', $data);
    }

    public function profile($id) {
        $row = $this->Users_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'role_id' => getRoleName($row->role_id),
                'first_name' => $row->first_name,
                'last_name' => $row->last_name,
                'email' => $row->email,
                'password' => $row->password,
                'contact' => $row->contact,
                'add_line1' => $row->add_line1,
                'add_line2' => $row->add_line2,
                'city' => $row->city,
                'state' => $row->state,
                'postcode' => $row->postcode,
                'country_id' => getCountryName($row->country_id),
                'created_at' => $row->created_at,
                'status' => $row->status,
            );
            $this->viewAdminContent('users/users/profile', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL . 'users'));
        }
    }

    public function create() {
        $data = array(
            'action' => site_url( Backend_URL . 'users/create_action'),
            'id' => set_value('id'),
            'role_id' => set_value('role_id', 3),
            'first_name' => set_value('first_name'),
            'last_name' => set_value('last_name'),
            'your_email' => set_value('your_email'),
            'contact' => set_value('contact'),
            'add_line1' => set_value('add_line1'),
            'add_line2' => set_value('add_line2'),
            'city' => set_value('city'),
            'state' => set_value('state'),
            'postcode' => set_value('postcode'),
            'country_id' => set_value('country_id', 224),
            'status' => set_value('status', 'Active')
        );
        $this->viewAdminContent('users/users/create', $data);
    }

    public function create_action() {  
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'role_id'       => intval($this->input->post('role_id', TRUE)),                                
                'first_name'    => $this->input->post('first_name', TRUE),
                'last_name'     => $this->input->post('last_name', TRUE),
                'email'         => $this->input->post('your_email', TRUE),
                'password'      => password_encription( $this->input->post('password', TRUE) ),
                'contact'       => $this->input->post('contact', TRUE),
                'add_line1'     => $this->input->post('add_line1', TRUE),
                'add_line2'     => $this->input->post('add_line2', TRUE),
                'city'          => $this->input->post('city', TRUE),
                'state'         => $this->input->post('state', TRUE),
                'postcode'      => $this->input->post('postcode', TRUE),
                'country_id'    => $this->input->post('country_id', TRUE),
                'created_at'    => date("Y-m-d H:i:s"),
                'status'        => $this->input->post('status', TRUE),
            );
            
            $id = $this->Users_model->insert($data);   
            $this->session->set_flashdata('msgs', 'User registered successfully');
            redirect(site_url("admin/users/update/{$id}"));
        }
    }

    public function create_company() {
        $data = array(
            'action' => site_url( Backend_URL . 'users/create_action_company'),
            'id' => set_value('id'),
            'first_name' => set_value('first_name'),
            'last_name' => set_value('last_name'),
            'company_name' => set_value('company_name'),
            'about_company' => set_value('about_company'),
            'org_type_id' => set_value('org_type_id'),
            'logo' => set_value('logo'),
            'your_email' => set_value('your_email'),
            'contact' => set_value('contact'),
            'website' => set_value('website'),
            'add_line1' => set_value('add_line1'),
            'add_line2' => set_value('add_line2'),
            'city' => set_value('city'),
            'state' => set_value('state'),
            'postcode' => set_value('postcode'),
            'country_id' => set_value('country_id'),
            'status' => set_value('status'),
            'is_featured' => set_value('is_featured', 0),
        );

        $this->viewAdminContent('users/users/create_company', $data);
    }

    public function create_action_company() {
        $this->_rules_company();
        if ($this->form_validation->run() == FALSE) {
            $this->create_company();
        } else {
            if($_FILES['logo']['name']){
                $logo = uploadPhoto($_FILES['logo'], 'uploads/company/'.date('Y/m/'), rand(1111, 9999).'-'.time());
            } else {
                $logo = null;
            }
            $data = array(
                'role_id'       => 4,
                'first_name'    => $this->input->post('first_name', TRUE),
                'last_name'     => $this->input->post('last_name', TRUE),
                'company_name'  => $this->input->post('company_name', TRUE),
                'about_company' => $this->input->post('about_company', TRUE),
                'org_type_id'   => (int)$this->input->post('org_type_id', TRUE),
                'logo'          => $logo,
                'email'         => $this->input->post('your_email', TRUE),
                'password'      => password_encription($this->input->post('password', TRUE)),
                'contact'       => $this->input->post('contact', TRUE),
                'website'       => $this->input->post('website', TRUE),
                'add_line1'     => $this->input->post('add_line1', TRUE),
                'add_line2'     => $this->input->post('add_line2', TRUE),
                'city'          => $this->input->post('city', TRUE),
                'state'         => $this->input->post('state', TRUE),
                'postcode'      => $this->input->post('postcode', TRUE),
                'country_id'    => $this->input->post('country_id', TRUE),
                'is_featured'   => (int)$this->input->post('is_featured', TRUE),
                'created_at'    => date("Y-m-d H:i:s"),
                'status'        => 'Active',
            );
            $this->Users_model->insert($data);
            $this->session->set_flashdata('msgs', 'Company registered successfully');
            redirect(site_url("admin/users"));
        }
    }

    public function update($id) {
        $row = $this->Users_model->get_by_id($id);
        if ($row) {
            $role_id = ($this->input->get('role_id'))?(int)$this->input->get('role_id'):$row->role_id;
            $data = array(
                'button' => 'Update',
                'id' => set_value('id', $row->id),
                'role_id' => set_value('role_id', $role_id),
                'is_featured' => set_value('is_featured', $row->is_featured),
                'company_name' => set_value('company_name', $row->company_name),
                'website' => set_value('website', $row->website),
                'logo' => set_value('logo', $row->logo),
                'about_company' => set_value('about_company', $row->about_company),
                'org_type_id' => set_value('org_type_id', $row->org_type_id),
                'first_name' => set_value('first_name', $row->first_name),
                'last_name' => set_value('last_name', $row->last_name),
                'email' => set_value('email', $row->email),                
                'contact' => set_value('contact', $row->contact),
                'add_line1' => set_value('add_line1', $row->add_line1),
                'add_line2' => set_value('add_line2', $row->add_line2),
                'city' => set_value('city', $row->city),
                'state' => set_value('state', $row->state),
                'postcode' => set_value('postcode', $row->postcode),
                'country_id' => set_value('country_id', $row->country_id),
                'created_at' => set_value('created_at', $row->created_at),                
                'status' => set_value('status', $row->status),
            );

            if($role_id == 4){
                $data['action'] = site_url( Backend_URL . 'users/update_action_company');
                $this->viewAdminContent('users/users/update_company', $data);
            } else {
                $data['action'] = site_url( Backend_URL . 'users/update_action');
                $this->viewAdminContent('users/users/update', $data);
            }
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('users'));
        }
    }

    public function update_action_company() {
        $id = (int)$this->input->post('id', TRUE);
        $this->_rules_company_update();
        if ($this->form_validation->run() == FALSE) {
            $this->update($id);
        } else {
            if($_FILES['logo']['name']){
                $data['logo'] = uploadPhoto($_FILES['logo'], 'uploads/company/'.date('Y/m/'), rand(1111, 9999).'-'.time());
            }

            $data = array(
                'role_id'       => (int)$this->input->post('role_id', TRUE),
                'first_name'    => $this->input->post('first_name', TRUE),
                'last_name'     => $this->input->post('last_name', TRUE),
                'company_name'  => $this->input->post('company_name', TRUE),
                'is_featured'  => $this->input->post('is_featured', TRUE),
                'about_company' => $this->input->post('about_company', TRUE),
                'org_type_id'   => (int)$this->input->post('org_type_id', TRUE),
                'password'      => password_encription($this->input->post('password', TRUE)),
                'contact'       => $this->input->post('contact', TRUE),
                'website'       => $this->input->post('website', TRUE),
                'add_line1'     => $this->input->post('add_line1', TRUE),
                'add_line2'     => $this->input->post('add_line2', TRUE),
                'city'          => $this->input->post('city', TRUE),
                'state'         => $this->input->post('state', TRUE),
                'postcode'      => $this->input->post('postcode', TRUE),
                'country_id'    => $this->input->post('country_id', TRUE),
                'created_at'    => date("Y-m-d H:i:s"),
                'status'        => 'Active',
            );
            $this->Users_model->update($id, $data);
            $this->session->set_flashdata('msgs', 'Update Successfully');
            redirect(site_url("admin/users/update/{$id}"));
        }
    }

    public function update_action() {
        $id = $this->input->post('id', TRUE);
        $data = array(
            'role_id'       => $this->input->post('role_id', TRUE),
            'first_name'    => $this->input->post('first_name', TRUE),
            'last_name'     => $this->input->post('last_name', TRUE),
            'contact'       => $this->input->post('contact', TRUE),
            'add_line1'     => $this->input->post('add_line1', TRUE),
            'add_line2'     => $this->input->post('add_line2', TRUE),
            'city'          => $this->input->post('city', TRUE),
            'state'         => $this->input->post('state', TRUE),
            'postcode'      => $this->input->post('postcode', TRUE),
            'country_id'    => $this->input->post('country_id', TRUE)
        );
        $this->Users_model->update($id, $data);
        $this->session->set_flashdata('msgs', 'User Update Successfully');
        redirect(site_url("admin/users/update/{$id}"));
    }

    public function freeze($id) {
        $row = $this->Users_model->get_by_id($id);
        if ($row) {
            $data = (array) $row;                       
            $this->viewAdminContent('users/users/freeze', $data);
        } else {
            $this->session->set_flashdata('msge', 'User Not Found');
            redirect(site_url('users'));
        }
    }
    
    public function setStatus(){
        $id         = $this->input->post('id');
        $status     = $this->input->post('status');        
        $this->db->set('status', $status);
        $this->db->where('id', $id);        
        $this->db->update('users');        
        if($status =='Inactive'){
            echo ajaxRespond('OK', "<p class='ajax_notice'>Account Freezed</p>");
        } else {
            echo ajaxRespond('OK', "<p class='ajax_success'>Account UnFreezed</p>");
        }                        
    }
    
    
    public function set_status()
    {
        $post_id    = intval($this->input->post('post_id'));
        $status     = $this->input->post('status');
        $this->db->set('status', $status)->where('id', $post_id)->update('users');

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


    public function _rules_company_update(){
        $this->form_validation->set_rules('first_name', 'first name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('last_name', 'last name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('company_name', 'company name', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('org_type_id', 'company type', 'trim|required|is_natural_no_zero', [
            'is_natural_no_zero' => 'Please Select Company Type'
        ]);

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function _rules_company(){
        $this->form_validation->set_rules('first_name', 'first name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('last_name', 'last name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('company_name', 'company name', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('org_type_id', 'company type', 'trim|required|is_natural_no_zero', [
            'is_natural_no_zero' => 'Please Select Company Type'
        ]);
        $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]|max_length[20]');
        $this->form_validation->set_rules('your_email', 'email', 'trim|valid_email|required|max_length[80]|is_unique[users.email]',
                [ 'is_unique' => 'This email already in used', 'valid_email' => 'Enter a valid email address']);

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function _rules(){
        $this->form_validation->set_rules('first_name', 'first name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('last_name', 'last name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]|max_length[20]');
        $this->form_validation->set_rules('your_email', 'your email', 'trim|valid_email|required|max_length[80]|is_unique[users.email]',
            [ 'is_unique' => 'This email already in used', 'valid_email' => 'Enter a valid email address']);

        $this->form_validation->set_rules('role_id', 'role_id', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function image_upload($photo, $id = 0) {
        $handle = new \Verot\Upload\Upload($photo);
        if ($handle->uploaded) {
            $prefix                     = $id;
            $handle->file_new_name_body = 'user_photo';
            $handle->image_resize       = true;
            $handle->image_x            = 400;
            $handle->image_ratio_y      = true;
            $handle->allowed            = array(
                'image/jpeg', 
                'image/jpg', 
                'image/gif', 
                'image/png', 
                'image/bmp'
            );
            $handle->file_new_name_body = uniqid($prefix) . '_' . md5(microtime()) . '_' . time();           
            $handle->process( 'uploads/users_profile/');           
            $handle->processed;
            return $receipt_img = $handle->file_dst_name;
        }
    }
    
                   
    public function _menu() {
        return buildMenuForMoudle([
            'module' => 'Recruiter/User',
            'icon' => 'fa-users',
            'href' => 'users',
            'children' => [
                [
                    'title' => 'All User',
                    'icon' => 'fa fa-circle-o',
                    'href' => 'users'
                ],[
                    'title' => ' + Add New User',
                    'icon' => 'fa fa-circle-o',
                    'href' => 'users/create'
                ],[
                    'title' => ' + Add New Recruiter',
                    'icon' => 'fa fa-circle-o',
                    'href' => 'users/create_company'
                ],[
                    'title' => 'Role / ACL',
                    'icon' => 'fa fa-circle-o',
                    'href' => 'users/roles'
                ],[
                    'title' => 'Logins Log',
                    'icon' => 'fa fa-list',
                    'href' => 'users/login_history'
                ],[
                    'title' => 'Logins Graph VIew',
                    'icon' => 'fa fa-pie-chart',
                    'href' => 'users/login_history/graph'
                ]
            ]
        ]);
    }
               
    public function password( $id ){  
        
        $row = $this->Users_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id'            => $row->id,
                'first_name'    => $row->first_name,
                'last_name'     => $row->last_name,
                'email'         => $row->email,
                'password'      => $row->password,
                'status'        => $row->status
            );
            $this->viewAdminContent('users/users/password', $data);
        } else {
            $this->session->set_flashdata('message', '<p class="ajax_error">Record Not Found</p>');
            redirect( site_url( Backend_URL . 'users') );
        }        
    }
    
    public function reset_password(){
        ajaxAuthorized();
        $user_id  = intval( $this->input->post('user_id') );
        $new_pass = $this->input->post('new_pass');
        $con_pass = $this->input->post('con_pass');
                        
        if ($new_pass != $con_pass) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Confirm Password Not Match</p>');                
            exit;
        }
     
        $hass_pass = password_encription( $new_pass ); 
        
        $this->db->set('password', $hass_pass);
        $this->db->where('id', $user_id);
        $this->db->update('users');
        echo ajaxRespond('OK', '<p class="ajax_success">Password Reset Successfully</p>');                  
    }
   
    
    
}
