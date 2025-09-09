<?php defined('BASEPATH') OR exit('No direct script access allowed');

function packageHtmlRadio($name = 'input_radio', $selected = 0, $type = 'Event') {
    $radio = '';
    $id = 0;
    $ci = & get_instance();
    $array = $ci->db->get_where('packages', ['type' => $type])->result();
    // $radio .= '<div style="padding-top:8px;">';
//    dd($array);
    if (count($array)) {
        foreach ($array as $value) {
            $id++;
            $radio .= '<label>';
            $radio .= '<input type="radio" name="' . $name . '" id="' . $name . '_' . $id.'" ';
            $radio .= ( trim($selected) == $value->id) ? ' checked ' : '';
            $radio .= 'value="'.$value->id.'"/>&nbsp;' . $value->name;
            $radio .= '&nbsp;&nbsp;&nbsp;</label><br/>';
        }
    }
    // $radio .= '</div>';
    return $radio;
}