<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function get_banner_thumb__new($post_id) {
    $result = mysql_fetch_array(mysql_query("SELECT `thumb` FROM `cms_content` WHERE `post_id` = '$post_id'"));

    if(empty($result['thumb'])) {
        print '<img src="'. ImageResize . BannerDir . 'no-thumb.gif&w=120px&h=100&zc=1" alt="Thumb"/>';
    } else {
        print '<img src="'. ImageResize . BannerDir . $result['thumb']. '&w=120px&h=100&zc=1" alt="Thumb"/>';
    }
}

function uploadSliderPhoto($FILE = array(), $path = '', $name = '') {
    $handle = new Verot\Upload\Upload($FILE);
    if ($handle->uploaded) {
        $handle->file_new_name_body = $name;
        $handle->file_force_extension = true;
        $handle->file_new_name_ext = 'jpg';
        $handle->process($path);
        if ($handle->processed) {
            return stripslashes($handle->file_dst_pathname);
        } else {
            return '';
        }
    }
    return '';
}

function removeSliderPhoto($photo = null) {
    $filename = dirname(APPPATH) . "/{$photo}";
    if ($photo && file_exists($filename)) {
        unlink($filename);
    }
    return TRUE;
}

function getSlideShow(){
    $ci =& get_instance();
    $ci->db->select('post_title,thumb');
    $ci->db->from('cms');        
    $ci->db->order_by('page_order', 'ASC');        
    $ci->db->where('post_type','slide');
    $ci->db->where('status','Publish');
    $slides =  $ci->db->get()->result();
    
    $pointer = '<ol class="carousel-indicators">';
    $sl = 0;
    foreach($slides as $slide ){    
        $active = ($sl == 0 ) ? 'class="active"' : '';
        $pointer .= "<li data-target=\"#myCarousel\" data-slide-to=\"{$sl}\" {$active}></li> ";
        ++$sl;                
    }
    $pointer .= '</ol>';
    
    $banners = '<div class="carousel-inner">';
    $sl2 = 0;
    foreach($slides as $slide ){    
        $active = ($sl2 == 0 ) ? 'active' : '';
        $banners .= "<div class=\"item {$active}\">";
        $banners .=     "<img class=\"img-responsive\" src=\"{$slide->thumb}\">";
        $banners .= "</div>";
        ++$sl2;
    }
    $banners .= '</div>';  
    
    
    $control = '<a style="background-image: none; cursor: pointer;" class="carousel-control left" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>

                <a style="background-image: none; cursor: pointer;" class="carousel-control right" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>';
    return $pointer . $banners . $control;            
}

function slideStatus($status = 'Publish', $id = 0) {
        switch ($status) {
            case 'Publish':
                // 
                $return = '<span class="btn btn-success btn-xs" onclick="setStatus(\'Draft\', '.$id.' );"> <i class="fa fa-check-square"></i> Publish</span>';
                break;
            case 'Draft':
                $return = '<span class="btn btn-danger btn-xs"  onclick="setStatus(\'Publish\', '.$id.' );"> <i class="fa fa-ban"></i> Draft</span>';
                break;            
            default:
                $return = '<span class="btn btn-danger btn-xs"  onclick="setStatus(\'Publish\', '.$id.' );"> <i class="fa fa-ban"></i> Draft</span>';
                break;
        }
        return $return;
    }
