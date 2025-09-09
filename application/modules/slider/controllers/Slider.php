<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2019-10-05
 */

class Slider extends Admin_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Slider_model');
        $this->load->helper('slider');
        $this->load->library('form_validation');
    }

    public function index(){
        
        $start = intval($this->input->get('start'));
        
        $config['base_url'] = build_pagination_url( Backend_URL . 'slider/', 'start');
        $config['first_url'] = build_pagination_url( Backend_URL . 'slider/', 'start');

        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Slider_model->total_rows();
        $sliders = $this->Slider_model->get_limit_data();                
                
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'slides' => $sliders,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'sl' => 0,
        );
        $this->viewAdminContent('slider/slider/index', $data);
    }       

    public function create(){
        
        $data = array(
            'button' => 'Create',
            'action' => site_url( Backend_URL . 'slider/create_action'),
	    'id' => set_value('id'),	    
	    'title' => set_value('title'),
	    'caption' => set_value('caption'),
	    'thumb' => set_value('thumb'),
	);
        $this->viewAdminContent('slider/slider/create', $data);
    }
    
    public function create_action(){
       $photo = uploadSliderPhoto($_FILES['thumb'], 'uploads/cms/slider/', date('Y-m-d-H-i-s_') . rand(0, 9));

        $data = array(
            'user_id'       => $this->user_id,
            'parent_id'     => 0,
            'post_type'     => 'slide',
            'menu_name'     => '',
            'post_title'    => $this->input->post('title'),
            'post_url'      => uniqid('slide_'),
            'content'       => $this->input->post('content'),
            'seo_title'     => '',
            'seo_keyword'   => '',
            'seo_description' => '',
            'thumb'         => $photo,
            'template'      => '',
            'status'        => 'Publish',
            'page_order'    => 0,
            'created'       => date('Y-m-d H:i:s'),
            'modified'      => date('Y-m-d H:i:s'),
        );

        $this->db->insert('cms',$data);
        $this->session->set_flashdata('message', '<p class="ajax_success">Slider Added Successfully</p>');
        redirect(site_url( Backend_URL. 'slider' ));

    }

    public function update( $id ){
        $slide = $this->Slider_model->get_by_id( $id );
        $data = array(
            'button'    => 'Update',
            'action'    => site_url( Backend_URL . 'slider/update_action'),
	    'id'        => set_value('id', $slide->id ),	    
	    'title'     => set_value('title', $slide->post_title ),
	    'content'   => set_value('caption', $slide->content ),
	    'thumb'     => set_value('thumb', $slide->thumb ),
	);
        $this->viewAdminContent('slider/slider/update', $data);
    }
    
    public function update_action(){
        
        $photo      = uploadSliderPhoto($_FILES['thumb'], 'uploads/cms/slider/', date('Y-m-d-H-i-s_') . rand(0, 9));
        $id         =  (int) $this->input->post('id');        
        $data = array(            
            'post_title'    => $this->input->post('title'),
            'content'       => $this->input->post('content'),
            'thumb'         => $photo,
        );

        
        $old_slide = $this->input->post('old_slide');        
        if($photo){ removeSliderPhoto( $old_slide ); }        
        
        $this->db->where('id', $id );
        $this->db->update('cms',$data);
        $this->session->set_flashdata('message', '<p class="ajax_success">Slider Updated Successfully</p>');
        redirect(site_url( Backend_URL. 'slider' ));

    }
    
    public function delete(){
        ajaxAuthorized();
        $id = $this->input->post('id');
        $slide = $this->Slider_model->get_by_id( $id );
        if($slide){
            removeSliderPhoto($slide->thumb);
            $this->db->where('id',$id);
            $this->db->delete('cms');
            echo ajaxRespond('OK','Deleted');
        } else {
            echo ajaxRespond('Fail','Delete Fail');
        }   
        
    }
    
    
    public function reorder(){ 
        $items      = $this->input->post('item');
        $reorder    = array();
        $order_id = 0;
        foreach($items as $item){
            ++$order_id;
            $reorder[] = array(
                'id'        => $item,
                'page_order'=> $order_id,
            );
        }
        
        if($reorder){
            $this->db->update_batch('cms', $reorder, 'id');
            echo ('<p class="ajax_success">Reorder Saved Successfully</p>');
        } else {
            echo ('<p class="ajax_error">Fail! Nothing to save here.</p>');
        }
        
        
    }
    
    public function _menu(){
         return add_main_menu('Slider', 'admin/slider', 'slider', 'fa-photo');        
    }

    public function _rules(){
	$this->form_validation->set_rules('name', 'name', 'trim|required');
	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }  
    
    public function setStatus() {
        $id     = $this->input->post('id');
        $status = $this->input->post('status');
        
        
        $this->db->set('status', $status);
        $this->db->where('id', $id);
        $this->db->update('cms');
        if ($status == 'Draft') {
            echo ajaxRespond('OK', slideStatus('Draft', $id ) );            
        } else {
            echo ajaxRespond('OK', slideStatus('Publish', $id ) );
        }
    }
}