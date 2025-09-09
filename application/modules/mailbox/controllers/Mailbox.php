<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 2018-08-14
 */

class Mailbox extends Admin_controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Mailbox_model');
        $this->load->helper('mails');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        
        $config['base_url'] = build_pagination_url( Backend_URL . 'mailbox/', 'q');
        $config['first_url'] = build_pagination_url( Backend_URL . 'mailbox/', 'q');
       

        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Mailbox_model->total_rows($q);
        $mails = $this->Mailbox_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'mails' => $mails,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->viewAdminContent('mailbox/mailbox/index', $data);
    }

    public function compose()
    {
        $g = ($this->input->get('g')) ? $this->input->get('g') : 'Recruiter';
        $data = [
            'group' => $g,
            'candidate_id' => (int) $this->input->get('cid'),
            'recruiter_id' => (int) $this->input->get('rid'),
            'subject' => '',
            'message' => '<p>&nbsp;<br/><br/><br/></p><p>Kind Regards.<br />--------------------<br /><strong>NGO career</strong><br />Website: www.ngocareer.com<br />Email address: info@ngocareer.com</p>',
            'hidden_can' => ($g == 'Recruiter') ? 'hidden' : '',
            'hidden_rec' => ($g == 'Candidate') ? 'hidden' : '',
        ];

        $this->viewAdminContent('mailbox/mailbox/compose', $data);
    }

    public function send_action()
    {

        // ajaxAuthorized();

        $reciver = $this->_receiver();
        $option = [
            'to' => $reciver->email,
            'receiver_id' => $reciver->id,
            'subject' => $this->input->post('subject'),
            'body' => $_POST['message']
        ];
        Modules::run('mail/compose', $option);

        $this->session->set_flashdata('message', '<p class="ajax_success">Email Sent Successfully</p>');
        redirect(site_url(Backend_URL . 'mailbox'));
    }

    private function _receiver()
    {
        $group = $this->input->post('group');
        $cid = (int) $this->input->post('candidate_id');
        $rid = (int) $this->input->post('recruiter_id');

        if ($group == 'Recruiter') {
            $data = $this->db->select('id,email')->where('id', $cid)->get('candidates')->row();
        } else {
            $data = $this->db->select('id,email')->where('id', $rid)->get('users')->row();
        }

        if ($data) {
            return $data;
        } else {
            return (object) ['id' => 0, 'email' => 'no@mail.com'];
        }
    }

    public function read($id)
    {

        $this->db->update('mails', ['status' => 'Read'], ['id' => $id]);

        $row = $this->Mailbox_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'mail_type' => $row->mail_type,
                'sender_id' => $row->sender_id,
                'receiver_id' => $row->receiver_id,
                'mail_from' => $row->mail_from,
                'mail_to' => $row->mail_to,
                'subject' => $row->subject,
                'body' => $row->body,
                'status' => $row->status,
                'system' => $row->system,
                'sent_at' => $row->sent_at,
            );
            $this->viewAdminContent('mailbox/mailbox/read', $data);
        } else {
            $this->session->set_flashdata('message', '<p class="ajax_error">Record Not Found</p>');
            redirect(site_url(Backend_URL . 'mailbox'));
        }
    }

    private function setLayout($MailBody = '')
    {
        $template = $this->load->view('email_templates/layout-active', '', true);
        return str_replace("%MailBody%", $MailBody, $template);
    }

    public function delete($id)
    {
        $row = $this->Mailbox_model->get_by_id($id);

        if ($row) {
            $this->Mailbox_model->delete($id);
            $this->session->set_flashdata('message', '<p class="ajax_success">Delete Record Success</p>');
            redirect(site_url(Backend_URL . 'mailbox'));
        } else {
            $this->session->set_flashdata('message', '<p class="ajax_error">Record Not Found</p>');
            redirect(site_url(Backend_URL . 'mailbox'));
        }
    }

    function batch_delete()
    {
        $id = $this->input->post('mailbox');
        if (!empty($id)) {
            $this->db->where_in('id', $id);
            $this->db->delete('mails');
            echo 'Delete Success';
        }
    }

    public function _menu()
    {
        return add_main_menu('Mailbox', 'admin/mailbox', 'mailbox', 'fa-envelope-o');
    }

}
