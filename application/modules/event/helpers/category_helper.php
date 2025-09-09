<?php defined('BASEPATH') OR exit('No direct script access allowed');

function getEventCategoryDropDown($selected = 0, $level = 'Select Category') {
    $ci = & get_instance();
    $results = $ci->db->get('event_categories')->result();

    $options = '<option value="0">-- '.$level.' --</option>';
    foreach ($results as $result) {
        $options .= '<option value="' . $result->id . '" ';
        $options .= ($result->id == $selected ) ? 'selected="selected"' : '';
        $options .= '>' . $result->name . '</option>';
    }
    return $options;
}