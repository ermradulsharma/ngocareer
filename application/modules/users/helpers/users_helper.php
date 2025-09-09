<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Users_helper {
    //Users_helper::Delete();
    public static function Delete($id = 1, $status = 'Unlocked') {

        if ($status == 'Unlocked') {
            return '<span onClick="delete_role(' . $id . ')" class="btn btn-danger btn-xs"> <i class="fa fa-trash-o"></i> Delete</span>';
        } else {
            return '<span class="btn btn-default btn-xs disabled"> <i class="fa fa-lock"></i> Locked</span>';
        }
    }

    public static function getModules($array = [], $role_id=0) {
        $html = '';
        if (empty($array)) {
            return $html;
        }
        
        foreach ($array as $key => $row) {
            $set  = 'module_' .$key;
            $html .= '<div class="col-md-12 form-group" id="'. $set .'">';
            $html .= '<input type="hidden" name="role_id" value="' . $role_id . '">';                
            $html .= "<div class=\"acl_module_name\" onclick=\"checkUncheck('". $set ."');\">";
            $html .= $row['module_name'];
            $html .= '&nbsp;&nbsp;<small class="text-red"> <i class="fa fa-check-square-o"></i>   Mark/Un-Mark All</small>';
            $html .= '</div>';
            $html .= self::getAcls($row['moulde_acls'], $role_id, $set);
            $html .= '</div>';
        }
        return $html;
    }

    public static function getAcls($array = [], $role_id = 0, $class = 'class') {
        $html = '<ul>';
        foreach ($array as $row) {
            $html .= '<li><label><input type="checkbox" class="'.$class.'" name="acl_id[]"';
            $html .= (self::isCheck($role_id, $row->id)) ? ' checked ' : '';
            $html .= 'value="' . $row->id . '"';
            $html .= '/>&nbsp;' . $row->permission_name . '</lable></li>';
        }
        $html .= '</ul>';
        return $html;
    }

    public static function isCheck($role_id = 0, $acl_id = 0) {

        $ci = & get_instance();
        return $ci->db->where('role_id', $role_id)
                ->where('acl_id', $acl_id)
                ->count_all_results('role_permissions');      
    }

    public static function makeTab($id, $active_tab) {

        $html = '<ul class="tabsmenu">';
        $tabs = [
            'profile' => 'View Profile',            
            'update' => 'Update',
            'password' => 'Change Password',
            'freeze' => 'Freeze/Unfreeze',
        ];
        foreach ($tabs as $link => $tab) {
            $html .= '<li><a href="' . Backend_URL . 'users/' . $link . '/' . $id . '"';
            $html .= ($link == $active_tab ) ? ' class="active"' : '';
            $html .= '> ' . $tab . '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }

    public static function getDropDownRoleName($role_id = 0) {
        $ci = & get_instance();
        $current_user_role_id = getLoginUserData('role_id');

        if($current_user_role_id != 1 ){
            $ci->db->where('id >', 2);
        }
//        $ci->db->where('id !=', 4);
        $roles = $ci->db->get('roles')->result();

        $options = '';
        foreach ($roles as $role) {
            $options .= '<option value="' . $role->id . '" ';
            $options .= ($role->id == $role_id ) ? 'selected="selected"' : '';
            $options .= '>' . $role->role_name . '</option>';
        }
        return $options;
    }

    static public function getRegistraionRange($range = '') {

        $status = array(
            '0' => '--Any--',
            date('Y-m-d') => 'Today',
            date('Y-m-d', strtotime("-1 Day")) => 'Last 2 Days',
            date('Y-m-d', strtotime("-3 Day")) => 'Last 3 Days',
            date('Y-m-d', strtotime("-7 Day")) => 'Last 7 Days',
            date('Y-m-d', strtotime("-1 Month")) => 'Last 1 Month',
            date('Y-m-d', strtotime("-3 Month")) => 'Last 3 Months',
            date('Y-m-d', strtotime("-6 Month")) => 'Last 6 Months',
            'Custom' => 'Custom'
        );
        $row = '';
        foreach ($status as $key => $option) {
            $row .= '<option value="' . $key . '"';
            $row .=  ($range == $key) ?  ' selected' : '';            
            $row .= '>' . $option . '</option>';
        }
        return $row;
    }
}


function userStatusSet( $status = 'Active', $id = 0){
       
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

function userStatus($status, $id){
    $html = '<div class="dropdown">';
    $html .= userStatusSet( $status, $id );
    $html .= '<ul class="dropdown-menu">';
    $html .= "<li><a onclick=\"statusUpdate({$id}, 'Active');\"> <i class=\"fa fa-check\"></i> Active</a></li>";
    $html .= "<li><a onclick=\"statusUpdate({$id}, 'Pending');\"> <i class=\"fa fa-hourglass-1\"></i> Pending</a></li>";
    $html .= "<li><a onclick=\"statusUpdate({$id}, 'Inactive');\"> <i class=\"fa fa-ban\"></i> Inactive</a></li>";
    $html .= '</ul>';
    $html .= '</div>';
    return $html;
}