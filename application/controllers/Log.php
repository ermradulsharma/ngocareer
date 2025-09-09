<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends Frontend_controller {        
    public function index(){
        $log = file_get_contents( APPPATH . '/logs/mail_log.txt');
        echo '<pre>';
        echo $log;
        echo '</pre>';        
//        echo $this->user_id;
    }
}