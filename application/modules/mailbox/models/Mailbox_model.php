<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mailbox_model extends Fm_model {

    public $table = 'mails';
    public $id = 'id';
    public $order = 'DESC';

    function __construct() {
        parent::__construct();
    }

    // get total rows
    function total_rows($q = NULL) {

        if ($q) {            
            $this->db->like('mail_type', $q);            
            $this->db->or_like('mail_from', $q);
            $this->db->or_like('mail_to', $q);
            $this->db->or_like('subject', $q);
            $this->db->or_like('body', $q);            
        }
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->select('id,mail_type,sender_id,receiver_id,mail_from,mail_to,subject,status,sent_at');
        $this->db->order_by($this->id, $this->order);
        if ($q) {            
            $this->db->like('mail_type', $q);            
            $this->db->or_like('mail_from', $q);
            $this->db->or_like('mail_to', $q);
            $this->db->or_like('subject', $q);
            $this->db->or_like('body', $q);            
        }
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

}
