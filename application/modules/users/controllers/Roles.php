<?php

class Roles extends Admin_controller {
    
     function __construct() {
        parent::__construct();        
        $this->load->library('form_validation');       
        $this->load->helper('users');
    }

    
    public function index() {      
        
        if($this->role_id != 1){  $this->db->where('roles.id !=', 1); }
        
        $roles_data = $this->db
                        ->select('roles.*, count(users.role_id) as totalUser')
                        ->from('roles')
                        ->join('users', 'users.role_id = roles.id', 'left')
                        ->group_by('roles.id')                        
                        ->get()
                        ->result();
        
        $this->viewAdminContent('users/roles', ['roles_data' => $roles_data]);
    }

    public function create() {
        // only Ajax method support 
        // else will return forbidden message
        ajaxAuthorized();
                        
        $role_name = $this->input->post('role_name');
        
        if (empty($role_name)) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Please enter role name</p>' );
        } else {
            $new_role = [
                'role_name' => $role_name,
                'status'    => 'Unlocked'
            ];
            $this->db->insert('roles', $new_role);         
            echo ajaxRespond('OK', '<p class="ajax_success">New Role Created Successfully</p>');
        }               
    }
   

    // edit role form
    public function rename() {
        ajaxAuthorized();
        $id = $this->input->post('id');
        $role = $this->db->get_where('roles', ['id' => $id])->row();
        
               
        echo '<form action="'. Backend_URL .'users/roles/update" class="form-inline" method="POST" id="update_form">
            <div class="form-group">
            <input name="id" value="'. $id .'" type="hidden">
            <input class="form-control" name="role_name" value="' . $role->role_name . '" type="text"></div>
            <button class="btn btn-success btn-sm" onclick="update_role(' . $id . ')" type="button" >Save</button>
        </form>';
        
    }

    // update role form
    public function update() {
        // Ajax Access Only 
        // Direct access Disallow 
        ajaxAuthorized();
        
        $role_name  = $this->input->post('role_name');
        $id         = $this->input->post('id');
        $data       = [ 'role_name' => $role_name ];
        
        $this->db->update('roles', $data, ['id' => $id ]);              
        echo ajaxRespond('OK', '<span style="color:green"><i class="fa fa-check-square-o"></i></span> '. $role_name );
    }

    // role ID  delete
    public function delete() {
        ajaxAuthorized();
        if($this->input->post('id') == true){
            $id = $this->input->post('id');
            $this->db->delete('roles', ['id' => $id]);
            echo ajaxRespond('OK','Role Deleted Successfully');
        } else {
            echo ajaxRespond('Fail', 'Forbiden! Unknown Access');
        }
        
    }

    public function getAcl() {
        ajaxAuthorized();
        //sleep(1);
        $role_id = $this->input->post('id');
        
        $acls = $this->db->select('acls.*, modules.name')
                        ->from('acls')
                        ->join('modules', 'modules.id = acls.module_id')
                        ->order_by('module_id', 'asc')
                        ->get()->result();
        $re_arranged = [];
        foreach ($acls as $acl) {
            $re_arranged[$acl->module_id]['module'] = $acl->module_id;
            $re_arranged[$acl->module_id]['module_name'] = $acl->name;
            $re_arranged[$acl->module_id]['moulde_acls'][] = $acl;
        }
        //echo '<div class="js_update_respond"></div>';
        echo '<div class="all_check"><label><input type="checkbox" name="checkall" onclick="checkedAll();"> Mark All Access Key - for <b>'. getRoleName( $role_id ) .'</b> Role</label></div>';        
        echo Users_helper::getModules($re_arranged, $role_id);        
    }

    // Role access permission 
    public function update_acl() {
        ajaxAuthorized();       
        
        $acls   = $this->input->post('acl_id');
        
        if(empty($acls)){  
            echo ajaxRespond('Fail', 'Empty Data');
            exit;
        }
        
        $roleID = $this->input->post('role_id');
        
        // trans start
        $this->db->trans_begin();   
        $permissions = [];

        foreach ($acls as $acl) {
            $permissions[] = [
                'role_id'   => $roleID,
                'acl_id'    => $acl
            ];
        }

        $this->db->delete('role_permissions', ['role_id' => $roleID]);
        $this->db->insert_batch('role_permissions', $permissions);
        
        // trans confirmation
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            echo ajaxRespond('Fail', '<div class="alert alert-danger" role="alert"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Fail! Try again</div>'); 
        } else {
            $this->db->trans_commit();
            echo ajaxRespond('OK', '<div class="alert alert-success" role="alert"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Update Successfully</div>');
        } 
        
    }
    
    
    
}