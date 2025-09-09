<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function getShortContent($long_text = '', $show = 100)
{
    $filtered_text = strip_tags($long_text);
    if ($show < strlen($filtered_text)) {
        return substr($filtered_text, 0, $show) . '...';
    } else {
        return $filtered_text;
    }
}

function dd($data, $file = array())
{
    echo '<pre>';
    print_r($data);
    if ($file) {
        print_r($file);
    }
    echo '</pre>';
    exit;
}

function pp($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
//    exit();
}

function getLoginUserData($key = '')
{
    //key: user_id, user_mail, role_id, name, photo
    $data =& get_instance();
    $prefix = $data->config->item('cookie_prefix');
    $global = json_decode(base64_decode($data->input->cookie("{$prefix}login_data", false)));
    return isset($global->$key) ? $global->$key : null;
}

function getLoginCandidatetData($key = '')
{
    //key: student_id, student_email, student_gmc, student_namestudent_name, student_history
    $data =& get_instance();
    $prefix = $data->config->item('cookie_prefix');
    $global = json_decode(base64_decode($data->input->cookie("{$prefix}candidate_data", false)));
    return isset($global->$key) ? $global->$key : null;
}

function numericDropDown($i = 0, $end = 12, $incr = 1, $selected = 0)
{
    $option = '';
    for ($i; $i <= $end; $i += $incr) {
        $option .= '<option value="' . sprintf('%02d', $i) . '"';
        $option .= ($selected == $i) ? ' selected' : '';
        $option .= '>' . sprintf('%02d', $i) . '</option>';
    }
    return $option;
}

function numericDropDown2($i = 0, $end = 12, $incr = 1, $selected = 0)
{
    $option = '';
    for ($i; $i <= $end; $i += $incr) {
        $option .= '<option value="' . sprintf('%02d', $i) . '"';
        $option .= ($selected == sprintf('%02d', $i)) ? ' selected' : '';
        $option .= '>' . sprintf('%02d', $i) . '</option>';
    }
    return $option;
}

function htmlRadio($name = 'input_radio', $selected = '', $array = ['Male' => 'Male', 'Female' => 'Female'], $attr = '')
{
    $radio = '';
    $id = 0;
    // $radio .= '<div style="padding-top:8px;">';
    if (count($array)) {
        foreach ($array as $key => $value) {
            $id++;
            $radio .= '<label>';
            $radio .= '<input type="radio" name="' . $name . '" id="' . $name . '_' . $id . '" ' . $attr;
            $radio .= (trim($selected) == $key) ? ' checked ' : '';
            $radio .= 'value="' . $key . '" />&nbsp;' . $value;
            $radio .= '&nbsp;&nbsp;&nbsp;</label>';
        }
    }
    // $radio .= '</div>';
    return $radio;
}

function selectOptions($selected = '', $array = null)
{
    $options = '';
    if (count($array)) {
        foreach ($array as $key => $value) {
            $options .= '<option value="' . $key . '" ';
            $options .= ($key == $selected) ? ' selected="selected"' : '';
            $options .= ">{$value}</option>";
        }
    }
    return $options;
}

function load_module_asset($module = null, $type = 'css', $script = null)
{
    $file = ($type == 'css') ? 'style.css.php' : 'script.js.php';
    if ($script) {
        $file = $script;
    }

    $path = APPPATH . "/modules/{$module}/assets/{$file}";
    if ($module && file_exists($path)) {
        include($path);
    }
}

function getPaginatorLimiter($selected = 100)
{
    $range = [100, 500, 1000, 2000, 5000];
    $option = '';
    foreach ($range as $limit) {
        $option .= '<option';
        $option .= ($selected == $limit) ? ' selected' : '';
        $option .= '>' . $limit . '</option>';
    }
    return $option;
}

function startPointOfPagination($limit = 25, $page = 0)
{
    return ($page) ? ($page - 1) * $limit : 0;
}

function getPaginator($total_row = 100, $currentPage = 1, $targetpath = '#&p', $limit = 25)
{
    $stages = 2;
    $page = intval($currentPage);
    $start = ($page) ? ($page - 1) * $limit : 0;

    // Initial page num setup
    $page = ($page == 0) ? 1 : $page;
    $prev = $page - 1;
    $next = $page + 1;

    $lastpage = ceil($total_row / $limit);
    $LastPagem1 = $lastpage - 1;
    $paginate = '';

    if ($lastpage > 1) {
        $paginate .= '<div class="row">';
        $paginate .= '<div class="col-md-12">';
        $paginate .= '<ul class="pagination low-margin">';
        $paginate .= '<li class="disabled"><a>Total: ' . $total_row . '</a></li>';

        // Previous
        $paginate .= ($page > 1) ? "<li><a href='$targetpath=$prev'>&lt; Pre</a></li>" : "<li class='disabled'><a> &lt; Pre</a></li>";
        // Pages
        if ($lastpage < 7 + ($stages * 2)) {
            for ($counter = 1; $counter <= $lastpage; $counter++) {
                $paginate .= ($counter == $page) ? "<li class='active'><a>$counter</a></li>" : "<li><a href='$targetpath=$counter'>$counter</a></li>";
            }
        } elseif ($lastpage > 5 + ($stages * 2)) {
            // Beginning only hide later pages
            if ($page < 1 + ($stages * 2)) {
                for ($counter = 1; $counter < 4 + ($stages * 2); $counter++) {
                    $paginate .= ($counter == $page) ? "<li class='active'><a>$counter</a></li>" : "<li><a href='$targetpath=$counter'>$counter</a></li>";
                }
                $paginate .= "<li class='disabled'><a>...</a></li>";
                $paginate .= "<li><a href='$targetpath=$LastPagem1'>$LastPagem1</a></li>";
                $paginate .= "<li><a href='$targetpath=$lastpage'>$lastpage</a></li>";
            } // Middle hide some front and some back
            elseif ($lastpage - ($stages * 2) > $page && $page > ($stages * 2)) {
                $paginate .= "<li><a href='$targetpath=1'>1</a></li>";
                $paginate .= "<li><a href='$targetpath=2'>2</a></li>";
                $paginate .= "<li><a>...</a></li>";
                for ($counter = $page - $stages; $counter <= $page + $stages; $counter++) {
                    $paginate .= ($counter == $page) ? "<li class='active'><a>$counter</a></li>" : "<li><a href='$targetpath=$counter'>$counter</a></li>";
                }

                $paginate .= "<li><a>...</a></li>";
                $paginate .= "<li><a href='$targetpath=$LastPagem1'>$LastPagem1</a></li>";
                $paginate .= "<li><a href='$targetpath=$lastpage'>$lastpage</a><li>";
            } else {

                // End only hide early pages
                $paginate .= "<li><a href='$targetpath=1'>1</a></li>";
                $paginate .= "<li><a href='$targetpath=2'>2</a></li>";
                $paginate .= "<li><a>...</a></li>";

                for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++) {
                    $paginate .= ($counter == $page) ? "<li class='active'><a>$counter</a></li>" : "<li><a href='$targetpath=$counter'>$counter</a></li>";
                }
            }
        }
        // Next

        $paginate .= ($page < $counter - 1) ? "<li><a href='$targetpath=$next'>Next &gt;</a></li>" : "<li class='disabled'><a>Next &gt;</a></li>";

        $paginate .= "</ul>";
        $paginate .= "<div class='clearfix'></div>";
        $paginate .= "</div>";
        $paginate .= "</div>";
    }
    return $paginate;
}

function ageCalculator($date = null)
{
    if ($date) {
        $tz = new DateTimeZone('Europe/London');
        $age = DateTime::createFromFormat('Y-m-d', $date, $tz)->diff(new DateTime('now', $tz))->y;
        return $age . ' years';
    } else {
        return 'Unknown';
    }
}

function sinceCalculator($date = null)
{
    if ($date) {
        $date = date('Y-m-d', strtotime($date));
        $tz = new DateTimeZone('Europe/London');
        $age = DateTime::createFromFormat('Y-m-d', $date, $tz)
            ->diff(new DateTime('now', $tz));

        $result = '';
        $result .= ($age->y) ? $age->y . 'y ' : '';
        $result .= ($age->m) ? $age->m . 'm ' : '';
        $result .= ($age->d) ? $age->d . 'd ' : '';
        $result .= ($age->h) ? $age->h . 'h ' : '';
        return $result;
    } else {
        return 'Unknown';
    }
}

function password_encription($string = '')
{
    return password_hash($string, PASSWORD_BCRYPT);
}

function initGoogleMap($lat = 0, $lng = 0, $divID = 'map-container', $title = 'Not Defiend')
{
    $script = '';
    if ($lat && $lng) {
        $script .= '<div style="height: 280px;" id="' . $divID . '"></div>' . "\r\n";
        $script .= <<<EOT
            <script src="https://maps.googleapis.com/maps/api/js?libraries=places,geometry&key=AIzaSyCSuu_Ag9Z2CEMxzzXdCcPNIUtPm0-GIXs"></script> 
            <script type="text/javascript">
            function init_map() {
                var var_location = new google.maps.LatLng($lat, $lng);

                var var_mapoptions = {
                    center: var_location,
                    zoom: 14
                };

                var var_marker = new google.maps.Marker({
                position: var_location,
                map: var_map,
                title: "{$title}"});

                var var_map = new google.maps.Map(document.getElementById("$divID"),
                        var_mapoptions);
                var_marker.setMap(var_map);
            }
            google.maps.event.addDomListener(window, 'load', init_map);

        </script>        

EOT;
    } else {
        $script .= '<noscript> Lat, and lng are empty </noscript>';
        $script .= $title;
    }
    return $script;
}

function initGoogleMapMulti($locations, $divID = 'map', $title = 'Not Defiend')
{
    $script = '';
    $count = 0;
    $js_location = '';


    if ($locations) {

        foreach ($locations as $location) {
            $count++;
            $js_location .= "['{$location->location}', {$location->lat}, {$location->lng}, {$count}]," . "\n";
        }


        $script .= '<div style="height: 280px;" id="' . $divID . '"></div>' . "\r\n";
        $script .= <<<EOT
            <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBOKy0BTRCMXke5lOw6YhaPmVy4L8d1xq0"></script> 
            <script type="text/javascript">            
                var locations = [$js_location];
                
                window.map = new google.maps.Map(document.getElementById('map'), {
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                var infowindow = new google.maps.InfoWindow();
                var bounds = new google.maps.LatLngBounds();
                for (i = 0; i < locations.length; i++) {
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                        map: map
                    });
                    bounds.extend(marker.position);
                    google.maps.event.addListener(marker, 'click', (function (marker, i) {
                        return function () {
                            infowindow.setContent(locations[i][0]);
                            infowindow.open(map, marker);
                        }
                    })(marker, i));
                }
                map.fitBounds(bounds);
                var listener = google.maps.event.addListener(map, "idle", function () {
                    map.setZoom(6);
                    google.maps.event.removeListener(listener);
                });

            </script>            

EOT;
    } else {
        $script .= '<noscript> Lat, and lng are empty </noscript>';
        $script .= $title;
    }
    return $script;
}

function timePassed($post_date)
{
    $html = '';
    $timestamp = (int)strtotime($post_date);
    $current_time = time();
    $diff = $current_time - $timestamp;

    $intervals = array(
        'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute' => 60
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

    if ($return) {
        $html = '<i class="fa fa-clock-o"></i> ' . $return;
    }

    return $html;
}

function timeLeft($end_date)
{
    $date = strtotime($end_date);//Converted to a PHP date (a second count)
    if ($date > time()) {
        // Calculate difference
        $diff = $date - time(); //time returns current time in seconds
        $days = floor($diff / (60 * 60 * 24)); //seconds/minute*minutes/hour*hours/day)
        $hours = round(($diff - $days * 60 * 60 * 24) / (60 * 60));
        return "$days days $hours hours remain";
    } else {
        return '<span style="color: red">expired</span>';
    }
}

function deadline($date)
{
    $today = date('Y-m-d');
    $date1 = new DateTime($date);
    $date2 = new DateTime($today);
    $diff = $date1->diff($date2);

    if ($diff->days >= 0 ) {
        return GDF($date) .  "<br/><small style=\"color: red\"> ({$diff->days} Days Left)</small>";        
    } else {
        return GDF($date) . '<br/><small style="color: red">(Expired)</span></small>';
    }
}

function get_admin_email()
{
    return getSettingItem('OutgoingEmail');
}

function getSettingItem($setting_key = null)
{
    $ci = &get_instance();
    $setting = $ci->db->get_where('settings', ['label' => $setting_key])->row();
    return isset($setting->value) ? $setting->value : false;
}

function getRoleName($id = 0)
{
    $ci = &get_instance();
    $role = $ci->db
        ->select('role_name as name')
        ->where('id', $id)
        ->get('roles')->row();
    return ($role) ? $role->name : '--';
}

function getCountryName($country_id = 0)
{
    $ci = &get_instance();
    $country = $ci->db
        ->select('name')
        ->get_where('countries', ['id' => $country_id])
        ->row();
    if ($country) {
        return $country->name;
    } else {
        return 'Unknown';
    }
}

function getDropDownCountries($country_id = 0, $level = '--Select Country--')
{
    $ci = &get_instance();
    $countries = $ci->db->get('countries')->result();
    $options = '<option value="">'.$level.'</option>';
    foreach ($countries as $country) {
        $options .= '<option value="' . $country->id . '" ';
        $options .= ($country->id == $country_id) ? 'selected="selected"' : '';
        $options .= '>' . $country->name . '</option>';
    }
    return $options;
}

function getDropDownEthnicitys($ethnicity_id = 0)
{
    $ci =& get_instance();
    $restuls = $ci->db->get('ethnicities')->result();

    $ethnicities = [];
    foreach ($restuls as $row) {
        $ethnicities[$row->category][] = [
            'id' => $row->id,
            'name' => $row->name,
        ];
    }
    $options = '';
    foreach ($ethnicities as $category => $items) {
        $options .= "<optgroup label=\"{$category}\">";
        foreach ($items as $item) {
            $options .= '<option value="' . $item['id'] . '" ';
            $options .= ($item['id'] == $ethnicity_id) ? 'selected="selected"' : '';
            $options .= '>' . $item['name'] . '</option>';
        }
        $options .= '</optgroup>';
    }
    return $options;
}


function bdDateFormat($data = '0000-00-00')
{
    return ($data == '0000-00-00') ? 'Unknown' : date('d/m/y', strtotime($data));
}

function isCheck($checked = 0, $match = 1)
{
    $checked = ($checked);
    return ($checked == $match) ? 'checked="checked"' : '';
}

function getCurrency($selected = '&pound;')
{
    $codes = [
        '&pound;' => "&pound; GBP",
        '&dollar;' => "&dollar; USD",
        '&#x20A6;' => "&#x20A6; NGN"
    ];
    $row = '';
    foreach ($codes as $key => $option) {
        $row .= '<option value="' . htmlentities($key) . '"';
        $row .= ($selected == $key) ? ' selected' : '';
        $row .= '>' . $option . '</option>';
    }
    return $row;
}

function globalDateTimeFormat($datetime = '0000-00-00 00:00:00')
{
    if ($datetime == '0000-00-00 00:00:00' or $datetime == '0000-00-00' or $datetime == '') {
        return '--';
    }
    return date('d/m/Y h:i A', strtotime($datetime));
}

function globalDateFormat($datetime = '0000-00-00 00:00:00')
{
    if ($datetime == '0000-00-00 00:00:00' or $datetime == '0000-00-00' or $datetime == null) {
        return '--';
    }
    return date('dS M, Y', strtotime($datetime));
}

// short format of globalDateFormat
function GDF($datetime)
{
    return globalDateFormat($datetime);
}

function globalTimeOnly($datetime = '0000-00-00 00:00:00')
{
    if ($datetime == '0000-00-00 00:00:00' or $datetime == '0000-00-00' or $datetime == null) {
        return 'Unknown';
    }
    return date('h:i A', strtotime($datetime));
}

function returnJSON($array = [])
{
    return json_encode($array);
}

function ajaxRespond($status = 'FAIL', $msg = 'Fail! Something went wrong')
{
    return returnJSON(['Status' => strtoupper($status), 'Msg' => $msg]);
}

function ajaxAuthorized()
{
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        return true;
    } else {
        $html = '';
        $html .= '<center>';
        $html .= '<h1 style="color:red;">Access Denied !</h1>';
        $html .= '<hr>';
        $html .= '<p>It seems that you might come here via an unauthorised way</p>';
        $html .= '</center>';
        die($html);
    }
}

function globalCurrencyFormat($amount = 0, $sign = '&pound;')
{
    if ($sign != '&pound;') {
        $prefix = getSettingItem('Currency');
    } else {
        $prefix = $sign;
    }

    if (is_null($amount) or empty($amount)) {
        return 0;
    } else {
        return $prefix . number_format($amount, 2);
    }
}

function bdContactNumber($contact = null)
{
    if ($contact && strlen($contact) == 11) {
        return substr($contact, 0, 5) . '-' . substr($contact, 5, 3) . '-' . substr($contact, 8, 3);
    } else {
        return $contact;
    }
}

function getUserNameByID($user_id = 0)
{
    $username = '<label class="label label-danger">User Deleted</label>';
    if ($user_id) {
        $ci = &get_instance();
        $user = $ci->db->get_where('users', ['id' => $user_id])->row();
        if ($user) {
            $username = $user->first_name . ' ' . $user->last_name;
        }
    }
    return $username;
}

function getUserNameEmailByID($user_id = 0)
{
    $username = '<label class="label label-danger">User Deleted</label>';
    if ($user_id) {
        $ci = &get_instance();
        $user = $ci->db->get_where('users', ['id' => $user_id])->row();
        if ($user) {
            $username = $user->first_name . ' ' . $user->last_name . ' (' . $user->email . ')';
        }
    }
    return $username;
}

function statusLevel($status = null)
{
    if ($status == 'Publish') {
        return '<span class="label label-success">Publish</span>';
    } elseif ($status == 'Draft') {
        echo '<span class="label label-warning">Draft</span>';
    }
}

function two_date_diff($form, $today)
{
    $date1 = new DateTime($form);
    $date2 = new DateTime($today);
    $diff = $date1->diff($date2);

    if ($diff->d == 0) {
        return 'Same Day';
    } else {
        return $diff->d . ' Day ago';
    }
}

function numeric_dropdown($i = 0, $end = 12, $incr = 1, $selected = 0)
{
    $option = '';
    for ($i; $i <= $end; $i += $incr) {
        $option .= '<option value="' . $i . '"';
        $option .= ($selected == $i) ? ' selected' : '';
        $option .= '>' . sprintf('%02d', $i) . '</option>';
    }
    return $option;
}

function numeric_dropdown_2($i = 0, $end = 12, $incr = 1, $selected = 0)
{
    $option = '';
    for ($i; $i <= $end; $i += $incr) {
        $option .= '<option value="' . sprintf('%02d', $i) . '"';
        $option .= ($selected == $i) ? ' selected' : '';
        $option .= '>' . sprintf('%02d', $i) . '</option>';
    }
    return $option;
}

function encode($string, $key = 'my_encript_key')
{
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    $j = null;
    $hash = null;
    for ($i = 0; $i < $strLen; $i++) {
        $ordStr = ord(substr($string, $i, 1));
        if ($j == $keyLen) {
            $j = 0;
        }
        $ordKey = ord(substr($key, $j, 1));
        $j++;
        $hash .= strrev(base_convert(dechex($ordStr + $ordKey), 16, 36));
    }
    return $hash;
}

function decode($string, $key = 'my_encript_key')
{
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    $j = null;
    $hash = null;
    for ($i = 0; $i < $strLen; $i += 2) {
        $ordStr = hexdec(base_convert(strrev(substr($string, $i, 2)), 36, 16));
        if ($j == $keyLen) {
            $j = 0;
        }
        $ordKey = ord(substr($key, $j, 1));
        $j++;
        $hash .= chr($ordStr - $ordKey);
    }
    return $hash;
}

function getMyEncodeKey($string, $salt, $key)
{
    $deocode = decode($string, $salt);
    $json_data = json_decode($deocode);
    if (isset($json_data->$key)) {
        return $json_data->$key;
    } else {
        return false;
    }
}

function getLocationList($selected = 0, $type = 0, $parent_id = 0)
{
    $ci = &get_instance();
    $ci->db->where('type', $type);
    if ($parent_id) {
        $ci->db->where('parent_id', $parent_id);
    }
    $countries = $ci->db->get('countries')->result();

    $options = '';
    foreach ($countries as $country) {
        $options .= '<option value="' . $country->id . '" ';
        $options .= ($country->id == $selected) ? 'selected="selected"' : '';
        $options .= ">{$country->name}</option>";
    }
    return $options;
}

function uploadPhoto($FILE = array(), $path = '', $name = '')
{
    $handle = new \Verot\Upload\Upload($FILE);
    if ($handle->uploaded) {
        $handle->file_new_name_body = $name;
        $handle->file_force_extension = true;
        $handle->file_new_name_ext = 'jpg';
        $handle->process($path);
        if ($handle->processed) {
            return stripslashes($handle->file_dst_pathname);
        }
    }
    return '';
}

function build_pagination_url($link = 'listing', $page = 'page', $ext = false)
{
    $array = $_GET;
    $url = $link . '?';

    unset($array[$page]);
    unset($array['_']);

    if ($array) {
        $url .= \http_build_query($array);
    }
    if ($ext) {
        $url .= "&{$page}";
    }
    return $url;
}

function more_text($text, $id = 1, $limit = 200)
{
    $html = '';
    $plain_txt = strip_tags($text);
    $leanth = strlen($plain_txt);
    $short_txt = substr($plain_txt, 0, $limit);

    if ($leanth >= $limit) {
        $html .= '<span id="less' . $id . '">';
        $html .= str_replace("\n", "<br/>", $short_txt);
        $html .= '....&nbsp;<span style="color:#f60; cursor:pointer;" onClick="view_full_text(\'' . $id . '\');">more&rarr;</span>';
        $html .= '</span>';

        $html .= '<span id="more' . $id . '" style="display:none">';
        $html .= $text;
        $html .= '&nbsp;<span style="color:#f60; cursor:pointer;" onClick="view_full_text(\'' . $id . '\');">&larr;Less</span>';
        $html .= '</span>';
    } else {
        return $html .= $text;
    }
    return $html;

//    js need
//    function view_full_text(id){	
//        $('#less'+id).toggle();
//        $('#more'+id).toggle();
//    }
}

function getPhotoWithLtr($photo, $name = '', $noPhotoWidth = '150', $noPhotoHeight = '150')
{
    $filename = dirname(BASEPATH) . '/' . $photo;
    if ($photo && file_exists($filename)) {
        return $photo;
    } else {
        if ($name) {
            $text = firstLetterOfEachWord($name);
        } else {
            $text = getSettingItem('NoPhotoText');
        }
        return 'holder.js/' . $noPhotoWidth . 'x' . $noPhotoHeight . '?size=14&text=' . $text;
    }
}

function getPhoto($photo)
{
    $filename = dirname(BASEPATH) . "/{$photo}";
    if ($photo && file_exists($filename)) {
        return $photo;
    } else {
        return 'uploads/no-photo.jpg';
    }
}

function removeImage($photo = null)
{
    $filename = dirname(APPPATH) . '/' . $photo;
    if ($photo && file_exists($filename)) {
        unlink($filename);
    }
    return TRUE;
}

function firstLetterOfEachWord($str, $limit = 2)
{
    $ret = '';
    foreach (explode(' ', $str) as $word) {
        $ret .= strtoupper($word[0]);
    }
    return substr($ret, 0, $limit);
}

function slugify($text)
{
    $filter1 = strtolower(strip_tags(trim($text)));
    $filter2 = html_entity_decode($filter1);
    $filter2 = @iconv('utf-8', 'utf-8//TRANSLIT', $filter2);
    $filter3 = @iconv('utf-8', 'us-ascii//TRANSLIT', $filter2);
    $filter4 = preg_replace('~[^ a-z0-9_.]~', ' ', $filter3);
    $filter5 = preg_replace('~ ~', '-', $filter4);
    $return = preg_replace('~-+~', '-', $filter5);
    if (empty($return)) {
        return 'auto-' . time() . rand(0, 99);
    } else {
        return @$return;
    }
}

function getSliderPhoto($photo)
{
    $filename = dirname(BASEPATH) . "/{$photo}";
    if ($photo && file_exists($filename)) {
        return $photo;
    } else {
        return 'uploads/no-photo.jpg';
    }
}

function getMyCvFormat($candidate_id, $candidate_cv_id = 0)
{
    $ci = &get_instance();
    $cvs = $ci->db->get_where('candidate_cv', ['candidate_id' => $candidate_id])->result();
    $options = '<option value="">--Select CV Format--</option>';
    foreach ($cvs as $cv) {
        $options .= '<option value="' . $cv->id . '" ';
        $options .= ($cv->id == $candidate_cv_id) ? 'selected="selected"' : '';
        $options .= '>' . $cv->title . ' (' . $cv->orig_name . ')</option>';
    }
    return $options;
}

function getOrganizationTypes($org_type_id = 0)
{
    $ci = &get_instance();
    $orgTypes = $ci->db->get('organization_types')->result();
    $options = '<option value="">--Select Organization Type--</option>';
    foreach ($orgTypes as $type) {
        $options .= '<option value="' . $type->id . '" ';
        $options .= ($type->id == $org_type_id) ? 'selected="selected"' : '';
        $options .= '>' . $type->name . '</option>';
    }
    return $options;
}

function getJobCategoriesDropDown($selected = 0)
{
    $ci = &get_instance();
    $results = $ci->db->get('job_categories')->result();

    $options = '';
    foreach ($results as $result) {
        $options .= '<option value="' . $result->id . '" ';
        if (!empty($selected)) {
            $selected_array = explode(',', $selected);
            $options .= in_array($result->id, $selected_array) ? 'selected="selected"' : '';
        }
        $options .= '>' . $result->name . '</option>';
    }
    return $options;
}

function sendMail($template, $options)
{
    return Modules::run('mail/processor', $template, $options);
}

function vacancyFormat( $vac = 0){
    return (!$vac) ?  'Not Specify' :  sprintf('%02d', $vac );
}

function isSpecify( $string = ''){
    return (!$string) ?  'Not Specify' :  $string;
}

function jobG8AppLink( $array ){
    //    $data = json_decode( $json, true );
    if(isset($array['ApplicationURL'])){
        return $array['ApplicationURL'];
    }
}

//Distances dropdown list
function getDistances($selected = 10){
    
    $distances = [
        '3' => '3 miles',
        '5' => '5 miles',
        '10' => '10 miles',
        '15' => '15 miles',
        '20' => '20 miles',
        '30' => '30 miles',
        '50' => '50 miles',
        '100' => '100 miles',
    ];
    $row = '<option value="2">--Select--</option>';
    foreach ($distances as $key => $option) {
        $row .= '<option value="' . intval($key) . '"';
        $row .= ($selected == $key) ? ' selected' : '';
        $row .= ">{$option}</option>";
    }
    return $row;
}
function getPhotoDefault($photo, $cls = 'img-responsive', $w=280,$h=260, $zc=1) {
    $filename = dirname(BASEPATH) . "/{$photo}";
    if (!$photo or !file_exists($filename)) {
        $photo = 'uploads/no-photo.jpg';
    }
    $img_url    = site_url( $photo );
    $resize     = "w={$w}px&h={$h}px&zc={$zc}";
    $site_url   = site_url("timthumb.php?src={$img_url}&{$resize}");
    return  "<img src=\"{$site_url}\" alt=\"Photo\" class=\"$cls\" />";
}