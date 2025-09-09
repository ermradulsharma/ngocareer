<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// Newsletter_frontend_subscriber
class Ajax extends Frontend_controller
{

    function __construct()
    {
        $this->load->model('Newsletter_subscriber_model');
    }

    public function subscribe()
    {
        ajaxAuthorized();
        $name = $this->input->post('name', TRUE);
        $email_address = $this->input->post('newsletter_email', TRUE);

        if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
            echo ajaxRespond('Fail', '<span class="text-danger">Invalide Email Address</span>');
            exit;
        }

        $exists = $this->Newsletter_subscriber_model->isExists($email_address);
        if ($exists) {
            $subscribed = $this->Newsletter_subscriber_model->check($email_address);
            if ($subscribed != 'Subscribe') {
                $data = array(
                    'status' => 'Subscribe',
                    'modified' => date('Y-m-d H:i:s')
                );
                $subscribed = intval($subscribed);
                $this->Newsletter_subscriber_model->update($subscribed, $data);
            } else {
                echo ajaxRespond('FAIL', '<span class="text-danger">Already Subscribed</span>');
                exit;
            }
        } else {
            $data = array(
                'name' => $name,
                'email' => $email_address,
                'status' => 'Subscribe',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            );
            $this->Newsletter_subscriber_model->insert($data);
        }

        $encoded_email = base64_encode($email_address);
        $filter = [
            'subject' => 'Newsletter Subscription',
            'receiver_email' => $email_address,
            'unsubscribe_url' => site_url('newsletter_unsubscribe?e=' . $encoded_email)
        ];
        sendMail('onNewsletter', $filter);

        echo ajaxRespond('OK', '<span class="text-success">Subscribe Successfully! Check Your Email.</span>');
    }

    public function unsubscribe()
    {
        $email = $this->input->get('e', TRUE);
        $decoded_email = base64_decode($email);

        if (!filter_var($decoded_email, FILTER_VALIDATE_EMAIL)) {
            $this->viewFrontContent('newsletter_subscriber/unsubscribe', [
                'email' => null,
                'message' => 'Invalid Email Address',
            ]);
        }

        $user = $this->Newsletter_subscriber_model->get_by_email($decoded_email);
        if ($user) {
            if ($user->status == 'Unsubscribe') {
                $this->viewFrontContent('newsletter_subscriber/unsubscribe', [
                    'email' => $decoded_email,
                    'message' => 'You are already Unsubscribed',
                ]);
            } else {
                $this->Newsletter_subscriber_model->update_by_email($decoded_email, ['status' => 'Unsubscribe']);
                $this->viewFrontContent('newsletter_subscriber/unsubscribe', [
                    'email' => $decoded_email,
                    'message' => 'Successfully Unsubscribed',
                ]);
            }
        } else {
            $this->viewFrontContent('newsletter_subscriber/unsubscribe', [
                'email' => null,
                'message' => 'Invalid Email Address',
            ]);
        }
    }

    public function alert_unsubscribe()
    {
        $email = $this->input->get('e', TRUE);
        $decoded_email = base64_decode($email);

        if (!filter_var($decoded_email, FILTER_VALIDATE_EMAIL)) {
            $this->viewFrontContent('newsletter_subscriber/unsubscribe', [
                'email' => null,
                'message' => 'Invalid URL'
            ]);
        }

        $this->db->select('email, status');
        $this->db->from('job_alert_setup');
        $this->db->where('email', $decoded_email);
        $user = $this->db->get()->row();
//        echo $this->db->last_query();
//        dd($user);

        if ($user) {
            if ($user->status == 'Off') {
                $this->viewFrontContent('newsletter_subscriber/unsubscribe', [
                    'email' => $decoded_email,
                    'message' => 'You are already Unsubscribed'
                ]);
            } else {
                $this->db->set('status', 'Off');
                $this->db->where('email', $decoded_email);
                $this->db->update('job_alert_setup');
                $this->viewFrontContent('newsletter_subscriber/unsubscribe', [
                    'email' => $decoded_email,
                    'message' => 'Successfully Unsubscribed',
                ]);
            }
        } else {
            $this->viewFrontContent('newsletter_subscriber/unsubscribe', [
                'email' => null,
                'message' => 'Invalid URL'
            ]);
        }
    }

}
