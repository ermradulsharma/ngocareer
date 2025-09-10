<?php

/**
 * Description of NGO Project Related various utility code
 *
 * @author Khairul Azam
 * Date: 25th Feb, 2020
 */
class Ngo
{

    //put your code here

    private static $ci;

    function __construct()
    {
        self::$ci = &get_instance();
    }

    static public function getDaysRange($range = '')
    {
        $status = array(
            '0' => 'Any Time',
            date('Y-m-d') => 'Today',
            date('Y-m-d', strtotime('+3 Day')) => 'Next 3 Days',
            date('Y-m-d', strtotime('+7 Day')) => 'Next 7 Days',
            date('Y-m-d', strtotime('+1 Month')) => 'Next 30 Days'
        );
        $row = '';
        foreach ($status as $key => $option) {
            $row .= '<option value="' . $key . '"';
            $row .= ($range == $key) ? ' selected' : '';
            $row .= '>' . $option . '</option>';
        }
        return $row;
    }

    static public function getPastDaysRange($range = '')
    {
        $status = array(
            '0' => 'Any Time',
            date('Y-m-d') => 'Today',
            date('Y-m-d', strtotime('-3 Day')) => 'Last 3 Days',
            date('Y-m-d', strtotime('-7 Day')) => 'Last 7 Days',
            date('Y-m-d', strtotime('-1 Month')) => 'Last 30 Days'
        );
        $row = '';
        foreach ($status as $key => $option) {
            $row .= '<option value="' . $key . '"';
            $row .= ($range == $key) ? ' selected' : '';
            $row .= '>' . $option . '</option>';
        }
        return $row;
    }

    static public function getJobBenefits($benefit_ids = '')
    {
        $ci = &get_instance();
        $benefit_ids = explode(',', $benefit_ids);
        $results = $ci->db
            ->select('name')
            ->where_in('id', $benefit_ids)
            ->get('job_benefits')
            ->result();
        if ($results) {
            $html = '<h5><strong>Benefits</strong></h5>';
            foreach ($results as $result) {
                $html .= $result->name . ', ';
            }
            return rtrim($html, ', ');
        }
    }

    static public function getJobSkills($skill_ids = '')
    {
        $ci = &get_instance();
        $skill_ids = explode(',', $skill_ids);
        $results = $ci->db
            ->select('name')
            ->where_in('id', $skill_ids)
            ->get('job_skills')
            ->result();
        if ($results) {
            $html = '<h5><strong>Skills</strong></h5>';
            foreach ($results as $result) {
                $html .= $result->name . ', ';
            }
            return rtrim($html, ', ');
        }
    }

    static public function getJobTypeDropDown($selected = 0)
    {
        $ci = &get_instance();
        $results = $ci->db->get('job_types')->result();

        $options = '';
        foreach ($results as $result) {
            $options .= '<option value="' . $result->id . '" ';
            $options .= ($result->id == $selected) ? 'selected="selected"' : '';
            $options .= '>' . $result->name . '</option>';
        }
        return $options;
    }

    static function getJobCategoryDropDown($selected = 0)
    {
        //Get total jobs count GROUP BY Category
        self::$ci->db->select('count(*)');
        self::$ci->db->where('status', 'Published');
        self::$ci->db->where('deadline >=', date('Y-m-d'));
        self::$ci->db->where('jobs.job_category_id', 'c.id', false);
        $job_qty = self::$ci->db->get_compiled_select('jobs');

        //Get All categories
        self::$ci->db->select('c.id as id, c.name as name');
        self::$ci->db->select("({$job_qty}) as posts");
        self::$ci->db->from('job_categories as c');
        $categories = self::$ci->db->get()->result();

        $options = '';
        foreach ($categories as $cat) {
            $options .= '<option value="' . $cat->id . '" ';
            $options .= ($cat->id == $selected) ? 'selected="selected"' : '';
            $options .= '>' . $cat->name . ' (' . $cat->posts . ')</option>';
        }
        return $options;
    }

    static function getEventCategoryDropDown($selected = 0, $level = 'Category')
    {
        //Get total jobs count GROUP BY Category
        self::$ci->db->select('count(*)');
        self::$ci->db->where('status', 'Published');
        self::$ci->db->where('end_date >=', date('Y-m-d'));
        self::$ci->db->where('event_category_id', 'c.id', false);
        $event_qty = self::$ci->db->get_compiled_select('events');

        //Get All categories
        self::$ci->db->select('c.id as id, c.name as name');
        self::$ci->db->select("({$event_qty}) as posts");
        self::$ci->db->from('event_categories as c');
        $categories = self::$ci->db->get()->result();

        $options = '<option value="0">' . $level . '</option>';
        foreach ($categories as $cat) {
            $options .= '<option value="' . $cat->id . '" ';
            $options .= ($cat->id == $selected) ? 'selected="selected"' : '';
            $options .= '>' . $cat->name . ' (' . $cat->posts . ')</option>';
        }
        return $options;
    }

    static public function getCompanyTypeDropDown($id = 0, $label = 'Organization Type')
    {
        $ci = &get_instance();
        $results = $ci->db->get('organization_types')->result();
        $options = "<option value=\"0\">{$label}</option>";
        foreach ($results as $row) {
            $options .= '<option value="' . $row->id . '" ';
            $options .= ($row->id == $id) ? 'selected="selected"' : '';
            $options .= '>' . $row->name . '</option>';
        }
        return $options;
    }

    static public function getSalary($salary_type, $salary_min, $salary_max, $salary_period, $salary_currency)
    {
        if ($salary_type == 'Range') {
            return $salary_currency . number_format($salary_min) . ' - ' . $salary_currency . number_format($salary_max) . ' ' . $salary_period;
        } elseif ($salary_type == 'Fixed') {
            return $salary_currency . number_format($salary_min) . ' ' . $salary_period;
        } else {
            return 'Negotiable';
        }
    }

    static function company($id = 0)
    {
        self::$ci->db->select('id,first_name,last_name,company_name');
        self::$ci->db->where('role_id', 4);
        $companies = self::$ci->db->get('users')->result();

        $html = '';
        foreach ($companies as $com) {
            $html .= "<option value=\"{$com->id}\"";
            $html .= ($id == $com->id) ? ' selected' : '';
            $html .= ">{$com->company_name} ({$com->first_name} {$com->first_name})";
            $html .= '</option>';
        }
        return $html;
    }

    /* Candidate / Job Seeker Menu */

    static function menu($menus)
    {
        $url = self::$ci->uri->segment(1);
        $url .= '/';
        $url .= self::$ci->uri->segment(2);
        $active = $url;
        $html = '<ul class="nav nav-sidebar">';
        foreach ($menus as $link) {
            $html .= '<li';
            $html .= ($active == $link['link']) ? ' class="active"' : '';
            $html .= "><a href=\"{$link['link']}\">";
            $html .= "<i class=\"fa {$link['icon']}\"></i> ";
            $html .= $link['name'];
            $html .= '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }

    //Get featured jobs default limit 6
    static function getFeaturedJobs($limit = 6)
    {
        $where = array('j.status' => 'Published', 'j.is_feature' => '1');
        self::$ci->db->select('j.*');
        self::$ci->db->select('c.name as category_name');
        self::$ci->db->select('u.id as company_id');
        self::$ci->db->select('u.company_name as company_name');
        self::$ci->db->from('jobs as j');
        self::$ci->db->join('job_categories as c', 'j.job_category_id = c.id', 'LEFT');
        self::$ci->db->join('users as u', 'u.id = j.user_id', 'LEFT');
        self::$ci->db->where($where);
        self::$ci->db->where('deadline >=', date('Y-m-d'));;
        self::$ci->db->limit($limit);
        return self::$ci->db->get()->result();
    }

    //Get featured recruiters default limit 4
    static function getFeaturedRecruiters($limit = 4)
    {
        self::$ci->db->select('count(*)');
        self::$ci->db->where('is_feature', '1');
        self::$ci->db->where('user_id', 'u.id', false);
        $job_qty = self::$ci->db->get_compiled_select('jobs');

        self::$ci->db->select("({$job_qty}) as job_count");

        self::$ci->db->select('u.id as company_id');
        self::$ci->db->select('u.company_name as company_name');
        self::$ci->db->select('u.logo as company_logo');
        //        self::$ci->db->select('count(j.user_id) as total');
        self::$ci->db->from('users as u');
        self::$ci->db->where('u.role_id', '4');
        self::$ci->db->where('u.is_featured', '1');
        self::$ci->db->order_by('job_count', 'desc');
        self::$ci->db->limit($limit);
        return self::$ci->db->get()->result();
    }

    //Get recent jobs last 30 days
    static function getRecentJobs($limit = 6)
    {
        self::$ci->db->select('j.*, c.name as category_name');
        self::$ci->db->select('u.id as company_id, IFNULL(j.AdvertiserName, u.company_name) as company_name');
        self::$ci->db->from('jobs as j');
        self::$ci->db->join('job_categories as c', 'j.job_category_id = c.id', 'LEFT');
        self::$ci->db->join('users as u', 'u.id = j.user_id', 'LEFT');
        self::$ci->db->where('j.status', 'Published');
        self::$ci->db->where('j.created_at >=', date('Y-m-d 00:00:00', strtotime('-30 Days')));
        self::$ci->db->order_by('id', 'DESC');
        self::$ci->db->limit($limit);
        return self::$ci->db->get()->result();
    }

    //Get all jobs categoris & jobs count
    static function getAllJobsByCategories()
    {
        $sql = 'SELECT COUNT(*) AS `Qty`, `job_category_id` as cid, c.name as name, c.slug FROM `jobs` as j
                LEFT JOIN job_categories as c on c.id = j.job_category_id
                WHERE job_category_id != 0 and status = "Published" and deadline >= NOW()
                GROUP BY `job_category_id` ORDER BY `name` ASC limit 30';

        $categories = self::$ci->db->query($sql)->result();

        $html = '<ul>';
        foreach ($categories as $cat) {
            if ($cat->Qty) {
                $html .= "<li><a href=\"jobs/{$cat->slug}\">";
                $html .= "{$cat->name} Jobs ({$cat->Qty})";
                $html .= '</a></li>';
            }
        }
        $html .= '</ul>';
        return $html;
    }

    //Get all jobs country & jobs count
    // static function getAllJobsByCountry()
    // {

    //     $sql = 'SELECT COUNT(*) AS `Qty`, `country_id` as cid, c.name as country FROM `jobs`
    //             LEFT JOIN countries as c on c.id = jobs.country_id
    //             WHERE country_id != 0 and status = "Published" and deadline >= NOW()
    //             GROUP BY `country_id` ORDER BY `Qty` DESC limit 30';

    //     $countries = self::$ci->db->query($sql)->result();

    //     $html = '<ul>';
    //     foreach ($countries as $row) {
    //         $html .= "<li><a href=\"ngo-job-search?country_id={$row->cid}\">";
    //         $html .= "{$row->country} ({$row->Qty} Jobs)";
    //         $html .= '</a></li>';
    //     }
    //     $html .= '</ul>';
    //     return $html;
    // }

    static function getAllJobsByCountry()
    {

        $sql = 'SELECT COUNT(*) AS `Qty`, `country_id` as cid, c.name as country FROM `jobs`
                LEFT JOIN countries as c on c.id = jobs.country_id
                WHERE country_id != 0 and status = "Published" and deadline >= NOW()
                GROUP BY `country_id` ORDER BY `Qty` DESC limit 30';

        $countries = self::$ci->db->query($sql)->result();
        //$Advertisers = self::$ci->db->get()->result();

        $html = '<ul>';
        // foreach ($countries as $row) {
        //     $html .= "<li><a href=\"ngo-job-search?country_id={$row->cid}\">";
        //     $html .= "{$row->country} ({$row->Qty} Jobs)";
        //     $html .= '</a></li>';
        // }
        foreach ($countries as $row) {
            $url = site_url("jobs/{$row->country_id}" . slugify($row->country));
            $html .= "<li><a href=\"{$url}\">";
            $html .= "{$row->country} Jobs ({$row->Qty})";
            $html .= '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }
    //Get all employers & jobs count
    static function getAllJobsByEmployers()
    {
        //Get total jobs count GROUP BY Category
        self::$ci->db->select('count(*)');
        //        self::$ci->db->where('status', 'Publish');
        self::$ci->db->where('jobs.user_id', 'u.id', false);
        $job_qty = self::$ci->db->get_compiled_select('jobs');

        //Get All Employers
        self::$ci->db->select('u.id as id, u.company_name as name');
        self::$ci->db->select("({$job_qty}) as posts");
        self::$ci->db->where('u.role_id', 4);
        self::$ci->db->from('users as u');
        self::$ci->db->limit(30);
        $employers = self::$ci->db->get()->result();

        $html = '<ul>';
        foreach ($employers as $emp) {
            if ($emp->posts) {
                $url = site_url("company-details/{$emp->id}/" . slugify($emp->name) . '.html');
                $html .= "<li><a href=\"{$url}\">";
                $html .= "{$emp->name} ({$emp->posts})";
                $html .= '</a></li>';
            }
        }
        $html .= '</ul>';
        return $html;
    }
    //Get all employers & jobs count
    static function getAllJobsByAdvertiser()
    {

        // SELECT COUNT(*) AS `Rows`, `AdvertiserName` FROM `jobs` GROUP BY `AdvertiserName` ORDER BY `Rows` DESC LIMIT 30


        //Get All Employers
        self::$ci->db->select('COUNT(*) AS `Qty`, `AdvertiserName`');
        self::$ci->db->from('jobs');
        self::$ci->db->group_by('AdvertiserName');
        self::$ci->db->order_by('Qty', 'DESC');
        self::$ci->db->limit(30);
        $Advertisers = self::$ci->db->get()->result();

        $html = '<ul>';
        foreach ($Advertisers as $Adv) {
            if ($Adv->Qty) {
                $url = site_url('company/profile/') . urlencode($Adv->AdvertiserName);
                $html .= "<li><a href=\"{$url}\">";
                $html .= getShortContent($Adv->AdvertiserName, 35) . " Jobs({$Adv->Qty} )";
                $html .= '</a></li>';
            }
        }
        $html .= '</ul>';
        return $html;
    }

    //Get all employers & jobs count
    static function getAllJobsByOrganizationTypes()
    {

        $today = date('Y-m-d');
        $sql = "SELECT  COUNT(*) AS `posts`, u.org_type_id as id, ot.name FROM `jobs` as j
                LEFT JOIN users as u on u.id = j.user_id
                join organization_types as ot on ot.id = u.org_type_id
                where j.status = 'Published' and j.deadline >= '{$today}'
                GROUP by u.org_type_id";


        $org_types = self::$ci->db->query($sql)->result();

        $html = '<ul>';
        foreach ($org_types as $type) {
            $url = site_url("ngo-job-search?org={$type->id}");
            $html .= "<li><a href=\"{$url}\">";
            $html .= "{$type->name} ({$type->posts})";
            $html .= '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }

    static function getOrganizationTypesDropdown($selected = 0)
    {
        self::$ci->db->from('organization_types');
        $results = self::$ci->db->get()->result();

        $options = '';
        foreach ($results as $row) {
            $options .= '<option value="' . $row->id . '" ';
            $options .= ($row->id == $selected) ? 'selected="selected"' : '';
            $options .= '>' . $row->name . '</option>';
        }
        return $options;
    }

    static function RecentNGOEvents($limit = 4)
    {
        self::$ci->db->select('e.*');
        self::$ci->db->select('c.name as cat_name');
        self::$ci->db->from('events as e');
        self::$ci->db->join('event_categories as c', 'c.id = e.event_category_id', 'LEFT');
        self::$ci->db->where('e.end_date >=', date('Y-m-d'));
        self::$ci->db->where('e.status', 'Publish');
        self::$ci->db->order_by('e.id', 'DESC');
        self::$ci->db->limit($limit);
        return self::$ci->db->get()->result();
    }

    static function CheckAlreadyAppliedForThisJob($job_id = 0, $candidate_id = 0)
    {
        if (empty($candidate_id)) {
            return false;
        }
        self::$ci->db->from('job_applications');
        self::$ci->db->where('job_id', $job_id);
        self::$ci->db->where('candidate_id', $candidate_id);
        return self::$ci->db->count_all_results();
    }



    static public function jobAdsSummery()
    {
        $ci = &get_instance();
        $ci->db->where('status', 'Published');
        $jobs = $ci->db->count_all_results('jobs');
        $f_jobs = number_format($jobs);

        $ci->db->where('user_id', '0');
        $ci->db->group_by('AdvertiserName');
        //        $advtizer = $ci->db->count_all_results('jobs');
        $advtizer = $ci->db->get('jobs')->num_rows();

        $ci->db->where('role_id', 4);
        $ci->db->where('status', 'Active');
        $companies = $ci->db->count_all_results('users');
        $f_companies = number_format($companies + $advtizer);
        return "<span>{$f_jobs}</span> Job Ads | <span>{$f_companies}</span> Companies";
    }

    static function orgType()
    {
        //Get All categories
        self::$ci->db->select('id,name');
        self::$ci->db->from('organization_types');
        $types = self::$ci->db->get()->result();

        $html = '<ul>';
        foreach ($types as $type) {
            $html .= "<li><a href=\"ngo-job-search?org_type={$type->id}\">";
            $html .= "{$type->name}";
            $html .= '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }

    //Get all employers & jobs count
    static function popularLocations()
    {
        $json = file_get_contents(__DIR__ . '/locations.json');
        $locs = \GuzzleHttp\json_decode($json);

        $html = '<ul>';
        foreach ($locs as $loc) {
            $url = ("ngo-job-search?location={$loc->name}&lat={$loc->lat}&lng={$loc->lng}&dis=50");
            $html .= "<li><a href=\"{$url}\">";
            $html .= $loc->name;
            $html .= '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }


    static function getEventByCategories()
    {
        //Get total jobs count GROUP BY Category
        self::$ci->db->select('count(*)');
        self::$ci->db->where('status', 'Published');
        self::$ci->db->where('end_date >=', date('Y-m-d'));
        self::$ci->db->where('event_category_id', 'e.id', false);
        $job_qty = self::$ci->db->get_compiled_select('events');

        //Get All categories
        self::$ci->db->select('e.id as id, e.name as name');
        self::$ci->db->select("({$job_qty}) as posts");
        self::$ci->db->from('event_categories as e');
        self::$ci->db->order_by('e.name', 'ASC');
        $categories = self::$ci->db->get()->result();

        $html = '<ul>';
        foreach ($categories as $cat) {
            if ($cat->posts) {
                $html .= "<li><a href=\"events?category={$cat->id}\">";
                $html .= "{$cat->name} ({$cat->posts})";
                $html .= '</a></li>';
            }
        }
        $html .= '</ul>';
        return $html;
    }
}
