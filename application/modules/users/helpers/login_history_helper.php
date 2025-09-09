<?php defined('BASEPATH') OR exit('No direct script access allowed');

function login_historyTabs($id, $active_tab) {
	$html = '<ul class="tabsmenu">';
	$tabs = [
                'read'   => 'Details',        
               //  'update' => 'Update',        
                'delete' => 'Delete',
            ];

	foreach ($tabs as $link => $tab) {
		$html .= '<li> <a href="' . Backend_URL .'login_history/'. $link .'/'. $id .'"';
		$html .= ($link === $active_tab ) ? ' class="active"' : '';
		$html .= '> ' . $tab . '</a></li>';
	}
	$html .= '</ul>';
	return $html;
}

function getBrowserList( $selected = 0 ) {
        $ci =& get_instance();
        $browsers =  $ci->db->select('browser, COUNT(id) as total')->group_by('browser')->get('user_logs')->result();
    
	$html = '<option value="0">--Any Browser--</option>';
        foreach ( $browsers as $value ) {
            $html .= '<option value="'.$value->browser.'"';
            $html .= ($selected == $value->browser) ? 'selected' : '';
            $html .= ' >'.$value->browser.' ('.$value->total.')</option>';
        }
	return $html;
}

function getDeviceList( $selected = 0 ) {
        $ci =& get_instance();
	$devices = $ci->db->select('device, COUNT(id) as total')->group_by('device')->get('user_logs')->result();
    
	$html = '<option value="0">--Any Device--</option>';
        foreach ( $devices as  $value ) {
            $html .= '<option value="'.$value->device.'" ';
            $html .= ($selected == $value->device) ? 'selected' : '';
            $html .= ' >'.$value->device.' ('.$value->total.')</option>';
        }
	return $html;
}


                                