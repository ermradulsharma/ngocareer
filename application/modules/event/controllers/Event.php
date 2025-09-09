<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* Author: Khairul Azam
 * Date : 2020-03-18
 */

class Event extends Admin_controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('Event_model');
        $this->load->model('job/Transaction', 'Transaction');
        $this->load->helper('event');
        $this->load->helper('event/category');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $category = intval($this->input->get('category', TRUE));
        $status = $this->input->get('status', TRUE);
        $deadline = $this->input->get('deadline', TRUE);
        $user = intval($this->input->get('user', TRUE));
        $start = intval($this->input->get('start'));

        $config['base_url'] = build_pagination_url(Backend_URL . 'event/', 'start');
        $config['first_url'] = build_pagination_url(Backend_URL . 'event/', 'start');

        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Event_model->total_rows($q, $category, $status, $deadline, $user, $this->user_id, $this->role_id);
        $events = $this->Event_model->get_limit_data($config['per_page'], $start, $q, $category, $status, $deadline, $user, $this->user_id, $this->role_id);
                
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'events' => $events,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'category' =>  $category,
            'status' =>  $status,
            'deadline' =>  $deadline,
            'user' =>  $user,
//            'sql' =>  $this->db->last_query(),
        );
        $this->viewAdminContent('event/event/index', $data);
    }

    public function read($id)
    {
        $row = $this->Event_model->get_event_by_id($id, $this->user_id, $this->role_id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'user_id' => $row->user_id,
                'package_id' => $row->package_id,
                'event_category_id' => $row->event_category_id,
                'title' => $row->title,
                'location' => $row->location,
                'lat' => $row->lat,
                'lng' => $row->lng,
                'physical_address' => $row->physical_address,
                'region' => $row->region,
                'country_id' => $row->country_id,
                'event_link' => $row->event_link,
                'start_date' => $row->start_date,
                'end_date' => $row->end_date,
                'description' => $row->description,
                'full_description' => $row->full_description,
                'summary' => $row->summary,
                'image' => $row->image,
                'organizer_name' => $row->organizer_name,
                'organization_type' => $row->organization_type,
                'organization_details' => $row->organization_details,
                'status' => $row->status,
                'remark' => $row->remark,
                'hit_count' => $row->hit_count,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            );
            $this->viewAdminContent('event/event/read', $data);
        } else {
            $this->session->set_flashdata('msge', 'Event Not Found');
            redirect(site_url(Backend_URL . 'event'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url(Backend_URL . 'event/create_action'),
            'id' => set_value('id'),
            'user_id' => set_value('user_id'),
            'package_id' => set_value('package_id'),
            'event_category_id' => set_value('event_category_id'),
            'title' => set_value('title'),
            'location' => set_value('location'),
            'lat' => set_value('lat'),
            'lng' => set_value('lng'),
            'physical_address' => set_value('physical_address'),
            'region' => set_value('region'),
            'country_id' => set_value('country_id'),
            'event_link' => set_value('event_link'),
            'start_date' => set_value('start_date'),
            'end_date' => set_value('end_date'),
            'description' => set_value('description'),
            'full_description' => set_value('full_description'),
            'summary' => set_value('summary'),
            'image' => set_value('image'),
            'organizer_name' => set_value('organizer_name'),
            'organization_type' => set_value('organization_type', 'Individual'),
            'organization_details' => set_value('organization_details'),
            'status' => set_value('status', 'Draft'),
            'remark' => set_value('remark'),
            'created_at' => set_value('created_at'),
            'updated_at' => set_value('updated_at'),
            'login_role_id' => $this->role_id,
        );
        if(in_array($this->role_id, [1,2,3])){
            $data['status_option'] = array('Draft' => 'Draft', 'Pending' => 'Pending', 'Published' => 'Publish', 'Suspend' => 'Suspend', 'Archive' => 'Archive');
        } else {
            $data['status_option'] = array('Draft' => 'Draft', 'Pending' => 'Submit for Approval', 'Published' => 'Publish');
        }
        $this->viewAdminContent('event/event/create', $data);
    }

    public function create_action()
    {
        $this->_rules();

        $status = $this->input->post('status', TRUE);

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } elseif ($this->role_id == 4 && !in_array($status, ['Draft', 'Pending'])){
            $this->session->set_flashdata('msge', 'Please change event status.');
            $this->create();
        }  else {
            $data = array(
                'package_id' => (int)$this->input->post('package_id', TRUE),
                'event_category_id' => (int)$this->input->post('event_category_id', TRUE),
                'title' => $this->input->post('title', TRUE),
                'location' => $this->input->post('location', TRUE),
                'lat' => $this->input->post('lat', TRUE),
                'lng' => $this->input->post('lng', TRUE),
                'physical_address' => $this->input->post('physical_address', TRUE),
                'region' => $this->input->post('region', TRUE),
                'country_id' => $this->input->post('country_id', TRUE),
                'event_link' => $this->input->post('event_link', TRUE),
                'start_date' => $this->input->post('start_date', TRUE),
                'end_date' => $this->input->post('end_date', TRUE),
                'description' => $this->input->post('description', TRUE),
                'full_description' => $this->input->post('full_description', TRUE),
                'summary' => $this->input->post('summary', TRUE),
                'organizer_name' => $this->input->post('organizer_name', TRUE),
                'organization_type' => $this->input->post('organization_type', TRUE),
                'organization_details' => $this->input->post('organization_details', TRUE),
                'status' => $this->input->post('status', TRUE),
                'remark' => $this->input->post('remark', TRUE),
                'created_at' => date('Y-m-d H:i:s')
            );
            if($this->role_id == 4){
                $data['user_id'] = $this->user_id; // Company, Organisation ID
            } else {
                $data['user_id'] = (int)$this->input->post('user_id', TRUE); // Company, Organisation ID
            }

            if($_FILES['image']['name']){
                $data['image'] = uploadPhoto($_FILES['image'], 'uploads/event/'.date('Y/m/'), rand(11, 99).'-'.time());
            }

            $event_id = $this->Event_model->insert($data);

            if($this->role_id == 4 && $status == 'Pending'){
                sendMail('onPostNewEventMailToAdmin', [
                    'sender_id' => $this->user_id,
                    'event_title' => $data['title'],
                    'event_update_url' => site_url(Backend_URL.'event/update/'.$event_id),
                    'user_name' => getUserNameByID($this->user_id),
                ]);
            }

            $this->session->set_flashdata('msgs', 'Event Added Successfully');
            $status = $this->input->post('status', TRUE);
            if( $status == 'Published'){
                redirect(site_url(Backend_URL . 'event/payment_form/'. $event_id ));
            } else {
                redirect(site_url(Backend_URL . 'event/update/'. $event_id ));
            }
        }
    }

    public function update($id)
    {
        $row = $this->Event_model->get_event_by_id($id, $this->user_id, $this->role_id);
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url(Backend_URL . 'event/update_action'),
                'id' => set_value('id', $row->id),
                'user_id' => set_value('user_id', $row->user_id),
                'package_id' => set_value('package_id', $row->package_id),
                'event_category_id' => set_value('event_category_id', $row->event_category_id),
                'title' => set_value('title', $row->title),
                'location' => set_value('location', $row->location),
                'lat' => set_value('lat', $row->lat),
                'lng' => set_value('lng', $row->lng),
                'physical_address' => set_value('physical_address', $row->physical_address),
                'region' => set_value('region', $row->region),
                'country_id' => set_value('country_id', $row->country_id),
                'event_link' => set_value('event_link', $row->event_link),
                'start_date' => set_value('start_date', $row->start_date),
                'end_date' => set_value('end_date', $row->end_date),
                'description' => set_value('description', $row->description),
                'full_description' => set_value('full_description', $row->full_description),
                'summary' => set_value('summary', $row->summary),
                'image' => set_value('image', $row->image),
                'organizer_name' => set_value('organizer_name', $row->organizer_name),
                'organization_type' => set_value('organization_type', $row->organization_type),
                'organization_details' => set_value('organization_details', $row->organization_details),
                'status' => set_value('status', $row->status),
                'remark' => set_value('remark', $row->remark),
                'created_at' => set_value('created_at', $row->created_at),
                'updated_at' => set_value('updated_at', $row->updated_at),
                'login_role_id' => $this->role_id,
            );
            if(in_array($this->role_id, [1,2,3])){
                $data['status_option'] = array('Draft' => 'Draft', 'Pending' => 'Pending', 'Published' => 'Publish', 'Suspend' => 'Suspend', 'Archive' => 'Archive');
            } else {
                $data['status_option'] = array('Draft' => 'Draft', 'Pending' => 'Submit for Approval', 'Published' => 'Publish');
            }
            $this->viewAdminContent('event/event/update', $data);
        } else {
            $this->session->set_flashdata('msge', 'Event Not Found');
            redirect(site_url(Backend_URL . 'event'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        $id = (int)$this->input->post('id', TRUE);
        $status = $this->input->post('status', TRUE);

        if ($this->form_validation->run() == FALSE) {
            $this->update($id);
        } elseif ($this->role_id == 4 && !in_array($status, ['Draft', 'Pending'])){
            $this->session->set_flashdata('msge', 'Please change event status.');
            $this->update($id);
        } else {
            $data = array(
                'package_id' => (int)$this->input->post('package_id', TRUE),
                'event_category_id' => (int)$this->input->post('event_category_id', TRUE),
                'title' => $this->input->post('title', TRUE),
                'location' => $this->input->post('location', TRUE),
                'lat' => $this->input->post('lat', TRUE),
                'lng' => $this->input->post('lng', TRUE),
                'physical_address' => $this->input->post('physical_address', TRUE),
                'region' => $this->input->post('region', TRUE),
                'country_id' => $this->input->post('country_id', TRUE),
                'event_link' => $this->input->post('event_link', TRUE),
                'start_date' => $this->input->post('start_date', TRUE),
                'end_date' => $this->input->post('end_date', TRUE),
                'description' => $this->input->post('description', TRUE),
                'full_description' => $this->input->post('full_description', TRUE),
                'summary' => $this->input->post('summary', TRUE),
                'organizer_name' => $this->input->post('organizer_name', TRUE),
                'organization_type' => $this->input->post('organization_type', TRUE),
                'organization_details' => $this->input->post('organization_details', TRUE),
                'status' => $this->input->post('status', TRUE),
                'remark' => $this->input->post('remark', TRUE),
                'updated_at' => date('Y-m-d H:i:s'),
            );
            if($this->role_id == 4){
                $data['user_id'] = $this->user_id; // Company, Organisation ID
            } else {
                $data['user_id'] = (int)$this->input->post('user_id', TRUE); // Company, Organisation ID
            }
            if($_FILES['image']['name']){
                $data['image'] = uploadPhoto($_FILES['image'], 'uploads/event/'.date('Y/m/'), rand(11, 99).'-'.time());
            }

            $this->Event_model->update($id, $data);

            if($this->role_id == 4 && $status == 'Pending'){
                sendMail('onPostNewEventMailToAdmin', [
                    'sender_id' => $this->user_id,
                    'event_title' => $data['title'],
                    'event_update_url' => site_url(Backend_URL.'event/update/'.$id),
                    'user_name' => getUserNameByID($this->user_id),
                ]);
            }

            $this->session->set_flashdata('msgs', 'Event Updated Successfully');
            
            $status = $this->input->post('status', TRUE);
            if( $status == 'Published'){
                redirect(site_url(Backend_URL . 'event/payment_form/'. $id ));
            } else {
                redirect(site_url(Backend_URL . 'event/update/'. $id ));
            }            
        }
    }

    public function delete($id)
    {
        $row = $this->Event_model->get_event_by_id($id, $this->user_id, $this->role_id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'user_id' => $row->user_id,
                'package_id' => $row->package_id,
                'event_category_id' => $row->event_category_id,
                'title' => $row->title,
                'location' => $row->location,
                'lat' => $row->lat,
                'lng' => $row->lng,
                'physical_address' => $row->physical_address,
                'region' => $row->region,
                'country_id' => $row->country_id,
                'event_link' => $row->event_link,
                'start_date' => $row->start_date,
                'end_date' => $row->end_date,
                'description' => $row->description,
                'full_description' => $row->full_description,
                'summary' => $row->summary,
                'image' => $row->image,
                'organizer_name' => $row->organizer_name,
                'organization_type' => $row->organization_type,
                'organization_details' => $row->organization_details,
                'status' => $row->status,
                'remark' => $row->remark,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            );
            $this->viewAdminContent('event/event/delete', $data);
        } else {
            $this->session->set_flashdata('msge', 'Event Not Found');
            redirect(site_url(Backend_URL . 'event'));
        }
    }

    public function delete_action($id)
    {
        $row = $this->Event_model->get_event_by_id($id, $this->user_id, $this->role_id);
        if ($row) {
            removeImage($row->image);
            $this->Event_model->delete($id);
            $this->session->set_flashdata('msgs', 'Event Deleted Successfully');
            redirect(site_url(Backend_URL . 'event'));
        } else {
            $this->session->set_flashdata('msge', 'Event Not Found');
            redirect(site_url(Backend_URL . 'event'));
        }
    }

    public function _menu()
    {
        // return add_main_menu('Event', 'event', 'event', 'fa-hand-o-right');
        return buildMenuForMoudle([
            'module' => 'Event',
            'icon' => 'fa-hand-o-right',
            'href' => 'event',
            'children' => [
                [
                    'title' => 'All Event',
                    'icon' => 'fa fa-bars',
                    'href' => 'event'
                ], [
                    'title' => ' |_ Add New',
                    'icon' => 'fa fa-plus',
                    'href' => 'event/create'
                ], [
                    'title' => 'Manage Category',
                    'icon' => 'fa fa-bars',
                    'href' => 'event/category'
                ]
                
            ]
        ]);
    }

    public function _rules()
    {
        if($this->role_id != 4){
            $this->form_validation->set_rules('user_id', 'company', 'trim|required|numeric|is_natural_no_zero', [
                'is_natural_no_zero' => 'please select company'
            ]);
        }
        $this->form_validation->set_rules('event_category_id', 'event category id', 'trim|required|numeric|is_natural_no_zero', [
            'is_natural_no_zero' => 'please select event category'
        ]);
        $this->form_validation->set_rules('package_id', 'package', 'trim|required|numeric|is_natural_no_zero', [
            'is_natural_no_zero' => 'please select package'
        ]);
        $this->form_validation->set_rules('title', 'title', 'trim|required');
        $this->form_validation->set_rules('location', 'location', 'trim|required');
        $this->form_validation->set_rules('physical_address', 'physical address', 'trim|required');
        $this->form_validation->set_rules('region', 'region', 'trim|required');
        $this->form_validation->set_rules('country_id', 'country', 'trim|required|numeric|is_natural_no_zero');
        $this->form_validation->set_rules('start_date', 'start date', 'trim|required');
        $this->form_validation->set_rules('end_date', 'end date', 'trim|required');
        $this->form_validation->set_rules('description', 'description', 'trim|required');
        $this->form_validation->set_rules('organizer_name', 'organizer name', 'trim|required');
        $this->form_validation->set_rules('organization_type', 'organization type', 'trim|required');
        $this->form_validation->set_rules('status', 'status', 'trim|required');
        $this->form_validation->set_rules('remark', 'remark', 'trim');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    
    public function payment_form($event_id) {
        $data['id'] = $event_id;
        $data['email'] = getLoginUserData('user_mail');

        $this->db->select('p.id as package_id, p.name, p.price, p.duration');
        $this->db->where('e.id', $event_id);
        $this->db->from('events as e');
        $this->db->join('packages as p', 'p.id = e.package_id', 'LEFT');
        $data['payment_data'] = $this->db->get()->row();
        
        $this->db->where('ref_id', $event_id );
        $row = $this->db->get('transactions')->row();
        if($row){
            
            $data = array(
		'id'            => $row->id,
		'table'         => $row->table,
		'ref_id'        => $row->ref_id,
		'paid_amount'   => $row->paid_amount,		
		'payment_status' => $row->payment_status,
		'email'         => $row->email,
		'created_at'    => $row->created_at,
	    );
            
            $this->viewAdminContent('event/event/payment_info', $data);
        } else {            
            
            $this->viewAdminContent('event/event/payment_form', $data);
        }       
    }

    public function make_payment()
    {
        ajaxAuthorized();
        //include Stripe PHP library
        require_once APPPATH.'third_party/stripe/init.php';
        \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));

        //Get job id
        $id = (int)$this->input->post('event_id');

        $this->db->select('p.id as package_id, p.name, p.price, p.duration');
        $this->db->where('e.id', $id);
        $this->db->from('events as e');
        $this->db->join('packages as p', 'p.id = e.package_id', 'LEFT');
        $payment_data = $this->db->get()->row();


        $message = null;
        $success = false;
        $charge = null;
        $chargeJson = null;
        $data = [];

        //Get event information by event id
        $row = $this->Event_model->get_event_by_id($id, $this->user_id, $this->role_id);
        if(empty($row)){
            $message = "The event you are trying to access doesn\'t exists!";
            echo json_encode(['success' => $success, 'message' => $message, 'data' => $data]);
            exit;
        }

        try {

            //Creates timestamp that is needed to make up orderid
            $timestamp = strftime('Y');
            //You can use any alphanumeric combination for the orderid. Although each transaction must have a unique orderid.
            $orderid = $timestamp.'-'.$id;
            $amount = $payment_data->price;

            //add customer to stripe
//            $customer = \Stripe\Customer::create(array(
//                        'email' => $this->input->post('email'),
//                        'source' => $this->input->post('stripeToken')
//            ));
//            pp($customer['Message']);

            //charge a credit or a debit card
            $charge = \Stripe\Charge::create([
                'amount'      => $amount*100,
                'currency'    => $this->config->item('stripe_currency'),
                'source'      => $this->input->post('stripeToken'),
                'description' => $row->title,
                'metadata'    => [
                    'event_id' => $orderid,
                ],
            ]);

        } catch (\Stripe\Error\Card $e) {
            // Since it's a decline, \Stripe\Error\Card will be caught
            $body = $e->getJsonBody();
        } catch (\Stripe\Error\RateLimit $e) {
            // Too many requests made to the API too quickly
            $body = $e->getJsonBody();
        } catch (\Stripe\Error\InvalidRequest $e) {
            // Invalid parameters were supplied to Stripe's API
            $body = $e->getJsonBody();
        } catch (\Stripe\Error\Authentication $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            $body = $e->getJsonBody();
        } catch (\Stripe\Error\ApiConnection $e) {
            // Network communication with Stripe failed
            $body = $e->getJsonBody();
        } catch (\Stripe\Error\Base $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            $body = $e->getJsonBody();
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            $body = $e->getJsonBody();
        }
        //Get response message
        $message = isset($body['error']['message']) ? $body['error']['message'] : null;

        if ($charge) {
            //retrieve charge details
            $chargeJson = $charge->jsonSerialize();

            //check whether the charge is successful
            if ($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1) {

                $data = [
                    'balance_transaction' => $chargeJson['balance_transaction'],
                    'receipt_url'         => $chargeJson['receipt_url'],
                    'order_id'            => $orderid,
                ];

                // insert response into db
                $saveData = array(
                    'ref_id' => $id,
                    'package_id' => $payment_data->package_id,
                    'paid_amount' => $amount,
                    'response' => json_encode($chargeJson),
                    'payment_status' => $chargeJson['status'],
                    'email' => $this->input->post('email'),
                    'created_at' => date("Y-m-d H:i:s"),
                    'table' => 'events',
                );

                $this->Transaction->insert_transaction($saveData);

                $success = true;
                $message = 'Payment made successfully.';

                $this->db->select('e.id as event_id, e.title, e.user_id, u.first_name, u.last_name, u.email');
                $this->db->where('e.id', $id);
                $this->db->from('events as e');
                $this->db->join('users as u', 'u.id = e.user_id');
                $event_details = $this->db->get()->row();
                if ($event_details) {
                    sendMail('onPaymentEvent', [
                        'full_name' => $event_details->first_name.' '.$event_details->last_name,
                        'event_title' => $event_details->title,
                        'event_url' => site_url(Backend_URL.'event/update/'.$event_details->event_id),
                        'receiver_id' => $event_details->user_id,
                        'receiver_email' => $event_details->email,
                        'cc' => getSettingItem('IncomingEmail'),
                    ]);
                }

            } else {

                // insert response into db
                $success = false;
                $message = 'Something went wrong.';
            }
        }

        echo json_encode(['success' => $success, 'message' => $message, 'data' => $data]);

    }

}
