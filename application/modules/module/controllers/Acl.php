<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2016-11-14
 */

class Acl extends Admin_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Acl_model');       
        $this->load->library('form_validation');
    }

    public function index(){
        $acls = $this->Acl_model->get_all();
        $data = ['acls_data' => $acls];
        $this->viewAdminContent('module/acl/index', $data);
    }

    public function read($id){
        $row = $this->Acl_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'module_id' => $row->module_id,
		'permission_name' => $row->permission_name,
		'permission_key' => $row->permission_key,		
	    );
            $this->viewAdminContent('module/acl/view', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'module/acl'));
        }
    }

    public function create(){
        $data = array(
            'button' => 'Create',
            'update' => 'No',
            'action' => site_url( Backend_URL . 'module/acl/create_action'),
	    'id' => set_value('id'),
	    'module_id' => set_value('module_id'),
	    'permission_name' => set_value('permission_name'),
	    'permission_key' => set_value('permission_key'),
	    'order_id' => set_value('order_id'),
	);
        $this->viewAdminContent('module/acl/form', $data);
    }
    
    public function create_action(){                
        
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'module_id'         => $this->input->post('module_id',TRUE),
                'permission_name'   => $this->input->post('permission_name',TRUE),
                'permission_key'    => $this->input->post('permission_key',TRUE),
                'order_id'          => $this->input->post('order_id',TRUE),
            );

            $this->db->trans_start();
            $acl_id = $this->Acl_model->insert($data);
            
            $this->db->insert('role_permissions', array(
                'role_id'   => 1,
                'acl_id'    => $acl_id,
                'access'    => 1
            ));
             $this->db->trans_complete();
            
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url( Backend_URL. 'module/acl'));
        }
    }
    
    public function update($id){
        $row = $this->Acl_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'update' => 'Yes',
                'action' => site_url( Backend_URL . 'module/acl/update_action'),
		'id' => set_value('id', $row->id),
		'module_id' => set_value('module_id', $row->module_id),
		'permission_name' => set_value('permission_name', $row->permission_name),
		'permission_key' => set_value('permission_key', $row->permission_key),
		'order_id' => set_value('order_id', $row->order_id),
	    );
            $this->viewAdminContent('module/acl/form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'module/acl'));
        }
    }
    
    public function update_action(){
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'module_id'         => $this->input->post('module_id',TRUE),
		'permission_name'   => $this->input->post('permission_name',TRUE),
		'permission_key'    => $this->input->post('permission_key',TRUE),
		'order_id'          => $this->input->post('order_id',TRUE),
	    );

            $this->Acl_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', '<p class="ajax_success">Update Record Success</p>');
            redirect(site_url( Backend_URL. 'module/acl'));
        }
    }
    
    public function delete($id){
        $row = $this->Acl_model->get_by_id($id);

        if ($row) {
            $this->Acl_model->delete($id);
            $this->db->where('acl_id', $id )->delete('role_permissions');
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url( Backend_URL. 'module/acl'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL. 'module/acl'));
        }
    }

    public function _rules(){
        
        $update = $this->input->post('update');
        
        if( $update == 'Yes' ){
            $this->form_validation->set_rules('permission_key', 'permission key', 'trim|required'); 
        } else {
            $this->form_validation->set_rules('permission_key', 'permission key', 'trim|required|is_unique[acls.permission_key]',[
                'is_unique' => 'ACL Key Already Exist'
            ]);
        }
        
	$this->form_validation->set_rules('module_id', 'module id', 'trim|required');
	$this->form_validation->set_rules('permission_name', 'permission name', 'trim|required');
        
	$this->form_validation->set_rules('order_id', 'order id', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
        
}