<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_model extends Fm_model{

    public $table 	= 'users';
    public $id 		= 'id';    

    function __construct(){
        parent::__construct();
    }
               
        
    function update($id, $data){
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }        
}