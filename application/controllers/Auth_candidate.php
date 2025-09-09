<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Author: Iqbal Hossen
 * Date : 2020-02-25
 */

class Auth_candidate extends Frontend_controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Candidate_model');
        // Load facebook oauth library 
        $this->load->library('facebook');
        // Load google oauth library 
        $this->load->library('google');
    }
    
    public function employer_singup_action() {
        $email = $this->input->post('email');
        $is_exist = $this->db->get_where('users', ['email' => $email])->num_rows();

        $rules = array(
            array(
                'field' => 'first_name',
                'label' => 'First Name',
                'rules' => 'required'
            ),
            array(
                'field' => 'last_name',
                'label' => 'Last Name',
                'rules' => 'required'
            ),
            array(
                'field' => 'company_name',
                'label' => 'Company Name',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You must provide a %s.',
                ),
            ),
             array(
                'field' => 'org_type_id',
                'label' => 'Organization Type',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'Select must be a %s.',
                ),
            ),
            array(
                'field' => 'email',
                'label' => 'Email Address',
                'rules' => 'trim|required|valid_email',
                'errors' => array(
                    'required' => 'You must provide a %s.',
                ),
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required'
            ),
            array(
                'field' => 'retype_password',
                'label' => 'Retype Password',
                'rules' => 'required|matches[password]'
            )
        );
                
        $this->form_validation->set_rules($rules);
        
        //If Invalid Data
        $data['org_type_id'] = $this->input->post('org_type_id');
        $data['loginFormStyle'] = 'style="display:none;"';
        $data['singupFormStyle'] = 'style="display:block;"';
        $data['resetPassFormStyle'] = 'style="display:none;"';
        // Facebook authentication url 
        $data['fbLoginURL'] = $this->facebook->employer_login_url();
        $data['googleLoginURL'] = $this->google->getLoginUrl();
        
        $captcha = $this->input->post('captcha');
        $confirm = (int) $this->session->userdata('captcha_val1') + (int) $this->session->userdata('captcha_val2');                
        
        
        if ($captcha != $confirm ) {            
            $this->session->set_flashdata('message', '<p class="text-danger">Sum Not match please try again.</p>');            
            $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');           
            $this->viewFrontContent('frontend/employer', $data);
            return false;
        }        
        
        if ($this->form_validation->run() == FALSE || ($is_exist)) {            
            if($is_exist) {
               $this->session->set_flashdata('message', '<p class="text-danger">This email already has taken!</p>');
            }
            $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');           
            $this->viewFrontContent('frontend/employer', $data);
            return false;
        }

        $postData = $this->input->post();
        $saveField = array(
            'first_name' => $postData['first_name'],
            'last_name' => $postData['last_name'],
            'company_name' => $postData['company_name'],
            'role_id' => 4,
            'org_type_id' => $postData['org_type_id'],
            'email' => $postData['email'],
            'password' => password_encription($postData['password'], true),
            'created_at' => date("Y-m-d H:i:s"),
            'status' => 'Waiting',
        );

        if ($this->db->insert('users', $saveField)) {
            $lastId = $this->db->insert_id();

            $array = [
                'id' => $lastId,
                'email' => $saveField['email'],
                'date' => $saveField['created_at']
            ];
            $code = encode(json_encode($array), 'jhgjh^gkjg8KJHG^T*%(^%k');

            sendMail('onRegisterCompany', [
                'cc'                => getSettingItem('IncomingEmail'),
                'SiteTitle'         => getSettingItem('SiteTitle'),
                'receiver_id'       => $lastId,
                'receiver_email'    => $postData['email'],
                'full_name'         => $postData['first_name'].' '.$postData['last_name'],
                'verification'   => "<a target='_blank' href='".site_url('recruiter?verification='.$code)."'>Click here to verify your account</a>"
            ]);
           
            $this->session->set_flashdata('msgs', 'Recruiter Registration Has Been Successfully');
            redirect(site_url('recruiter'));
        } else {
            $this->session->set_flashdata('msge', "Recruiter Registration Could't be Created!");

            $this->viewFrontContent('frontend/employer', $data);
            return false;
        }
    }

    // This function use for employer login from
    public function employer($file_name) {
        $data['meta_title']         = getSettingItem('SiteTitle') .' | Recruiter Log in';
        $data['meta_description']   = 'Log in page';
        $data['meta_keywords']      = 'Log in page';
        $user_id = getLoginUserData('user_id');

        if($user_id){
            redirect(site_url('admin'));
        }
        
        $data['org_type_id'] = 0;
        // Facebook authentication url
        $data['fbLoginURL'] = $this->facebook->employer_login_url();
        $data['googleLoginURL'] = $this->google->getLoginUrl();

        $data['loginFormStyle'] = 'style="display:block;"';
        $data['singupFormStyle'] = 'style="display:none;"';
        $data['resetPassFormStyle'] = 'style="display:none;"';

        $verification = $this->input->get('verification');
        if(isset($verification)){
            $verification = decode($verification, 'jhgjh^gkjg8KJHG^T*%(^%k');
            $verification = json_decode($verification);
            if($verification){
                $row = $this->db->get_where('users', ['id' => $verification->id, 'email' => $verification->email, 'created_at' => $verification->date])->row();
                if($row){
                    if($row->status == 'Waiting'){
                        $this->db->update('users', ['status'=>'Active'], ['id'=>$verification->id]);
                        $this->session->set_flashdata('verification', '<p class="ajax_success">Your account verification successfully!</p>');
                    } else {
                        $this->session->set_flashdata('verification', '<p class="ajax_notice">Your account already verified!</p>');
                    }
                } else {
                    $this->session->set_flashdata('verification', '<p class="ajax_error">Your account verification fail! Please try again!</p>');
                }
            }
        }

        $this->viewFrontContent('frontend/'.$file_name, $data);
    }

    public function store() {
        $email = $this->input->post('email'); // get parent category
        $is_exist = $this->db->get_where('candidates', ['email' => $email, 'oauth_provider' => null])->num_rows();

        $rules = array(
            array(
                'field' => 'first_name',
                'label' => 'First Name',
                'rules' => 'required'
            ),
            array(
                'field' => 'last_name',
                'label' => 'Last Name',
                'rules' => 'required'
            ),
            array(
                'field' => 'email',
                'label' => 'Email Address',
                'rules' => 'trim|required|valid_email',
//                'rules' => 'trim|required|valid_email|callback_unique_email',
                'errors' => array(
                    'required' => 'You must provide a %s.',
                ),
            ),
            array(
                'field' => 'mobile_number',
                'label' => 'Mobile Number',
                'rules' => 'required',
                'errors' => array(
                    'required' => 'You must provide a %s.',
                ),
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required'
            ),
            array(
                'field' => 'retype_password',
                'label' => 'Retype Password',
                'rules' => 'required|matches[password]'
            )
        );

        $this->form_validation->set_rules($rules);
        
        if ($this->form_validation->run() == FALSE || ($is_exist)) {
            
            if($is_exist) {
               $this->session->set_flashdata('message', '<p class="ajax_error">This email already has taken!</p>');
            }
            $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
            
            $data['loginFormStyle'] = 'style="display:none;"';
            $data['singupFormStyle'] = 'style="display:block;"';
            $data['resetPassFormStyle'] = 'style="display:none;"';
            // Facebook authentication url 
            $data['authURL'] = $this->facebook->login_url();
            $data['googleLoginURL'] = $this->google->getLoginUrl();

            $this->viewFrontContent('frontend/candidate/login', $data);
            return false;
        }

        $postData = $this->input->post();
        $saveField = array(
            'first_name' => $postData['first_name'],
            'last_name' => $postData['last_name'],
            'full_name' => $postData['first_name'].' '.$postData['last_name'],
            'email' => $postData['email'],
            'password' => password_encription($postData['password'], true),
            'mobile_number' => $postData['mobile_number'],
            'created_at' => date("Y-m-d H:i:s"),
            'status' => 'Waiting',
        );

        $insert_id = $this->Candidate_model->store($saveField);
        if ($insert_id) {
            $array = [
                'id' => $insert_id,
                'email' => $postData['email'],
                'date' => $saveField['created_at']
            ];
            $code = encode(json_encode($array), 'jhgjh^gkjg8KJHG^T*%(^%k');
            sendMail('onRegisterCandidate', [
                'cc'            => getSettingItem('IncomingEmail'),
                'receiver_id'   => $insert_id,
                'SiteTitle'     => getSettingItem('SiteTitle'),
                'receiver_email' => $postData['email'],
                'full_name'      => $postData['first_name'].' '.$postData['last_name'],
                'url'            => "<a target='_blank' href='".site_url('myaccount/profile')."'>".site_url('myaccount/profile')."</a>",
                'verification'   => "<a target='_blank' href='".site_url('login?verification='.$code)."'>Click here to verify your account</a>"
            ]);

            $this->session->set_flashdata('message', '<p class="ajax_success">Candidate Registration Has Been Successfully. Please check your email.</p>');
            redirect(site_url('myaccount/profile'));
        } else {
            $this->session->set_flashdata('message', '<p class="ajax_error">Candidate Registration Could\'t be Created! </p>');

            $data['loginFormStyle'] = 'style="display:none;"';
            $data['singupFormStyle'] = 'style="display:block;"';
            $data['resetPassFormStyle'] = 'style="display:none;"';
            // Facebook authentication url 
            $data['authURL'] = $this->facebook->login_url();
            $data['googleLoginURL'] = $this->google->getLoginUrl();

            $this->viewFrontContent('frontend/candidate/login', $data);
            return false;
        }
    }

    public function unique_email() {
        $email = $this->input->post('email'); // get parent category
        $is_exist = $this->db->get_where('candidates', ['email' => $email, 'oauth_provider' => null])->num_rows();

        if (!$is_exist) {
            $this->form_validation->set_message('unique_email', 'This email already has taken!');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function login_form($file_name) {

        // Authenticate user with facebook 
        if ($this->facebook->is_authenticated()) {
            $this->facebook_callback();
        }

        // Authenticate user with facebook 
        if ($this->google->isLoggedIn() || $this->session->userdata('loggedIn')) {
            redirect(site_url('myaccount/profile'));
        }

        // Facebook authentication url 
        $data['authURL'] = $this->facebook->login_url();
        $data['googleLoginURL'] = $this->google->getLoginUrl();

        $data['loginFormStyle'] = 'style="display:block;"';
        $data['singupFormStyle'] = 'style="display:none;"';
        $data['resetPassFormStyle'] = 'style="display:none;"';
        
        $data['meta_title']         = getSettingItem('SiteTitle') .' | ' . 'Log in page';
        $data['meta_description']   = 'Log in page';
        $data['meta_keywords']      = 'Log in page';

        $verification = $this->input->get('verification');
        if(isset($verification)){
            $verification = decode($verification, 'jhgjh^gkjg8KJHG^T*%(^%k');
            $verification = json_decode($verification);
            if($verification){
                $row = $this->db->get_where('candidates', ['id' => $verification->id, 'email' => $verification->email, 'created_at' => $verification->date])->row();
                if($row){
                    if($row->status == 'Waiting'){
                        $this->db->update('candidates', ['status'=>'Active'], ['id'=>$verification->id]);
                        $this->session->set_flashdata('verification', '<p class="ajax_success">Your account verification successfully!</p>');
                    } else {
                        $this->session->set_flashdata('verification', '<p class="ajax_notice">Your account already verified!</p>');
                    }
                } else {
                    $this->session->set_flashdata('verification', '<p class="ajax_error">Your account verification fail! Please try again!</p>');
                }
            }
        }

        $this->viewFrontContent('frontend/candidate/'.$file_name, $data);
    }

    //This function use for facebook call back function
    public function facebook_callback() {

        if ($this->facebook->is_authenticated()) {
            
            // Get user info from facebook 
            $fbUser = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,link,gender,picture');
            if(!empty($fbUser['id'])){
                
                // Preparing data for database insertion 
                $userData['oauth_provider'] = 'facebook';
                $userData['oauth_uid'] = !empty($fbUser['id']) ? $fbUser['id'] : null;
                $userData['first_name'] = !empty($fbUser['first_name']) ? $fbUser['first_name'] : null;
                $userData['last_name'] = !empty($fbUser['last_name']) ? $fbUser['last_name'] : null;
                $userData['full_name'] = $userData['first_name'] . ' ' . $userData['last_name'];
                $userData['email'] = !empty($fbUser['email']) ? $fbUser['email'] : null;
                $userData['gender'] = !empty($fbUser['gender']) ? $fbUser['gender'] : null;
                $userData['picture'] = !empty($fbUser['picture']['data']['url']) ? $fbUser['picture']['data']['url'] : null;

                // Insert or update user data to the database 
                $userID = $this->Candidate_model->checkFacebookGoogleUser($userData);

                // Check user data insert or update status 
                if (!empty($userID)) {
                    $data['userData'] = $userData;

                    // Store the user profile info into session 
                    $cookie_data = json_encode([
                        'id' => $userID,
                        'email' => $userData['email'],
                        'name' => $userData['full_name']
                    ]);

                    $cookie = [
                        'name' => 'candidate_data',
                        'value' => base64_encode($cookie_data),
                        'expire' => 60 * 60 * 24 * 7,
                        'secure' => false
                    ];

                    $this->input->set_cookie($cookie);
                    $this->session->set_userdata($cookie);

                    // Store the status and user profile info into session 
                    $this->session->set_userdata('loggedIn', true);

                }//if
                
                redirect(site_url('myaccount/profile'));
            }//if
            redirect(site_url('login'));
            //The user has been successfully re-authenticated.
        }
        // Facebook authentication url 
        redirect(site_url('login'));
    }

    //This function use for google call back function
    public function google_callback() {

        if (isset($_GET['code'])) {
            $this->google->setAccessToken();

            $gUserInfo = $this->google->getUserInfo(); //get user info 
            // Preparing data for database insertion 
            $userData['oauth_provider'] = 'google';
            $userData['oauth_uid'] = $gUserInfo->id;
            $userData['first_name'] = $gUserInfo->givenName;
            $userData['last_name'] = $gUserInfo->familyName;
            $userData['full_name'] = $gUserInfo->name;
            $userData['email'] = $gUserInfo->email;
            $userData['gender'] = !empty($gUserInfo->gender) ? $gUserInfo->gender : null;
            $userData['picture'] = !empty($gUserInfo->picture) ? $gUserInfo->picture : null;

            // Insert or update user data to the database 
            $userID = $this->Candidate_model->checkFacebookGoogleUser($userData);

            // Check user data insert or update status 
            if (!empty($userID)) {

                // Store the user profile info into session 
                $cookie_data = json_encode([
                    'id' => $userID,
                    'email' => $userData['email'],
                    'name' => $userData['full_name']
                ]);

                $cookie = [
                    'name' => 'candidate_data',
                    'value' => base64_encode($cookie_data),
                    'expire' => 60 * 60 * 24 * 7,
                    'secure' => false
                ];

                $this->input->set_cookie($cookie);
                $this->session->set_userdata($cookie);
                // Store the status and user profile info into session 
                $this->session->set_userdata('loggedIn', true);
                redirect(site_url('myaccount/profile'));
            }

            redirect(site_url('myaccount/profile'));
        } else {
            $error = 'User denied permission';
            redirect(site_url('login'));
        }
    }

    public function web_login() {

        $username = $this->security->xss_clean(trim($this->input->post('username')));
        $password = $this->security->xss_clean(trim($this->input->post('password')));
        //$remember = ($this->input->post('remember')) ? (60 * 60 * 24 * 7) : 0;

        if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Please enter a valid email</p>');
            exit;
        }

//        $socialSingInExist = $this->socialSigninCheck($username);
//        if($socialSingInExist){
//            echo ajaxRespond('Fail', '<p class="ajax_error">This email sign in fcebook/google!</p>');
//            exit;
//        }

        $candidate = $this->find($username);
        if (!$candidate) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Incorrect Email Address!</p>');
            exit;
        }

        if ($candidate->oauth_provider == 'facebook') {
            echo ajaxRespond('Fail', '<p class="ajax_error">Please Sign in with Facebook!</p>');
            exit;
        }

        if ($candidate->oauth_provider == 'google') {
            echo ajaxRespond('Fail', '<p class="ajax_error">Please Sign in with Google!</p>');
            exit;
        }

        if (password_verify($password, $candidate->password) == false) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Incorrect Password!</p>');
            exit;
        }

        if ($candidate->status == 'Inactive') {
            echo ajaxRespond('Fail', '<p class="ajax_error">Your account is not active.</p>');
            exit;
        }

        if ($candidate->status == 'Waiting') {
            echo ajaxRespond('Fail', '<p class="ajax_error">Your account not verified.</p>');
            exit;
        }

        $this->saveSession($candidate);
        echo ajaxRespond('OK', '<p class="ajax_success">Login Success</p>');
        exit;
    }

    public function forgot_pass() {
        ajaxAuthorized();
        $email = $this->input->post('forgot_mail');

        $this->db->select('id,email,full_name');
        $candidate = $this->db->get_where('candidates', ['email' => $email, 'oauth_provider' => null])->row();
        if ($candidate) {
            $_token = encode($candidate->id, 'NGO_Career@2020');
            $array = [
                'Status' => 'OK',
                'email' => $email,               
                '_token' => $_token,
                'Msg' => '<p class="ajax_success">Reset password link sent to your email</p>'
            ];

            sendMail('onForgotPasswordCandidate', [
                'subject'         => getSettingItem('SiteTitle'),
                'receiver_id'       => $candidate->id,
                'receiver_email'    => $candidate->email,
                'url'               => site_url("/reset_password?token={$_token}"),
                'full_name'         => $candidate->full_name
            ]);

            echo json_encode($array);
        } else {
            echo ajaxRespond('Fail', '<p class="ajax_error">Email address not found!</p>');
        }
    }
    
    public function reset_password() {

        $token = $this->input->get('token');
        $data['token'] = $token;
        $data['meta_title']         = getSettingItem('SiteTitle') .' | ' . 'Log in page';
        $data['meta_description']   = 'Log in page';
        $data['meta_keywords']      = 'Log in page';
        
        $this->viewFrontContent('frontend/candidate/reset_password', $data);
    }
    
    public function reset_pass_action() {
        
        ajaxAuthorized();       
        $token    = $this->input->post('token');
        $new_pass = $this->input->post('new_pass');
        $con_pass = $this->input->post('con_pass');
        
        if ($new_pass != $con_pass) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Confirm Password Not Match</p>');
            exit;
        }

        $candidate_id = decode($token, 'NGO_Career@2020');
        $this->db->select('id,email,mobile_number,full_name');
        $this->db->where('id', $candidate_id );
        $candidate  = $this->db->select('email')->get('candidates')->row();        

        if ($candidate) {
            $hass_pass = password_encription($new_pass);
            $this->db->update('candidates', ['password' => $hass_pass], ['id' => $candidate_id ]);
            $this->saveSession($candidate);
            echo ajaxRespond('OK', '<p class="ajax_success">Password Reset Successfully</p>');
        } else {
            echo ajaxRespond('Fail', '<p class="ajax_error">Old Password not match, please try again.</p>');
        }        
    }
    
    private function saveSession($candidate){
        $remember = (60 * 60 * 24 * 7);
        $cookie_data = json_encode([
            'id'        => $candidate->id,
            'email'     => $candidate->email,
            'mobile'    => $candidate->mobile_number,
            'name'      => $candidate->full_name
        ]);

        $cookie = [
            'name' => 'candidate_data',
            'value' => base64_encode($cookie_data),
            'expire' => $remember,
            'secure' => false
        ];

        $this->input->set_cookie($cookie);
        $this->session->set_userdata($cookie);
        // Store the status and user profile info into session 
        $this->session->set_userdata('loggedIn', true);
    }

    private function find($username) {
        $this->db->select('id,email,mobile_number,full_name,oauth_provider,password,status');
        $this->db->where(['email' => $username, 'oauth_provider' => null]);
        return $this->db->get('candidates')->row();
    }

    private function socialSigninCheck($email) {
        return $this->db
                        ->select('*')
                        ->where('email', $email)
                        ->where_in('oauth_provider', ['facebook', 'google'])
                        ->get('candidates')
                        ->row();
    }

    public function logout() {
        // Remove local Facebook session 
        $this->facebook->destroy_session();
        // Remove user data from session 
//        $this->session->unset_userdata('userData'); 
        // Reset OAuth access token 
        $this->google->logout();

        $cookie = [
            'name' => 'candidate_data',
            'value' => false,
            'expire' => -84000,
            'secure' => false
        ];

        $this->input->set_cookie($cookie);
        $this->session->set_userdata('loggedIn', false);
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('value');
        $this->session->unset_userdata('expire');
        $this->session->unset_userdata('secure');
        redirect(site_url('login'));
    }

}
