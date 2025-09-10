<?php

/**
 * Description of Admin_controller
 *
 * @author Kanny
 */

class Admin_controller extends MX_Controller
{

    protected $user_id;
    protected $role_id;

    public function __construct()
    {
        parent::__construct();

        $this->load->library('user_agent');
        $this->load->helper('security');
        $this->load->helper('acl_helper');
        $this->load->model('module/Acl_model', 'acls');

        $this->user_id  = (int) getLoginUserData('user_id');
        $this->role_id  = (int) getLoginUserData('role_id');

        // if ($this->isActiveAccount() == false) {
        //     redirect(base_url('auth/logout'), 'refresh');
        // }
        if ($this->user_id <= 0) {
            redirect(site_url('recruiter'));
        }
        $this->set_admin_prefix($this->uri->uri_string());
    }

    private function isActiveAccount()
    {
        $this->db->select('status');
        $this->db->where('id', $this->user_id);
        $user = $this->db->get('users')->row();

        return ($user && $user->status == 'Active') ? true : false;
    }

    private function check_access($string = 'dashboard')
    {
        // $backend_uri = 'admin'; // prefix no need to touch        
        $controller = empty($this->uri->segment(2)) ? $string : $this->uri->segment(2);
        $method     = empty($this->uri->segment(3)) ? '' : '/' . $this->uri->segment(3);
        $access_key = $controller . $method;
        return $this->acls->checkPermission($access_key, $this->role_id);
    }

    private function set_admin_prefix($string = '/')
    {
        if ($this->uri->segment(1) != 'admin') {
            redirect(site_url('admin') . '/' . $string);
        };
    }

    public function viewAdminContent($view, $data = [])
    {
        if ($this->input->is_ajax_request()) {
            $this->load->view($view, $data);
        } else {
            $this->load->view('backend/layout/header');
            $this->load->view('backend/layout/sidebar');
            //            pp($view);
            if ($this->check_access($view)) {
                $this->load->view($view, $data);
            } else {
                $this->load->view('backend/restrict');
            }
            $this->load->view('backend/layout/footer');
        }
    }
}
