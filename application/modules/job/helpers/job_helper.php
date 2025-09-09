<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function jobTabs($id, $active_tab)
{
    $html = '<ul class="tabsmenu">';
    $tabs = [
        'preview'   => '<i class="fa fa-file-text"></i> Preview',
        'applicants' => '<i class="fa fa-users"></i> Applicants',
        'update'    => '<i class="fa fa-edit"></i> Update',
        'archive'   => '<i class="fa fa-archive"></i> Archive',
        'payment_form'   => '<i class="fa fa-money"></i> Payment ',
    ];

    foreach ($tabs as $link => $tab) {
        $html .= '<li><a href="' . Backend_URL . "job/{$link}/{$id}\"";
        $html .= ($link == $active_tab ) ? ' class="active"' : '';
        $html .= '>' . $tab . '</a></li>';
    }
    $html .= '</ul>';
    return $html;
}

function viewApplication($id = 0)
{
    $ci = & get_instance();
    $ci->db->where('job_id', $id);
    return $ci->db->count_all_results('job_applications');
}


function googlePreviewLink( $id ){
    $ci =& get_instance();
    $ci->db->select('file');
    $ci->db->where('id', $id );
    $cv         = $ci->db->get('candidate_cv')->row();
    $cv_name    = ($cv) ? $cv->file : '404.doc';    
    $href       = site_url( "uploads/cv/{$cv_name}" );
    return "https://docs.google.com/viewer?url={$href}";
}

function applicantStatus( $status = null ){
    
    switch ($status){
        case 'Shortlisted':
            $cls = 'label-success';
            $rtn = 'Shortlisted';
            break;        
        case 'Rejected':
            $cls = 'label-danger';
            $rtn = 'Rejected';
            break;        
        default :
            $cls = 'label-info';
            $rtn = '<i class="fa fa-spinner fa-spin"></i> Pending';
            break;                
    }
    return "<span class=\"badge {$cls}\">{$rtn}</span>";
}