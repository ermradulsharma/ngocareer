<?php defined('BASEPATH') OR exit('No direct script access allowed');

function typeTabs($id, $active_tab)
{
    $html = '<ul class="tabsmenu">';
    $tabs = [
        'read' => 'Details',
        'update' => 'Update',
        'delete' => 'Delete',
    ];

    foreach ($tabs as $link => $tab) {
        $html .= '<li><a href="' . Backend_URL . "job/type/{$link}/{$id}\"";
        $html .= ($link == $active_tab) ? ' class="active"' : '';
        $html .= '>' . $tab . '</a></li>';
    }
    $html .= '</ul>';
    return $html;
}

