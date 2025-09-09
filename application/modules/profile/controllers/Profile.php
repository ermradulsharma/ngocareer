<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 8th Oct 2016
 * Update: 11 Nov 2017
 */

class Profile extends Admin_controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Profile_model');
        $this->load->helper('Profile');
        $this->load->library('form_validation');
    }
    
    public function index() {
        $data   = $this->Profile_model->get_by_id($this->user_id);                        
        $this->viewAdminContent('profile/profile', $data);
    }
    
    public function update_action() {
        $data = array(
            'first_name'    => $this->input->post('first_name'),
            'last_name'     => $this->input->post('last_name'),
            'company_name'  => $this->input->post('company_name'),                                  
            'about_company' => $this->input->post('about_company'),
            'website'       => $this->input->post('website'),
            'org_type_id'   => (int) $this->input->post('org_type_id'),
            'contact'       => $this->input->post('contact'),                                  
            'add_line1'     => $this->input->post('add_line1'),            
            'add_line2'     => $this->input->post('add_line2'),            
            'city'          => $this->input->post('city'),            
            'state'         => $this->input->post('state'),            
            'postcode'      => $this->input->post('postcode'),
            'country_id'    => (int) $this->input->post('country_id'),                                 
        );
        if($_FILES['logo']['name']){
            $data['logo'] = $this->update_logo();
        }
        
        $this->Profile_model->update($this->user_id, $data);
        $this->session->set_flashdata('msgs', 'Profile Updated Successfully');
        redirect(Backend_URL . 'profile');
    }
    
    
    private function update_logo() {
        $photo  = '';
        $handle = new \Verot\Upload\Upload($_FILES['logo']);
        if ($handle->uploaded) {
            $handle->file_overwrite = true;
            $handle->file_new_name_body = uniqid( "{$this->user_id}_" );
            $handle->image_resize   = true;
            $handle->file_force_extension = true;
            $handle->file_new_name_ext = 'jpg';
            $handle->image_ratio    = true;
            $handle->image_x        = 350;
            $handle->image_y        = 350;
            $handle->jpeg_quality   = 100;            
            $handle->Process('uploads/profile/' . date('Y/m/'));
            $photo = stripslashes($handle->file_dst_pathname);            
            if ( $handle->processed ) {
                $handle->clean();
            }
        }  
        return $photo;
    }

  
    public function password() {
        $this->viewAdminContent('password');
    }

    public function update_password() {
        $old_pass = $this->input->post('old_pass');
        $new_pass = $this->input->post('new_pass');
        $con_pass = $this->input->post('con_pass');

        if (strlen($new_pass) < 4 ) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Password length min 6 character</p>');
            exit;
        }
        
        if ($new_pass != $con_pass) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Confirm Password Not Match</p>');
            exit;
        }
                
        $user = $this->db->select('password')
                ->where('id', $this->user_id)
                ->get('users')->row();
        $db_pass = $user->password;
        

        if( $user && password_verify($old_pass, $db_pass)) {
            
            $this->db->set('password', password_encription($new_pass) );
            $this->db->where('id', $this->user_id);
            $this->db->update('users');

            echo ajaxRespond('OK', '<p class="ajax_success">Password Reset Successfully</p>');
        } else {
            echo ajaxRespond('Fail', '<p class="ajax_error">Old Password not match, please try again.</p>');
        }
    }
      
    
  
    public function _menu() {
        return buildMenuForMoudle([
            'module' => 'My Account',
            'icon' => 'fa fa-puzzle-piece',
            'href' => 'profile',
            'children' => [
                [
                    'title' => 'Profile',
                    'icon' => 'fa fa-user',
                    'href' => 'profile'
                ],[
                    'title' => 'Change Password',
                    'icon' => 'fa fa-random',
                    'href' => 'profile/password'
                ]
            ]
        ]);
    }

}
