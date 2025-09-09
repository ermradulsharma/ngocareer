<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_helper {
    public static function switchFormFiled( $field, $name,  $value = '' ){
        // 'Text','Textarea','HTML','JSON' 
        $html = "<input name='data[{$name}][type]' value='{$field}' type='hidden'/>";
        switch ($field){  
            case "Text":
                $html .= self::getTextfield($name, $value );
                break;
            case "Radio":
                $html .= self::getRadiobox($name, $value );
                break;
            case "Textarea":
                $html .= self::getTextarea($name, $value );
                break;
            case "HTML":
                $html .= self::getHTML($name, $value );
                break;                        
            case "JSON":
                $html .= self::getJSON($name, $value );
                break;
            case "Currency":
                $html .= self::getCurrency($name, $value );
                break;
            default:
                $html .= self::getTextfield($name, $value );                           
        }   
        return $html;
    }

    private static function getCurrency($name, $selected = '&pound'){
        $codes = [
            '&pound'    => "&pound; GBP",
            '&dollar'   => "&dollar; USD",
            '&nira'     => "&#x20A6; NGN"
        ];

        $row = '<select name="data['.$name.'][value]" class="form-control">';
        foreach( $codes as $key=>$option){
            $row .= '<option value="'. htmlentities($key).'"';
            $row .= ($selected == $key) ? ' selected' : '';
            $row .= '>'. $option.'</option>';
        }
        $row .= '</select>';
        return $row;
    }
    
    private static function getTextarea( $name, $value ){        
        return '<textarea rows="5" name="data['.$name.'][value]" class="form-control">'.$value. '</textarea>';
    }
    
    private static function getHTML( $name, $value ){        
        return '<textarea rows="5" name="data['.$name.'][value]" class="form-control">'.$value. '</textarea>';
    }
    
    private static function getRadiobox( $name, $value ){        
        $html = '';  
        
        $options = [
            'Yes'   => 'Yes', 
            'No'    => 'No', 
        ];
        
        foreach($options as $key => $option ){                        
            $html .= '<label class="radio-inline">';
            $html .= '<input value="'.$key.'" type="radio" name="data['.$name.'][value]"';
            $html .= ($value == $key ) ? ' checked ' : '';
            $html .= "> &nbsp;{$option} &nbsp;&nbsp;</label>";
        }
        return $html;
    }
    
    private static function getJSON( $name, $json ){   
        $options = json_decode($json, true);
        $html = '';        
        foreach($options as $key => $value ){   
            $fa_icon = strtolower($key);
            $html .= '<div class="input-group" style="margin-bottom:5px; width:50%;">';
            $html .= "<span style=\"width:100px; text-align:left; background:#f9f9f9;\" class=\"input-group-addon\"><i class='fa fa-{$fa_icon}'></i> {$key}</span>";
            $html .= "<input name=\"data[{$name}][value][{$key}]\" value=\"{$value}\" type=\"text\" class=\"form-control\"/>";
            $html .= '</div>';
        }        
        return $html;
    }
    
    private static function getTextfield( $name, $value ){        
        return '<input name="data['.$name.'][value]" class="form-control" value="'.$value.'" type="text" id="'.$name.'">';
    }
    
    public static function splitSettings( $key = ''){               
        return preg_replace_callback('/(?<!\b)[A-Z][a-z]+|(?<=[a-z])[A-Z]/', function($match) {
            return ' '. $match[0];
        }, $key);
    }     
}