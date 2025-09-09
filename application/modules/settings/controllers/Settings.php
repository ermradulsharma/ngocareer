<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2016-11-17
 */

class Settings extends Admin_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Settings_model');
        $this->load->helper('settings');        
    }

    public function index(){
       
        $this->db->where('category', 'General');
        $data['settings'] = $this->db->get('settings')->result();
        $this->viewAdminContent('settings/index', $data);
    }
            
    public function update(){        
        ajaxAuthorized();        
        $settings = $this->input->post('data');                
        
        
        foreach($settings as $label=>$option ){
        
            $value = $option['value'];
            if ($option['type'] == 'JSON'){  
                    $value = json_encode($option['value']);
            }
            
            $this->db->set('value', $value);
            $this->db->where('label', $label);            
            $this->db->update('settings');
        }
        echo ajaxRespond('OK', '<p class="ajax_success"> <b>Settings!</b> Saved Successfully.</p>');        
    }
}