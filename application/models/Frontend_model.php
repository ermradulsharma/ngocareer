<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Frontend_model extends CI_Model
{

    protected $user_id;
    protected $role_id;

    public function __construct()
    {
        parent::__construct();
        $this->user_id = (int) getLoginUserData('user_id');
        $this->role_id = (int) getLoginUserData('role_id');
    }

    function total_blog($cat = null, $archive = NULL)
    {
        $this->__blog_sql($cat, $archive);
        return $this->db->get()->num_rows();
    }

    function get_blog($limit = 25, $start = 0, $cat = null, $archive = NULL)
    {
        $this->__blog_sql($cat, $archive);
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    private function __blog_sql($cat, $archive)
    {
        $this->db->select('cms.id,post_url,post_title,content,cms.thumb,c.url,c.name as category');
        if ($cat) {
            $this->db->where('c.url', $cat);
        }
        if ($archive) {
            $this->db->like('created', $archive);
        }
        $this->db->where('post_type', 'post');
        $this->db->join('cms_options as c', '(c.id=cms.parent_id and cms.post_type = "post")', 'LEFT');
        $this->db->from('cms');
    }

    function get_blog_post($slug)
    {
        $this->db->select('id,post_url,post_title,content,thumb,seo_title,seo_keyword,seo_description');
        $this->db->where('post_url', $slug);
        $post = $this->db->get('cms')->row();
        if ($post) {
            return $post;
        } else {
            return (object) [
                'id' => 0,
                'post_title' => 'No Post',
                'content' => 'No Content',
                'thumb' => 'no-thumb.jpg'
            ];
        }
    }

    function total_job($cat_id, $org, $type_id, $country_id, $keyword, $lat, $lng, $salary_range, $posted, $deadline, $sort_by, $location = null)
    {
        $this->__job_search($cat_id, $org, $type_id, $country_id, $keyword, $lat, $lng, $salary_range, $posted, $deadline, $sort_by, $location);
        return $this->db->get()->num_rows();
    }

    function get_job($limit, $start, $cat_id, $org, $type_id, $country_id, $keyword, $lat, $lng, $salary_range, $posted, $deadline, $sort_by, $location = null)
    {
        $this->__job_search($cat_id, $org, $type_id, $country_id, $keyword, $lat, $lng, $salary_range, $posted, $deadline, $sort_by, $location);
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    private function __job_search($cat_id, $org, $type_id, $country_id, $keyword, $lat, $lng, $salary_range, $posted, $deadline, $sort_by, $location = null)
    {
        if ($lat && $lng) {
            $sql_str = '(3959 * acos(cos( radians(' . $lat . ')) * cos(radians(j.lat)) 
                    * cos(radians(j.lng) - radians(' . $lng . ')) + sin(radians(' . $lat . ')) 
                    * sin(radians(j.lat)))) AS Radius';

            $this->db->select('j.*, ' . $sql_str);
            $this->db->having('Radius <=', 500);
        } else {
            $this->db->select('j.*');
        }

        $this->db->select('jt.name as job_type, c.name as cat_name');
        $this->db->from('jobs as j');
        $this->db->join('job_types as jt', 'jt.id = j.job_type_id', 'LEFT');
        $this->db->join('job_categories as c', 'c.id = j.job_category_id', 'LEFT');
        $this->db->join('users as u', 'j.user_id = u.id', 'LEFT');

        if ($cat_id) {
            $this->db->where('job_category_id', $cat_id);
        }
        if ($org) {
            $this->db->where('u.org_type_id', $org);
        }
        if ($type_id) {
            $this->db->where('job_type_id', $type_id);
        }
        if ($country_id) {
            $this->db->where('j.country_id', $country_id);
        }
        if ($posted) {
            $this->db->where('j.created_at >=', $posted);
        }
        if ($deadline) {
            $this->db->where('deadline <=', $deadline);
        }
        if ($type_id) {
            $this->db->where('job_type_id', $type_id);
        }
        $this->db->where('j.status', 'Published');
        $this->db->where('deadline >=', date('Y-m-d'));

        if ($keyword) {
            $this->db->group_start();
            $this->db->like('title', $keyword);
            $this->db->or_like('description', $keyword);
            $this->db->group_end();
        }

        if ($salary_range) {
            $salary_range = explode(':', $salary_range);
            $min_salary = $salary_range[0];
            $max_salary = $salary_range[1];
            $this->db->group_start();
            $this->db->where('salary_min >=', $min_salary);
            $this->db->where('salary_min <=', $max_salary);
            $this->db->group_end();
        }

        $this->db->order_by('j.is_feature', 'ASC');

        if ($sort_by == 'NewJobASC') {
            $this->db->order_by('created_at', 'ASC');
        } elseif ($sort_by == 'NewJobDESC') {
            $this->db->order_by('created_at', 'DESC');
        } elseif ($sort_by == 'DeadlineASC') {
            $this->db->order_by('deadline', 'ASC');
        } elseif ($sort_by == 'DeadlineDESC') {
            $this->db->order_by('deadline', 'DESC');
        } else {
            $this->db->order_by('j.id', 'DESC');
        }
    }

    function total_related_job($job_id, $cat_id)
    {
        $this->db->where_not_in('j.id', [$job_id]);
        $this->db->where('j.job_category_id', $cat_id);
        $this->db->where('j.status', 'Published');
        $this->db->where('j.deadline >=', date('Y-m-d'));
        $this->db->from('jobs as j');
        $this->db->join('job_categories as c', 'j.job_category_id = c.id', 'LEFT');
        $this->db->join('job_types as jt', 'jt.id = j.job_type_id');
        return $this->db->count_all_results();
    }

    function get_related_job($limit, $start, $job_id, $cat_id)
    {
        $this->db->select('j.*, jt.name as job_type, c.name as category_name');
        $this->db->where_not_in('j.id', [$job_id]);
        $this->db->where('j.job_category_id', $cat_id);
        $this->db->where('j.status', 'Published');
        $this->db->where('j.deadline >=', date('Y-m-d'));
        $this->db->limit($limit, $start);
        $this->db->from('jobs as j');
        $this->db->join('job_categories as c', 'j.job_category_id = c.id', 'LEFT');
        $this->db->join('job_types as jt', 'jt.id = j.job_type_id', 'LEFT');
        return $this->db->get()->result();
    }

    function get_job_details($job_id)
    {
        $this->db->select('j.*, jt.name as job_type');
        $this->db->select('c.name as category_name, sc.name as sub_category_name');
        $this->db->select('u.id as company_id, u.website as company_website');
        $this->db->select('u.company_name as company_name, u.logo as company_logo, u.about_company');
        $this->db->select('u.add_line1, u.add_line2, u.city, u.state, u.postcode, u.country_id as u_country_id');
        $this->db->from('jobs as j');
        $this->db->join('job_categories as c', 'j.job_category_id = c.id', 'LEFT');
        $this->db->join('job_categories as sc', 'j.sub_category_id = sc.id', 'LEFT');
        $this->db->join('users as u', 'u.id = j.user_id', 'LEFT');
        $this->db->join('job_types as jt', 'jt.id = j.job_type_id', 'LEFT');
        $this->db->where('j.id', $job_id);
        return $this->db->get()->row();
    }

    function get_event_details($id)
    {
        $this->db->select('e.*');
        $this->db->select('c.name as category_name');
        $this->db->select('u.id as company_id, u.website as company_website');
        $this->db->select('u.company_name as company_name, u.logo as company_logo, u.about_company');
        $this->db->select('u.add_line1, u.add_line2, u.city, u.state, u.postcode, u.country_id as company_country_id');
        $this->db->from('events as e');
        $this->db->join('event_categories as c', 'e.event_category_id = c.id', 'LEFT');
        $this->db->join('users as u', 'u.id = e.user_id', 'LEFT');
        $this->db->where('e.id', $id);
        return $this->db->get()->row();
    }

    function total_company($q, $org_type_id)
    {
        $this->__company_search($q, $org_type_id);
        return $this->db->count_all_results('users');
    }

    function get_company($limit, $start, $q, $org_type_id)
    {
        $this->__company_search($q, $org_type_id);
        $this->db->limit($limit, $start);
        return $this->db->get('users')->result();
    }

    private function __company_search($q, $org_type_id)
    {
        if ($org_type_id) {
            $this->db->where('org_type_id', $org_type_id);
        }
        if ($q) {
            $this->db->group_start();
            $this->db->like('company_name', $q);
            $this->db->group_end();
        }
        $this->db->where('role_id', 4);
    }

    function get_company_details($company_id)
    {
        $this->db->select('u.*');
        $this->db->from('users as u');
        $this->db->where('u.id', $company_id);
        return $this->db->get()->row();
    }

    function total_company_job($company_id)
    {
        $this->db->where('user_id', $company_id);
        return $this->db->count_all_results('jobs');
    }

    function get_company_job($limit, $start, $company_id)
    {

        $this->db->select('j.id,j.title,j.description,j.vacancy,j.deadline,j.location');
        $this->db->select('j.salary_type,j.created_at');
        $this->db->select('t.name as type,c.name as category');
        $this->db->from('jobs as j');
        $this->db->join('job_categories as c', 'j.job_category_id = c.id', 'LEFT');
        $this->db->join('job_types as t', 't.id = j.job_type_id', 'LEFT');
        $this->db->where('j.user_id', $company_id);
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }


    function total_advertiser($q)
    {
        $this->__advertiser_search($q);
        return $this->db->count_all_results('jobs');
    }

    function get_advertiser($limit, $start, $q)
    {
        $this->db->select('id,COUNT(*) AS `Qty`, `AdvertiserName`');
        $this->__advertiser_search($q);
        $this->db->limit($limit, $start);
        return $this->db->get('jobs')->result();
    }

    // function get_country($limit, $start, $q) {
    //     $this->db->select('id,COUNT(*) AS `Qty`, `AdvertiserName`');
    //     $this->__advertiser_search($q);
    //     $this->db->limit($limit, $start);
    //     return $this->db->get('jobs')->result();
    // }

    private function __advertiser_search($q)
    {
        $this->db->where('AdvertiserName !=', NULL);
        $this->db->group_by('AdvertiserName');
        if ($q) {
            $this->db->group_start();
            $this->db->like('AdvertiserName', $q);
            $this->db->group_end();
        }
    }




    function total_advertiser_job($Advertiser)
    {
        $this->db->where('AdvertiserName', $Advertiser);
        return $this->db->count_all_results('jobs');
    }

    function get_advertiser_job($limit, $start, $Advertiser)
    {
        $this->db->select('j.id,j.title,j.description,j.vacancy,j.deadline,j.location');
        $this->db->select('j.salary_type,j.created_at');
        $this->db->select('t.name as type, c.name as category');
        $this->db->from('jobs as j');
        $this->db->join('job_categories as c', 'j.job_category_id = c.id', 'LEFT');
        $this->db->join('job_types as t', 't.id = j.job_type_id', 'LEFT');
        $this->db->where('AdvertiserName', $Advertiser);
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    function total_event($cat_id, $keyword, $lat, $lng)
    {
        $this->__event_search($cat_id, $keyword, $lat, $lng);
        return $this->db->get()->num_rows();
    }

    function get_event($limit, $start, $cat_id, $keyword, $lat, $lng)
    {
        $this->__event_search($cat_id, $keyword, $lat, $lng);
        $this->db->limit($limit, $start);
        $this->db->order_by('id', 'DESC');
        return $this->db->get()->result();
    }

    private function __event_search($cat_id, $keyword, $lat, $lng)
    {
        if ($lat && $lng) {
            $sql_str = '(3959 * acos(cos( radians(' . $lat . ')) * cos(radians(e.lat)) 
                    * cos(radians(e.lng) - radians(' . $lng . ')) + sin(radians(' . $lat . ')) 
                    * sin(radians(e.lat)))) AS Radius';

            $this->db->select('e.*, ' . $sql_str);
            $this->db->having('Radius <=', 500);
        } else {
            $this->db->select('e.*');
        }

        $this->db->select('c.name as cat_name');
        $this->db->from('events as e');
        $this->db->join('event_categories as c', 'c.id = e.event_category_id', 'LEFT');

        if ($cat_id) {
            $this->db->where('e.event_category_id', $cat_id);
        }
        $this->db->where('e.end_date >=', date('Y-m-d'));
        $this->db->where('e.status', 'Published');

        if ($keyword) {
            $this->db->group_start();
            $this->db->like('title', $keyword);
            $this->db->or_like('description', $keyword);
            $this->db->group_end();
        }
    }
}
