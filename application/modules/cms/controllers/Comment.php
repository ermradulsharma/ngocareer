<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Author: Imran Hossain
 * Date : 05 Nov 2020 @10:47 am
 */

class Comment extends Admin_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Comment_model');
        $this->load->helper('comment');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $status = urldecode($this->input->get('status', TRUE));
        $start = intval($this->input->get('start'));

        $config['base_url'] = build_pagination_url(Backend_URL . 'cms/comment/', 'start');
        $config['first_url'] = build_pagination_url(Backend_URL . 'cms/comment/', 'start');

        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Comment_model->total_rows($q, $status);
        $comments = $this->Comment_model->get_limit_data($config['per_page'], $start, $q, $status);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'comments' => $comments,
            'q' => $q,
            'status' => $status,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->viewAdminContent('cms/comment/index', $data);
    }

    public function update($id)
    {
        $row = $this->Comment_model->get_by_id($id);
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url(Backend_URL . 'cms/comment/update_action'),
                'id' => set_value('id', $row->id),
                'parent_id' => set_value('parent_id', $row->parent_id),
                'post_id' => set_value('post_id', $row->post_id),
                'user_id' => set_value('user_id', $row->user_id),
                'name' => set_value('name', $row->name),
                'email' => set_value('email', $row->email),
                'comment' => set_value('comment', $row->comment),
                'status' => set_value('status', $row->status),
                'created_at' => set_value('created_at', $row->created_at),
                'updated_at' => set_value('updated_at', $row->updated_at),
            );
            $this->viewAdminContent('cms/comment/update', $data);
        } else {
            $this->session->set_flashdata('msge', 'Comment Not Found');
            redirect(site_url(Backend_URL . 'cms/comment'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        $id = $this->input->post('id', TRUE);
        if ($this->form_validation->run() == FALSE) {
            $this->update($id);
        } else {
            $data = array(
                'comment' => $this->input->post('comment', TRUE),
                'status' => $this->input->post('status', TRUE),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            $this->Comment_model->update($id, $data);
            $this->session->set_flashdata('msgs', 'Comment Updated Successfully');
            redirect(site_url(Backend_URL . 'cms/comment/'));
        }
    }

    public function delete($id)
    {
        $row = $this->Comment_model->get_by_id($id);
        if ($row) {
            $this->Comment_model->delete($id);
            $this->session->set_flashdata('msgs', 'Comment Deleted Successfully');
            redirect(site_url(Backend_URL . 'cms/comment'));
        } else {
            $this->session->set_flashdata('msge', 'Comment Not Found');
            redirect(site_url(Backend_URL . 'cms/comment'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('comment', 'comment', 'trim|required');
        $this->form_validation->set_rules('status', 'status', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}