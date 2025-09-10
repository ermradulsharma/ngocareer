<?php

function getPhotoNew($config = [])
{
    $default = [
        'class' => 'img-responsive',
        'attr'  => '',
        'photo' => '',
        'no_photo_size' => 'default',
    ];
    $setting =  $config + $default;

    $filename = dirname(APPPATH) . '/' . $setting['photo'];
    if ($setting['photo'] && file_exists($filename)) {
        return '<img class="' . $setting['class'] . '" src="' . $setting['photo'] . '" ' . $setting['attr'] . '>';
    } else {
        return '<img class="no_photo ' . $setting['class'] . '" src="uploads/no_photo_' . $setting['no_photo_size'] . '.jpg" ' . $setting['attr'] . '>';
    }
}

function getEmailById($user_id = 0)
{
    $CI = &get_instance();
    $user = $CI->db->select('email')->where('id', $user_id)->get('users')->row();
    return ($user) ? $user->email : null;
}

function featured_status($data_id, $status)
{
    if ($status == 'Yes') {
        return "<span id=\"fea_$data_id\"><span title='Click to unfeature' class=\"ajax_active\" onClick=\"change_featured_status($data_id,$status);\"><i class=\"fa fa-retweet\"></i> Yes</span></span>";
    } else {
        return "<span id=\"fea_$data_id\"><span title='Click to Feature' class=\"ajax_inactive\" onClick=\"change_featured_status($data_id,$status);\"><i class=\"fa fa-retweet\"></i> No</span></span>";
    }
}

function getUserData($user_id = 0, $filde_name = 'id')
{
    $CI = &get_instance();
    $user = $CI->db->select($filde_name)->from('users')->where('id', $user_id)->get()->row();
    if ($user) {
        return $user->$filde_name;
    } else {
        return $id = 0;
    }
}

function getCurrencyCode()
{
    $prefix = getSettingItem('Currency');
    switch ($prefix) {
        case '&pound;':
            return 'GBP';
            break;
        case '&#x9f3;':
            return 'BDT';
            break;
        case '&dollar;':
            return 'USD';
            break;
        case '&euro;':
            return 'EUR';
            break;
        default:
            return 'GBP';
    }
}


function timePassed($date_time = '0000-00-00 00:00:00')
{
    $return = '';

    if ($date_time == '0000-00-00 00:00:00') {
        $return = '';
    } else {

        $timestamp = (int) strtotime($date_time);
        $current_time = time();
        $diff = $current_time - $timestamp;

        $intervals = array(
            'year' => 31556926,
            'month' => 2629744,
            'week' => 604800,
            'day' => 86400,
            'hour' => 3600,
            'minute' => 60
        );
        if ($diff == 0) {
            $return = 'just now';
        }
        if ($diff < 60) {
            $return = $diff == 1 ? $diff . ' second ago' : $diff . ' seconds ago';
        }
        if ($diff >= 60 && $diff < $intervals['hour']) {
            $diff = floor($diff / $intervals['minute']);
            $return = $diff == 1 ? $diff . ' minute ago' : $diff . ' minutes ago';
        }
        if ($diff >= $intervals['hour'] && $diff < $intervals['day']) {
            $diff = floor($diff / $intervals['hour']);
            $return = $diff == 1 ? $diff . ' hour ago' : $diff . ' hours ago';
        }
        if ($diff >= $intervals['day'] && $diff < $intervals['week']) {
            $diff = floor($diff / $intervals['day']);
            $return = $diff == 1 ? $diff . ' day ago' : $diff . ' days ago';
        }
        if ($diff >= $intervals['week'] && $diff < $intervals['month']) {
            $diff = floor($diff / $intervals['week']);
            $return = $diff == 1 ? $diff . ' week ago' : $diff . ' weeks ago';
        }
        if ($diff >= $intervals['month'] && $diff < $intervals['year']) {
            $diff = floor($diff / $intervals['month']);
            $return = $diff == 1 ? $diff . ' month ago' : $diff . ' months ago';
        }
        if ($diff >= $intervals['year']) {
            $diff = floor($diff / $intervals['year']);
            $return = $diff == 1 ? $diff . ' year ago' : $diff . ' years ago';
        }
    }
    return $return;
}

function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) {
        $string = array_slice($string, 0, 1);
    }
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
