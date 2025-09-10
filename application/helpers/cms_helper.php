<?php defined('BASEPATH') or exit('No direct script access allowed');

function getCMSPagebyID($id)
{
    $ci = &get_instance();
    $content = $ci->db->get_where('cms', ['id' => $id])->row();
    return $content->content;
}

function getPostWidgetByCategoryID($category_id = 0, $limit = 20)
{
    $ci = &get_instance();
    $posts = $ci->db->from('cms')
        ->where('parent_id', $category_id)
        ->where('post_type', 'post')
        ->where('status', 'Publish')
        ->limit($limit, 0)
        ->get()->result();
    //return $posts;
    $html = '<div id="" class="" data-ride="">';
    $html .= '<div id="eventCarousel" class="owl-carousel owl-theme">';

    $i = 1;
    foreach ($posts as $post) {
        $html .= '<div class="item">';
        $html .= '<div class="box-feature">';
        $html .= '<a href="' . $post->post_url . '">' . getCMSFeaturedThumb($post->thumb, "365", "240") . '</a>';
        $html .= '<div class="box-feature-content">';
        $html .= '<a href="' . $post->post_url . '"><h2>' . getShortContent($post->post_title, 20) . '<i class="fa fa-chevron-right" aria-hidden="true"></i></h2></a>';
        $html .= '<p>' . getShortContent($post->content, 75) . '</p>';

        $html .= '</div>';
        $html .= ' </div>';
        $html .= ' </div>';
        $i++;
    }
    $html .= '</div>';

    $html .= '</div>';

    return $html;
}

function getReviewsHome()
{
    $ci = &get_instance();
    $reviews = $ci->db->get_where('testimonials', ['status' => 'Active'])->result();

    $html = '';
    $html .= '<div id="carousel-reviews" class="carousel slide" data-ride="carousel">';
    $html .= '<div class="carousel-inner">';
    $i = 0;
    foreach ($reviews as $review) {
        $i++;
        if ($i == 1) {
            $html .= '<div class="item active">';
        } else {
            $html .= '<div class="item">';
        }
        $html .= '<div class="block-text rel zmin">';
        $html .= '<p>' . $review->content . '</p>';
        $html .= '</div>';
        // $html .= '<div class="thumb"><img src="'.getPhoto($review->photo).'"></div>'; 
        $html .= '<div class="person-text-image rel text-right">';
        $html .= '<div class="person-text rel">';
        $html .= '<p>' . $review->name . '</p>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
    }

    $html .= '</div>';
    $html .= '<a class="left carousel-control" href="#carousel-reviews" role="button" data-slide="prev">
                    <img src="assets/theme/images/left-arrow.png" class="img-responsive">
                </a>
                <a class="right carousel-control" href="#carousel-reviews" role="button" data-slide="next">
                    <img src="assets/theme/images/right-arrow.png" class="img-responsive">
                </a>
        ';
    $html .= '</div>';


    return $html;
}

function getPostWidgetByCategoryIDNews($category_id = 0, $limit = 16)
{
    $ci = &get_instance();
    $ci->db->from('cms');
    if ($category_id) {
        $ci->db->where('parent_id', $category_id);
    }
    $ci->db->where('post_type', 'post');
    $ci->db->where('status', 'Publish');
    $ci->db->order_by('id', 'DESC');
    $ci->db->limit($limit);
    $posts = $ci->db->get()->result();
    $html = '';
    $html .= '<div id="newsCarousel" class="owl-carousel owl-theme">';

    $i = 1;
    foreach ($posts as $post) {
        $html .= '<div class="item">';
        $html .= '<div class="box-feature news-box">';
        $html .= '<div class="news-box-image">';
        $html .= '<a href="' . $post->post_url . '">' . getCMSFeaturedThumb($post->thumb, "265", "190") . '</a>';
        $html .= '</div>';
        $html .= '<div class="box-feature-content">';
        $html .= '<a href="' . $post->post_url . '"><h3>' . getShortContent($post->post_title, 30) . '</h3></a>';
        $html .= '<p>' . getShortContent($post->content, 80) . '</p>';

        $html .= '</div>';
        $html .= ' </div>';
        $html .= ' </div>';
        $i++;
    }
    $html .= '</div>';
    $html .= '<script>           
                $(document).ready(function(){
                $("#newsCarousel").owlCarousel({
                autoPlay: 3000, //Set AutoPlay to 3 seconds
                loop: true,
                margin: 10,
                navigation : true,              
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                        nav: false,
                        dots: false
                    },
                    600: {
                        items: 2,
                        nav: false,
                        dots: false
                    },
                    1000: {
                        items: 4,
                        navigation : true,
                        dots: false
                    }
                }
                });
            });
            </script>';

    return $html;
}

function getRelatedPost($category_id = 0, $limit = 20)
{
    $ci = &get_instance();
    $ci->db->from('cms');
    if ($category_id) {
        $ci->db->where('parent_id', $category_id);
    }
    $ci->db->where('post_type', 'post');
    $ci->db->where('status', 'Publish');
    $ci->db->limit($limit);
    $posts = $ci->db->get()->result();
    $html = '<div class="row">';
    foreach ($posts as $post) {
        $html .= '<div class="col-md-3">';
        $html .= '<div class="news-box-image">';
        $html .= '<a href="' . $post->post_url . '">' . getCMSFeaturedThumb($post->thumb, "265", "190") . '</a>';
        $html .= '</div>';
        $html .= '<div class="box-feature-content">';
        $html .= '<a href="' . $post->post_url . '"><h3>' . getShortContent($post->post_title, 30) . '</h3></a>';
        $html .= '<p>' . getShortContent($post->content, 80) . '</p>';
        $html .= '</div>';
        $html .= ' </div>';
    }
    $html .= '</div>';
    return $html;
}

function upcomingEventWidgets($limit = 20)
{
    $ci = &get_instance();
    $posts = $ci->db->from('events')
        ->where('expire >=', date('Y-m-d'))
        //                    ->where('post_type', 'post')
        //                    ->where('status', 'Publish')
        ->limit($limit, 0)
        ->get()->result();
    //return $posts;
    $html = '';
    $html .= '<div id="eventCarousel" class="owl-carousel owl-theme">';

    $i = 1;
    foreach ($posts as $post) {
        $html .= '<div class="item">';
        $html .= '<div class="box-feature">';
        $html .= '<a href="upcoming-events/' . $post->url . '">' . getCMSFeaturedThumb($post->thumb, "265", "190") . '</a>';
        $html .= '<div class="box-feature-content">';
        $html .= '<a href="upcoming-events/' . $post->url . '"><h3>' . getShortContent($post->title, 22) . '</h3></a>';
        $html .= '<p>' . getShortContent($post->content, 100) . '</p>';
        $html .= '</div>';
        $html .= ' </div>';
        $html .= ' </div>';
        $i++;
    }
    $html .= '</div>';
    return $html;
}

function getCMSFeaturedThumb($thumb = null, $width = '120', $height = 0)
{
    $site_url = site_url();
    if ($height) {
        $resize = 'w=' . $width . 'px&h=' . $height . 'px';
    } else {
        $resize = 'w=' . $width . 'px';
    }
    //$filepath = dirname(BASEPATH) . '/uploads/cms_photos/' . $thumb;
    if ($thumb) {
        return '<img src="' . $site_url . 'timthumb.php?src=' . $site_url . $thumb . '&' . $resize . '" alt="Photo" class="img-responsive" />';
    } else {
        return '<img src="' . $site_url . '/timthumb.php?' . $site_url . 'uploads/no-photo.jpg&' . $resize . '"  alt="No Photo" class="img-responsive"/>';
        return '';
    }
}

function getCMSPageBanner($thumb = null)
{
    $site_url = site_url();

    $filepath = dirname(BASEPATH) . '/uploads/cms_photos/' . $thumb;
    if ($thumb && file_exists($filepath)) {
        return '<img src="' . $site_url . 'uploads/cms_photos/' . $thumb . '" alt="Photo" class="img-responsive" />';
    } else {
        //return '<img src="'.$site_url.'/timthumb.php?'.$site_url.'uploads/no-photo.jpg&'.$resize.'"  alt="No Photo" class="img-responsive"/>';
        return '';
    }
}

function getCMSPhoto($photo = null, $size = 'midium', $class = 'img-responsive')
{
    switch ($size) {
        case 'small':
            $width_height = 'width="120"';
            break;
        case 'midium':
            $width_height = 'width="200"';
            break;
        default:
            $width_height = '';
    }
    $filename = dirname(APPPATH) . '/uploads/cms_photos/' . $photo;
    if ($photo && file_exists($filename)) {
        return '<img class="' . $class . '" src="uploads/cms_photos/' . $photo . '" ' . $width_height . '>';
    } else {
        return '<img class="' . $class . '" src="uploads/no-photo.jpg" ' . $width_height . '>';
    }
}

function getCMSPhotoFront($photo = null, $class = 'img-responsive', $width = null, $height = null)
{
    $size = '';
    if ($width != null || $height != null) {
        $size = "width=\"{$width}\" height=\"{$height}\" ";
    }
    return resizePhotoWithTimThumb($photo, $width, $height);
    //    $filename = dirname(APPPATH) . '/' . $photo;
    //    if ($photo && file_exists($filename)) {
    //        return "<img class=\"{$class}\" src=\"{$photo}\" {$size}>";
    //    }
}

function getNavigationMenu($menu_id = 0, $class = 'menu', $id = 'myNavbar')
{
    $CI = &get_instance();

    $CI->db->select('rel.id, rel.parent');
    $CI->db->select('rel.obj_id');

    $CI->db->select("case when `rel`.`type` = 'category' then cat.name else c.menu_name END AS title");
    $CI->db->select("case when `rel`.`type` = 'category' then CONCAT(\"category/\", cat.url) else c.post_url END AS url");

    $CI->db->from('cms_relations as rel');
    $CI->db->join('cms as c', 'rel.obj_id = c.id', 'LEFT');
    $CI->db->join('cms_options as cat', 'cat.id=rel.obj_id', 'LEFT');

    $CI->db->where('rel.opt_id', $menu_id);
    $CI->db->order_by('rel.order', 'ASC');
    $pages = $CI->db->get()->result_array();
    if ($pages) {
        $active = $CI->uri->segment(1);
        $items = array();
        foreach ($pages as $page) {
            $items[$page['parent']][] = $page;
        }

        $nav = "<div class=\"collapse navbar-collapse\" id=\"{$id}\">";
        $nav .= '<ul class="nav navbar-nav">';
        $nav .= navigationBuilder($items, 0, 0, $active);
        $nav .= '</ul>';
        $nav .= '</div>';
        return $nav;
    } else {
        return FALSE;
    }
}

function getFooterMenu($menu_id = 0, $class = 'menu', $id = 'id')
{
    $CI = &get_instance();
    $CI->db->select('rel.id, rel.parent');
    $CI->db->select("case when `o`.`type` = 'category' then o.name else cms.menu_name END AS title");
    $CI->db->select("case when `o`.`type` = 'category' then o.url else cms.post_url END AS url");

    $CI->db->from('cms_relations as rel');
    $CI->db->join('cms', 'rel.obj_id = cms.id', 'LEFT');
    $CI->db->join('cms_options as o', 'rel.obj_id = o.id', 'LEFT');
    $CI->db->where('rel.opt_id', $menu_id);
    $CI->db->order_by('rel.order', 'ASC');
    $pages = $CI->db->get()->result_array();

    if ($pages) {
        $active = site_url($CI->uri->segment(1));
        $items = array();
        foreach ($pages as $page) {
            $items[$page['parent']][] = $page;
        }

        $nav = "<ul class=\"footer-nav {$class}\" id=\"{$id}\">";
        $nav .= navigationBuilder($items, 0, 0, $active);
        $nav .= '</ul>';
        return $nav;
    } else {
        return false;
    }
}

function navigationBuilder($items, $parentID = 0, $level = 0, $active = 0)
{
    $output = '';
    foreach ($items[$parentID] as $root) {

        $url = str_replace(site_url(), '', $root['url']);
        $output .= '<li ';
        if (empty($items[$root['id']])) {
            if ($root['url'] == 'home') {
                $output .= ($active == '') ? ' class="active"' : '';
                $output .= '><a href="' . site_url() . '">' . $root['title'];
                $output .= '</a>';
            } else {
                $output .= ($active == $url) ? ' class="active"' : '';
                $output .= '><a href="' . $url . '">' . $root['title'];
                $output .= '</a>';
            }
        } else {
            $output .= ' class="dropdown">';
            $output .= '<a class="dropdown-toggle" data-toggle="dropdown" href="#">';
            $output .= $root['title'];
            $output .= '<span class="caret"></span></a>';
            $output .= '<ul class="dropdown-menu">';
            $output .= navigationBuilder($items, $root['id'], $level + 1, $active);
            $output .= '</ul>';
            $output .= '</a>';
        }

        $output .= '</li>';
    }
    return $output;
}

function blogCatList()
{
    $ci = &get_instance();
    $url = $ci->uri->segment(2);

    $ci->db->select('count(*)');
    $ci->db->where('parent_id', 'cms_options.id', false, false);
    $sql = $ci->db->get_compiled_select('cms');

    $ci->db->select("({$sql}) as posts");
    $ci->db->select('id,name,url');
    $ci->db->where('type', 'category');
    $cats = $ci->db->get('cms_options')->result();

    $html = '';
    $html .= '<nav class="sidenav"><ul>';
    foreach ($cats as $cat) {
        $active = ($url == $cat->url) ? 'active' : '';
        $html .= "<li class=\"{$active}\">";
        $html .= '<a href="' . site_url("blog/{$cat->url}") . '">';
        $html .= "{$cat->name} ({$cat->posts})";
        $html .= '</a></li>';
    }
    $html .= '<li><a href="' . site_url('blog') . '/"> All </a></li>';
    $html .= '</ul></nav>';
    return $html;
}

function recentPost($current_post = 0)
{
    $CI = &get_instance();
    $posts = $CI->db->select('post_url, post_title, thumb')->get_where('cms', ['id !=' => $current_post, 'post_type' => 'post'], 0, 5)->result();
    $html = '';
    if ($posts) {
        $html .= '<div class="panel panel-default recent-post">
                  <div class="panel-heading">
                      <h3 class="panel-title">Recent Posts</h3>
                  </div>
                  <div style="padding-top:0px;" class="panel-body">
                      <ul style="padding-left:0; list-style:none; margin-bottom:0;">';
        foreach ($posts as $post) {
            $html .= '<li><div class="col-md-4"><img class="img-responsive" src="' . getPhoto($post->thumb) . '"/></div>';
            $html .= '<div class="col-md-8"><a href="' . site_url($post->post_url) . '">' . $post->post_title . '</a></div>';
            $html .= '<div class="clearfix"></div></li>';
        }
        $html .= '</ul></div></div>';
    }
    return $html;
}

function getBreadcrumb($parent_id = 0, $class = null, $olid = null)
{
    $ci = &get_instance();
    $html = '';
    if ($parent_id == 0) {
        return FALSE;
    }
    $html .= '<ol class="breadcrumb ' . $class . '" id="' . $olid . '>">';
    $html .= '<li class="breadcrumb-item"><a href="' . site_url() . '">Home</a></li>';
    $ci->db->select('id, parent_id, menu_name, post_url');
    $ci->db->where('id', $parent_id);
    $ci->db->where('post_type', 'page');
    $mainPage = $ci->db->get('cms')->row();
    if ($mainPage) {
        if ($ci->uri->segment(1) === $mainPage->post_url) {
            $active = 'active';
        } else {
            $active = '';
        }
        $html .= '<li class="breadcrumb-item ' . $active . '"><a href="' . site_url($mainPage->post_url) . '">' . $mainPage->menu_name . '</a></li>';
    }
    $ci->db->select('id, parent_id, menu_name, post_url');
    $ci->db->where('post_url', $ci->uri->segment(1));
    $ci->db->where('post_type', 'page');
    $currentPage = $ci->db->get('cms')->row();
    if ($currentPage) {
        if ($ci->uri->segment(1) === $currentPage->post_url) {
            $active = 'active';
        } else {
            $active = '';
        }
        $html .= '<li class="breadcrumb-item ' . $active . '">' . $currentPage->menu_name . '</li>';
    }
    $html .= '</ol>';
    return $html;
}

function getPhotoWithTimThumb($photo, $width = '110', $height = '110')
{
    $filename = dirname(BASEPATH) . '/' . $photo;
    if ($photo && file_exists($filename)) {
        return base_url('timthumb.php?src=' . base_url($photo) . '&h=' . $height . '&w=' . $width . '&zc=2');
    } else {
        return 'uploads/no-photo.jpg';
    }
}

function getTotalPost()
{
    $ci = &get_instance();
    return $ci->db->where(['post_type' => 'post'])->count_all_results('cms');
}

function getTotalPage()
{
    $ci = &get_instance();
    return $ci->db->where(['post_type' => 'page'])->count_all_results('cms');
}

function getTotalMenu()
{
    $ci = &get_instance();
    return $ci->db->where(['type' => 'menu'])->count_all_results('cms_options');
}

function getEvents($limit = 25, $label = 'No Upcoming Event Found!')
{

    $ci = &get_instance();
    $ci->db->where('status', 'Publish');
    $ci->db->limit($limit);
    $events = $ci->db->get('events')->result();

    if (!$events) {
        return $label;
    }
    $html = '';
    foreach ($events as $event) {
        $html .= '<div class="event-list">';
        $html .= '<div class="row">';
        $html .= '<div class="col-md-4 col-sm-4">';
        $html .= '<img src="' . getPhoto($event->thumb) . '" class="img-responsive" style="width: 100%;">';
        $html .= '</div>';
        $html .= '<div class="col-md-8 col-sm-8">';
        $html .= '<h3>' . getShortContent($event->title, 250) . '</h3>';
        $html .= '<div class="date"><strong>Event Date:</strong>' . globalDateFormat($event->event_date) . '</div>';
        $html .= '<p>' . getShortContent($event->content, 230) . '</p>';
        $html .= '<p><a class="donation" href="upcoming-events/' . $event->url . '">Read More</a></p>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
    }

    $html .= '<div class="text-center"><?php echo $pagination; ?></div>';

    return $html;
}

function viewSocialLinksImg()
{
    $links = json_decode($GLOBALS['General']['SocialLinks'], true);
    $html = '';
    $html .= '<div class="social">';
    if (!empty($links)) {
        if (!empty($links['YouTube'])) {
            $html .= "<a href=\"{$links['YouTube']}\"><img src=\"assets/theme/images/youtube.png\"/></a>";
        }
        if (!empty($links['Facebook'])) {
            $html .= "<a href=\"{$links['Facebook']}\"><img src=\"assets/theme/images/facebook.png\"/></a>";
        }
        if (!empty($links['Twitter'])) {
            $html .= "<a href=\"{$links['Twitter']}\"><img src=\"assets/theme/images/twitter.png\"/></a>";
        }
        if (!empty($links['Instagram'])) {
            $html .= "<a href=\"{$links['Instagram']}\"><img src=\"assets/theme/images/instagram.png\"/></a>";
        }
        if (!empty($links['Linkedin'])) {
            $html .= "<a href=\"{$links['Linkedin']}\"><img src=\"assets/theme/images/in.png\"/></a>";
        }
        if (!empty($links['Pinterest'])) {
            $html .= "<a href=\"{$links['Pinterest']}\"><img src=\"assets/theme/images/pinterest.png\"/></a>";
        }
    }
    $html .= '</div>';
    return $html;
}

function viewSocialLinks()
{
    if (isset($GLOBALS['General']['SocialLinks'])) {
        $links = json_decode($GLOBALS['General']['SocialLinks'], true);
        $html = '';
        if (!empty($links)) {
            $html .= '<ul>';
            foreach ($links as $site => $link) {
                if ($link) {
                    $fa_icon = strtolower($site);
                    $html .= '<li>';
                    $html .= "<a href=\"{$link}\" target='_blank'><i class='fa fa-{$fa_icon}'></i></a>";
                    $html .= '</li>';
                }
            }
            $html .= '</ul>';
        }
        return $html;
    }
}

function getWidget($name = '')
{
    $user_id = getLoginUserData('user_id');
    if (array_key_exists($name, $GLOBALS['Widget'])) {
        return $GLOBALS['Widget'][$name];
    } else {
        return ($user_id == 1)
            ? "<p style=\"color:red;\">{$name} Not Found in Setting Table</p>"
            : '';
    }
}

function getGeneral($name = '')
{
    $user_id = getLoginUserData('user_id');
    if (array_key_exists($name, $GLOBALS['General'])) {
        return $GLOBALS['General'][$name];
    } else {
        return ($user_id == 1)
            ? "<p style=\"color:red;\">{$name} Not Found in Setting Table</p>"
            : '';
    }
}

function cookie()
{
    $html = '';
    $html .= '<div id="cookie_bar">
                <span class="text-left">We use cookies to enhance your experience. By continuing to visit this site you agree to our use of cookies.
                <a class="ctcc-more-info-link" tabindex="0" target="_blank" href="' . base_url() . 'cookie-policy">Find out more.</a>
                </span>
                <span id="Cookie" class="pull-right">
                    <i class="fa fa-check" aria-hidden="true"></i> continue
                </span>
            </div>';
    $html .= "<script>        
                $(document).on('click', '#Cookie', function() {
                    $('#cookie_bar').slideUp(500);
                    setCookie('cookie_accepted', 'yes', 7);
                });
                var cookie_accepted = getCookie('cookie_accepted');
                if (cookie_accepted === 'yes') {
                    $('#cookie_bar').addClass('hidden');
                } else {
                    $('#cookie_bar').removeClass('hidden');
                }
            </script>";
    return $html;
}
