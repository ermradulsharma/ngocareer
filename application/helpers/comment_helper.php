<?php defined('BASEPATH') or exit('No direct script access allowed');

function getCommentList($post_id = 0)
{
    $CI = &get_instance();
    $CI->db->select('c.*, CONCAT(u.first_name, " ", u.last_name) as full_name, u.logo');
    $CI->db->from('cms_comments as c');
    $CI->db->join('users as u', 'u.id = c.user_id', 'LEFT');
    $CI->db->where('c.post_id', $post_id);
    $CI->db->where('c.parent_id', 0);
    $CI->db->where('c.status', 'Approve');
    $CI->db->order_by('c.id', 'DESC');
    //    echo $CI->db->last_query();
    $results = $CI->db->get()->result();

    $html = '';
    if ($results) {
        $html .= '<div class="comment_list post-content">';
    }

    $html .= '<div class="card">
	    <div class="card-body">';

    foreach ($results as $row) {
        //        dd($row);
        $name = ($row->user_id) ? $row->full_name : $row->name;
        $photo = getPhoto($row->logo, $name);
        $html .= '<div class="row coment-sec-single">
                    <div class="col-md-1">
                        <img style="border-radius: 50%;" src="' . $photo . '" class="img img-rounded img-responsive"/>
                    </div>
                    <div class="col-md-11">
                        <p><strong>' . $name . '</strong> <small>' . timePassed($row->created_at) . '</small></p>
                       <div class="clearfix"></div>
                        <p>' . $row->comment . '</p>
                        <p class="text-right">
                            <a class="btn btn-outline-primary ml-2" onclick="commentReplyForm(' . $row->id . ', \'' . $name . '\')"> <i class="fa fa-reply"></i> Reply</a>
                       </p>
                    </div>
                </div>';

        $html .= '<div class="row"><div class="col-md-11 col-md-offset-1"><div id="comment_box_id_' . $row->id . '"></div></div></div>';
        $html .= getParentCommentList($row->id);
    }
    $html .= '</div></div>';
    if ($results) {
        $html .= '</div>';
    }
    return $html;
}


function getParentCommentList($id = 0)
{
    $CI = &get_instance();
    $CI->db->select('c.*, CONCAT(u.first_name, " ", u.last_name) as full_name, u.logo');
    $CI->db->from('cms_comments as c');
    $CI->db->join('users as u', 'u.id = c.user_id', 'LEFT');
    $CI->db->where('c.parent_id', $id);
    $CI->db->where('c.status', 'Approve');
    $CI->db->order_by('c.id', 'DESC');
    $results = $CI->db->get()->result();

    $html = '';
    foreach ($results as $row) {
        $name = ($row->user_id) ? $row->full_name : $row->name;
        $photo = getPhoto($row->logo, $name);
        $html .= '<div class="card card-inner">
	    <div class="card-body">';

        $html .= '<div class="row coment-sec-single">
                    <div class="col-md-1 coment-sec-2">
                        <img style="border-radius:50%;" src="' . $photo . '" class="img img-rounded img-responsive"/>
                    </div>
                    <div class="col-md-11">
                        <p><strong>' . $name . '</strong> <small>' . timePassed($row->created_at) . '</small></p>
                       <div class="clearfix"></div>
                        <p>' . $row->comment . '</p>';
        //        $html .= '<p class="text-right">
        //                            <a class="btn btn-outline-primary ml-2" onclick="commentReplyForm('.$row->id.', \''.$name.'\')"> <i class="fa fa-reply"></i> Reply</a>
        //                       </p>';
        $html .= '</div>
                </div>';

        $html .= '<div class="row"><div class="col-md-11 col-md-offset-1"><div id="comment_box_id_' . $row->id . '"></div></div></div>';

        $html .= getParentCommentList($row->id);

        $html .= '</div></div>';
    }
    return $html;
}

function countArchiveComment($q = '')
{
    $CI = &get_instance();
    $CI->db->from('cms');
    $CI->db->like('created', $q);
    $CI->db->where('status', 'Publish');
    $CI->db->where('post_type', 'post');
    $count = $CI->db->count_all_results();

    return ($count) ? ' (' . $count . ') ' : '';
}
