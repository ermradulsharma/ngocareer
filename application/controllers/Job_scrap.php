<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Author: Khairul Azam
 * Date : 2020-05-05
 */

class Job_scrap extends CI_Controller
{
    function __construct()
    {
        parent::__construct();        
    }
    
    function index_back(){
        
        ini_set('memory_limit', '-1');     
        $src        = 'https://www.jobg8.com/fileserver/jobs.aspx?username=AUTOGEN_USR_3833FD60B1&password=AUTOGEN_PWD_98E2DB670C&accountnumber=818758&filename=Jobs.zip';
        $content    = file_get_contents($src);
                
        if($content == 'Download Recently Performed'){
            die($content);
        }
        $base_dir   = dirname( BASEPATH )  . '/JobG8/';
        $zip_file   = "{$base_dir}/Jobs.zip";    
        
        unlink( $zip_file );
        
        file_put_contents($zip_file, $content);
                              
        $this->unzip($zip_file, $base_dir);
        
        $xml_path   = "{$base_dir}/Jobs.xml";        
        $jobs       = simplexml_load_file( $xml_path ) or die("Error: Cannot create object");

        $data = [];
        foreach( $jobs as $job ){
            $data[] = [
                'id' => null,
                'user_id' => 0,
                'package_id' => 0,
                'job_category_id' => $this->setCategoryID( (string) $job->Classification ),
                'sub_category_id' => 0,
                'location' => (string) $job->Location,
                'lat' => null,
                'lng' => null,
                'country_id' => $this->setCountryID( (string) $job->Country ),
                'job_type_id' => 0,
                'title' => trim( (string) $job->Position ),
                'description' => (string) $job->Description,
                'vacancy' => 0,
                'job_benefit_ids' => null,
                'job_skill_ids' => 0,
                'company_email' => 0,
                'deadline' => date('Y-m-d', strtotime('+28 Days')),
                'salary_type' => 0,
                'salary_min' => 0,
                'salary_max' => 0,
                'salary_period' => 0,
                'salary_currency' => substr( (string) $job->SalaryCurrency, -3),
                'hit_count' => 0,
                'recruiters_note' => 0,
                'admin_note' => 'JobG8 Job',
                'is_feature' => 0,
                'status' => 'Published',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),                
                'DisplayReference' => (string) $job->DisplayReference,
                'AdvertiserName' => (string) $job->AdvertiserName,
                'jobg8' => json_encode([                   
                    'AdvertiserType' => (string) $job->AdvertiserType,
                    'SenderReference' => (string) $job->SenderReference,
                    'Classification' => (string) $job->Classification,                    
                    'Area' => (string) $job->Area,
                    'ApplicationURL' => (string) $job->ApplicationURL,
                    'Language' => (string) $job->Language,
                    'EmploymentType' => (string) $job->EmploymentType,
                    'StartDate' => (string) $job->StartDate,
                    'WorkHours' => (string) $job->WorkHours,
                    'SalaryCurrency' => (string) $job->SalaryCurrency,
                    'SalaryPeriod' => (string) $job->SalaryPeriod,
                    'JobType' => (string) $job->JobType,
                    'SellPrice' => (string) $job->SellPrice
                ])
            ];    
        }
        
        if($data){
            $this->db->trans_start();
            $this->db->query('SET FOREIGN_KEY_CHECKS=0;');            
            $this->db->where('DisplayReference !=', null)->where('jobg8 !=', null)->delete('jobs');
            $this->db->insert_batch('jobs', $data);
            $this->db->query('SET FOREIGN_KEY_CHECKS=1;');
            $this->db->trans_complete();
            echo count($data)  . ' Job(s) Inserted With Old + New';
        } else {
            echo 'No Job Here to Insert';
        }
        
        
        $this->setLatLng();
    }
    
    function index(){
        
        ini_set('memory_limit', '-1');     
        $src        = 'https://www.jobg8.com/fileserver/jobs.aspx?username=AUTOGEN_USR_3833FD60B1&password=AUTOGEN_PWD_98E2DB670C&accountnumber=818758&filename=Jobs.zip';
        $content    = file_get_contents($src);
                
        if($content == 'Download Recently Performed'){
            die($content);
        }
        $base_dir   = dirname( BASEPATH )  . '/JobG8/';
        
        $zip_file   = "{$base_dir}/Jobs.zip";    
        
        unlink( $zip_file );
        
        file_put_contents($zip_file, $content);
                              
        $this->unzip($zip_file, $base_dir);
        
        $xml_path   = "{$base_dir}/Jobs.xml";        
        $jobs       = simplexml_load_file( $xml_path ) or die("Error: Cannot create object");
        
        
        //Get last attempt from temp_jobs
        $this->db->select('attempt');
        $previous_data = $this->db->get('temp_jobs')->row();
        $attempt = ($previous_data) ? $previous_data->attempt+1 : 1;
        
        
        $data = $data_jobg8 = [];
        foreach( $jobs as $job ){
            //Array parepare temp_jobs table data insert
            $data[] = [
                'attempt' => $attempt,
                'job_category_id' => $this->setCategoryID( (string) $job->Classification ),
                'location' => (string) $job->Location,
                'country_id' => $this->setCountryID( (string) $job->Country ),
                'title' => trim( (string) $job->Position ),
                'description' => (string) $job->Description,
                'deadline' => date('Y-m-d', strtotime('+28 Days')),
                'salary_currency' => substr( (string) $job->SalaryCurrency, -3),
                'admin_note' => 'JobG8 Job',
                'status' => 'Published',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),                
                'DisplayReference' => (string) $job->DisplayReference,
                'SenderReference' => (string) $job->SenderReference,
                'AdvertiserName' => (string) $job->AdvertiserName,
                'jobg8' => json_encode([                   
                    'AdvertiserType' => (string) $job->AdvertiserType,
                    'SenderReference' => (string) $job->SenderReference,
                    'Classification' => (string) $job->Classification,                    
                    'Area' => (string) $job->Area,
                    'ApplicationURL' => (string) $job->ApplicationURL,
                    'Language' => (string) $job->Language,
                    'EmploymentType' => (string) $job->EmploymentType,
                    'StartDate' => (string) $job->StartDate,
                    'WorkHours' => (string) $job->WorkHours,
                    'SalaryCurrency' => (string) $job->SalaryCurrency,
                    'SalaryPeriod' => (string) $job->SalaryPeriod,
                    'JobType' => (string) $job->JobType,
                    'SellPrice' => (string) $job->SellPrice
                ])
            ];  
            
            //Array parepare jobg8 table data insert
            $data_jobg8[] = [
                'attempt' => $attempt,
                'job_category_id' => $this->setCategoryID( (string) $job->Classification ),
                'location' => (string) $job->Location,
                'country_id' => $this->setCountryID( (string) $job->Country ),
                'title' => trim( (string) $job->Position ),
                'deadline' => date('Y-m-d', strtotime('+28 Days')),
                'salary_currency' => substr( (string) $job->SalaryCurrency, -3),
                'admin_note' => 'JobG8 Job',
                'status' => 'Published',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),                
                'DisplayReference' => (string) $job->DisplayReference,
                'SenderReference' => (string) $job->SenderReference,
                'AdvertiserName' => (string) $job->AdvertiserName,
                'jobg8' => json_encode([                   
                    'AdvertiserType' => (string) $job->AdvertiserType,
                    'SenderReference' => (string) $job->SenderReference,
                    'Classification' => (string) $job->Classification,                    
                    'Area' => (string) $job->Area,
                    'ApplicationURL' => (string) $job->ApplicationURL,
                    'Language' => (string) $job->Language,
                    'EmploymentType' => (string) $job->EmploymentType,
                    'StartDate' => (string) $job->StartDate,
                    'WorkHours' => (string) $job->WorkHours,
                    'SalaryCurrency' => (string) $job->SalaryCurrency,
                    'SalaryPeriod' => (string) $job->SalaryPeriod,
                    'JobType' => (string) $job->JobType,
                    'SellPrice' => (string) $job->SellPrice
                ])
            ]; 
        }
        
        if($data){
            
            $this->db->trans_start();
            
            //Empty all data from temp_jobs
            $this->db->from('temp_jobs'); 
            $this->db->truncate(); 
            
            //New data insert temp_jobs table
            $this->db->insert_batch('temp_jobs', $data);
            
            //New data insert jobg8 table
            $this->db->insert_batch('jobg8', $data_jobg8);
            
            //Get Not Match Data From Jobs Table
            $this->db->select('jobs.id as job_id, temp_jobs.id as temp_job_id');
            $this->db->join('temp_jobs', 'temp_jobs.SenderReference=jobs.SenderReference', 'left');
            $this->db->where('jobs.DisplayReference IS NOT NULL', null, false)->where('jobs.jobg8 IS NOT NULL', null, false);
            $this->db->where('temp_jobs.id IS NULL', null, false);
            $not_match_jobs_data = $this->db->get('jobs')->result_array();
            $not_match_job_ids = array_column($not_match_jobs_data, 'job_id');

            //Get Matching Data From Jobs Table
            $this->db->select('jobs.id as job_id, temp_jobs.id as temp_job_id');
            $this->db->join('temp_jobs', 'temp_jobs.SenderReference=jobs.SenderReference', 'inner');
            $this->db->where('jobs.DisplayReference IS NOT NULL', null, false)->where('jobs.jobg8 IS NOT NULL', null, false);
            $match_jobs_data = $this->db->get('jobs')->result_array();
            $match_job_ids = array_column($match_jobs_data, 'temp_job_id');

            //Get jobg8 data from temp_jobs
            $jobg8_data = $this->db->get('temp_jobs')->result();

            $update_data = [];
            $new_data = [];
            
            if($jobg8_data){
                
                foreach ($jobg8_data as $job) {
                    if(in_array($job->id, $match_job_ids)){
                        //Get job_id by temp table id
                        $job_id = $this->searchForJobId( $job->id, $match_jobs_data );
                        if($job_id){
                            $update_data[] = [
                                'id' => $job_id,
                                'job_category_id' => $job->job_category_id,
                                'location' => $job->location,
                                'country_id' => $job->country_id,
                                'title' => $job->title,
                                'description' => (string) $job->description,
                                'deadline' => $job->deadline,
                                'salary_currency' => $job->salary_currency,
                                'updated_at' => date('Y-m-d H:i:s'),                
                                'DisplayReference' => $job->DisplayReference,
                                'SenderReference' => (string) $job->SenderReference,
                                'AdvertiserName' => $job->AdvertiserName,
                                'jobg8' => $job->jobg8
                            ];
                        }
                        
                    }else{
                        $new_data[] = [
                            'id' => null,
                            'user_id' => 0,
                            'package_id' => 0,
                            'job_category_id' => $job->job_category_id,
                            'sub_category_id' => 0,
                            'location' => $job->location,
                            'lat' => null,
                            'lng' => null,
                            'country_id' => $job->country_id,
                            'job_type_id' => 0,
                            'title' => $job->title,
                            'description' => (string) $job->description,
                            'vacancy' => 0,
                            'job_benefit_ids' => null,
                            'job_skill_ids' => 0,
                            'company_email' => 0,
                            'deadline' => $job->deadline,
                            'salary_type' => 0,
                            'salary_min' => 0,
                            'salary_max' => 0,
                            'salary_period' => 0,
                            'salary_currency' => $job->salary_currency,
                            'hit_count' => 0,
                            'recruiters_note' => 0,
                            'admin_note' => 'JobG8 Job',
                            'is_feature' => 0,
                            'status' => 'Published',
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),                
                            'DisplayReference' => $job->DisplayReference,
                            'SenderReference' =>  $job->SenderReference,
                            'AdvertiserName' => $job->AdvertiserName,
                            'jobg8' => $job->jobg8
                        ];
                    }
                }

                if(!empty($new_data)){
                    //New data insert jobs table
                    $this->db->insert_batch('jobs', $new_data);
                }
                
                if(!empty($update_data)){
                    //Update job existing data by id
                    $this->db->update_batch('jobs', $update_data, 'id');
                }
                
                //Delete job table where jobg8 != jobs table not match
                if (!empty($not_match_job_ids)) {
                    $this->db->where_in('id', $not_match_job_ids);
                    $this->db->delete('jobs');
                }

            }//if not empty temp_jobs table data
            
            $this->db->trans_complete();
            
            echo count($data)  . " Job(s) Inserted With Temp Jobs Table";
            echo count($jobg8_data)  . " Job(s) Found \n";
            echo count($new_data)  . " Job(s) New Inserted  \n";
            echo count($update_data)  . " Job(s) Updated \n";
            echo count($not_match_job_ids)  . " Job(s) Deleted \n";
            
        } else {
            echo 'No Job Here to Insert';
        }
        
        $this->setLatLng();
    }
   
    
    //Get existing job id by temp_job_id
    public function searchForJobId($temp_job_id, $array) {
        foreach ($array as $key => $val) {
            if ($val['temp_job_id'] === $temp_job_id) {
                return $val['job_id'];
            }
        }
        return null;
    }
    
    public function setLatLng(){
        
        echo "New Location Sync =" . $this->sync_new_loc();
        echo "<br/>";
        
        $this->db->select('id,location');
        //$this->db->limit(25);
        $this->db->where('lat', null);
        $this->db->or_where('lng', null);
        $locations = $this->db->get('lat_lng_local_db')->result();
        
        $update = [];
        foreach($locations as $loc ){
            $geo = $this->getLatLng( urlencode($loc->location) );
            $update[] = [
                'id'  => $loc->id,
                'lat' => $geo['lat'],
                'lng' => $geo['lng'],
            ];            
        }
        
        if($update){
            $this->db->update_batch('lat_lng_local_db', $update, 'id');
            echo count($update) . ' Lat Lng Sync';
        } else {
            echo 'No Lat Lng Sync';
        }
        $this->sync_jobs_lat_lng();
    }

    private function getLatLng( $address = ''){
        if(empty($address)){
            return ['lat' => null, 'lng' => null ];
        }

        $key        = 'AIzaSyB4ukTuYJXlQxjwg3xeH0EiNG-Ry0okF-4';
        //$address    = 'Li%C3%A8ge';
        $json_url   = "https://maps.googleapis.com/maps/api/geocode/json?key={$key}&address={$address}";

        $json_str   = file_get_contents( $json_url );
        $obj        = json_decode($json_str);
        
        
        if($obj->status == 'OK'){
            $loc = $obj->results[0]->geometry->location;
            return ['lat' => $loc->lat, 'lng' => $loc->lng ];
        } else {
            return ['lat' => null, 'lng' => null ];
        }
        //echo "Lat: {$loc->lat} ===  Lng: {$loc->lng}";
    }
    
    private function sync_new_loc(){
        
        $this->db->query(
            "INSERT INTO lat_lng_local_db (location) 
            SELECT location FROM `jobs` WHERE location NOT IN (SELECT location FROM lat_lng_local_db) GROUP BY location"
        );
        return $this->db->affected_rows();
    }
    
    private function sync_jobs_lat_lng(){
        
        $this->db->query(
            "UPDATE `jobs` SET 
                `lat` = (SELECT lat FROM `lat_lng_local_db` where location = jobs.location ),
                `lng` = (SELECT lng FROM `lat_lng_local_db` where location = jobs.location ) 
            WHERE (`lat` is null or lng is null);"
        );        
    }
    
    private function setCategoryID( $string = null ){   
        $trim_cat = trim($string);
        $id = 16;
        switch ($trim_cat){
            case 'Accounting': 
            case 'Comptabilité': 
                $id = 1; 
                break;
            case 'Administration': 
                $id = 2; 
                break;
            case 'Advert / Media / Entertainment': 
            case 'Publicité / Médias / Divertissements': 
                $id = 3; 
                break;
            case 'Banking & Financial Services':
            case 'Bank- & Finanzwesen':
                $id = 4; 
                break;
            case 'Call Centre / Customer Service': 
                $id = 5; 
                break;
            case 'Community & Sport': 
            case 'Communauté et Sport': 
                $id = 6; 
                break;
            case 'Construction': 
                $id = 7; 
                break;
            case 'Consulting & Corporate Strategy': 
            case "Consultation et Stratégie d'entreprise": 
                $id = 8; 
                break;
            case 'Education':
            case 'Éducation':
                $id = 9; 
                break;
            case 'Engineering ': 
                $id = 10; 
                break;
            case 'Government & Defence': 
            case 'Öffentlicher Dienst': 
                $id = 11; 
                break;
            case 'Healthcare & Medical': 
                $id = 12; 
                break;
            case 'Hospitality & Tourism': 
                $id = 13; 
                break;
            case 'HR / Recruitment': 
                $id = 14; 
                break;            
            case 'I.T. & Communications':
            case 'IT & Telekommunikation':
                $id = 15; break;            
//            case 'Insurance & Superannuation': $id = 16; break;
            case 'Legal': 
                $id = 17; 
                break;
            case 'Manufacturing Operations': 
            case 'Activité de fabrication': 
                $id = 18; 
                break;
            case 'Mining / Oil / Gas': 
                $id = 19; 
                break;
//            case 'Other': $id = 16; break;
            case 'Primary Industry': 
                $id = 20; 
                break;
            case 'Real Estate & Property': 
                $id = 21; 
                break;
            case 'Retail & Consumer Products': 
                $id = 22; 
                break;
            case 'Science & Technology': 
                $id = 23; 
                break;
            case 'Trades & Services': 
            case 'Kaufmännische Berufe': 
                $id = 24; 
                break;
            case 'Transport & Logistics': 
                $id = 7; 
                break;
            case 'Executive Positions': 
                $id = 25; 
                break;
            case 'Self Employment': 
                $id = 26; 
                break;
            default :                 
        }
        return $id;
    }
    
    private function unzip( $zip_file, $dist ){
        $zip = new ZipArchive;
 
        if ($zip->open($zip_file) === TRUE){
            $zip->extractTo( $dist );
            $zip->close();
        }
    }
    
    private function setCountryID($country){
        $id = 0;
        switch ($country){                    
            case 'Afghanistan': $id = 1; break;
            case 'Albania': $id = 2; break;
            case 'Algeria': $id = 3; break;
            case 'American Samoa': $id = 4; break;
            case 'Andorra': $id = 5; break;
            case 'Angola': $id = 6; break;
            case 'Anguilla': $id = 7; break;
            case 'Antarctica': $id = 8; break;
            case 'Antigua and Barbuda': $id = 9; break;
            case 'Argentina': $id = 10; break;
            case 'Armenia': $id = 11; break;
            case 'Aruba': $id = 12; break;
            case 'Australia': $id = 13; break;
            case 'Austria': $id = 14; break;
            case 'Azerbaijan': $id = 15; break;
            case 'Bahamas': $id = 16; break;
            case 'Bahrain': $id = 17; break;
            case 'Bangladesh': $id = 18; break;
            case 'Barbados': $id = 19; break;
            case 'Belarus': $id = 20; break;
            case 'Belgium': $id = 21; break;
            case 'Belize': $id = 22; break;
            case 'Benin': $id = 23; break;
            case 'Bermuda': $id = 24; break;
            case 'Bhutan': $id = 25; break;
            case 'Bolivia': $id = 26; break;
            case 'Bosnia and Herzegowina': $id = 27; break;
            case 'Botswana': $id = 28; break;
            case 'Bouvet Island': $id = 29; break;
            case 'Brazil': $id = 30; break;
            case 'British Indian Ocean Territory': $id = 31; break;
            case 'Brunei Darussalam': $id = 32; break;
            case 'Bulgaria': $id = 33; break;
            case 'Burkina Faso': $id = 34; break;
            case 'Burundi': $id = 35; break;
            case 'Cambodia': $id = 36; break;
            case 'Cameroon': $id = 37; break;
            case 'Canada': $id = 38; break;
            case 'Cape Verde': $id = 39; break;
            case 'Cayman Islands': $id = 40; break;
            case 'Central African Republic': $id = 41; break;
            case 'Chad': $id = 42; break;
            case 'Chile': $id = 43; break;
            case 'China': $id = 44; break;
            case 'Christmas Island': $id = 45; break;
            case 'Cocos (Keeling) Islands': $id = 46; break;
            case 'Colombia': $id = 47; break;
            case 'Comoros': $id = 48; break;
            case 'Congo': $id = 49; break;
            case 'Cook Islands': $id = 50; break;
            case 'Costa Rica': $id = 51; break;
            case "Cote D'Ivoire": $id = 52; break;
            case 'Croatia': $id = 53; break;
            case 'Cuba': $id = 54; break;
            case 'Cyprus': $id = 55; break;
            case 'Czech Republic': $id = 56; break;
            case 'Denmark': $id = 57; break;
            case 'Djibouti': $id = 58; break;
            case 'Dominica': $id = 59; break;
            case 'Dominican Republic': $id = 60; break;
            case 'East Timor': $id = 61; break;
            case 'Ecuador': $id = 62; break;
            case 'Egypt': $id = 63; break;
            case 'El Salvador': $id = 64; break;
            case 'Equatorial Guinea': $id = 65; break;
            case 'Eritrea': $id = 66; break;
            case 'Estonia': $id = 67; break;
            case 'Ethiopia': $id = 68; break;
            case 'Falkland Islands (Malvinas)': $id = 69; break;
            case 'Faroe Islands': $id = 70; break;
            case 'Fiji': $id = 71; break;
            case 'Finland': $id = 72; break;
            case 'France': $id = 73; break;
            case 'France, Metropolitan': $id = 74; break;
            case 'French Guiana': $id = 75; break;
            case 'French Polynesia': $id = 76; break;
            case 'French Southern Territories': $id = 77; break;
            case 'Gabon': $id = 78; break;
            case 'Gambia': $id = 79; break;
            case 'Georgia': $id = 80; break;
            case 'Germany': $id = 81; break;
            case 'Ghana': $id = 82; break;
            case 'Gibraltar': $id = 83; break;
            case 'Greece': $id = 84; break;
            case 'Greenland': $id = 85; break;
            case 'Grenada': $id = 86; break;
            case 'Guadeloupe': $id = 87; break;
            case 'Guam': $id = 88; break;
            case 'Guatemala': $id = 89; break;
            case 'Guinea': $id = 90; break;
            case 'Guinea-bissau': $id = 91; break;
            case 'Guyana': $id = 92; break;
            case 'Haiti': $id = 93; break;
            case 'Heard and Mc Donald Islands': $id = 94; break;
            case 'Honduras': $id = 95; break;
            case 'Hong Kong': $id = 96; break;
            case 'Hungary': $id = 97; break;
            case 'Iceland': $id = 98; break;
            case 'India': $id = 99; break;
            case 'Indonesia': $id = 100; break;
            case 'Iran (Islamic Republic of)': $id = 101; break;
            case 'Iraq': $id = 102; break;
            case 'Ireland': $id = 103; break;
            case 'Israel': $id = 104; break;
            case 'Italy': $id = 105; break;
            case 'Jamaica': $id = 106; break;
            case 'Japan': $id = 107; break;
            case 'Jordan': $id = 108; break;
            case 'Kazakhstan': $id = 109; break;
            case 'Kenya': $id = 110; break;
            case 'Kiribati': $id = 111; break;
            case "Korea, Democratic People's Republic of": $id = 112; break;
            case 'Korea, Republic of': $id = 113; break;
            case 'Kuwait': $id = 114; break;
            case 'Kyrgyzstan': $id = 115; break;
            case "Lao People's Democratic Republic": $id = 116; break;
            case 'Latvia': $id = 117; break;
            case 'Lebanon': $id = 118; break;
            case 'Lesotho': $id = 119; break;
            case 'Liberia': $id = 120; break;
            case 'Libyan Arab Jamahiriya': $id = 121; break;
            case 'Liechtenstein': $id = 122; break;
            case 'Lithuania': $id = 123; break;
            case 'Luxembourg': $id = 124; break;
            case 'Macau': $id = 125; break;
            case 'Macedonia, The Former Yugoslav Republic of': $id = 126; break;
            case 'Madagascar': $id = 127; break;
            case 'Malawi': $id = 128; break;
            case 'Malaysia': $id = 129; break;
            case 'Maldives': $id = 130; break;
            case 'Mali': $id = 131; break;
            case 'Malta': $id = 132; break;
            case 'Marshall Islands': $id = 133; break;
            case 'Martinique': $id = 134; break;
            case 'Mauritania': $id = 135; break;
            case 'Mauritius': $id = 136; break;
            case 'Mayotte': $id = 137; break;
            case 'Mexico': $id = 138; break;
            case 'Micronesia, Federated States of': $id = 139; break;
            case 'Moldova, Republic of': $id = 140; break;
            case 'Monaco': $id = 141; break;
            case 'Mongolia': $id = 142; break;
            case 'Montenegro': $id = 143; break;
            case 'Montserrat': $id = 144; break;
            case 'Morocco': $id = 145; break;
            case 'Mozambique': $id = 146; break;
            case 'Myanmar': $id = 147; break;
            case 'Namibia': $id = 148; break;
            case 'Nauru': $id = 149; break;
            case 'Nepal': $id = 150; break;
            case 'Netherlands': $id = 151; break;
            case 'Netherlands Antilles': $id = 152; break;
            case 'New Caledonia': $id = 153; break;
            case 'New Zealand': $id = 154; break;
            case 'Nicaragua': $id = 155; break;
            case 'Niger': $id = 156; break;
            case 'Nigeria': $id = 157; break;
            case 'Niue': $id = 158; break;
            case 'Norfolk Island': $id = 159; break;
            case 'Northern Mariana Islands': $id = 160; break;
            case 'Norway': $id = 161; break;
            case 'Oman': $id = 162; break;
            case 'Pakistan': $id = 163; break;
            case 'Palau': $id = 164; break;
            case 'Panama': $id = 165; break;
            case 'Papua New Guinea': $id = 166; break;
            case 'Paraguay': $id = 167; break;
            case 'Peru': $id = 168; break;
            case 'Philippines': $id = 169; break;
            case 'Pitcairn': $id = 170; break;
            case 'Poland': $id = 171; break;
            case 'Portugal': $id = 172; break;
            case 'Puerto Rico': $id = 173; break;
            case 'Qatar': $id = 174; break;
            case 'Reunion': $id = 175; break;
            case 'Romania': $id = 176; break;
            case 'Russian Federation': $id = 177; break;
            case 'Rwanda': $id = 178; break;
            case 'Saint Kitts and Nevis': $id = 179; break;
            case 'Saint Lucia': $id = 180; break;
            case 'Saint Vincent and the Grenadines': $id = 181; break;
            case 'Samoa': $id = 182; break;
            case 'San Marino': $id = 183; break;
            case 'Sao Tome and Principe': $id = 184; break;
            case 'Saudi Arabia': $id = 185; break;
            case 'Senegal': $id = 186; break;
            case 'Serbia': $id = 187; break;
            case 'Seychelles': $id = 188; break;
            case 'Sierra Leone': $id = 189; break;
            case 'Singapore': $id = 190; break;
            case 'Slovakia (Slovak Republic)': $id = 191; break;
            case 'Slovenia': $id = 192; break;
            case 'Solomon Islands': $id = 193; break;
            case 'Somalia': $id = 194; break;
            case 'South Africa': $id = 195; break;
            case 'South Georgia and the South Sandwich Islands': $id = 196; break;
            case 'Spain': $id = 197; break;
            case 'Sri Lanka': $id = 198; break;
            case 'St. Helena': $id = 199; break;
            case 'St. Pierre and Miquelon': $id = 200; break;
            case 'Sudan': $id = 201; break;
            case 'Suriname': $id = 202; break;
            case 'Svalbard and Jan Mayen Islands': $id = 203; break;
            case 'Swaziland': $id = 204; break;
            case 'Sweden': $id = 205; break;
            case 'Switzerland': $id = 206; break;
            case 'Syrian Arab Republic': $id = 207; break;
            case 'Taiwan': $id = 208; break;
            case 'Tajikistan': $id = 209; break;
            case 'Tanzania, United Republic of': $id = 210; break;
            case 'Thailand': $id = 211; break;
            case 'Togo': $id = 212; break;
            case 'Tokelau': $id = 213; break;
            case 'Tonga': $id = 214; break;
            case 'Trinidad and Tobago': $id = 215; break;
            case 'Tunisia': $id = 216; break;
            case 'Turkey': $id = 217; break;
            case 'Turkmenistan': $id = 218; break;
            case 'Turks and Caicos Islands': $id = 219; break;
            case 'Tuvalu': $id = 220; break;
            case 'Uganda': $id = 221; break;
            case 'Ukraine': $id = 222; break;
            case 'United Arab Emirates': $id = 223; break;
            case 'United Kingdom': $id = 224; break;
            case 'United States': $id = 225; break;
            case 'United States Minor Outlying Islands': $id = 226; break;
            case 'Uruguay': $id = 227; break;
            case 'Uzbekistan': $id = 228; break;
            case 'Vanuatu': $id = 229; break;
            case 'Vatican City State (Holy See)': $id = 230; break;
            case 'Venezuela': $id = 231; break;
            case 'Viet Nam': $id = 232; break;
            case 'Virgin Islands (British)': $id = 233; break;
            case 'Virgin Islands (U.S.)': $id = 234; break;
            case 'Wallis and Futuna Islands': $id = 235; break;
            case 'Western Sahara': $id = 236; break;
            case 'Yemen': $id = 237; break;
            case 'Zaire': $id = 238; break;
            case 'Zambia': $id = 239; break;
            case 'Zimbabwe': $id = 240; break;
        }
        return $id;
    }
    
    /* Not In use */
    private function getCountryID( $name = 'United Kingdom'){
        // SELECT * FROM `countries` WHERE name = 'United Kingdom'
        $this->db->select('id');
        $this->db->where('name', $name);
        $country = $this->db->get('countries')->row();
        return ($country) ? $country->id : 0;
    }
    private function getCategoryID( $name = 'United Kingdom'){        
        $this->db->select('id');
        $this->db->where('name', $name);
        $cat = $this->db->get('job_categories')->row();
        return ($cat) ? $cat->id : 0;
    }
    
    function tmp(){
        exit;
        $this->db->select('id,jobg8');
//        $this->db->limit(2500, 0);
        $jobs = $this->db->get('jobs')->result();
        
        echo $this->db->last_query();
        echo '<br/>';
        
        $update = [];
        foreach($jobs as $job ){
            $data = json_decode($job->jobg8);
            
            $update[] = [
                'id' => $job->id,
                'AdvertiserName' => $data->AdvertiserName
            ];            
        }
        $this->db->update_batch('jobs', $update, 'id');                
    }
}