<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function getRecentJobPosts($limit = 10, $user_id = 0)
{
    $ci =& get_instance();
    $html = '';

    $ci->db->select('*');
    $ci->db->limit($limit);
    if ($user_id) { $ci->db->where('user_id', $user_id); }
    $ci->db->where('status', 'Pending');
    $ci->db->order_by('id', 'DESC');
    $jobs = $ci->db->get('jobs')->result();

    if (!$jobs) {
        $html .= '<tr>';
        $html .= '<td colspan="6"><p class="ajax_notice">No Pending job to approve.</p></td>';
        $html .= '</tr>';
        return $html;
    }

    foreach ($jobs as $job) {
        $vacancy = sprintf('%02d', $job->vacancy);
        $html .= '<tr>';
        $html .= '<td class="text-center">' . $job->id . '</td>';
        $html .= '<td><a href="' . base_url('job-details/' . $job->id) . '/preview.html">' . $job->title . ' <i class="fa fa-external-link"></i></a></td>';
        $html .= "<td class='text-center'>{$vacancy}</td>";
        $html .= "<td>{$job->status}</td>";
        $html .= "<td>" . timePassed($job->created_at) . "</td>";
        $html .= "<td><a href='".site_url(Backend_URL.'job/update/'.$job->id)."' class='btn btn-warning btn-xs'><i class='fa fa-edit'></i> Edit</a></td>";
        $html .= '</tr>';
    }
    return $html;
}


function getRecentEventPosts($limit = 10, $user_id = 0)
{
    $ci =& get_instance();
    $html = '';

    $ci->db->select('*');
    $ci->db->limit($limit);
    if ($user_id) { $ci->db->where('user_id', $user_id); }
    $ci->db->where('status', 'Pending');
    $ci->db->order_by('id', 'DESC');
    $events = $ci->db->get('events')->result();

    if (!$events) {
        $html .= '<tr>';
        $html .= '<td colspan="5"><p class="ajax_notice">No Pending Event to publish.</p></td>';
        $html .= '</tr>';
        return $html;
    }

    foreach ($events as $event) {
        $html .= '<tr>';
        $html .= '<td class="text-center">'.$event->id.'</td>';
        $html .= '<td>'.$event->title.'</td>';
        $html .= "<td>{$event->status}</td>";
        $html .= "<td>" . timePassed($event->created_at) . "</td>";
        $html .= "<td><a href='".site_url(Backend_URL.'event/update/'.$event->id)."' class='btn btn-warning btn-xs'><i class='fa fa-edit'></i> Edit</a></td>";
        $html .= '</tr>';
    }
    return $html;
}

function getRecentJobApplication($limit = 10, $user_id = 0)
{
    $ci =& get_instance();
    $html = '';

    $ci->db->select('a.*, j.title as job_title, cv.candidate_id');
    $ci->db->select('c.full_name as candidate_name');
    if ($user_id) { $ci->db->where('j.user_id', $user_id); }
    $ci->db->from('job_applications as a');
    $ci->db->join('jobs as j', 'a.job_id = j.id', 'LEFT');
    $ci->db->join('candidate_cv as cv', 'a.candidate_cv_id = cv.id', 'LEFT');
    $ci->db->join('candidates as c', 'c.id = cv.candidate_id', 'LEFT');
    $ci->db->limit($limit);
    $ci->db->order_by('id', 'DESC');
    $jobs = $ci->db->get()->result();

    if (!$jobs) {
        $html .= '<tr>';
        $html .= '<td colspan="5">No Recent Job Application.</td>';
        $html .= '</tr>';
        return $html;
    }

    foreach ($jobs as $job) {
        $link = base_url('admin/candidate/details/' . $job->candidate_id);
        $html .= '<tr>';
        $html .= '<td><a href="' . $link . '">' . $job->candidate_name . '</a></td>';
        $html .= '<td>' . $job->job_title . '</td>';
        $html .= "<td>" . timePassed($job->applied_at) . "</td>";
        $html .= "<td class='text-center'><a href=\"admin/job/applicants/{$job->job_id}\">View All <i class=\"fa fa-external-link\"></i></a></td>";
        $html .= '</tr>';
    }
    return $html;
}

function getRecentPaymentLog($limit = 10)
{
    $ci =& get_instance();
    $html = '';

    $ci->db->from('transactions');
    $ci->db->limit($limit);
    $ci->db->order_by('id', 'DESC');
    $results = $ci->db->get()->result();

    if (!$results) {
        $html .= '<tr>';
        $html .= '<td colspan="5">No Recent Payment.</td>';
        $html .= '</tr>';
        return $html;
    }

    foreach ($results as $row) {
        $html .= '<tr>';
        $html .= '<td>' . $row->email . '</td>';
        $html .= '<td class="text-right">' . globalCurrencyFormat($row->paid_amount) . '</td>';
        $html .= '<td>' . $row->payment_status . '</td>';
        $html .= "<td>" . globalDateTimeFormat($row->created_at) . "</td>";
        $html .= '</tr>';
    }
    return $html;
}


function getUpcomingExams($limit = 10)
{
    $ci =& get_instance();
    $ci->db->select('e.id,e.name,e.datetime,cn.name as centre');
    $ci->db->select('c.name as category_name');
    $ci->db->from('exams as e');
    $ci->db->join('exam_centres as cn', 'cn.id=e.exam_centre_id', 'LEFT');
    $ci->db->join('exam_categories as c', 'e.exam_category_id=c.id', 'LEFT');

    $ci->db->where('datetime >=', date('Y-m-d 00:00:0'));
    $ci->db->order_by('datetime', 'ASC');
    $ci->db->limit($limit);
    $exams = $ci->db->get()->result();

//    dd( $exams );


    $html = '';
    if (!$exams) {
        $html .= '<tr>';
        $html .= '<td colspan="4">No Incoming Mail.</td>';
        $html .= '</tr>';
        return $html;
    }

    foreach ($exams as $exam) {
        $html .= '<tr>';
        $html .= "<td>{$exam->name}</td>";
        $html .= "<td>{$exam->category_name}</td>";
        $html .= "<td>{$exam->centre}</td>";
        $html .= "<td>" . globalDateFormat($exam->datetime) . "</td>";
        $html .= '</tr>';
    }
    return $html;
}