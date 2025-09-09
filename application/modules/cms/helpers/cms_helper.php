<?php

if (!defined('BASEPATH')) {    exit('No direct script access allowed'); }

function drawCategoryTree($categories, $parentID = 0, $level = 0) {
    $output = '<ul>';
    if (isset($categories[$parentID]) && count($categories[$parentID])) {
        foreach ($categories[$parentID] as $cat) {
            $output .= "<li>" . $cat['title'];
            $output .= "<ul>";
            $output .= drawCategoryTree($categories, $cat['id'], $level + 1);
            $output .= "</ul></li>";
        }
    }
    $output .= '</ul>';
    return $output;
}

function show_menu_tree($array, $curParent, $opt_id, $currLevel = 0, $prevLevel = -1) {
    $return = '';
    foreach ($array as $categoryId => $list) {
        if ($curParent == $list['parent_id']) {
            if ($list['parent_id'] == 0) {
                $class = "dropdown list-unstyled";
            } else {
                $class = "sub_menu";
            }
            if ($currLevel > $prevLevel) {
                $return .= "<ul class='{$class}'>";
            }
            if ($currLevel == $prevLevel) {
                $return .= '</li>';
            }
            $return .= '<li id="arrayorder_' . $list['id'] . '" class="pageslist" style="padding: 10px 0px;">
<span id="menu_' . $list['id'] . '">' . $list['id'] . ' - ' . ($list['title']) . '</span>
<span class="action pull-right">';
            // $checked = ($list['is_login'] == 1) ? 'checked="checked"' : '';
            $checked = '';
            $return .= '<label class="checkbox"><input type="checkbox" onclick="isLoginMenuItem(' . $list['id'] . ');" id="login_' . $list['id'] . '" ' . $checked . '> Is Login </label>';
            $return .= '<span class="btn btn-xs btn-warning" onclick="updateMenuForm(' . $list['id'] . ',' . '\'' . $list['obj_id'] . '\'' . ');"> <i class="fa fa-edit"></i></span>
<span class="btn btn-xs btn-danger" onclick="DeleteMenuItem(' . $list['id'] . ');"> <i class="fa fa-trash-o"></i></span>
</span>
</li>';
            if ($currLevel > $prevLevel) {
                $prevLevel = $currLevel;
            }
            $currLevel++;
            show_menu_tree($array, $categoryId, $opt_id, $currLevel, $prevLevel);
            $currLevel--;
        }
    }
    if ($currLevel == $prevLevel)
        $return .= " </li> </ul> ";
    return $return;
}

function showAvatar($type = 'no_image') {
    $CI = & get_instance();
    if ($type == 'no_image') {
        return base_url('asset/cms/img/avatar.png');
    }
    if ($type == 'male') {
        return base_url('asset/cms/img/avatar.png');
    }
    if ($type == 'female') {
        return base_url('asset/cms/img/avatar_female.png');
    }
}

function cmsStatus($selected = 'Draft') {
    $status = ['Publish' => 'Publish', 'Draft' => 'Draft', 'Trash' => 'Trash'];
    return selectOptions($selected, $status);
}

function getMenuOptionData($selected = 1) {
    $CI = & get_instance();
    $rows = $CI->db->get_where('cms_options', ['type' => 'menu'])->result();
    $options = '<option value="admin/cms/menu">--Please Select--</option>';
    foreach ($rows as $row) {
        $options .= "<option value=\"admin/cms/menu/?id={$row->id}\" ";
        $options .= ($row->id == $selected ) ? 'selected="selected"' : '';
        $options .= ">{$row->name}</option>";
    }
    return $options;
}
function getCMSStatus( $status = 'Active', $id = 0){
       
    switch ( $status ){
      
        case 'Publish': 
            $class = 'btn-success';
            $icon = '<i class="fa fa-check-square-o"></i> ';
            break;            
        case 'Draft':
            $class = 'btn-default'; 
            $icon = '<i class="fa fa-file-o" ></i> ';
            break;                             
        case 'Trash':
            $class = 'btn-danger';
            $icon = '<i class="fa fa-trash-o"></i> ';
            break;              
        default :
            $class = 'btn-default';
            $icon = '<i class="fa fa-info"></i> ';
    }  
    
    
    return '<button class="btn '. $class .' btn-xs" id="active_status_'. $id .'" type="button" data-toggle="dropdown">
            '. $icon . $status .' &nbsp; <i class="fa fa-angle-down"></i>
        </button>';
    
    
}
function isCheckCMSPageAccess($access_array_data = array(), $access_key = 0) {
    if (in_array($access_key, $access_array_data)) {
        return 'checked="checked"';
    }
}

function getPageTemplates($selected = '') {
    $folder = APPPATH . '/views/frontend/template/';
    if (!is_dir($folder)) {
        return false;
    }
    $templates = scandir($folder);
    $row = '<option value="0"> Default </option>';
    foreach ($templates as $template) {
        if (stripos($template, '.') > 0) {
            $row .= "<option value='{$template}'";
            $row .= ($selected == $template) ? ' selected="selected"' : '';
            $row .= '>' . substr($template, 0, -4) . '</option>';
        }
    }
    return $row;
}

function getCategoryTemplates($selected = '') {
    $folder = APPPATH . '/views/frontend/category/';
    if (!is_dir($folder)) {
        return false;
    }
    $templates = scandir($folder);
    foreach ($templates as $template) {
        if (stripos($template, '.') > 0) {
            $row .= "<option value='{$template}'";
            $row .= ($selected == $template) ? ' selected="selected"' : '';
            $row .= '>' . substr($template, 0, -4) . '</option>';
        }
    }
    return $row;
}

function caretoryParentIdByName($parent_id) {
    $CI = & get_instance();
    $catName = $CI->db->select('*')->get_where('cms_options', ['id' => $parent_id, 'type' => 'category'])->row();
    $count = $CI->db->where('id', $parent_id)->where('id', $parent_id)->count_all_results('cms_options');

    if ($count > 0) {
        return $catName->name;
    } else {
        echo 'Default';
    }
}

function getPageTree($parent_id = 0) {
    $ci = & get_instance();
    $ci->db->select('id,post_title,parent_id');
    $ci->db->from('cms');
    $ci->db->where('post_type', 'page');
    $ci->db->order_by('page_order', 'ASC');
    $result = $ci->db->get()->result();
    $pages = array();
    foreach ($result as $page) {
        $pages[$page->parent_id][] = array(
            'id' => $page->id,
            'title' => $page->post_title,
            'parent_id' => $page->parent_id
        );
    }
    return buildParentPageTree($pages, 0, 0, $parent_id);
}

function buildParentPageTree($array_data, $parentID = 0, $level = 0, $selected = 0) {
    $output = '';
    if (isset($array_data[$parentID]) && count($array_data[$parentID])) {
        foreach ($array_data[$parentID] as $child) {
            $output .= '<option value="' . $child['id'] . '"';
            $output .= ($selected == $child['id']) ? ' selected="selected">' : '>';
            $output .= bildPagentPageHelper($level);
            $output .= $child['title'];
            $output .= '</option>';
            $output .= buildParentPageTree($array_data, $child['id'], $level + 1, $selected);
        }
    }
    return $output;
}

function bildPagentPageHelper($label = 1) {
    if ($label == 1) {
        return '&nbsp;&nbsp;&nbsp;|_&nbsp;';
    } elseif ($label == 2) {
        return '&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;|_&nbsp;';
    } elseif ($label == 3) {
        return '&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;|_&nbsp;';
    } else {
        return '';
    }
}

//function slugify($text) {
//    $filter1 = strtolower(strip_tags(trim($text)));
//    $filter2 = html_entity_decode($filter1);
//    $filter3 = iconv('utf-8', 'us-ascii//TRANSLIT', $filter2);
//    $filter4 = preg_replace('~[^ a-z0-9_.]~', ' ', $filter3);
//    $filter5 = preg_replace('~ ~', '-', $filter4);
//    $return = preg_replace('~-+~', '-', $filter5);
//    if (empty($return)) {
//        return 'auto-' . time() . rand(0, 99);
//    } else {
//        return $return;
//    }
//}

function getCategoryDropDown($selected = 0, $level = 'Select Category') {
    $CI = & get_instance();
    $categories = $CI->db->select('id,name')->get_where('cms_options', ['type' => 'category'])->result();

    $row = '<option value="0">--- '.$level.' ---</option>';
    foreach ($categories as $category) {
        $row .= '<option value="' . $category->id . '"';
        $row .= ($selected == $category->id) ? ' selected' : '';
        $row .= '>' . $category->name . '</option>';
    }
    return $row;
}

function statusGroup($status, $id){
    $html = '<div class="dropdown">';
    $html .= getCMSStatus( $status, $id );
    $html .= '<ul class="dropdown-menu">';
    $html .= "<li><a onclick=\"statusUpdate({$id}, 'Publish');\"> <i class=\"fa fa-check\"></i> Publish</a></li>";
    $html .= "<li><a onclick=\"statusUpdate({$id}, 'Draft');\"> <i class=\"fa fa-ban\"></i> Draft</a></li>";
    $html .= "<li><a onclick=\"statusUpdate({$id}, 'Trash');\"> <i class=\"fa fa-trash-o\"></i> Trash</a></li>";
    $html .= '</ul>';
    $html .= '</div>';
    return $html;
}