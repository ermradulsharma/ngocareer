<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1>Register New User</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin </a></li>
        <li class="active">User list</li>
    </ol>
</section>

<section class="content">
    <div class="box box-primary">

        <div class="panel-body">
            <form action="<?php echo Backend_URL; ?>users/create_action" method="post" id="user_form"
                  class="form-horizontal">

                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="role_id" class="col-sm-3 control-label">Role<sup>*</sup></label>
                            <div class="col-sm-9">
                                <select name="role_id" class="form-control" id="role_id">
                                    <?php echo Users_helper::getDropDownRoleName($role_id); ?>
                                </select>
                                <?php echo form_error('role_id') ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="first_name" class="col-sm-3 control-label">First Name<sup>*</sup></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="first_name" id="first_name"
                                       placeholder="First Name" value="<?php echo $first_name; ?>"/>
                                <?php echo form_error('first_name') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="col-sm-3 control-label">Last Name<sup>*</sup></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="last_name" id="last_name"
                                       placeholder="Last Name" value="<?php echo $last_name; ?>"/>
                                <?php echo form_error('last_name') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="your_email" class="col-sm-3 control-label">Email<sup>*</sup></label>
                            <div class="col-sm-9">
                                <input autocomplete="off" type="text" class="form-control" name="your_email"
                                       id="your_email" placeholder="Valid Email Address" value="<?php echo $your_email; ?>"/>
                                <?php echo form_error('your_email') ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-sm-3 control-label">Password<sup>*</sup></label>
                            <div class="col-sm-9">
                                <input type="password" autocomplete="off" class="form-control" name="password"
                                       id="password" placeholder="Password"/>
                                <?php echo form_error('password') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contact" class="col-sm-3 control-label">Contact</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="contact" id="contact"
                                       placeholder="Contact" value="<?php echo $contact; ?>"/>
                                <?php echo form_error('contact') ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-9 col-md-offset-3 ">
                                <a href="<?php echo site_url(Backend_URL . 'users') ?>" class="btn btn-default"><i
                                            class="fa fa-long-arrow-left"></i> Cancel & Back to List</a>
                                <button type="submit" class="btn btn-primary">Register & Continue Update <i
                                            class="fa fa-long-arrow-right"></i></button>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="add_line1" class="col-sm-3 control-label">Address Line1</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="add_line1" id="add_line1"
                                       placeholder="Address Line1" value="<?php echo $add_line1; ?>"/>
                                <?php echo form_error('add_line1') ?>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="add_line2" class="col-sm-3 control-label">Address Line2</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="add_line2" id="add_line2"
                                       placeholder="Address Line2" value="<?php echo $add_line2; ?>"/>
                                <?php echo form_error('add_line2') ?>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="city" class="col-sm-3 control-label">City</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="city" id="city"
                                       placeholder="City" value="<?php echo $city; ?>"/>
                                <?php echo form_error('city') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="state" class="col-sm-3 control-label">State</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="state" id="state"
                                       placeholder="State" value="<?php echo $state; ?>"/>
                                <?php echo form_error('state') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="postcode" class="col-sm-3 control-label">Postcode</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="postcode" id="postcode"
                                       placeholder="Postcode" value="<?php echo $postcode; ?>"/>
                                <?php echo form_error('postcode') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="country_id" class="col-sm-3 control-label">Country</label>
                            <div class="col-sm-9">
                                <select name="country_id" class="form-control" id="country_id">
                                    <?php echo getDropDownCountries($country_id); ?>
                                </select>
                                <?php echo form_error('country_id') ?>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="status" class="col-sm-3 control-label">Status</label>
                            <div class="col-sm-5">
                                <select name="status" class="form-control" id="status">
                                    <?php echo selectOptions( $status, [
                                        'Active' => 'Active',
                                        'Inactive' => 'Inactive',
                                        'Pending' => 'Pending']); ?>
                                </select>
                                <?php echo form_error('status') ?>
                            </div>
                        </div>
                    </div>
                </div>


            </form>
        </div>
    </div>

</section>