<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/* Author: Khairul Azam
 * Date : 2016-11-04
 */

class Widget extends Admin_controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Widget_model');
    }

    public function index() {
        
        $widgets = $this->Widget_model->get();   
        
        //dd( $widgets );
        
        $output = '';
        foreach($widgets as $widget){
            $output .= "<form method='post' id='{$widget->label}'>";
            $output .= '<fieldset>';
            $output .= "<legend>{$widget->label}</legend>";
            $output .= "<div id='respond_{$widget->label}'></div>";
            
            $output .= self::switchFormFiled($widget->field_type, $widget->label, $widget->value );
            
            
            $output .= '<div class="action-row">';
            $output .= "<button onclick=\"return save_widget('{$widget->label}');\" class=\"btn btn-xs pull-left btn-success\"><i class=\"fa fa-save\"></i> Save</button>";
            
            $output .= "<span onclick=\"return delete_widget('{$widget->label}');\"";
            $output .= ' class="btn btn-xs pull-right btn-danger"><i class="fa fa-times"></i> Detete</span>';
            
            $output .= '</div>';
            $output .= '</fieldset>';
            $output .= '</form>';
        }
        $data['output'] = $output;
        
        $this->viewAdminContent('cms/widget/index', $data );
    }
       
    public function add(){
        ajaxAuthorized();
        $type   = $this->input->post('type');
        $key    = $this->input->post('name_key');
        if(!$key){
            echo ajaxRespond('OK', '<p class="ajax_error">Please Put Valid Name Key</p>');
        }
        
        $data = [
            'category'      => 'Widget',
            'field_type'    => $type,
            'label'         => $key,        
            'value'         => ''        
        ];
     
        $this->db->insert('settings', $data );
        
        echo ajaxRespond('OK', '<p class="ajax_success">Chanages Saved Successfully</p>');
    }
    
    public function save(){
        ajaxAuthorized();
        $label = $this->input->post('label');        
        $content = $this->input->post('content');        
         
        $this->db->set('value', $content );
        $this->db->where('label', $label );
        $this->db->update('settings');
        
        echo ajaxRespond('OK', '<p class="ajax_success">Chanages Saved Successfully</p>');
    }
    
    public function delete(){
        $label = $this->input->post('label');
        $this->db->where('label', $label );
        $this->db->delete('settings');
        
        echo '<p class="ajax_success">Widget Deleted Successfully</p>';
    }
    
          
    public static function switchFormFiled( $field, $name,  $value = '' ){
        // 'Text','Textarea','HTML','JSON' 
        switch ($field){            
            case 'Textarea':
                return self::getTextarea($name, $value );
            case 'HTML':
                return self::getHtml($name, $value );
            default:
                return self::getTextfield($name, $value );                           
        }        
    }  
    
    
    private static function getTextfield( $name, $value ){        
        $filed = '<input name="label" value="'.$name.'" type="hidden"">';
        $filed .= '<input name="content" class="form-control" value="'.$value.'" type="text"">';
        return $filed;
    }
    
    private static function getTextarea( $name, $value ){    
        $filed = '<input name="label" value="'.$name.'" type="hidden"">';
        $filed .= '<textarea rows="5" name="content" class="form-control">'.$value. '</textarea>';
        return $filed;
    }
    
    private static function getHtml( $name, $value ){  
        $filed = '<input name="label" value="'.$name.'" type="hidden"">';
        $filed .= '<textarea rows="5" name="content" class="form-control">'.$value. '</textarea>';
        return $filed;
    }    
    
}
