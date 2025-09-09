<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Newsletter_subscriber_model extends Fm_model
{

    public $table = 'newsletter_subscribers';
    public $id = 'id';
    protected $email = 'email';
    public $order = 'DESC';

    function __construct(){
        parent::__construct();
    }
    
    // get data by id
    function get_by_email($email){
        $this->db->where($this->email, $email);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL) {
        if($q){          
            $this->db->like('name', $q);
            $this->db->or_like('email', $q);
        }
        
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        if($q){          
            $this->db->like('name', $q);
            $this->db->or_like('email', $q);
        }
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    function check( $email = ''){
        $row = $this->db->get_where($this->table, ['email' =>$email])->row();
        //dd($row->id);
        if($row->status=='Unsubscribe'){
            return $row->id;
        }else{
            return 'Subscribe';
        }
    }
    function isExists($email = ''){
        return $this->db->get_where($this->table, ['email' =>$email])->num_rows();
    }


    // update data
    function update_by_email($email, $data){
        $this->db->where($this->email, $email);
        $this->db->update($this->table, $data);
    }

    function get_by_status($status = 'All'){
        //$this->db->select('id as ID,name as SubscriberName,email as EmailAddress,status as Status');
        $this->db->select('id,name,email,status');
        if($status != 'All'){
            $this->db->where('status', $status);
        }        
        return $this->db->get($this->table)->result_array();
    }

}