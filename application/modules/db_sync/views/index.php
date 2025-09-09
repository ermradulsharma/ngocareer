<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php load_module_asset('db_sync', 'css'); ?>
<section class="content-header" id="js_ajax_scroll">
    <h1> Database Synchronize  <small>Control panel</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">DB</li>
    </ol>          
</section>

<section class="content">
    <div class="alert alert-warning">
        <h2> <i class="fa fa-warning"></i> Warning! Database Zone is Very Sensitive</h2>
        <h4>Please avoid this option, if you don't have any database related knowledge.</h4>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div id="ajax_respond"></div>        
            <div id="jquery-dialog"></div>
        </div>
        
        <div class="col-md-6"> 
            
            <?php $this->load->view('history'); ?>
        </div>

        <div class="col-md-6">

            
            <div class="box">
                <div class="box-header">
                    <h3 class="panel-title">
                        <i class="fa fa-list"></i> <b> Upload DB File to Server</b>
                    </h3>
                    <hr/>
                </div>
                
                
                <div class="box-body">
                    <form class="form-horizontal" method="post">

                    <div class="form-group">
                        <label class="col-md-3 control-label">DB Type : </label>
                        <div class="col-md-9" style="padding-top: 8px;">                            
                            <label>
                                <input type="radio" value="db" name="db_type" checked="checked">
                                Full Database &nbsp;&nbsp;&nbsp;&nbsp; 
                            </label>
                            
                            <label><input type="radio" value="tbl" name="db_type"> Single Table </label>
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="col-md-3 control-label"> Select : </label>
                        <div class="col-md-4">
                            
                            <div class="btn btn-default btn-file">
                                <i class="fa fa-hdd-o"></i> Choose a SQL File ( *.sql or *.sql.zip)
                                <input type="file" name="db">
                            </div>                            
                        </div>                                                
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"> Action : </label>                        
                        <div class="col-md-4">                            
                            <button id="upload_sql_file" class="btn btn-primary">
                                <i class="fa fa-cloud-upload"></i> 
                                Start Upload
                            </button>
                        </div>                        
                    </div>
                    <p>&nbsp;</p>
                    
                    </form>
                </div>
            </div>

           
            
            <?php $this->load->view('tables'); ?>

        </div>
    </div>          
</section>

<?php load_module_asset('db_sync', 'js'); ?>