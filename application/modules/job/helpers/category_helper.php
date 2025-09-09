<?php defined('BASEPATH') OR exit('No direct script access allowed');

function categoryTabs($id, $active_tab)
{
    $html = '<ul class="tabsmenu">';
    $tabs = [
        'read' => 'Details',
        'update' => 'Update',
        'delete' => 'Delete',
    ];

    foreach ($tabs as $link => $tab) {
        $html .= '<li><a href="' . Backend_URL . "job/category/{$link}/{$id}\"";
        $html .= ($link == $active_tab) ? ' class="active"' : '';
        $html .= '>' . $tab . '</a></li>';
    }
    $html .= '</ul>';
    return $html;
}

function getJobCategoryDropDown($selected = 0) {
    $ci = & get_instance();
    $results = $ci->db->get('job_categories')->result();

    $options = '';
    foreach ($results as $result) {
        $options .= '<option value="' . $result->id . '" ';
        $options .= ($result->id == $selected ) ? 'selected="selected"' : '';
        $options .= '>' . $result->name . '</option>';
    }
    return $options;
}

function getJobSubCategoryDropDown($cat_id=0,$selected = 0) {
    $ci = & get_instance();
    $ci->db->where('category_id', $cat_id);
    $results = $ci->db->get('job_sub_categories')->result();
  
    $options = '<option value="0">-- Select Sub Category --</option>';
    foreach ($results as $result) {
        $options .= '<option value="' . $result->id . '" ';
        $options .= ($result->id == $selected ) ? 'selected="selected"' : '';
        $options .= '>' . $result->name . '</option>';
    }
    return $options;
}

function getJobCategoryName($id = 0) {
    $ci = & get_instance();
    $ci->db->select('name');
    $ci->db->where('id',$id);
    $category = $ci->db->get('job_categories')->row();
    return ($category) ? $category->name :  '--';
}

function getJobSubCategoryName($id = 0) {
    $ci = & get_instance();
    $ci->db->select('name');
    $ci->db->where('id',$id);
    $sub_cat = $ci->db->get('job_sub_categories')->row();
    return ($sub_cat) ? $sub_cat->name :  '--';
}
function getJobTypeName($id = 0) {
    $ci = & get_instance();
    $ci->db->select('name');
    $ci->db->where('id',$id);
    $type = $ci->db->get('job_types')->row();
    return ($type) ? $type->name :  '--';
}


function getJobBenefitName($ids = null) {
    if(is_null($ids)){ return '--'; }
    $b = [];
    $id = explode(',', $ids);
    $ci = & get_instance();
    $ci->db->select('name');
    $ci->db->where_in('id', $id);
    $benefits = $ci->db->get('job_benefits')->result();
    foreach($benefits as $ben){
        $b[] = $ben->name;
    }
    return implode(',&nbsp;', $b);
}
function getJobSkillsName($ids = null) {
    if(is_null($ids)){ return '--'; }
    $b = [];
    $id = explode(',', $ids);
    $ci = & get_instance();
    $ci->db->select('name');
    $ci->db->where_in('id', $id);
    $benefits = $ci->db->get('job_skills')->result();
    foreach($benefits as $ben){
        $b[] = $ben->name;
    }
    return implode(',&nbsp;', $b);
}

function getCategoryName($data,$id){
    return isset($data[$id]) ? $data[$id] : '--';
}