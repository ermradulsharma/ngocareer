<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1>Register New Recruiter</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Backend_URL; ?>"><i class="fa fa-dashboard"></i> Admin </a></li>
        <li class="active">User list</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-9">

            <div class="box box-primary">

                <div class="box-body">
                    <div id="success_report"></div>

                    <form action="<?php echo Backend_URL; ?>users/create_action_company" method="post" id="user_form"
                          class="form-horizontal" enctype="multipart/form-data">
                        <input type="hidden" name="role_id" value="4"/>

                        <fieldset>
                            <legend>Contact Person</legend>

                            <div class="form-group">
                                <label for="first_name" class="col-sm-3 control-label">Full Name<sup>*</sup></label>
                                <div class="col-sm-9">

                                    <div class="input-group">
                                        <span class="input-group-addon">First Part</span>
                                        <input type="text" class="form-control" name="first_name" id="first_name"
                                               placeholder="First Name" value="<?php echo $first_name; ?>"/>
                                        <?php echo form_error('first_name') ?>

                                        <span class="input-group-addon">Last Part</span>
                                        <input type="text" class="form-control" name="last_name" id="last_name"
                                               placeholder="Last Name" value="<?php echo $last_name; ?>"/>
                                        <?php echo form_error('last_name') ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="your_email" class="col-sm-3 control-label">Email<sup>*</sup></label>
                                <div class="col-sm-9">
                                    <input autocomplete="off" type="text" class="form-control" name="your_email"
                                           id="your_email" placeholder="Valid Email Address"
                                           value="<?php echo $your_email; ?>"/>
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
                                    <input type="text" class="form-control" name="contact"
                                           id="contact" placeholder="Contact" value="<?php echo $contact; ?>"/>
                                </div>
                            </div>

                        </fieldset>

                        <fieldset>
                            <legend>Company Information</legend>

                            <div class="form-group">
                                <label for="company_name" class="col-sm-3 control-label">Company
                                    Name<sup>*</sup></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="company_name" id="company_name"
                                           placeholder="Company Name" value="<?php echo $company_name; ?>"/>
                                    <?php echo form_error('company_name') ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="org_type_id" class="col-sm-3 control-label">Company Type<sup>*</sup></label>
                                <div class="col-sm-9">
                                    <select name="org_type_id" class="form-control" id="org_type_id">
                                        <?php echo Ngo::getCompanyTypeDropDown($org_type_id, 'Select Company Type'); ?>
                                    </select>
                                    <?php echo form_error('org_type_id') ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="logo" class="col-sm-3 control-label">Logo</label>
                                <div class="col-sm-9">
                                    <input type="file" name="logo" id="logo">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="website" class="col-sm-3 control-label">Website</label>
                                <div class="col-sm-9">
                                    <input type="url" class="form-control" name="website"
                                           id="website" placeholder="https://www.example.com/"
                                           value="<?php echo $website; ?>"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="add_line1" class="col-sm-3 control-label">Address Line1</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="add_line1"
                                           id="add_line1" placeholder="Address Line1"
                                           value="<?php echo $add_line1; ?>"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="add_line2" class="col-sm-3 control-label">Address Line2</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="add_line2"
                                           id="add_line2" placeholder="Address Line2"
                                           value="<?php echo $add_line2; ?>"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="city" class="col-sm-3 control-label">City</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="city" id="city"
                                           value="<?php echo $city; ?>" placeholder="City"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="state" class="col-sm-3 control-label">Region/State</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="state" value="<?php echo $state; ?>"
                                           id="state" placeholder="State"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="postcode" class="col-sm-3 control-label">Postcode</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="postcode"
                                           value="<?php echo $postcode; ?>"
                                           id="postcode" placeholder="Postcode"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="country_id" class="col-sm-3 control-label">Country</label>
                                <div class="col-sm-9">
                                    <select name="country_id" class="form-control" id="country_id">
                                        <option value="0">-- Select Country --</option>
                                        <?php echo getDropDownCountries($country_id); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="about_company" class="col-sm-3 control-label">About Company</label>
                                <div class="col-sm-9">
                    <textarea class="form-control" rows="3" name="about_company" id="about_company"
                              placeholder="About Company"><?php echo $about_company; ?></textarea>
                                    <?php echo form_error('about_company') ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="is_featured" class="col-sm-3 control-label">Mark as
                                    Featured<sup>*</sup></label>
                                <div class="col-sm-9"
                                     style="padding-top:8px;"><?php echo htmlRadio('is_featured', $is_featured, [
                                        0 => 'No',
                                        1 => 'Yes',
                                    ]); ?></div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-9 col-md-offset-3 ">
                                    <a href="<?php echo site_url(Backend_URL . 'users') ?>" class="btn btn-default"><i
                                                class="fa fa-long-arrow-left"></i> Cancel & Back to List</a>
                                    <button type="button" onclick="submitFrom();" class="btn btn-primary">Register <i
                                                class="fa fa-long-arrow-right"></i></button>
                                </div>
                            </div>
                        </fieldset>


                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('about_company', {
        width: ['100%'],
        height: ['300px'],
        customConfig: '<?php echo site_url('assets/lib/plugins/ckeditor/config.js'); ?>'
    });
</script>

<script type="text/javascript">

    function submitFrom() {
        var error = 0;

        // var first_name = $('[name=first_name]').val();
        // if (!first_name) {
        //     $('[name=first_name]').addClass('required');
        //     error = 1;
        // } else {
        //     $('[name=first_name]').removeClass('required');
        // }
        //
        // var last_name = $('[name=last_name]').val();
        // if (!last_name) {
        //     $('[name=last_name]').addClass('required');
        //     error = 1;
        // } else {
        //     $('[name=last_name]').removeClass('required');
        // }
        //
        // var your_email = $('[name=your_email]').val();
        // if (!your_email) {
        //     $('[name=your_email]').addClass('required');
        //     error = 1;
        // } else {
        //     $('[name=your_email]').removeClass('required');
        // }
        //
        // var password = $('[name=password]').val();
        // if (!password) {
        //     $('[name=password]').addClass('required');
        //     error = 1;
        // } else {
        //     $('[name=password]').removeClass('required');
        // }
        //
        // var company_name = $('[name=company_name]').val();
        // if (!company_name) {
        //     $('[name=company_name]').addClass('required');
        //     error = 1;
        // } else {
        //     $('[name=company_name]').removeClass('required');
        // }

        if (!error) {
            $('#user_form').submit();
        } else {
            return false;
        }
    }
</script>