<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Author: Khairul Azam
 * Date : 2016-10-13
 */

class Auth extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->library('form_validation');
    }

    public function login() {
        ajaxAuthorized();
        //sleep(1);
        /*
         * Stop Brute Force Attract   // by sleeping now... 
         * will add account deactivation letter      
         */

        $username = $this->security->xss_clean(trim($this->input->post('username')));
        $password = $this->security->xss_clean(trim($this->input->post('password')));
        $remember = ($this->input->post('remember')) ? (60 * 60 * 24 * 7) : 0;

        if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Please enter a valid user name</p>');
            exit;
        }
                        
        $user = $this->Auth_model->validateUser($username);
        if (!$user) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Incorrect Username!</p>');
            exit;
        }
        if (password_verify($password, $user->password) == false) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Incorrect Password!</p>');
            exit;
        }

        if ($user->status == 'Inactive') {
            echo ajaxRespond('Fail', '<p class="ajax_error">Your account is not active.</p>');
            exit;
        }
        $history_id = $this->login_history( $user->id, $user->role_id );
        $cookie_data = json_encode([
            'user_id' => $user->id,
            'company_id' => $user->company_id,
            'user_mail' => $user->email,
            'role_id' => $user->role_id,
            'name' => $user->first_name . ' ' . $user->last_name,
            'history' 	=> $history_id
        ]);

        $cookie = [
            'name' => 'login_data',
            'value' => base64_encode($cookie_data),
            'expire' => $remember,
            'secure' => false
        ];

        $this->input->set_cookie($cookie);
        $this->session->set_userdata($cookie);
        

        echo ajaxRespond('OK', '<p class="ajax_success">Login Success</p>');
        exit;
        // Save Session and refresh                              
    }

    public function sign_up(){
        ajaxAuthorized();
        $this->_rules();
        
    
        if ($this->form_validation->run() == FALSE) {             
            $valid = [
                'first_name'    => form_error('first_name'),             
                'last_name'     => form_error('last_name'),
                // 'role_id'       => form_error('role_id'),
                'email'         => form_error('email'),
                'password'      => form_error('password'),                
                'privacy_policy'=> form_error('privacy_policy'),                                
            ];
            
           $respond = [
               'status'     => 0,
               'errors'     => $valid,
               'message'    => 'Fail! Please fill up the form properly',
           ];
           echo ( json_encode( $respond ) );
           
        } else {
            $user_id = $this->create();            
            $this->auto_login( $user_id );
            $respond = [
                'status'     => 1,               
                'message'    => 'Account Created Successfully! Redirecting ...',
            ];
            echo ( json_encode( $respond ) );
        }
    }

    private function auto_login($user_id) {
        $username = $this->security->xss_clean($this->input->post('your_email'));
        $password = $this->security->xss_clean($this->input->post('password'));
        $remember = (60 * 60 * 24 * 7);
        $role_id    = 4;
        $history_id = $this->login_history( $user_id, $role_id );
        
        $cookie_data = json_encode([
            'user_id' => $user_id,
            'role_id' => $role_id,
            'user_mail' => $username,
            'name' => $this->input->post('first_name') . ' ' . $this->input->post('last_name'),
            'photo' => 'no-photo.gif',
            'history' => $history_id
            
        ]);

        $cookie = [
            'name'      => 'login_data',
            'value'     => base64_encode($cookie_data),
            'expire'    => $remember,
            'secure'    => false
        ];

        $this->input->set_cookie($cookie);
        $this->session->set_userdata($cookie);

        return ajaxRespond('OK', '<p class="ajax_success">Auto login success</p>');
    }

    public function logout() {

        $cookie = [
            'name' => 'login_data',
            'value' => false,
            'expire' => -84000,
            'secure' => false
        ];

        $this->input->set_cookie($cookie);
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('value');
        $this->session->unset_userdata('expire');
        $this->session->unset_userdata('secure');
        $this->session->unset_userdata('history');
        $this->logout_history();

        redirect(site_url('sign-in'));
    }

    public function login_form() {
        $this->load->view('auth/login');
    }

    private function create() {
        $first_name = $this->input->post('first_name', TRUE);
        $last_name  = $this->input->post('last_name', TRUE);
        $email      = $this->input->post('email', TRUE);        
        
        $user_data = [
            'role_id'       => 4,
            'first_name'    => $first_name,
            'last_name'     => $last_name,
            'email'         => $email,
            'add_line1'     => $this->input->post('address_line1', TRUE),
            'add_line2'     => $this->input->post('address_line2', TRUE),                                 
            'password'      => password_encription($this->input->post('password', TRUE)),
            'status'        => 'Pending',
            'created'       => date('Y-m-d H:i:s'),
        ];
        $this->Auth_model->sign_up($user_data);

        $user_id = $this->db->insert_id();
                        
        $user_data['user_id']   = $user_id;
        $user_data['raw_pass']  = $this->input->post('password', TRUE);
        
        Modules::run('mail/sendWelcomeMail', $user_data);
        return $user_id;
    }    
    
    public function _rules(){
        $this->form_validation->set_rules('first_name', 'first name', 'trim|required', array(
            'required' => 'Enter your first name'
        ));
        $this->form_validation->set_rules('email', 'email', 'trim|valid_email|required|is_unique[users.email]', 
                [ 'is_unique' => '<span id="your_email_error">This email already in used. Try another one</span>', 
                  'valid_email' => '<span id="your_email_error">Please enter a valid email address</span>',
                  'required' => '<span id="your_email_error">Enter your email address</span>'
                ]);
        // $this->form_validation->set_rules('role_id', 'role_id', 'required|less_than[7]|greater_than[4]');
        $this->form_validation->set_rules('privacy_policy', 'privacy policy', 'required', array(
            'required' => 'You must accpet privacy policy'
        )); 
        $this->form_validation->set_rules('password', 'password field', 'required', array(
            'required' => 'Password field is required'
        ));        
        $this->form_validation->set_error_delimiters('<span class="req"><p>', '</p></span>');	
    } 

    public function forgot_pass() {
        $email      = $this->input->post('forgot_mail');
        $is_exist   = $this->db->get_where('users', ['email' => $email])->num_rows();

        if ($is_exist) {
            $hash_email = password_hash($email, PASSWORD_DEFAULT);

            $array = [
                'email' => $email,
                'Status' => 'OK',
                '_token' => $hash_email,
                'Msg' => '<p class="ajax_success">Reset password link sent to your email </p>'
            ];

            Modules::run('mail/pwd_mail', $array);
            echo json_encode($array);
        } else {
            echo ajaxRespond('Fail', '<p class="ajax_error">Email address not found!</p>');
        }
    }

    public function reset_password() {
        $this->load->view('auth/reset');
    }

    public function reset_password_action() {
        $reset_token    = $this->input->post('verify_token');
        $email          = trim($this->input->post('email'));

        $new_pass   = $this->input->post('new_password');
        $re_pass    = $this->input->post('retype_password');
        $hash_pass  = password_encription($new_pass);

        // send mail here 
        if (password_verify($email, $reset_token)) {
            if ($new_pass == $re_pass) {
                $this->db->set('password', $hash_pass);
                $this->db->where('email', $email);
                $this->db->update('users');                
                echo ajaxRespond('OK', '<p class="ajax_success">Password Reset Successfully</p>');
            } else {
                echo ajaxRespond('Fail', '<p class="ajax_error">Confirm Password Not Match</p>');
            }            
        } else {
            echo ajaxRespond('Fail', '<p class="ajax_error">Token Not Match</p>');
        }
    }
  
    private function  login_history( $user_id  =  null, $role_id = 0 ) {
        $this->load->library('user_agent');
        if ($this->agent->is_browser()){
            $agent = $this->agent->browser();
        } elseif ($this->agent->is_robot()) {
            $agent = $this->agent->robot();
        }  elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        } else {
             $agent = 'Unidentified User Agent';
        }
       
                
        $history = [
            'user_id'       => $user_id,
            'login_time'    => date('Y-m-d H:s:i'),            
            'ip'            => getenv('REMOTE_ADDR'),          
            'role_id'       => $role_id,
            'browser'       => $agent,
            'device'        => $this->agent->platform(),
        ];
                
        $this->db->insert('user_logs', $history );
        return $this->db->insert_id();        
    }
    
    private function logout_history(){
        $id     = getLoginUserData('history');        
        $this->db->set('logout_time', date('Y-m-d H:i:s') );        
        $this->db->where('id', $id );
        $this->db->update('user_logs');
    }
}