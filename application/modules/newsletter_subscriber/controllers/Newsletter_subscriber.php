<?php

defined('BASEPATH') OR exit('No direct script access allowed');



/* Author: Khairul Azam
 * Date : 2016-10-17
 */

class Newsletter_subscriber extends Admin_controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Newsletter_subscriber_model');
        $this->load->library('form_validation');
    }

    public function index() {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = Backend_URL . 'newsletter_subscriber/?q=' . urlencode($q);
            $config['first_url'] = Backend_URL . 'newsletter_subscriber/?q=' . urlencode($q);
        } else {
            $config['base_url'] = Backend_URL . 'newsletter_subscriber/';
            $config['first_url'] = Backend_URL . 'newsletter_subscriber/';
        }

        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Newsletter_subscriber_model->total_rows($q);
        $newsletter_subscriber = $this->Newsletter_subscriber_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'subscribers' => $newsletter_subscriber,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->viewAdminContent('newsletter_subscriber/index', $data);
    }

    
    public function read($id) {
        $row = $this->Newsletter_subscriber_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'name' => $row->name,
                'email' => $row->email,
                'status' => $row->status,
                'created' => $row->created,
                'modified' => $row->modified,
            );
            $this->viewAdminContent('newsletter_subscriber/view', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(Backend_URL . 'newsletter_subscriber'));
        }
    }

    public function create() {
        $data = array(
            'button' => 'Create',
            'action' => site_url( Backend_URL . 'newsletter_subscriber/create_action'),
            'id' => set_value('id'),
            'name' => set_value('name'),
            'email' => set_value('email'),
            'status' => set_value('status'),
            'created' => set_value('created'),
            'modified' => set_value('modified'),
        );
        $this->viewAdminContent('newsletter_subscriber/form', $data);
    }

    public function create_action() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'name' => $this->input->post('name', TRUE),
                'email' => $this->input->post('email', TRUE),
                'status' => 'Subscribe',
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            );

            $this->Newsletter_subscriber_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url(Backend_URL . 'newsletter_subscriber'));
        }
    }


    public function update($id) {
        $row = $this->Newsletter_subscriber_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url( Backend_URL . 'newsletter_subscriber/update_action'),
                'id' => set_value('id', $row->id),
                'name' => set_value('name', $row->name),
                'email' => set_value('email', $row->email),
                'status' => set_value('status', $row->status),
                'created' => set_value('created', $row->created),
                'modified' => set_value('modified', $row->modified),
            );
            $this->viewAdminContent('newsletter_subscriber/form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url(Backend_URL . 'newsletter_subscriber'));
        }
    }

    public function update_action() {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
                'name' => $this->input->post('name', TRUE),
                'email' => $this->input->post('email', TRUE),
                'status' => $this->input->post('status', TRUE)                                
            );

            $this->Newsletter_subscriber_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url( Backend_URL . 'newsletter_subscriber'));
        }
    }

    public function delete($id) {
        $row = $this->Newsletter_subscriber_model->get_by_id($id);

        if ($row) {
            $this->Newsletter_subscriber_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url( Backend_URL . 'newsletter_subscriber'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url( Backend_URL . 'newsletter_subscriber'));
        }
    }

    public function export_csv() {
        $status      = ($this->input->post('status'));                      
        $subscribers = $this->Newsletter_subscriber_model->get_by_status($status);        
        $setFileName = 'Subscribers_' . date("Y-m-d") . '.csv';
        $this->download_send_headers( $setFileName );
        echo $this->array2csv($subscribers);
        exit;
    }

    private function array2csv(array &$array){
       if (count($array) == 0) {
         return null;
       }
       ob_start();
       $df = fopen("php://output", 'w');
       fputcsv($df, array_keys(reset($array)));
       foreach ($array as $row) {
          fputcsv($df, $row);
       }
       fclose($df);
       return ob_get_clean();
    }
    private function download_send_headers($filename) {
        // disable caching
        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");

        // force download  
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");

        // disposition / encoding on response body
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");
    }


    public function _rules() {     
        $this->form_validation->set_rules('email', 'email', 
                'required|valid_email|is_unique[newsletter_subscribers.email]',
                array(
                'required'      => 'You have not provided %s.',
                'is_unique'     => 'This subscriber already exists.'
        ));     
        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }



}
