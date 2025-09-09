<?php

defined('BASEPATH') OR exit('No direct script access allowed');


function profileTab($active_tab) {

    $html = '<ul class="tabsmenu">';
    $tabs = [
        'profile' => '<i class="fa fa-user"></i> My Profile',
        'profile/password' => '<i class="fa fa-random"></i> Password',        
    ];

    foreach ($tabs as $link => $tab) {
        $html .= '<li><a href="' . Backend_URL . $link . '"';
        $html .= ($link == $active_tab ) ? ' class="active"' : '';
        $html .= ">{$tab}</a></li>";
    }

    $html .= '</ul>';
    return $html;
}