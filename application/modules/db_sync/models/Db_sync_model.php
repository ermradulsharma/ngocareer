<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Db_sync_model extends Fm_model{

    public $table   = 'db_sync';
    public $id      = 'id';
    public $order   = 'DESC';
    private $sqlite;
    
    function __construct(){
        parent::__construct();
        $this->sqlite = $this->load->database('sqlite', TRUE);
    }    
    
    // get all
    function get_all() {
        $this->sqlite->order_by($this->id, $this->order);
        return $this->sqlite->get($this->table)->result();
    }     
    
    // delete data
    function delete($id) {
        $this->sqlite->where($this->id, $id);
        $this->sqlite->delete($this->table);
    }
    
    function insert($data) {
        $this->sqlite->insert($this->table, $data);
        return $this->sqlite->insert_id();
    }
}