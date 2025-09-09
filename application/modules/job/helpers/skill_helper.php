<?php defined('BASEPATH') OR exit('No direct script access allowed');

function skillTabs($id, $active_tab)
{
    $html = '<ul class="tabsmenu">';
    $tabs = [
        'read' => 'Details',
        'update' => 'Update',
        'delete' => 'Delete',
    ];

    foreach ($tabs as $link => $tab) {
        $html .= '<li><a href="' . Backend_URL . "job/skill/{$link}/{$id}\"";
        $html .= ($link == $active_tab) ? ' class="active"' : '';
        $html .= '>' . $tab . '</a></li>';
    }
    $html .= '</ul>';
    return $html;
}

function getJobSkillsDropDown($selected = 0) {
    $ci = & get_instance();
    $results = $ci->db->get('job_skills')->result();

    $options = '';
    foreach ($results as $result) {
        $options .= '<option value="' . $result->id . '" ';
        if(!empty($selected)){
            $selected_array = explode(',', $selected);
            $options .= in_array($result->id, $selected_array) ? 'selected="selected"' : '';
        }
        $options .= '>' . $result->name . '</option>';
    }
    return $options;
}