<?php defined('BASEPATH') or exit('No direct script access allowed');

/* 
 * Author: Khairul Azam
 * Date : 2016-10-13
 */

class Auth extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->library('form_validation');
        // Load facebook oauth library 
        $this->load->library('facebook');
        // Load google oauth library 
        $this->load->library('google');
    }

    public function login()
    {
        ajaxAuthorized();
        //sleep(1);
        /*
         * Stop Brute Force Attract   // by sleeping now... 
         * will add account deactivation letter      
         */

        $username = $this->security->xss_clean(trim($this->input->post('username')));
        $password = $this->security->xss_clean(trim($this->input->post('password')));
        //$remember = ($this->input->post('remember')) ? (60 * 60 * 24 * 7) : 0;

        if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
            echo ajaxRespond('Fail', '<p class="ajax_error">Please enter a valid user name</p>');
            exit;
        }

        $user = $this->Auth_model->find($username);
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
        $this->saveSession($user);

        echo ajaxRespond('OK', '<p class="ajax_success">Login Success</p>');
        exit;
        // Save Session and refresh                              
    }

    private function saveSession($user)
    {
        $remember = (60 * 60 * 24 * 7);
        $history_id = $this->login_history($user);
        $cookie_data = json_encode([
            'user_id' => $user->id,
            'user_mail' => $user->email,
            'role_id' => $user->role_id,
            'name' => $user->first_name . ' ' . $user->last_name,
            'logo' => $user->logo,
            'history'     => $history_id
        ]);

        $cookie = [
            'name' => 'login_data',
            'value' => base64_encode($cookie_data),
            'expire' => $remember,
            'secure' => false
        ];

        $this->input->set_cookie($cookie);
        $this->session->set_userdata($cookie);
    }

    public function logout()
    {

        // Remove local Facebook session 
        $this->facebook->destroy_session();
        // Remove user data from session 
        // Reset OAuth access token 
        $this->google->logout();

        $cookie = array(
            'name' => 'login_data',
            'value' => false,
            'expire' => -84000,
            'secure' => false
        );

        $this->input->set_cookie($cookie);
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('value');
        $this->session->unset_userdata('expire');
        $this->session->unset_userdata('secure');
        $this->session->unset_userdata('history');
        $this->logout_history();

        redirect(site_url('recruiter'));
    }

    public function login_form()
    {

        $this->load->view('auth/login');
    }

    //This function use for facebook call back function
    public function facebook_callback()
    {

        if ($this->facebook->is_authenticated()) {

            // Get user info from facebook 
            $fbUser = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,link,gender,picture');
            if (!empty($fbUser['id'])) {
                // Preparing data for database insertion 
                $userData['oauth_provider'] = 'facebook';
                $userData['oauth_uid'] = !empty($fbUser['id']) ? $fbUser['id'] : null;
                $userData['first_name'] = !empty($fbUser['first_name']) ? $fbUser['first_name'] : null;
                $userData['last_name'] = !empty($fbUser['last_name']) ? $fbUser['last_name'] : null;
                $userData['email'] = !empty($fbUser['email']) ? $fbUser['email'] : null;
                $userData['logo'] = !empty($fbUser['picture']['data']['url']) ? $fbUser['picture']['data']['url'] : null;

                // Insert or update user data to the database 
                $userID = $this->Auth_model->checkFacebookGoogleUser($userData);

                // Check user data insert or update status 
                if (!empty($userID)) {
                    $data['userData'] = $userData;

                    $userData['id'] = $userID;
                    $userData['role_id'] = 4;

                    $history_id = $this->login_history((object) $userData);
                    $cookie_data = json_encode([
                        'user_id' => $userID,
                        'user_mail' => $userData['email'],
                        'role_id' => 4,
                        'name' => $userData['first_name'] . ' ' . $userData['last_name'],
                        'logo' => $userData['logo'],
                        'history'     => $history_id
                    ]);

                    $cookie = [
                        'name' => 'login_data',
                        'value' => base64_encode($cookie_data),
                        'expire' => 60 * 60 * 24 * 7,
                        'secure' => false
                    ];

                    $this->input->set_cookie($cookie);
                    $this->session->set_userdata($cookie);
                } //if

                redirect(site_url('admin'));
            } //if                        
            //The user has been successfully re-authenticated.
        }
        // Facebook authentication url 
        redirect(site_url('recruiter'));
    }

    //This function use for google call back function
    public function google_callback()
    {

        if (isset($_GET['code'])) {
            $this->google->setAccessToken();

            $gUserInfo = $this->google->getUserInfo(); //get user info 
            // Preparing data for database insertion 
            $userData['oauth_provider'] = 'google';
            $userData['oauth_uid'] = $gUserInfo->id;
            $userData['first_name'] = $gUserInfo->givenName;
            $userData['last_name'] = $gUserInfo->familyName;
            //            $userData['company_name'] = $gUserInfo->name;
            $userData['email'] = $gUserInfo->email;

            // Insert or update user data to the database 
            $userID = $this->Auth_model->checkFacebookGoogleUser($userData);

            // Check user data insert or update status 
            if (!empty($userID)) {

                $userData['id'] = $userID;
                $userData['role_id'] = 4;
                $history_id = $this->login_history((object) $userData);

                $cookie_data = json_encode([
                    'user_id' => $userID,
                    'user_mail' => $userData['email'],
                    'role_id' => 4,
                    'name' => $userData['first_name'] . ' ' . $userData['last_name'],
                    'logo' => null,
                    'history'     => $history_id
                ]);

                $cookie = [
                    'name' => 'login_data',
                    'value' => base64_encode($cookie_data),
                    'expire' => 60 * 60 * 24 * 7,
                    'secure' => false
                ];

                $this->input->set_cookie($cookie);
                $this->session->set_userdata($cookie);

                redirect(site_url('admin'));
            }

            redirect(site_url('admin'));
        } else {
            $error = 'User denied permission';
            redirect(site_url('recruiter'));
        }
    }

    public function forgot_pass()
    {
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

    public function reset_password()
    {
        $this->load->view('auth/reset');
    }

    public function reset_password_action()
    {
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

                $user = $this->Auth_model->find($email);
                $this->saveSession($user);

                echo ajaxRespond('OK', '<p class="ajax_success">Password Reset Successfully</p>');
            } else {
                echo ajaxRespond('Fail', '<p class="ajax_error">Confirm Password Not Match</p>');
            }
        } else {
            echo ajaxRespond('Fail', '<p class="ajax_error">Token Not Match</p>');
        }
    }

    private function login_history($user)
    {
        $this->load->library('user_agent');
        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser();
        } elseif ($this->agent->is_robot()) {
            $agent = $this->agent->robot();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        } else {
            $agent = 'Unidentified User Agent';
        }

        $history = [
            'user_id'       => $user->id,
            'login_time'    => date('Y-m-d H:s:i'),
            'ip'            => getenv('REMOTE_ADDR'),
            'role_id'       => $user->role_id,
            'browser'       => $agent,
            'device'        => $this->agent->platform(),
        ];

        $this->db->insert('user_logs', $history);
        return $this->db->insert_id();
    }

    private function logout_history()
    {
        $id     = getLoginUserData('history');
        $this->db->set('logout_time', date('Y-m-d H:i:s'));
        $this->db->where('id', $id);
        $this->db->update('user_logs');
    }
}
