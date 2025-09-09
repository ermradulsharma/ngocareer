<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login_history_model extends Fm_model{

    public $table   = 'user_logs';
    public $id      = 'id';
    public $order   = 'DESC';

    function __construct(){
        parent::__construct();
    }   
    
    // get total rows
    function total_rows($most_login = NULL, $browser = NULL , $device = NULL, $role_id  = 0 , $range = null, $fd = null, $td = null  ) {       
        if($most_login == 'yes') { $this->db->group_by('user_id'); }
        $this->__search($most_login, $browser, $device, $role_id, $range, $fd, $td);        
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $most_login = NULL, $browser = NULL , $device = NULL, $role_id  = 0, $range = null, $fd = null, $td = null  ) {
        
        $this->db->select('h.*,u.email');
        $this->db->from('user_logs as h');
        $this->db->join('users as u', 'u.id=h.user_id','LEFT');
        if($most_login == 'yes') {
            $this->db->select('COUNT(h.user_id) as visit');
            $this->db->order_by('visit', 'DESC');
            $this->db->group_by('h.user_id');
        }
        $this->__search($browser, $device, $role_id, $range, $fd, $td);        
	$this->db->order_by('h.id', 'DESC');
	$this->db->limit($limit, $start);
        return $this->db->get()->result();
    }
    
    function __search($browser, $device, $role_id, $range, $fd, $td){
        
        if($browser){ $this->db->where('browser', $browser ); }
        if($device) { $this->db->where('device', $device );   }
        if($role_id){ $this->db->where('role_id', $role_id ); }  
        if($fd && $td){            
            $this->db->where("`login_time` BETWEEN '{$fd}' AND '{$td}'");
        }      
        if($range && $range != 'Custom'){
            $this->db->where('login_time >=', $range);                      
        }
    }
            
}