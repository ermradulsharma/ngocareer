<?php
defined('BASEPATH') OR exit('No direct script access allowed');
load_module_asset('users', 'css');
?>
<section class="content-header">
    <h1>User Details <small>of</small> <?php echo "{$first_name} {$last_name}"; ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php Backend_URL ?>"><i class="fa fa-user"></i> Admin</a></li>
        <li><a href="<?php echo Backend_URL . 'users' ?>"> User</a></li>
        <li class="active">Update Company Profile</li>
    </ol>
</section>


<section class="content">

    <form class="form-horizontal" action="<?php echo $action; ?>" enctype="multipart/form-data" role="form" id="personalForm" method="post">
        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
        <input type="hidden" name="role_id" id="role_id" value="4" />
        <?php echo validation_errors(); ?>
        <?php echo Users_helper::makeTab($id, 'update'); ?>
        <div class="box no-border">
            <div class="row">

                <div class="col-md-9">
                    <div class="box-body">
                        <fieldset>
                            <legend>Contact Person</legend>
                            <div class="form-group">
                                <label for="email" class="control-label col-md-3">Full Name</label>

                                <div class="col-md-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">First Part</span>
                                        <input type="text" class="form-control" placeholder="First Name"
                                               name="first_name" value="<?php echo $first_name; ?>">


                                        <span class="input-group-addon">Last Part</span>
                                        <input type="text" class="form-control" placeholder="Last Name"
                                               name="last_name" value="<?php echo $last_name; ?>"/>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="email" class="control-label col-md-3">Email Address</label>
                                <div class="col-md-9">
                                    <input type="text" name="email" id="email" class="form-control"
                                           value="<?php echo $email; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contact" class="control-label col-md-3">Contact Number</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input required="required" maxlength="11" type="text" class="form-control" id="contact" placeholder="Contact Number"
                                               name="contact" value="<?php echo $contact; ?>" onkeypress="return DigitOnly(event);">
                                        <span class="input-group-addon text-bold">Max 11 Character</span>
                                    </div>
                                </div>
                            </div>
                        </fieldset>


                        <fieldset>
                            <legend>Company Information</legend>
                            <div class="form-group">
                                <label for="company_name" class="control-label col-md-3">Company Name<sup>*</sup></label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input required="required" type="text" class="form-control" id="company_name" placeholder="Company Name"
                                               name="company_name" value="<?php echo $company_name; ?>">
                                        <span class="input-group-addon text-bold">Max 50 Character</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="org_type_id" class="control-label col-md-3">Company Type<sup>*</sup></label>
                                <div class="col-sm-9">
                                    <select name="org_type_id" class="form-control" id="org_type_id">
                                        <option value="0">-- Select Company Type --</option>
                                        <?php echo Ngo::getCompanyTypeDropDown($org_type_id); ?>
                                    </select>
                                    <?php echo form_error('org_type_id') ?>
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
                                <label for="add_line1" class="control-label col-md-3">Address Line 1</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="add_line1" placeholder="Address Line 1"
                                           name="add_line1" value="<?php echo $add_line1; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="add_line2" class="control-label col-md-3">Address Line 2</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="add_line2" placeholder="Address Line 2"
                                           name="add_line2" value="<?php echo $add_line2; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="city" class="control-label col-md-3">City</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="city" placeholder="City"
                                           name="city" value="<?php echo $city; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="state" class="control-label col-md-3">Region/State</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="state" placeholder="Region/State"
                                           name="state" value="<?php echo $state; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="postcode" class="control-label col-md-3">Postcode</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="postcode" placeholder="Postcode"
                                           name="postcode" value="<?php echo $postcode; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="country_id" class="control-label col-md-3">Country</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="country_id">
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
                                <label for="is_featured" class="col-sm-3 control-label">Mark as Featured<sup>*</sup></label>
                                <div class="col-sm-9"
                                     style="padding-top:8px;"><?php echo htmlRadio('is_featured', $is_featured, [
                                        0 => 'No',
                                        1 => 'Yes',
                                    ]); ?></div>
                            </div>

                        </fieldset>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="box-body">
                        <fieldset>
                            <legend>Company Logo</legend>
                            <div class="thumbnail upload_image">
                                <img src="<?php echo getPhoto($logo); ?>" alt="Thumbnail">
                            </div>
                            <div class="btn btn-default btn-file">
                                <i class="fa fa-picture-o"></i> Select Logo
                                <input accept="image/*" type="file" name="logo" class="file_select" onchange="photoPreview(this, '.upload_image')">
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>

            <div class="box-footer text-center">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i>
                    Update
                </button>
            </div>


        </div>
    </form>
</section>

<script type="text/javascript">
    function roleChange() {
        var id = $('#id').val();
        var role_id = $('#role_id').val();
        location.href = `admin/users/update/${id}?role_id=${role_id}`;
    }
</script>
<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('about_company', {
        width: ['100%'],
        height: ['300px'],
        customConfig: '<?php echo site_url('assets/lib/plugins/ckeditor/config.js'); ?>'
    });
</script>