<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php load_module_asset('users', 'css'); ?>
<section class="content-header">
    <h1>Candidate<small><?php echo $button ?></small></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL ?>"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL ?>candidate">Candidate</a></li>
        <li class="active">Update</li>
    </ol>
</section>

<section class="content"><?php echo candidateTabs($id, 'update'); ?>
    <div class="box no-border">
        <div class="box-header with-border">
            <h3 class="box-title">Update Candidate</h3>
        </div>

        <div class="box-body">
            <form class="form-horizontal" action="<?php echo $action; ?>" method="post">
                <div class="form-group">
                    <label for="first_name" class="col-sm-2 control-label">First Name :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="first_name" id="first_name"
                               placeholder="First Name" value="<?php echo $first_name; ?>"/>
                        <?php echo form_error('first_name') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="last_name" class="col-sm-2 control-label">Last Name :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name"
                               value="<?php echo $last_name; ?>"/>
                        <?php echo form_error('last_name') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email"
                               value="<?php echo $email; ?>" readonly/>
                        <?php echo form_error('email') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="date_of_birth" class="col-sm-2 control-label">Date Of Birth :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control js_datepicker" name="date_of_birth" id="date_of_birth"
                               placeholder="Date Of Birth" value="<?php echo $date_of_birth; ?>"/>
                        <?php echo form_error('date_of_birth') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="marital_status" class="col-sm-2 control-label">Marital Status :</label>
                    <div class="col-sm-10"
                         style="padding-top:8px;"><?php echo htmlRadio('marital_status', $marital_status, array('Married' => 'Married', 'Single' => 'Single', 'Divorced' => 'Divorced', 'Widowed' => 'Widowed')); ?></div>
                </div>

                <div class="form-group">
                    <label for="country_id" class="col-sm-2 control-label">Country :</label>
                    <div class="col-sm-10">
                        <select name="country_id" class="form-control" id="country_id">
                            <?php echo getDropDownCountries($country_id); ?>
                        </select>
                        <?php echo form_error('country_id') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="permanent_address" class="col-sm-2 control-label">Permanent Address :</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="permanent_address" id="permanent_address"
                                  placeholder="Permanent Address" rows="4"><?php echo $permanent_address; ?></textarea>
                        <?php echo form_error('permanent_address') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="present_address" class="col-sm-2 control-label">Present Address :</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="present_address" id="present_address"
                                  placeholder="Present Address" rows="4"><?php echo $present_address; ?></textarea>
                        <?php echo form_error('present_address'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="home_phone" class="col-sm-2 control-label">Home Phone :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="home_phone" id="home_phone"
                               placeholder="Home Phone" value="<?php echo $home_phone; ?>"/>
                        <?php echo form_error('home_phone') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="mobile_number" class="col-sm-2 control-label">Mobile Number :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="mobile_number" id="mobile_number"
                               placeholder="Mobile Number" value="<?php echo $mobile_number; ?>"/>
                        <?php echo form_error('mobile_number') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="gender" class="col-sm-2 control-label">Gender :</label>
                    <div class="col-sm-10"
                         style="padding-top:8px;"><?php echo htmlRadio('gender', $gender, array('Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other')); ?></div>
                </div>

                <div class="form-group">
                    <label for="career_summary" class="col-sm-2 control-label">Career Summary :</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" name="career_summary" id="career_summary"
                                  placeholder="Career Summary"><?php echo $career_summary; ?></textarea>
                        <?php echo form_error('career_summary') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="qualifications" class="col-sm-2 control-label">Qualifications :</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" name="qualifications" id="qualifications"
                                  placeholder="Qualifications"><?php echo $qualifications; ?></textarea>
                        <?php echo form_error('qualifications') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="keywords" class="col-sm-2 control-label">Keywords :</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" name="keywords" id="keywords"
                                  placeholder="Keywords"><?php echo $keywords; ?></textarea>
                        <?php echo form_error('keywords') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="additional_information" class="col-sm-2 control-label">Additional Information :</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="3" name="additional_information"
                                  id="additional_information"
                                  placeholder="Additional Information"><?php echo $additional_information; ?></textarea>
                        <?php echo form_error('additional_information') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="status" class="col-sm-2 control-label">Status :</label>
                    <div class="col-sm-10"
                         style="padding-top:8px;"><?php echo htmlRadio('status', $status, array('Active' => 'Active', 'Inactive' => 'Inactive', 'Pending' => 'Pending')); ?></div>
                </div>

                <div class="col-md-12 text-right">
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                    <a href="<?php echo site_url(Backend_URL . 'candidate') ?>" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>