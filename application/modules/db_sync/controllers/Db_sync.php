<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* Author   : Khairul Azam
 * Date     : 2016-10-14
 * Update   : 2020-01-21
 */

class Db_sync extends Admin_controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Db_sync_model');      
        $this->load->helper('db_sync');      
    }

    public function index() {
        $data['db_sync_data']   = $this->Db_sync_model->get_all();
        $data['tables']         = $this->db->list_tables();
        
        $this->viewAdminContent('db_sync/index', $data);
    }   

    public function delete() {
        $id     = (int) $this->input->post('id');
        $file   = $this->input->post('file');
        
        $file_path = dirname ( BASEPATH ) .'/DB/' . $file;
        if($file && file_exists($file_path)){
            unlink($file_path);
        }
        
        $this->Db_sync_model->delete($id);
        echo ajaxRespond('OK', '<p class="ajax_success">File Deleted Successfully</p>');
    }

    public function  backup_full_db(){
        echo $this->backup_full_db_system();
    }

    public function restore(){
        ajaxAuthorized();
               
        $file_name   = $this->input->post('file');
        $table       = $this->input->post('table');

        if($table == 'db'){
            $this->backup_full_db_system();
        } else {
            $this->exportTableSystem( $table );
        }        
        
       
        $dbPath     = dirname( BASEPATH ) . '/DB/' . $file_name;       
        $templine   = '';	
        $lines      = file($dbPath); // Read in entire file
        foreach($lines as $line){
            if (substr($line, 0, 2) == '--' || $line == ''){
                continue;
            }
            $templine .= $line;
            if (substr(trim($line), -1, 1) == ';'){
                $this->db->query($templine);
                $templine = '';
            }
        }            
              
        $respond['Status'] = 'OK';
        $respond['Msg']    = '<p class="ajax_success">'. ucfirst($table) .' Restored Successfully</p>';                                   
        echo json_encode($respond);                     
    }
    
    public function upload_sql_file(){
       ajaxAuthorized();
         
       $file_name   = 'test';       
       $dbPath      = dirname( BASEPATH ) . '/DB/' . $file_name;
        
       $event_fire  = 'Full DB Backuped';
       $record_id   = $this->add_change_log( $event_fire, 'db', $file_name );      
       
       $sql_file = "test.sql";
       $array['Status'] = 'OK';
       $array['Msg']    = '<p class="ajax_success">Full DB Export Successful</p>';
       $array['TblRow'] = '<tr>'
                            . '<td>'. $record_id .'</td>'
                            . '<td> <code> db</code> </td>'
                            . '<td> Full DB Backuped <br/><em class="small">'. date('h:i A d/m/y'). '</em></td>'                            
                            . '<td>'. 
                                db_download_btn( $sql_file ) .
                                ' <span class="btn btn-xs btn-warning"><i class="fa fa-rotate-left"></i></span>'
                                .' <span class="btn btn-xs btn-danger" onclick="deleteTable('. $record_id .',\''. $sql_file .'\' );">
                                <i class="fa fa-times"></i></span></td>'
                        . '</tr>';
       
                     
       echo json_encode($array);                     
    }
    
    public function exportTable( $table = null ){    
       ajaxAuthorized();        
       $table_new   = is_null($table) ? $this->input->post('table') : $table;        
       echo $this->exportTableSystem( $table_new);                    
    }    

    public function truncateTable(){
        ajaxAuthorized();
        
        $table      = $this->input->post('table');
        $truncate   = $this->db->truncate($table);
        if($truncate){
            echo ajaxRespond('OK','Complete');
        } else {
            echo ajaxRespond('Fail','Fail To Truncate');
        }
    }
    
    private function add_change_log( $event_fired, $db_type, $file_name ) {
        ajaxAuthorized();
        
        $data = [
            'user_id'       => $this->user_id,
            'created'       => date('Y-m-d H:i:s'),
            'event_fired'   => $event_fired,            
            'db'            => $db_type,
            'file'          => $file_name . '.sql'
        ];
        return $this->Db_sync_model->insert($data);          
    }
    
    private function exportTableSystem( $setTable = null ){
                 
        $table   = is_null($setTable) ? $this->input->post('table') : $setTable;               

        $db      = $this->db->database;
        $host    = $this->db->hostname;
        $user    = $this->db->username;
        $pass    = $this->db->password;
       
        $raw_mysql_path     = str_replace('www', '', $this->input->server('DOCUMENT_ROOT'));
        $refine_mysql_path  = str_replace('/', '\\', $raw_mysql_path);
        $mysqlPath          = (PHP_OS == "WINNT") ? "{$refine_mysql_path}bin\\mysql\\mysql-5.7.24-winx64\\bin\\" : '';
                      
        $file_name      = $table . date('_Y-m-d_H-i-s');
        $dbPath         = dirname( BASEPATH ) . '/DB/'. $file_name;
        $sql_string     = "mysqldump --host={$host} --user={$user} --password={$pass} {$db} {$table} > {$dbPath}.sql";

        system( $mysqlPath . $sql_string);

        $event_fire  = ucfirst($table) . ' Table Backuped';
        $record_id   = $this->add_change_log(  $event_fire, $table, $file_name );      
        
        $sql_file        = "{$file_name}.sql";
        $array['Status'] = 'OK';
        $array['Msg']    = '<p class="ajax_success">'. $table .' Export Successfully</p>';
        $array['TblRow'] = '<tr>'
                . '<td>'. $record_id .'</td>'
                . '<td>'. ucfirst($table).' Table Backuped<br/><em class="small">'. globalDateTimeFormat ( date('Y-m-d H:i:s')). '</em></td>'                
                . '<td>'. db_download_btn( $sql_file ) 
                        .' <span class="btn btn-xs btn-warning"><i class="fa fa-rotate-left"></i></span>'
                        .' <span class="btn btn-xs btn-danger" onclick="deleteTable('. $record_id .',\''. $sql_file .'\');">
                        <i class="fa fa-times"></i></span></td>'
                . '</tr>';

        return json_encode($array);                     
    }
    
    private function backup_full_db_system(){
        ajaxAuthorized();
       
        $db      = $this->db->database;
        $host    = $this->db->hostname;
        $user    = $this->db->username;
        $pass    = $this->db->password;
       
        $raw_mysql_path     = str_replace('www', '', $this->input->server('DOCUMENT_ROOT'));
        $refine_mysql_path  = str_replace('/', '\\', $raw_mysql_path);
        $mysqlPath          = (PHP_OS == "WINNT") ? "{$refine_mysql_path}bin\\mysql\\mysql-5.7.24-winx64\\bin\\" : '';
          
        $file_name   = $db . date('_Y-m-d_H-i-s');
       
        $dbPath = dirname( BASEPATH ) . '/DB/' . $file_name;

        $sql_string = "mysqldump --host={$host} --user={$user} --password={$pass} {$db} > {$dbPath}.sql";

        system( $mysqlPath .$sql_string);

        $event_fire  = 'Full DB Backuped';
        $record_id   = $this->add_change_log( $event_fire, 'db', $file_name );      

        $sql_file = "{$file_name}.sql";
        $array['Status'] = 'OK';
        $array['Msg']    = '<p class="ajax_success">Full DB Export Successful</p>';
        $array['TblRow'] = '<tr>'
                            . '<td>'. $record_id .'</td>'                            
                            . '<td> Full DB Backuped <br/><em class="small">'. globalDateTimeFormat( date('Y-m-d H:i:s')) . '</em></td>'                            
                            . '<td>'. 
                                db_download_btn( $sql_file ) .
                                ' <span class="btn btn-xs btn-warning"><i class="fa fa-rotate-left"></i></span>'
                                .' <span class="btn btn-xs btn-danger" onclick="deleteTable('. $record_id .',\''. $sql_file .'\' );">
                                <i class="fa fa-times"></i></span></td>'
                        . '</tr>';                           
        return json_encode($array);                     
    }
        
}
