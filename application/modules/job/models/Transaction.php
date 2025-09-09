<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends Fm_model {

    public $response;

    public function get_last_ten_transactions()
    {
        $query = $this->db->get('transactions', 10);

        return $query->result();
    }

    public function insert_transaction($saveData)
    {
        if($this->db->insert('transactions', $saveData)){
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

}
