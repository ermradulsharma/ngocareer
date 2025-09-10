<?php defined('BASEPATH') || exit('No direct script access allowed');

class Fm_model extends CI_Model
{

    protected $user_id;
    protected $company_id;
    protected $role_id;

    public function __construct()
    {
        parent::__construct();
        $this->user_id      = (int) getLoginUserData('user_id');
        $this->company_id   = (int) getLoginUserData('company_id');
        $this->role_id      = (int) getLoginUserData('role_id');
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }
    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
}
