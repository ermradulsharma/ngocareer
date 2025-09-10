<?php defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends Fm_model
{

    public $table   = 'users';

    function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $username string    
     * @return array
     */
    function find($username)
    {
        return $this->db
            ->select('id,role_id,first_name,last_name,email,password,status,logo')
            ->get_where($this->table, ['email' => $username, 'oauth_provider' => null])
            ->row();
    }

    /*
     * Insert / Update facebook profile data into the database
     * Insert / Update google profile data into the database
     * @param array the data for inserting into the table
     */

    public function checkFacebookGoogleUser($userData = array())
    {

        if (!empty($userData)) {
            //check whether user data already exists in database with same oauth info
            $this->db->select('id');
            $this->db->from('users');
            $this->db->where(array('oauth_provider' => $userData['oauth_provider'], 'oauth_uid' => $userData['oauth_uid']));
            $prevQuery = $this->db->get();
            $prevCheck = $prevQuery->num_rows();

            if ($prevCheck > 0) {
                $prevResult = $prevQuery->row_array();

                //update user data
                //                $userData['modified'] = date("Y-m-d H:i:s");
                //                $update = $this->db->update('users', $userData, array('id' => $prevResult['id']));
                //get user ID
                $userID = $prevResult['id'];
            } else {
                //insert user data
                $userData['role_id'] = 4;
                $userData['created_at'] = date("Y-m-d H:i:s");
                $insert = $this->db->insert('users', $userData);

                //get user ID
                $userID = $this->db->insert_id();
            }
        }

        //return user ID
        return $userID ? $userID : FALSE;
    }

    //    function sign_up($data){                
    //        $this->db->insert($this->table, $data);
    //    }

}
