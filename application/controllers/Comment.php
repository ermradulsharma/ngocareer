<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Comment extends Frontend_controller
{

    // every thing coming form Frontend Controller
    function __construct()
    {
        parent::__construct();
        $this->load->helper('comment_helper');
    }

    function add_comment()
    {
        ajaxAuthorized();
        if(getSettingItem('CommentAutoApprove') == 'Yes'){
            $status = 'Approve';
            $msg = 'Comment added success!';
        } else {
            $status = 'Pending';
            $msg = 'Comment submitted success! Waiting for approval.';
        }
        $data = array(
            'parent_id' => intval($this->input->post('parent_comment_id', TRUE)),
            'post_id' => $this->input->post('post_id', TRUE),
            'user_id' => intval($this->user_id),
            'comment' => $this->input->post('comment', TRUE),
            'name' => $this->input->post('name', TRUE),
            'email' => $this->input->post('email', TRUE),
            'status' => $status,
            'created_at' => date('Y-m-d H:i:s')
        );
//        dd($data);
        $this->db->insert('cms_comments', $data);
        echo ajaxRespond('OK', '<p class="ajax_success">'.$msg.'</p>');
    }

}
