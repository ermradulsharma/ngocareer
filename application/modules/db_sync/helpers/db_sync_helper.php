<?php

function getTableTruncateButton( $table = null ){
        
    $tables = array(
        'users','user_meta','settings','roles','role_permissions','modules','acls','countries',
        'branch','db_sync','listing_brands','product_categories','listings','customers'
    );    

    if($table && in_array($table, $tables)){                        
        return '<button class="btn btn-xs btn-default disabled"> - - - - -</button>';
    } else {
        return '<button class="btn btn-xs btn-danger" onclick="truncateDialog(\''. $table .'\');"><i class="fa fa-trash-o"></i> Clean </button>';        
    }     
}

function db_download_btn( $file = ''){
    
    $file_path = dirname ( BASEPATH ) .'/DB/' . $file;
    
    if($file && file_exists($file_path)){  
        return '<a href="'. site_url( 'DB/'. $file ) .'"><span class="btn btn-xs btn-success"><i class="fa fa-download"></i></span></a>';
    }else{  
        return '<span class="btn btn-xs btn-default disabled"><i class="fa fa-download"></i></span>';
    } 
}

function db_restore_btn( $file = '', $type = 'db' ){
    
    $file_path = dirname ( BASEPATH ) .'/DB/' . $file;
    
    if($file && file_exists($file_path)){  
        return '<span onclick="RestoreDB(\''. $file . '\', \'' . $type . '\' );" class="btn btn-xs btn-warning"><i class="fa fa-rotate-left"></i></span>';
    }else{  
        return '<span class="btn btn-xs btn-default disabled"><i class="fa fa-rotate-left"></i></span>';
    } 
}





function countColumns($table = ''){
    $ci =& get_instance();
    $database    = $ci->db->database;

    $result = $ci->db->query(
            "SELECT COUNT(*) as col
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE table_schema = '$database'
            AND table_name = '$table'")->row();    

    return $result->col;
}

function countRows($table = ''){
    $ci =& get_instance();   
    return $ci->db->count_all_results($table);    
}