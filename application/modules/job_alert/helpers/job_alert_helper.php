<?php

function findCategoriesName($cats,$ids){
    $data = explode(',', $ids);
    $name = '';
    foreach($data as $id ){
        $name .= isset($cats[$id]) ? "{$cats[$id]}, " : '';
    }
    return rtrim($name, ', ');
}
