<?php defined('BASEPATH') or exit('No direct script access allowed');

function candidateTabs($id, $active_tab)
{
    $html = '<ul class="tabsmenu">';
    $tabs = [
        'read' => 'Details',
        'update' => 'Update',
        'delete' => 'Delete',
    ];

    foreach ($tabs as $link => $tab) {
        $html .= '<li><a href="' . Backend_URL . "candidate/{$link}/{$id}\"";
        $html .= ($link == $active_tab) ? ' class="active"' : '';
        $html .= '>' . $tab . '</a></li>';
    }
    $html .= '</ul>';
    return $html;
}

function getCandidatePhoto($picture = null ){
    $supported_image = ['gif','jpg','jpeg','png'];
    $src_file_name = $picture;

    $ext = strtolower(pathinfo($src_file_name, PATHINFO_EXTENSION));
    if (!is_null($picture) && !in_array($ext, $supported_image)) {
        return $picture;
    }

    $filename = dirname(BASEPATH) . "/{$picture}";
    if ($picture && file_exists($filename)) {
        return $picture;
    } else {
        return 'uploads/no-photo.jpg';
    }
}

function candidateStatusSet( $status = 'Active', $id = 0){
    switch ( $status ){
        case 'Pending':
            $class = 'btn-warning';
            $icon = '<i class="fa fa-hourglass-1"></i> ';
            break;
        case 'Active':
            $class = 'btn-success';
            $icon = '<i class="fa fa-check-square-o"></i> ';
            break;
        case 'Inactive':
            $class = 'btn-danger';
            $icon = '<i class="fa fa-ban"></i> ';
            break;
        default :
            $class = 'btn-default';
            $icon = '<i class="fa fa-info"></i> ';
    }
    return '<button class="btn '. $class .' btn-xs" id="active_status_'. $id .'" type="button" data-toggle="dropdown">
            '. $icon . $status .' &nbsp; <i class="fa fa-angle-down"></i>
        </button>';
}

function candidateStatus($status, $id){
    $html = '<div class="dropdown">';
    $html .= candidateStatusSet( $status, $id );
    $html .= '<ul class="dropdown-menu">';
    $html .= "<li><a onclick=\"statusUpdate({$id}, 'Active');\"> <i class=\"fa fa-check\"></i> Active</a></li>";
    $html .= "<li><a onclick=\"statusUpdate({$id}, 'Pending');\"> <i class=\"fa fa-hourglass-1\"></i> Pending</a></li>";
    $html .= "<li><a onclick=\"statusUpdate({$id}, 'Inactive');\"> <i class=\"fa fa-ban\"></i> Inactive</a></li>";
    $html .= '</ul>';
    $html .= '</div>';
    return $html;
}
