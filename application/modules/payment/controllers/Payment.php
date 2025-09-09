<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
/* Author: Khairul Azam
 * Date : 2020-03-16
 */

class Payment extends Admin_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Payment_model');        
    }

    public function index(){
        $q          = urldecode($this->input->get('q', TRUE));
        $start      = intval($this->input->get('start'));
        
        $config['base_url']     = build_pagination_url( Backend_URL . 'payment/', 'start');
        $config['first_url']    = build_pagination_url( Backend_URL . 'payment/', 'start');

        $config['per_page']     = 25;
        $config['page_query_string'] = TRUE;
        $config['total_rows']   = $this->Payment_model->total_rows($q);
        $payments               = $this->Payment_model->get_limit_data($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'payments' => $payments,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->viewAdminContent('payment/payment/index', $data);
    }

    public function details($id){
        $row = $this->Payment_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'table' => $row->table,
		'ref_id' => $row->ref_id,
		'paid_amount' => $row->paid_amount,
		'response' => $this->explore( json_decode($row->response, true)),
		'payment_status' => $row->payment_status,
		'email' => $row->email,
		'created_at' => $row->created_at,
	    );            
            
            $this->load->view('payment/payment/details', $data);
        } 
    }

    private function explore( $array ){        
        $output = '<table class="table table-striped no-margin table-bordered">';
        foreach($array as $key=>$log ){
            $row = is_array($log) ? $this->explore($log) : $log;
            $output .= '<tr>';
                $output .= '<td width="100">'. $key .'</td>';
                $output .= '<td width="5">:</td>';
                $output .= '<td>'. $row .'</td>';
            $output .= ' </tr>';
        }
        $output .= '</table>';
        return $output;
    }

    public function _menu(){
        return add_main_menu('Payment', 'admin/payment', 'payment', 'fa-hand-o-right');        
    }
}