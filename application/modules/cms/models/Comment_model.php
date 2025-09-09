<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Comment_model extends Fm_model
{
    public $table = 'cms_comments';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get total rows
    function total_rows($q = NULL, $status)
    {
        $this->__sql($q, $status);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL, $status)
    {
        $this->db->order_by($this->id, $this->order);
        $this->__sql($q, $status);
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    private function __sql($q, $status){
        $this->db->select('c.*, u.first_name, u.last_name, u.email as user_email, cms.post_title, cms.post_url');
        if ($q) {
            $this->db->like('c.comment', $q);
        }
        if($status){
            $this->db->where('c.status', $status);
        }
        $this->db->from("{$this->table} as c");
        $this->db->join("users as u", "u.id = c.user_id", "left");
        $this->db->join("cms", "cms.id = c.post_id", "left");
    }
}