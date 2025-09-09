<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Widget_model extends Fm_model {

    public $table   = 'settings';

    function __construct() {
        parent::__construct();
    }

    function get() {
        $this->db->select('label,value,field_type');
        $this->db->where('category', 'Widget');
        return $this->db->get($this->table)->result();
    }
}
