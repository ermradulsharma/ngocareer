<?php load_module_asset('users', 'css'); ?>
<section class="content-header">
    <h1>My Profile <small>Change Password</small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php Backend_URL ?>"><i class="fa fa-user"></i> Admin</a></li>
        <li><a href="<?php Backend_URL . '/profile/' ?>"><i class="fa fa-dashboard"></i> Profile</a></li>
        <li class="active">Change Password</li>
    </ol>
</section>

<style type="text/css">
    span.input-group-addon.part1 {
        width: 150px;
    }
</style>

<section class="content">

    <?php
    echo form_open('', [
        'method' => 'post',
        'role' => 'form',
        'name' => 'updatePassword',
        'id' => 'update_password',
        'class' => 'form-horizontal'
    ]);
    ?>

    <?php echo profileTab('profile/password'); ?>
    <div class="box no-border">

        <div class="box-body">
            <div id="ajax_respond"></div>
            <div class="form-group">
                <div class="col-md-6">
                    <div class="input-group">                               
                        <span class="input-group-addon part1"><i class="fa fa-pencil-square-o"></i> Current Password<sup>*</sup> </span>
                        <input type="password" required=""
                               name="old_pass" 
                               maxlength="12"
                               id="old_pass" 
                               class="form-control">
                        <span class="input-group-addon">Max 12 Characters</span>
                    </div> 
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon part1">New Password<sup>*</sup></span>
                        <input type="password" required="" 
                               name="new_pass"
                               maxlength="12"
                               id="new_pass" class="form-control">
                        <span class="input-group-addon">Max 12 Characters</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon part1">Confirm Password<sup>*</sup></span>
                        <input type="password" required="" 
                               name="con_pass"
                               maxlength="12"
                               id="con_pass"  
                               class="form-control">
                        <span class="input-group-addon">Max 12 Characters</span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-2"> 
                    <button class="btn btn-primary emform" onclick="password_change();" type="button" >
                        <i class="fa fa-random" ></i> 
                        Save New Password
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</section>

<script type="text/javascript">
    function password_change() {
        var formData = jQuery('#update_password').serialize();
        var error = 0;

        if (!error) {
            jQuery.ajax({
                url: 'admin/profile/update_password',
                type: "post",
                dataType: 'json',
                data: formData,
                beforeSend: function () {
                    jQuery('#ajax_respond')
                            .html('<p class="ajax_processing">Please Wait...</p>')
                            .css('display', 'block');
                },
                success: function (jsonRespond) {
                    if (jsonRespond.Status === 'OK'){
                        jQuery('#ajax_respond').html(jsonRespond.Msg);
                        setTimeout(function () {
                            jQuery('#ajax_respond').slideUp('slow');
                        }, 2000);
                        jQuery('#update_password').trigger("reset");
                    } else {
                        jQuery('#ajax_respond').html(jsonRespond.Msg);
                    }
                }
            });
        }
        return false;
    }
</script>
