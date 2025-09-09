<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_model extends Fm_model {

    public $table   = 'cms_contact_us';
    public $id      = 'id';
    public $order   = 'DESC';

    function __construct() {
        parent::__construct();
    }

    // get total rows
    function total_rows($q = NULL) {

        if ($q) {
            $this->db->like('ip', $q);
            $this->db->or_like('content', $q);
        }
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        if ($q) {
            $this->db->like('ip', $q);
            $this->db->or_like('content', $q);
        }
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    public function ReadUnread($id,$status){
        return $this->db->where('id', $id)->update($this->table,['status'=>$status]);
    }

}
