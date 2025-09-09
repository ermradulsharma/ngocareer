<?php
if (!defined('BASEPATH')) {    exit('No direct script access allowed'); }

function selectable_menu_tree($pages, $curParent, $currLevel = 0, $prevLevel = -1) {
    $pagesOut = '';
    foreach ($pages as $page_id => $page) {
        if ($curParent == $page['parent_id']) {
            if ($page['parent_id'] == 0){
                $class = "dropdown list-unstyled";
            } else {
                $class = "ssub_menu";
            }
            if ($currLevel > $prevLevel){
                $pagesOut .= "<ul class='{$class}' style='padding-left: 20px;'>";
            }
            $pagesOut .= ($currLevel == $prevLevel) ? '</li>' : '';
            $pagesOut .= '<li><label>';
            $pagesOut .= "<input class=\"page\" type=\"checkbox\" name=\"page_ids[]\" value=\"{$page_id}\" id=\"data_{$page_id}\"> ";
            $pagesOut .= $page['title'] . '</label></li>';
            if ($currLevel > $prevLevel) {
                $prevLevel = $currLevel;
            }
            $currLevel++;
            $pagesOut .= selectable_menu_tree($pages, $page_id, $currLevel, $prevLevel);
            $currLevel--;
        }
    }
    $pagesOut .= ($currLevel == $prevLevel) ? "</li></ul>" : '';
    return $pagesOut;
}


function getMenuPages($pages, $parentID = 0, $level = 0) {
    $output = '';
    if (isset($pages[$parentID]) && count($pages[$parentID])) {
        foreach ($pages[$parentID] as $cat) {
            $output .= "<li class=\"dd-item\" data-id=\"{$cat['id']}\">\r\n";

            $output .= "\t\t<div id=\"{$cat['id']}\" class=\"dd-handle\">{$cat['title']}</div>\r\n";
            
            $output .= '<div class="dd-action">';
            $output .= "<span class='btn btn-xs btn-primary item_edit' data-id=\"{$cat['id']}\"><i class='fa fa-edit'></i></span>";
            $output .= " <span class='btn btn-xs btn-danger remove_menu_item' data-id=\"{$cat['id']}\"><i class='fa fa-times'></i></span>";            
            $output .= '</div>';

            $output .= '<ol class="dd-list">';
            $output .= getMenuPages($pages, $cat['id'], $level + 1);
            $output .= '</ol>' . "\r\n";

            $output .= "\t</li>" . "\r\n";
        }
    }    
    return $output;
}

function selectable_category_menu_tree($categories, $curParent, $currLevel = 0, $prevLevel = -1) {
    $categoriesOut = '';
    foreach ($categories as $category_id => $category) {
        if ($curParent == $category['parent_id']) {
            if ($category['parent_id'] == 0){
                $class = "dropdown list-unstyled";
            } else {
                $class = "ssub_menu";
            }
            if ($currLevel > $prevLevel){
                $categoriesOut .= "<ul class='{$class}' style='padding-left: 20px;'>";
            }
            $categoriesOut .= ($currLevel == $prevLevel) ? '</li>' : '';
            $categoriesOut .= '<li><label>';
            $categoriesOut .= "<input class=\"cat\" type=\"checkbox\" name=\"category_ids[]\" value=\"{$category_id}\" id=\"data_{$category_id}\"> ";
            $categoriesOut .= $category['title'] . '</label></li>';
            if ($currLevel > $prevLevel) {
                $prevLevel = $currLevel;
            }
            $currLevel++;
            $categoriesOut .= selectable_category_menu_tree($categories, $category_id, $currLevel, $prevLevel);
            $currLevel--;
        }
    }
    $categoriesOut .= ($currLevel == $prevLevel) ? "</li></ul>" : '';
    return $categoriesOut;
}