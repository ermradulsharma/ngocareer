<?php
defined('BASEPATH') OR exit('No direct script access allowed');

load_module_asset('users', 'css');
?>
<section class="content-header">
    <h1>User Details <small>of</small> <?php echo $first_name . ' ' . $last_name; ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin </a></li>        
        <li class="active">User list</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">               
            <?php echo Users_helper::makeTab($id, 'freeze'); ?>
            <div class="box box-primary no-border">


                <div class="box-header"> 
                    <p class="alert alert-warning"><i class="fa fa-warning"></i> 
                        Deleting a user is not accepted due to user has many relational data.
                        You can only Freeze/Un-freeze a account.</p> 
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped">	    	    	   
                        <tr><td width="150">Full Name</td><td width="5">:</td><td><?php echo $first_name . ' ' . $last_name; ?></td></tr>
                        <tr><td>Created Date</td><td>:</td><td><?php echo globalDateFormat($created_at); ?></td></tr>                                  
                        <tr><td>Email</td><td>:</td><td><?php echo $email; ?></td></tr>	    
                        <tr><td>Current Status</td><td>:</td><td id="currentStatus"><?php echo $status; ?></td></tr>                        
                    </table>                                                                                                                                                              
                </div>
                
                <div class="box-footer text-center">
                    <span onclick="setStatus('Inactive', <?php echo $id; ?>);" class="btn btn-warning"> 
                        <i class="fa fa-random"></i> Freeze This Account
                    </span>

                    <span onclick="setStatus('Active', <?php echo $id; ?>);" class="btn btn-success">                     
                        <i class="fa fa-random"></i> Unfreeze This Account
                    </span>
                </div>
            </div>                        
        </div>              
    </div>
</section>
<?php load_module_asset('users', 'js'); ?>