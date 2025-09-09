<h3 class="page-header">Change Password</h3>
<?php echo $this->session->flashdata('message'); ?>
<div class="row">
    <form class="form-horizontal" name="jobseeker_change_password" id="jobseeker_change_password" method="POST" action="<?= base_url('my_account/change_password_action') ?>">
        <div class="col-md-12">
            <div class="form-group row">
                <label for="username" class="col-md-4 col-form-label">Email</label>
                <div class="col-md-8">
                    <input name="email" placeholder="Enter Email" class="form-control here" required="required" type="text" readonly="" value="<?php echo $email; ?>" />
                </div>
            </div>
            <div class="form-group row">
                <label for="old_password" class="col-md-4 col-form-label">Old Password<span class="mandatory">*</span></label>
                <div class="col-md-8">
                    <input id="old_password" name="old_password" placeholder="Enter Old Password" class="form-control here" type="password" value="<?php echo $old_password;?>"/>
                    <span class="text-danger"><?php echo form_error('old_password'); ?></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="new_password" class="col-md-4 col-form-label">New Password<span class="mandatory">*</span></label> 
                <div class="col-md-8">
                    <input id="name" name="new_password" placeholder="Enter New Password" class="form-control here" type="password" value="<?php echo $new_password;?>" required="required" />
                    <span class="text-danger"><?php echo form_error('new_password'); ?></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="confirm_password" class="col-md-4 col-form-label">Confirm Password<span class="mandatory">*</span></label>
                <div class="col-md-8">
                    <input id="confirm_password" name="confirm_password" placeholder="Enter Confirm Password" class="form-control here" type="password" value="<?php echo $confirm_password;?>" required="required" />
                    <span class="text-danger"><?php echo form_error('confirm_password'); ?></span>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-offset-4 col-md-8">
                    <input type="hidden" name="id" name="id" value="<?php echo $id;?>" />
                    <button name="submit" type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </form>
</div>
