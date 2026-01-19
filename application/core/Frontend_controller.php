<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Frontend_controller extends MX_Controller
{

    public $user_id;
    public $role_id;
    public $candidate_id;

    public function __construct()
    {
        parent::__construct();

        $this->user_id = (int) getLoginUserData('user_id');
        $this->role_id = (int) getLoginUserData('role_id');
        $this->candidate_id = (int) getLoginCandidatetData('id');
    }

    public function index()
    {
        $PageSlug   = empty($this->uri->segment(1)) ? 'home' : $this->uri->segment(1);

        $cms        = $this->db->get_where('cms', ['post_url' => $PageSlug])->row_array();

        //        dd( $cms );
        $post_type  = $cms['post_type'];
        $categorySlug = $this->uri->segment(2);
        if ($PageSlug === 'blog' && !empty($categorySlug)) {
            $this->getCategoryPage($categorySlug, $cms);
        } elseif ($post_type == 'page') {
            $this->getCmsPage($cms, $PageSlug);
        } elseif ($post_type == 'post') {
            $this->blog_detail($cms);
        } else {
            http_response_code(404);
            $this->viewFrontContent('frontend/404', $cms);
        }
    }

    public function blog_detail()
    {
        $url = $this->uri->segment(1);
        $row = $this->db->get_where('cms', array('post_url' => $url, 'status' => 'Publish'))->row();

        $search = array('&lt;', '&gt;');
        $replace = array('<', '>');
        $content = str_replace($search, $replace, $row->content);

        $data = array(
            'id' => $row->id,
            'user_id' => $row->user_id,
            'parent_id' => $row->parent_id,
            'post_type' => $row->post_type,
            'post_title' => $row->post_title,
            'post_url' => $row->post_url,
            'content' => $content,
            'seo_title' => $row->seo_title,
            'seo_keyword' => $row->seo_keyword,
            'seo_description' => $row->seo_description,
            'thumb' => $row->thumb,
            'created' => $row->created,
            'status' => $row->status,
            'edit_url' => site_url(Backend_URL . 'cms/update_post/' . $row->id),
            'recent_posts' => $this->recentPost(),
            'recent_jobs' => $this->recentJobs(),
            'recent_comments' => $this->recentComments(),
            'allCategory' => $this->allCategory(),
        );
        $this->viewFrontContent('frontend/category/blog-single', $data);
    }

    public function login()
    {
        $this->viewFrontContent('frontend/login');
    }

    private function getCategoryPage($categorySlug = '')
    {
        $category = $this->db->get_where('cms_options', ['url' => $categorySlug, 'type' => 'category'])->row();
        $archive = $this->input->get('archive');
        $PageSlug = 'category/default';
        if ($category) {

            $page = (int) $this->input->get('p');
            $limit = 5;
            $start = startPointOfPagination($limit, $page);
            $targetpath = build_pagination_url('category/' . $categorySlug, 'p', true);

            $total = $this->db->get_where('cms', ['post_type' => 'post', 'parent_id' => $category->id, 'status' => 'Publish'])->num_rows();
            $this->db->limit($limit, $start);
            $this->db->order_by('id', 'DESC');
            $post_data = $this->db->get_where('cms', ['post_type' => 'post', 'parent_id' => $category->id, 'status' => 'Publish'])->result();
            //            pp($post_data);
            if ($category->template) {
                $PageSlug = substr($category->template, 0, -4);
            }

            $viewTeamplatePath = APPPATH . '/views/frontend/category/' . $PageSlug . '.php';

            $viewPath = (file_exists($viewTeamplatePath)) ? ('category/' . $PageSlug) : 'category/default';

            $cms_page = [];
            $cms_page['posts_data'] = $post_data;

            $cms_page['total']  = $total;
            $cms_page['targetpath'] = $targetpath;
            $cms_page['limit']  = $limit;
            $cms_page['page']   = $page;

            $cms_page['category_id'] = $category->id;
            $cms_page['category_thumb'] = $category->thumb;
            $cms_page['category_name'] = $category->name;
            $cms_page['category_parent_id'] = $category->url;
            $cms_page['category_description'] = $category->description;

            $cms_page['meta_title'] = $category->name;
            $cms_page['meta_description'] = getShortContent($category->description, 120);
            $cms_page['meta_keywords'] = $category->name;

            $cms_page['recent_posts'] = $this->recentPost();
            $cms_page['recent_comments'] = $this->recentComments();
            $cms_page['allCategory'] = $this->allCategory();
            $this->viewFrontContent('frontend/' . $viewPath, $cms_page);
        } else {
            $this->viewFrontContent('frontend/404');
        }
    }

    private function recentPost()
    {
        $this->db->where('status', 'Publish');
        $this->db->where('post_type', 'post');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(10);
        return $this->db->get('cms')->result();
    }

    private function recentJobs()
    {
        $this->db->select('id, title');
        $this->db->where('status', 'Published');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(10);
        return $this->db->get('jobs')->result();
    }

    private function recentComments()
    {
        $this->db->select('id, comment');
        $this->db->where('status', 'Approve');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(10);
        return $this->db->get('cms_comments')->result();
    }

    private function allCategory()
    {
        $this->db->where('type', 'category');
        return $this->db->get('cms_options')->result();
    }

    private function getCmsPage($cms, $PageSlug = '')
    {
        if ($cms['template']) {
            $PageSlug = substr($cms['template'], 0, -4);
        }

        $viewTeamplatePath = APPPATH . '/views/frontend/template/' . $PageSlug . '.php';
        $viewPath = (file_exists($viewTeamplatePath)) ? ('template/' . $PageSlug) : 'template/page';

        $data = [
            'id' => $cms['id'],
            'title' => $cms['post_title'],
            'content' => $cms['content'],
            'meta_title' => $cms['seo_title'],
            'meta_description' => getShortContent($cms['seo_description'], 120),
            'meta_keywords' => $cms['seo_keyword'],
            'parent_id' => $cms['parent_id'],
            'thumb' => $cms['thumb'],
            'edit_url' => site_url(Backend_URL . 'cms/update/' . $cms['id'])
        ];

        $this->viewFrontContent('frontend/' . $viewPath, $data);
    }

    public function viewFrontContent($view, $data = [])
    {
        // $GLOBALS = $this->getAllSetting(); // PHP 8.1+ Fatal Error Fix
        foreach ($this->getAllSetting() as $key => $value) {
            $GLOBALS[$key] = $value;
        }

        //        dd( $GLOBALS );
        $this->load->view('frontend/header', $data);
        $this->load->view($view, $data);
        $this->load->view('frontend/footer');
    }

    private function getAllSetting()
    {
        $this->db->select('category,label,value');
        $settings = $this->db->get('settings')->result();
        $return = [];
        foreach ($settings as $setting) {
            $return[$setting->category][$setting->label] = $setting->value;
        }
        $return['canonical'] = site_url($this->getPageUrl());
        return $return;
    }

    private function getPageUrl()
    {
        $controller     = $this->router->fetch_class();
        $method         = $this->router->fetch_method();
        $route          = "{$controller}/{$method}";
        $arr            = $this->router->routes;
        $match          = array_search($route, $arr);
        if ($match) {
            return $match;
        } else {
            return $this->uri->segment(1);
        }
    }

    protected function viewCandidateArea($view, $data = [])
    {

        $active_tab = $this->input->get('tab');

        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/candidate/sidebar', ['active' => $active_tab]);
        $this->load->view("frontend/candidate/{$view}", $data);
        $this->load->view('frontend/candidate/after');
        $this->load->view('frontend/footer');
    }
}
