<?php defined('BASEPATH') OR exit('No direct script access allowed');

// leave blank for module helper

function getETdeleteButton( $status = 'Unlocked', $id = 0){
    return ($status === 'Unlocked') 
        ? anchor(site_url(Backend_URL .'email_templates/delete/'.$id ),'<i class="fa fa-fw fa-trash"></i> Delete', 'class="btn btn-xs btn-danger"  title="Delete"  onclick="javasciprt: return confirm(\'Are You Sure ?\')"') 
        : '<span class="btn btn-xs btn-warning disabled" title="Locked"><i class="fa fa-lock"></i> Locked </span>';
}


function status( $selected = NULL){
    $status = [ 'Locked', 'Unlocked' ];
    $options = '';
    foreach ($status as $row) {
        $options .= '<option value="' . $row . '" ';
        $options .= ($row == $selected ) ? 'selected="selected"' : '';
        $options .= '>' . $row . '</option>';
    }
    return $options;	

}


