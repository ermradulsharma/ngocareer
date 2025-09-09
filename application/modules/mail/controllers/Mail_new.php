<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mail extends MX_Controller {
    
    private $site_title = '--Title Not Setup--';
    private $subject    = 'Someone try to send mail without subject';
    public $send_from   = 'flickmedialtd@gmail.com';
    public $from_name   = '--Flick Media Ltd--';
    public $send_to     = 'skyview059@gmail.com';
    public $cc     = null;
    public $body;
    private $ip;
    private $signature;

    public function __construct() {
        parent::__construct();
        $this->ip           = $this->input->ip_address();
        // Must Be Self Domain Email or SMTP
        $this->send_from    = getSettingItem('OutgoingEmail'); 
        $this->send_to      = getSettingItem('IncomingEmail');
        $this->from_name    = getSettingItem('SiteTitle');
        $this->site_title   = getSettingItem('SiteTitle');
        $this->return_path  = $this->send_to;
        $this->signature    = getSettingItem('EmailFooterSignature');
        $this->cc           = null;
    }
    
    public function index() {
        redirect(site_url());
    }
    
    public function test() {
        $this->send_to  = 'flickmedialtd@gmail.com';
        $this->subject  = "Test Mail || {$this->site_title}";
        
        $this->body     = '<p>Lorem Ipsum is simply dummy text of the printing '
                            . 'and typesetting industry. Lorem Ipsum has '
                            . 'been the industry</p>';

        echo $this->send();
    }

    //This function use for job alert mail send with cron job
    public function sendJobAlerts( $option = []) {
        $this->send_to = $option['send_to'];
        $this->subject = $option['subject'];
        $this->body = $option['body'];
        $this->log();
        $this->save_in_db('jobAlert', $option['candidate_id'], 1);
        return $this->send();
    }
    
    public function pwd_mail($array = array()) {
        $email = $array['email'];
        $token = $array['_token'];

        $user = $this->db->get_where('users', ['email' => $email])->row();
        if($user){
            return sendMail('onForgotPassword', [
                'receiver_id'       => $user->id,
                'receiver_email'    => $user->email,
                'url'               => base_url() . 'auth/reset_password?token=' . $token . '&email=' . $email,
                'full_name'         => $user->first_name
            ]);
        }
    }

    private function useEmailTeamplate($slug = '') {
        $this->db->select('title, template');
        $this->db->where('slug', $slug);
        $data = $this->db->get('email_templates')->row();
        if($data){
            return $data;
        } else {
            return (object) array( 'template' => 'Empty', 'title'=> "Unknown Subject || {$this->from_name}");
        }        
    }

    private function log() {
        $log_path = APPPATH . '/logs/mail_log.txt';
        $mail_log = date('Y-m-d H:i:s A') . ' | ' . $this->ip . ' | ' . $this->subject .' | ' . $this->send_from  .' | ' . $this->send_to . "\r\n";
        file_put_contents($log_path, $mail_log, FILE_APPEND);
    }

    private function save_in_db($mail_type = 'general', $receiver_id = 0, $sender_id = 0 ) {
        $data = [
            'mail_type'     => $mail_type,            
            'sender_id'     => $sender_id,
            'receiver_id'   => $receiver_id,
            'mail_from'     => $this->send_from,
            'mail_to'       => $this->send_to,
            'subject'       => $this->subject,
            'body'          => $this->getDefaultLayout($this->body),
            'sent_at'       => date('Y-m-d H:i:s')
        ];
        $this->db->insert('mails', $data);
    }

    private function send() {
        $this->load->library('email');
                
        $config['charset']  = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $config['newline']  = "\r\n";
        
        $config['protocol'] = 'smtp';
        $config['starttls'] = true;
        $config['smtp_host'] = 'n3plvcpnl23930.prod.ams3.secureserver.net';
        $config['smtp_user'] = 'customer.support@ngocareer.com';
        $config['smtp_pass'] = 'TN{nZfK[Q7B}';
        $config['smtp_port'] = 25;
        $config['smtp_timeout'] = 60;   
        $config['smtp_keepalive'] = true;   
        
        
        $this->email->initialize($config);
        
        $this->email->from($this->send_from, $this->from_name);
        $this->email->to($this->send_to);
        $this->email->reply_to($this->send_from, $this->from_name);
        if($this->cc){
            $this->email->cc($this->cc);
        }        

        $body    = $this->body;
        $this->email->subject( $this->subject );
        $this->email->message( $body );          
        $this->email->set_alt_message( $this->body );

        if ( $this->email->send() ) {
            return ajaxRespond('OK', '<p class="ajax_success">Mail sent successfully</p>');
        } else {      
            dd( $this->email->print_debugger() );

            return ajaxRespond('Fail', '<p class="ajax_error">Mail Not Sent! Please try Again</p>');
        }
    }

    private function getDefaultLayout( $MailBody = '') {
        $template =  $this->load->view('email_templates/layout-active', '', true);
        return str_replace("%MailBody%", $MailBody, $template);
    }

    private function filterEmailSubject($subject = null, $placeholder = '' ) {
//        $subject = str_replace('%SiteTitle%', getSettingItem('SiteTitle'), $subject);
        $search     = ['%SiteTitle%', '%subject%'];
        $replace    = [$this->site_title, $placeholder];
        return str_replace($search, $replace, $subject);
    }

    public function processor($set_template, $options) {
        // demo array
//        $array = [
//            'cc' => 'admin@gmail.com',
//            'sender_id' => $sender_id,
//            'receiver_id' => $receiver_id,
//            'receiver_email' => $receiver_email,
//            'attach' => $attach,
//            'subject' => $subject,
//            'message' => $message, // if no need template
//            'SiteTitle' => $SiteTitle, // if no need template
//        ];

        $sender_id      = isset($options['sender_id']) ? $options['sender_id'] : 1;
        $receiver_id    = isset($options['receiver_id']) ? $options['receiver_id'] : 1;
        $this->send_to  = isset($options['receiver_email']) ? $options['receiver_email'] : getSettingItem('IncomingEmail');
        $this->cc       = isset($options['cc']) ? $options['cc'] : null;

        if(isset($options['attach'])){
            $this->attach   = $options['attach'];
        }

        //Quote - %subject%
        $subject        = isset($options['subject']) ?  $options['subject'] : '';
        if($set_template){
            $template       = $this->useEmailTeamplate($set_template);
            $this->subject  = $this->filterEmailSubject($template->title, $subject);
            $body           = $this->filterEmailBody($template->template, $options);
            $this->body     = $this->filter_layout($body);
        } else {
            $this->subject  = $subject;
            $this->body     = $options['message'];
        }

        $this->log();
        $this->save_in_db($set_template, $receiver_id, $sender_id, 0);
        echo $this->send();
    }
    public function compose($options) {

        $sender_id      = 1;
        $receiver_id    = $options['receiver_id'];
        $this->send_to  = $options['to'];                       
        $this->subject  = $options['subject'];        
        $this->body     = $this->filter_layout( $options['body'] );                

        $this->log();
        $this->save_in_db('onManualEmail', $receiver_id, $sender_id, 0);
        return $this->send();
    }

    private function filter_layout($mail_body) {
        $search     = ['%CompanyName%', '%base_url%'];
        $replace    = [$this->from_name, site_url() ];
        $finial     = str_replace($search, $replace, $mail_body);

        $setLayout  = $this->load->view('email_templates/layout-active', '', true);
        return str_replace(['%MailBody%', '%signature%'], [$finial, $this->signature], $setLayout);
    }

    private function filterEmailBody($template = null, $placeholders = array(0)) {
        if ($template && count($placeholders)) {
            foreach ($placeholders as $key => $value) {
                $template = str_replace("%{$key}%", $value, $template);
            }
        }
        return $template;
    }

    public function contact_us() {
        ajaxAuthorized();
        
        $name       = $this->input->post('name');
        $email      = $this->input->post('email');  
        $contact    = $this->input->post('contact');
        $subject    = $this->input->post('subject');
        $message    = $this->input->post('cf_message');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die(ajaxRespond('Fail', '<p class="ajax_error">Invalid Email</p>'));
        }

        echo sendMail('onContactUs', [
            'name' => $name,
            'email' => $email,
            'contact' => $contact,
            'subject' => $subject,
            'message' => $message,
        ]);
    }
}