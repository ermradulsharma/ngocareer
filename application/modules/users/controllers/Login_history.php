<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 2017-08-01
 */

class Login_history extends Admin_controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Login_history_model');
        $this->load->helper('login_history');
        $this->load->library('form_validation');
    }

    public function index() {
        $most_login = urldecode($this->input->get('most_login', TRUE));
        $device = urldecode($this->input->get('device', TRUE));
        $browser = urldecode($this->input->get('browser', TRUE));
        $role_id = (int) $this->input->get('role_id');

        $range = urldecode($this->input->get('range', TRUE));
        $fd = ($this->input->get('fd', TRUE));
        $td = ($this->input->get('td', TRUE));

        $start = intval($this->input->get('start'));
        $most = ($this->input->get('most_login')) ? 'yes' : 'no';



        $config['base_url'] = build_pagination_url(Backend_URL . 'users/login_history/', 'start');
        $config['first_url'] = build_pagination_url(Backend_URL . 'users/login_history/', 'start');



        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Login_history_model->total_rows($most_login, $browser, $device, $role_id, $range, $fd, $td);
        $logins = $this->Login_history_model->get_limit_data($config['per_page'], $start, $most_login, $browser, $device, $role_id, $range, $fd, $td);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'logins' => $logins,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'most' => $most,
        );
        $this->viewAdminContent('login_history/index', $data);
    }

    public function graph() {

        $this->db->select('*, COUNT(id) as count');
        $this->db->from('user_logs');
        $this->db->group_by('browser');
        $browsers = $this->db->get()->result();

        $this->db->select('role_id,browser, id, COUNT(id) as role');
        $this->db->from('user_logs');
        $this->db->group_by('role_id');
        $roles = $this->db->get()->result();



        $this->db->select('device, COUNT(id) as devices');
        $this->db->from('user_logs');
        $this->db->group_by('device');
        $devices = $this->db->get()->result();



        $data['browsers'] = $browsers;
        $data['roles'] = $roles;
        $data['devices'] = $devices;

        $this->viewAdminContent('login_history/graph_view', $data);
    }

    public function getChart() {
        $day = [];
        for ($i = -15; $i <= 0; $i++) {
            $day[] = date('d M y', strtotime("+$i days "));
        }
        return json_encode($day);
    }

    public function getChartVendor() {
        $data = [];
        for ($i = -15; $i <= 0; $i++) {

            $date = date('Y-m-d', strtotime("+$i day "));
            $data[] = $this->countLoginVendor(3, $date);
        }
        return json_encode($data);
    }

    private function countLoginVendor($role_id = 0, $date = '0000-00-00') {

        $this->db->where('role_id', $role_id);
        $this->db->where('login_time <=', $date . ' 23:59:59');
        $this->db->where('login_time <=', $date . ' 23:59:59');
        return $this->db->get('user_logs')->num_rows();
    }

    public function getChartCustomer() {
        $data = [];
        for ($i = -15; $i <= 0; $i++) {

            $date = date('Y-m-d', strtotime("+$i days "));
            $data[] = $this->countLoginVendor(4, $date);
        }
        return json_encode($data);
    }

    public function bulk_action() {

        ajaxAuthorized();

        $log_ids = $this->input->post('log_id', TRUE);
        $action = $this->input->post('action', TRUE);

        if (count($log_ids) == 0 or empty($action)) {
            $message = '<p class="ajax_error">Please select at least one item and action.</p>';
            echo ajaxRespond('Fail', $message);
            exit;
        }

        switch ($action) {
            case 'Delete':
                $this->deleteLogs($log_ids);
                $message = '<p class="ajax_success">Marked Log Deleted Successfully</p>';
                break;
        }
        echo ajaxRespond('OK', $message);
    }

    private function deleteLogs($log_ids = []) {
        foreach ($log_ids as $log_id) {
            $this->db->where('id', $log_id);
            $this->db->delete('user_logs');
        }
    }

    public function delete(){
        ajaxAuthorized();
        $id = (int) $this->input->post('id');
        $user_id = (int) $this->input->post('user');
        $most = $this->input->post('most');
        
        if($most == 'yes'){
            $this->db->where('user_id', $user_id );            
        } else {
            $this->db->where('id', $id );
        }
        $this->db->delete('user_logs');
        
                        
        echo ajaxRespond('OK', '<p class="ajax_success">Delete Record Success</p>');        
    }

}
