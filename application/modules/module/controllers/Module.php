<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 2016-10-20
 */

class Module extends Admin_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Module_model');
        $this->load->helper('modules');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = Backend_URL . 'module/?q=' . urlencode($q);
            $config['first_url'] = Backend_URL . 'module/?q=' . urlencode($q);
        } else {
            $config['base_url'] = Backend_URL . 'module/';
            $config['first_url'] = Backend_URL . 'module/';
        }

        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Module_model->total_rows($q);
        $module = $this->Module_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'module_data' => $module,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->viewAdminContent('module/module/index', $data);
    }

    public function read($id)
    {
        $row = $this->Module_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'added_date' => $row->added_date,
                'order' => $row->order,
                'type' => $row->type,
                'name' => $row->name,
                'folder' => $row->folder,
                'description' => $row->description,
                'status' => $row->status,
            );
            $this->viewAdminContent('module/module/view', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(Backend_URL . 'module'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Add',
            'action' => site_url(Backend_URL . 'module/create_action'),
            'id' => set_value('id'),
            'added_date' => set_value('added_date'),
            'order' => set_value('order'),
            'type' => set_value('type'),
            'name' => set_value('name'),
            'folder' => set_value('folder'),
            'description' => set_value('description'),
            'status' => set_value('status'),
        );
        $this->viewAdminContent('module/module/form', $data);
    }

    private function add_module_acls($get_string = false, $module_id = 0)
    {
        if ($get_string == false) {
            return false;
        }

        $string = strtolower($get_string);

        $data = array(
            array(
                'permission_name' => ucfirst($string),
                'permission_key' => $string
            ), array(
                'permission_name' => ucfirst($string) . ' create',
                'permission_key' => $string . '/create'
            ), array(
                'permission_name' => ucfirst($string) . '/save create action',
                'permission_key' => $string . '/create_action'
            ), array(
                'permission_name' => ucfirst($string) . '/update',
                'permission_key' => $string . '/update'
            ), array(
                'permission_name' => ucfirst($string) . '/read',
                'permission_key' => $string . '/read'
            ), array(
                'permission_name' => ucfirst($string) . '/delete',
                'permission_key' => $string . '/delete',
            ), array(
                'permission_name' => ucfirst($string) . '/update_action',
                'permission_key' => $string . '/update_action'
            )
        );

        foreach ($data as $row) {

            $permission_name = $row['permission_name'];
            $permission_key = $row['permission_key'];
            if ($module_id) {
                $this->db->insert('acls', ['module_id' => $module_id, 'permission_name' => $permission_name, 'permission_key' => $permission_key, 'order_id' => 0]);
                $acl_id = $this->db->insert_id();
                $this->add_permissions_to_developer($acl_id);
            }
        }

    }

    private function add_permissions_to_developer($acl_id = 0)
    {
        if ($acl_id) {
            $this->db->insert('role_permissions', ['role_id' => 1, 'acl_id' => $acl_id, 'access' => 1]);
        }
    }


    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'added_date' => $this->input->post('added_date', TRUE),
                'order' => $this->input->post('order', TRUE),
                'type' => $this->input->post('type', TRUE),
                'name' => $this->input->post('name', TRUE),
                'folder' => $this->input->post('folder', TRUE),
                'description' => $this->input->post('description', TRUE),
                'status' => $this->input->post('status', TRUE),
            );

            $module_id = $this->Module_model->insert($data);

            $this->add_module_acls($this->input->post('folder', TRUE), $module_id);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url(Backend_URL . 'module'));
        }
    }

    public function update($id)
    {
        $row = $this->Module_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url(Backend_URL . 'module/update_action'),
                'id' => set_value('id', $row->id),
                'added_date' => set_value('added_date', $row->added_date),
                'order' => set_value('order', $row->order),
                'type' => set_value('type', $row->type),
                'name' => set_value('name', $row->name),
                'folder' => set_value('folder', $row->folder),
                'description' => set_value('description', $row->description),
                'status' => set_value('status', $row->status),
            );
            $this->viewAdminContent('module/module/form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(Backend_URL . 'module'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
                'added_date' => $this->input->post('added_date', TRUE),
                'order' => $this->input->post('order', TRUE),
                'type' => $this->input->post('type', TRUE),
                'name' => $this->input->post('name', TRUE),
                'folder' => $this->input->post('folder', TRUE),
                'description' => $this->input->post('description', TRUE),
                'status' => $this->input->post('status', TRUE),
            );

            $this->Module_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url(Backend_URL . 'module'));
        }
    }

    public function delete($id)
    {

        // DELETE FROM `role_permissions` WHERE `role_permissions`.`id` = 1374        
        // DELETE FROM `acls` WHERE `acls`.`id` = 2         
        // DELETE FROM `modules` WHERE `modules`.`id` = 15 

        $row = $this->Module_model->get_by_id($id);
        if ($row) {
            $this->db->select('id');
            $this->db->where('acls.module_id', $id);
            $prem_keys = $this->db->get('acls')->result();

            foreach ($prem_keys as $key) {
                $this->db->delete('role_permissions', array('acl_id' => $key->id));
            }

            $this->db->delete('acls', array('module_id' => $id));
            $this->Module_model->delete($id);
            $this->session->set_flashdata('message', '<p class="ajax_success">Delete Record Success</p>');
            redirect(site_url(Backend_URL . 'module'));
        } else {
            $this->session->set_flashdata('message', '<p class="ajax_error">Record Not Found</p>');
            redirect(site_url(Backend_URL . 'module'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('added_date', 'added date', 'trim|required');
        $this->form_validation->set_rules('order', 'order', 'trim|required');
        $this->form_validation->set_rules('type', 'type', 'trim|required');
        $this->form_validation->set_rules('name', 'name', 'trim|required');
        $this->form_validation->set_rules('folder', 'folder', 'trim|required');
        $this->form_validation->set_rules('status', 'status', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function menu()
    {
        return buildMenuForMoudle([
            'module' => 'Module Manager',
            'icon' => 'fa fa-puzzle-piece',
            'href' => 'module',
            'children' => [
                [
                    'title' => 'Module List',
                    'icon' => 'fa fa-puzzle-piece',
                    'href' => 'module'
                ], [
                    'title' => 'Access Control List',
                    'icon' => 'fa fa-check-square-o',
                    'href' => 'module/acl'
                ]
            ]
        ]);
    }


}