<?php load_module_asset('users', 'css'); ?>
<?php load_module_asset('users', 'js'); ?>


<section class="content-header">
    <h1>User Details <small>of</small> <?php echo $first_name . ' ' . $last_name; ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php Backend_URL ?>"><i class="fa fa-user"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL . '/users/' ?>"><i class="fa fa-dashboard"></i> Users</a></li>    
        <li class="active">Reset Password</li>
    </ol>
</section>

<section class="content">
    <?php echo Users_helper::makeTab($id, 'password'); ?>
    <div class="box no-border">

        <div class="box-body">

            <div class="col-md-12">
                <div id="ajax_respond"></div>
                <form name="updatePassword" id="update_password" role="form" method="POST">

                    <div class="input-group">                               
                        <span class="input-group-addon"><i class="fa fa-pencil-square-o"></i> UserID</span>                        
                        <input type="text" readonly="readonly" 
                               name="user_id" id="user_id" 
                               class="form-control" 
                               value="<?php echo $id; ?>"
                               >
                    </div>                          


                    <div class="input-group"  style="margin:  8px 0;">
                        <span class="input-group-addon">New Password<sup>*</sup></span>
                        <input type="password" required="" name="new_pass" id="new_pass" class="form-control">                         
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon">Confirm New Password<sup>*</sup></span>
                        <input type="password" required="" name="con_pass" id="con_pass"  class="form-control">                         
                    </div>
                    <div class="col-md-3 col-lg-offset-2"> 
                        <button class="btn btn-primary emform" onclick="password_change();" type="button" ><i class="fa fa-random" ></i> Update</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
<?php load_module_asset('users', 'js'); ?>