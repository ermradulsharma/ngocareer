<?php


function getSenderInfo( $json_str = '' ){
    if(empty($json_str)){ return '<em>Empty</em>'; }
    
    
    $data = json_decode($json_str, true );
    
    if(!is_array($data)){ return '<em>Empty</em>'; }
    
    $line = '';
    unset($data['message']);
    foreach($data as $key=>$value ){
        $label = ucfirst($key);
        $line .= "{$label}: {$value}<br/>";
    }
    return $line;
}