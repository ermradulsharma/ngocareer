<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function getDropDownCandidate($id=0){
    $ci =& get_instance();
    $ci->db->select('id,full_name,email');
    $candidates = $ci->db->get('candidates')->result();
    
    $output = '<option value="0">-- Select --</option>';
    foreach($candidates as $c ){
        $output .= "<option value=\"{$c->id}\"";
        $output .= ( $id == $c->id) ? ' selected' : '';            
        $output .= ">{$c->full_name} ({$c->email})";
        $output .= '</option>';
    }
    return $output;
}

function getDropDownRecruiter($id=0){
    $ci =& get_instance();
    $ci->db->select('id,CONCAT(first_name, " ", last_name) as full_name,email, company_name');
    $ci->db->where('role_id', 4);
    $recruiters = $ci->db->get('users')->result();
    
    $output = '<option value="0">-- Select --</option>';
    foreach($recruiters as $r ){
        $output .= "<option value=\"{$r->id}\"";
        $output .= ( $id == $r->id) ? ' selected' : '';            
        $output .= ">{$r->company_name}, {$r->full_name} ({$r->email})";
        $output .= '</option>';
    }
    return $output;
}
